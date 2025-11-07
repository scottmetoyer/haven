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
     * Call AI service - placeholder for Runpod integration
     * TODO: Replace with actual Runpod API integration
     */
    protected function callAIService(string $context, string $prompt): string
    {
        // Placeholder implementation
        // Replace this with your Runpod API call

        $apiEndpoint = config('services.runpod.endpoint');

        if (empty($apiEndpoint)) {
            // Fallback to mock response for development
            return $this->generateMockArticle($context, $prompt);
        }

        // TODO: Implement actual Runpod API call
        $response = Http::timeout(120)->post($apiEndpoint, [
            'context' => $context,
            'prompt' => $prompt,
            // Add other parameters as needed for your Runpod setup
        ]);

        if (!$response->successful()) {
            throw new \Exception('AI API request failed: ' . $response->body());
        }

        return $response->json()['generated_text'] ?? '';
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
