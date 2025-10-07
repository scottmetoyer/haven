<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicLayoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['theme.current' => 'default']);
        config(['theme.themes.default' => [
            'name' => 'Layout Test Site',
            'tagline' => 'Layout Test Tagline',
            'description' => 'Layout test description',
            'logo' => 'logo-test.png',
            'favicon' => 'favicon-test.ico',
            'colors' => [
                'primary' => '#FF0000',
                'secondary' => '#00FF00',
            ],
            'analytics' => [
                'google_analytics' => 'GA-TEST-123',
            ],
        ]]);
        config(['theme.asset_paths.logos' => 'images/logos']);
        config(['theme.asset_paths.favicons' => 'images/favicons']);
    }

    public function test_public_layout_includes_meta_description(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('<meta name="description"', false);
        $response->assertSee('Layout test description', false);
    }

    public function test_public_layout_includes_favicon(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('favicon-test.ico', false);
        $response->assertSee('rel="icon"', false);
    }

    public function test_public_layout_includes_theme_styles(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('x-theme-styles', false);
    }

    public function test_public_layout_includes_vite_assets(): void
    {
        $response = $this->get(route('page.privacy'));

        // Vite should inject asset tags
        $response->assertSee('resources/css/app.css', false);
        $response->assertSee('resources/js/app.js', false);
    }

    public function test_public_layout_includes_google_analytics_when_configured(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('GA-TEST-123');
        $response->assertSee('googletagmanager.com/gtag/js');
    }

    public function test_public_layout_excludes_google_analytics_when_not_configured(): void
    {
        config(['theme.themes.default.analytics.google_analytics' => '']);

        $response = $this->get(route('page.privacy'));

        $response->assertDontSee('googletagmanager.com/gtag/js');
    }

    public function test_public_layout_includes_navigation(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('Layout Test Site');
        $response->assertSee(route('home'), false);
    }

    public function test_public_layout_shows_tagline_in_navigation(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('Layout Test Tagline');
    }

    public function test_public_layout_shows_login_link_for_guests(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee(route('login'), false);
        $response->assertSee('Login');
    }

    public function test_public_layout_shows_dashboard_link_for_authenticated_users(): void
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('page.privacy'));

        $response->assertSee('Dashboard');
        $response->assertSee('Manage Articles');
    }

    public function test_public_layout_includes_footer(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('x-public-footer', false);
    }

    public function test_public_layout_has_flex_layout_structure(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('flex flex-col', false);
        $response->assertSee('flex-grow', false);
    }

    public function test_public_layout_uses_correct_lang_attribute(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('<html lang="en">', false);
    }

    public function test_public_layout_title_can_be_customized(): void
    {
        $view = $this->blade(
            '<x-layouts.public title="Custom Title">Content</x-layouts.public>'
        );

        $view->assertSee('<title>Custom Title</title>', false);
    }

    public function test_public_layout_uses_theme_name_as_default_title(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('Privacy Policy - Layout Test Site');
    }

    public function test_public_layout_meta_description_can_be_customized(): void
    {
        $view = $this->blade(
            '<x-layouts.public :metaDescription="\'Custom Description\'">Content</x-layouts.public>'
        );

        $view->assertSee('Custom Description', false);
    }

    public function test_public_layout_renders_slot_content(): void
    {
        $view = $this->blade(
            '<x-layouts.public><div>Test Content</div></x-layouts.public>'
        );

        $view->assertSee('Test Content');
    }

    public function test_public_layout_has_responsive_meta_viewport(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('<meta name="viewport" content="width=device-width, initial-scale=1">', false);
    }

    public function test_public_layout_has_proper_html_structure(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('<!DOCTYPE html>', false);
        $response->assertSee('</html>', false);
        $response->assertSee('<head>', false);
        $response->assertSee('</head>', false);
        $response->assertSee('<body', false);
        $response->assertSee('</body>', false);
    }
}
