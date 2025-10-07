<?php

use App\Services\ThemeService;

if (!function_exists('theme')) {
    /**
     * Get the theme service instance or a specific theme value
     */
    function theme(?string $key = null, mixed $default = null): mixed
    {
        $theme = app(ThemeService::class);

        if (is_null($key)) {
            return $theme;
        }

        return $theme->get($key, $default);
    }
}
