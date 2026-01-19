<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\ScrapedContent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateArticleFromScrapedContent implements ShouldQueue
{
    use Queueable;

    public $timeout = 300; // 5 minutes timeout
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $scrapedContentIds,
        public string $aiPrompt,
        public int $userId
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Fetch selected scraped content
            $scrapedContents = ScrapedContent::with('affiliateSite')
                ->whereIn('id', $this->scrapedContentIds)
                ->get();

            if ($scrapedContents->isEmpty()) {
                throw new \Exception('No scraped content found for the provided IDs.');
            }

            // Mark contents as processing
            foreach ($scrapedContents as $content) {
                $content->update(['status' => 'processing']);
            }

            // Build context for AI
            $context = $this->buildContextForAI($scrapedContents);

            // Call AI API (placeholder for Runpod integration)
            $articleContent = $this->callAIService($context, $this->aiPrompt);

            // Extract title from generated content
            $title = $this->extractTitle($articleContent);

            // Create article
            $article = Article::create([
                'user_id' => $this->userId,
                'title' => $title,
                'content' => $articleContent,
                'excerpt' => substr(strip_tags($articleContent), 0, 200),
                'published' => false,
                'is_ai_generated' => true,
            ]);

            // Attach scraped contents to article via pivot table
            $article->scrapedContents()->attach($this->scrapedContentIds);

            // Mark scraped contents as completed
            foreach ($scrapedContents as $content) {
                $content->update([
                    'status' => 'completed',
                    'processed_at' => now(),
                ]);
            }

            Log::info("Article generated successfully", [
                'article_id' => $article->id,
                'title' => $article->title,
                'scraped_content_count' => count($this->scrapedContentIds),
            ]);

            // TODO: Add notification to user when job completes
            // User::find($this->userId)->notify(new ArticleGeneratedNotification($article));

        } catch (\Exception $e) {
            Log::error("Failed to generate article from scraped content", [
                'error' => $e->getMessage(),
                'scraped_content_ids' => $this->scrapedContentIds,
            ]);

            // Mark contents as failed
            ScrapedContent::whereIn('id', $this->scrapedContentIds)
                ->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);

            throw $e;
        }
    }

    protected function buildContextForAI($scrapedContents): string
    {
        $context = "Below are the scraped content items to use as reference:\n\n";

        foreach ($scrapedContents as $index => $content) {
            $context .= "Content " . ($index + 1) . ":\n";
            $context .= "Title: " . ($content->title ?? 'N/A') . "\n";
            $context .= "URL: " . $content->content_url . "\n";
            $context .= "Source: " . $content->affiliateSite->name . "\n";
            $context .= "---\n\n";
        }

        return $context;
    }

    /**
     * Call Runpod vLLM serverless endpoint (OpenAI-compatible)
     */
    protected function callAIService(string $context, string $prompt): string
    {
        $endpointId = config('services.runpod.endpoint');
        $apiKey = config('services.runpod.key');

        if (empty($endpointId) || empty($apiKey)) {
            return $this->generateMockArticle($context, $prompt);
        }

        $systemPrompt = "You are an expert content writer. Write engaging, SEO-optimized articles based on the provided source material. " .
            "Format your response in markdown with a clear title (using # heading), introduction, body sections, and conclusion. " .
            "Include relevant keywords naturally throughout the content.";

        $userMessage = "Using the following source material as reference, {$prompt}\n\n{$context}";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json',
        ])->timeout(180)->post("https://api.runpod.ai/v2/{$endpointId}/runsync", [
            'input' => [
                'openai_route' => '/v1/chat/completions',
                'openai_input' => [
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'max_tokens' => 4096,
                    'temperature' => 0.7,
                ],
            ],
        ]);

        if (!$response->successful()) {
            throw new \Exception('Runpod API request failed: ' . $response->body());
        }

        $data = $response->json();

        if (isset($data['error'])) {
            throw new \Exception('Runpod API error: ' . $data['error']);
        }

        $output = $data['output'] ?? [];
        $choices = $output['choices'] ?? [];

        if (empty($choices)) {
            throw new \Exception('No content generated from AI service');
        }

        return $choices[0]['message']['content'] ?? '';
    }

    /**
     * Mock article generator for development/testing
     */
    protected function generateMockArticle(string $context, string $prompt): string
    {
        return "# Generated Article\n\n" .
               "This is a mock article generated based on the scraped content.\n\n" .
               "## Overview\n\n" .
               "The AI was instructed to: {$prompt}\n\n" .
               "## Content Summary\n\n" .
               "This article was generated from " . count($this->scrapedContentIds) . " scraped content items.\n\n" .
               "## Conclusion\n\n" .
               "Replace this mock implementation with your Runpod integration.\n\n" .
               "_Generated at: " . now()->toDateTimeString() . "_";
    }

    protected function extractTitle(string $content): string
    {
        // Try to extract first line as title
        $lines = explode("\n", trim($content));
        $firstLine = trim($lines[0]);

        // Remove markdown heading syntax if present
        $title = preg_replace('/^#+\s*/', '', $firstLine);

        // If title is too long or empty, use a substring
        if (empty($title) || strlen($title) > 200) {
            $title = substr(strip_tags($content), 0, 100) . '...';
        }

        return $title;
    }
}
