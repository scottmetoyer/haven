<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class ArticleFooterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['theme.current' => 'default']);
        config(['theme.themes.default' => [
            'name' => 'Test Site',
            'tagline' => 'Test Tagline',
            'description' => 'Test Description',
        ]]);
    }

    public function test_footer_appears_on_articles_index(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee('x-public-footer', false);
        $response->assertSee('Legal');
        $response->assertSee('Privacy Policy');
        $response->assertSee('Terms of Service');
    }

    public function test_footer_appears_on_article_show_page(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create([
            'user_id' => $user->id,
            'published' => true,
            'published_at' => now(),
        ]);

        $response = $this->get(route('articles.show', $article->slug));

        $response->assertSee('x-public-footer', false);
        $response->assertSee('Legal');
        $response->assertSee('Privacy Policy');
    }

    public function test_article_pages_have_flex_layout_for_footer(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee('flex flex-col', false);
        $response->assertSee('flex-grow', false);
    }

    public function test_article_show_page_has_flex_layout_for_footer(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create([
            'user_id' => $user->id,
            'published' => true,
            'published_at' => now(),
        ]);

        $response = $this->get(route('articles.show', $article->slug));

        $response->assertSee('flex flex-col', false);
        $response->assertSee('flex-grow', false);
    }

    public function test_footer_links_are_clickable_on_article_pages(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee(route('page.privacy'), false);
        $response->assertSee(route('page.terms'), false);
        $response->assertSee(route('page.dmca'), false);
        $response->assertSee(route('page.disclaimer'), false);
        $response->assertSee(route('page.contact'), false);
    }

    public function test_footer_displays_site_info_on_article_pages(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee('Test Site');
        $response->assertSee('Test Tagline');
    }

    public function test_footer_copyright_appears_on_article_pages(): void
    {
        $response = $this->get(route('articles.index'));

        $currentYear = date('Y');
        $response->assertSee("© {$currentYear}");
        $response->assertSee('All rights reserved');
    }
}
