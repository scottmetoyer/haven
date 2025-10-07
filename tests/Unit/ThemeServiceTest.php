<?php

namespace Tests\Unit;

use App\Services\ThemeService;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ThemeServiceTest extends TestCase
{
    protected ThemeService $themeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->themeService = new ThemeService();
    }

    public function test_current_returns_default_theme(): void
    {
        Config::set('theme.current', 'default');

        $this->assertEquals('default', $this->themeService->current());
    }

    public function test_config_returns_theme_configuration(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', [
            'name' => 'Test Site',
            'colors' => ['primary' => '#FF0000'],
        ]);

        $config = $this->themeService->config();

        $this->assertIsArray($config);
        $this->assertEquals('Test Site', $config['name']);
        $this->assertEquals('#FF0000', $config['colors']['primary']);
    }

    public function test_get_retrieves_specific_value(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', [
            'name' => 'Test Site',
            'colors' => ['primary' => '#FF0000'],
        ]);

        $this->assertEquals('Test Site', $this->themeService->get('name'));
        $this->assertEquals('#FF0000', $this->themeService->get('colors.primary'));
    }

    public function test_get_returns_default_when_key_not_found(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', []);

        $this->assertEquals('default-value', $this->themeService->get('nonexistent', 'default-value'));
    }

    public function test_name_returns_site_name(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', ['name' => 'My Affiliate Site']);

        $this->assertEquals('My Affiliate Site', $this->themeService->name());
    }

    public function test_name_falls_back_to_app_name(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', []);
        Config::set('app.name', 'Laravel App');

        $this->assertEquals('Laravel App', $this->themeService->name());
    }

    public function test_tagline_returns_site_tagline(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', ['tagline' => 'Best Tech Reviews']);

        $this->assertEquals('Best Tech Reviews', $this->themeService->tagline());
    }

    public function test_description_returns_site_description(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', ['description' => 'SEO description']);

        $this->assertEquals('SEO description', $this->themeService->description());
    }

    public function test_colors_returns_color_array(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', [
            'colors' => [
                'primary' => '#3B82F6',
                'secondary' => '#8B5CF6',
            ],
        ]);

        $colors = $this->themeService->colors();

        $this->assertIsArray($colors);
        $this->assertEquals('#3B82F6', $colors['primary']);
        $this->assertEquals('#8B5CF6', $colors['secondary']);
    }

    public function test_color_returns_specific_color(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', [
            'colors' => ['primary' => '#3B82F6'],
        ]);

        $this->assertEquals('#3B82F6', $this->themeService->color('primary'));
    }

    public function test_color_returns_default_when_not_found(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', ['colors' => []]);

        $this->assertEquals('#FFFFFF', $this->themeService->color('nonexistent', '#FFFFFF'));
    }

    public function test_logo_returns_asset_url(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', ['logo' => 'logo-test.png']);
        Config::set('theme.asset_paths.logos', 'images/logos');

        $logoUrl = $this->themeService->logo();

        $this->assertStringContainsString('images/logos/logo-test.png', $logoUrl);
    }

    public function test_favicon_returns_asset_url(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', ['favicon' => 'favicon-test.ico']);
        Config::set('theme.asset_paths.favicons', 'images/favicons');

        $faviconUrl = $this->themeService->favicon();

        $this->assertStringContainsString('images/favicons/favicon-test.ico', $faviconUrl);
    }

    public function test_social_returns_social_links(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', [
            'social' => [
                'twitter' => 'https://twitter.com/test',
                'facebook' => 'https://facebook.com/test',
            ],
        ]);

        $social = $this->themeService->social();

        $this->assertIsArray($social);
        $this->assertEquals('https://twitter.com/test', $social['twitter']);
        $this->assertEquals('https://facebook.com/test', $social['facebook']);
    }

    public function test_analytics_returns_analytics_config(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', [
            'analytics' => [
                'google_analytics' => 'GA-12345',
            ],
        ]);

        $analytics = $this->themeService->analytics();

        $this->assertIsArray($analytics);
        $this->assertEquals('GA-12345', $analytics['google_analytics']);
    }

    public function test_fonts_returns_fonts_config(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', [
            'fonts' => [
                'heading' => 'Roboto',
                'body' => 'Open Sans',
            ],
        ]);

        $fonts = $this->themeService->fonts();

        $this->assertIsArray($fonts);
        $this->assertEquals('Roboto', $fonts['heading']);
        $this->assertEquals('Open Sans', $fonts['body']);
    }

    public function test_css_variables_generates_valid_css(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', [
            'colors' => [
                'primary' => '#3B82F6',
                'secondary' => '#8B5CF6',
            ],
        ]);

        $css = $this->themeService->cssVariables();

        $this->assertStringContainsString(':root {', $css);
        $this->assertStringContainsString('--color-primary: #3B82F6;', $css);
        $this->assertStringContainsString('--color-secondary: #8B5CF6;', $css);
        $this->assertStringContainsString('}', $css);
    }

    public function test_theme_helper_function_returns_service_instance(): void
    {
        $theme = theme();

        $this->assertInstanceOf(ThemeService::class, $theme);
    }

    public function test_theme_helper_function_with_key_returns_value(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', [
            'name' => 'Helper Test Site',
        ]);

        $name = theme('name');

        $this->assertEquals('Helper Test Site', $name);
    }

    public function test_theme_helper_function_with_default_value(): void
    {
        Config::set('theme.current', 'default');
        Config::set('theme.themes.default', []);

        $value = theme('nonexistent.key', 'fallback');

        $this->assertEquals('fallback', $value);
    }

    public function test_multiple_themes_can_be_switched(): void
    {
        Config::set('theme.themes', [
            'default' => ['name' => 'Default Site'],
            'tech' => ['name' => 'Tech Site'],
        ]);

        Config::set('theme.current', 'default');
        $this->assertEquals('Default Site', $this->themeService->name());

        Config::set('theme.current', 'tech');
        // Create new instance to pick up config change
        $themeService = new ThemeService();
        $this->assertEquals('Tech Site', $themeService->name());
    }
}
