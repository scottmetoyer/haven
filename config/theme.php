<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Theme
    |--------------------------------------------------------------------------
    |
    | This value determines which theme configuration to use for the site.
    | You can define multiple themes below and switch between them using
    | the SITE_THEME environment variable.
    |
    */

    'current' => env('SITE_THEME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Theme Configurations
    |--------------------------------------------------------------------------
    |
    | Define all your site themes here. Each theme can have its own colors,
    | logos, and branding assets. This allows you to run multiple affiliate
    | sites from a single codebase.
    |
    */

    'themes' => [
        'default' => [
            'name' => env('APP_NAME', 'Haven'),
            'tagline' => env('SITE_TAGLINE', 'Your Affiliate Site'),
            'description' => env('SITE_DESCRIPTION', 'Default site description for SEO'),
            'logo' => env('SITE_LOGO', 'logo-default.png'),
            'favicon' => env('SITE_FAVICON', 'favicon-default.ico'),
            'colors' => [
                'primary' => env('SITE_PRIMARY_COLOR', '#3B82F6'),
                'secondary' => env('SITE_SECONDARY_COLOR', '#8B5CF6'),
                'accent' => env('SITE_ACCENT_COLOR', '#10B981'),
                'background' => env('SITE_BACKGROUND_COLOR', '#F3F4F6'),
                'text' => env('SITE_TEXT_COLOR', '#1F2937'),
            ],
            'fonts' => [
                'heading' => env('SITE_FONT_HEADING', 'Figtree'),
                'body' => env('SITE_FONT_BODY', 'Figtree'),
            ],
            'social' => [
                'twitter' => env('SITE_TWITTER', ''),
                'facebook' => env('SITE_FACEBOOK', ''),
                'instagram' => env('SITE_INSTAGRAM', ''),
                'linkedin' => env('SITE_LINKEDIN', ''),
            ],
            'analytics' => [
                'google_analytics' => env('GOOGLE_ANALYTICS_ID', ''),
                'google_tag_manager' => env('GOOGLE_TAG_MANAGER_ID', ''),
            ],
        ],

        // Example of additional theme configurations
        // 'tech-affiliate' => [
        //     'name' => 'Tech Reviews',
        //     'tagline' => 'Best Tech Product Reviews',
        //     'description' => 'Find the best tech products and deals',
        //     'logo' => 'logo-tech.png',
        //     'favicon' => 'favicon-tech.ico',
        //     'colors' => [
        //         'primary' => '#0EA5E9',
        //         'secondary' => '#6366F1',
        //         'accent' => '#14B8A6',
        //         'background' => '#FFFFFF',
        //         'text' => '#0F172A',
        //     ],
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Asset Paths
    |--------------------------------------------------------------------------
    |
    | Define the directory structure for theme assets.
    |
    */

    'asset_paths' => [
        'logos' => 'images/logos',
        'favicons' => 'images/favicons',
        'themes' => 'themes',
    ],

];
