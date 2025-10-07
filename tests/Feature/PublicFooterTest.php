<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicFooterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Set up test theme configuration
        config(['theme.current' => 'default']);
        config(['theme.themes.default' => [
            'name' => 'Test Site',
            'tagline' => 'Test Tagline',
            'description' => 'Test Description',
            'social' => [
                'twitter' => 'https://twitter.com/test',
                'facebook' => 'https://facebook.com/test',
                'instagram' => 'https://instagram.com/test',
            ],
        ]]);
    }

    public function test_footer_appears_on_article_index(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee('x-public-footer', false);
    }

    public function test_footer_contains_site_name(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee('Test Site');
    }

    public function test_footer_contains_legal_links(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee(route('page.privacy'), false);
        $response->assertSee(route('page.terms'), false);
        $response->assertSee(route('page.dmca'), false);
        $response->assertSee(route('page.disclaimer'), false);
    }

    public function test_footer_displays_legal_section_heading(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee('Legal');
        $response->assertSee('Privacy Policy');
        $response->assertSee('Terms of Service');
        $response->assertSee('DMCA Takedown');
        $response->assertSee('Affiliate Disclaimer');
    }

    public function test_footer_contains_social_links_when_configured(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee('https://twitter.com/test', false);
        $response->assertSee('https://facebook.com/test', false);
        $response->assertSee('https://instagram.com/test', false);
    }

    public function test_footer_does_not_show_social_links_when_not_configured(): void
    {
        config(['theme.themes.default.social' => []]);

        $response = $this->get(route('articles.index'));

        $response->assertDontSee('twitter.com');
        $response->assertDontSee('facebook.com');
    }

    public function test_footer_contains_contact_link(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee(route('page.contact'), false);
        $response->assertSee('Contact Us');
    }

    public function test_footer_displays_copyright_with_current_year(): void
    {
        $response = $this->get(route('articles.index'));

        $currentYear = date('Y');
        $response->assertSee("© {$currentYear}");
        $response->assertSee('Test Site');
        $response->assertSee('All rights reserved');
    }

    public function test_footer_displays_tagline_when_available(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee('Test Tagline');
    }

    public function test_footer_shows_description_when_tagline_not_available(): void
    {
        config(['theme.themes.default.tagline' => '']);

        $response = $this->get(route('articles.index'));

        $response->assertSee('Test Description');
    }

    public function test_footer_has_connect_section(): void
    {
        $response = $this->get(route('articles.index'));

        $response->assertSee('Connect');
    }

    public function test_footer_social_links_have_correct_attributes(): void
    {
        $response = $this->get(route('articles.index'));

        // Check for rel attributes on external links
        $response->assertSee('target="_blank"', false);
        $response->assertSee('rel="noopener noreferrer"', false);
    }

    public function test_footer_component_can_be_rendered(): void
    {
        $view = $this->blade('<x-public-footer />');

        $view->assertSee('Legal');
        $view->assertSee('Connect');
    }
}
