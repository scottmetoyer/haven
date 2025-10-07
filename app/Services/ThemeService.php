<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

class ThemeService
{
    /**
     * Get the current theme name
     */
    public function current(): string
    {
        return Config::get('theme.current', 'default');
    }

    /**
     * Get the current theme configuration
     */
    public function config(): array
    {
        $current = $this->current();
        return Config::get("theme.themes.{$current}", Config::get('theme.themes.default'));
    }

    /**
     * Get a specific theme value
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $config = $this->config();

        return data_get($config, $key, $default);
    }

    /**
     * Get theme colors
     */
    public function colors(): array
    {
        return $this->get('colors', []);
    }

    /**
     * Get a specific color
     */
    public function color(string $name, string $default = '#000000'): string
    {
        return $this->get("colors.{$name}", $default);
    }

    /**
     * Get the site name
     */
    public function name(): string
    {
        return $this->get('name', Config::get('app.name', 'Haven'));
    }

    /**
     * Get the site tagline
     */
    public function tagline(): string
    {
        return $this->get('tagline', '');
    }

    /**
     * Get the site description
     */
    public function description(): string
    {
        return $this->get('description', '');
    }

    /**
     * Get the logo path
     */
    public function logo(): string
    {
        $logo = $this->get('logo', 'logo-default.png');
        $path = Config::get('theme.asset_paths.logos', 'images/logos');

        return asset("{$path}/{$logo}");
    }

    /**
     * Get the favicon path
     */
    public function favicon(): string
    {
        $favicon = $this->get('favicon', 'favicon-default.ico');
        $path = Config::get('theme.asset_paths.favicons', 'images/favicons');

        return asset("{$path}/{$favicon}");
    }

    /**
     * Get social media links
     */
    public function social(): array
    {
        return $this->get('social', []);
    }

    /**
     * Get analytics configuration
     */
    public function analytics(): array
    {
        return $this->get('analytics', []);
    }

    /**
     * Get fonts configuration
     */
    public function fonts(): array
    {
        return $this->get('fonts', []);
    }

    /**
     * Generate CSS variables for the theme
     */
    public function cssVariables(): string
    {
        $colors = $this->colors();
        $css = ':root {';

        foreach ($colors as $name => $value) {
            $css .= "--color-{$name}: {$value};";
        }

        $css .= '}';

        return $css;
    }
}
