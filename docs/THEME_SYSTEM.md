# Multi-Site Theme System

The Haven theme system allows you to run multiple affiliate sites from a single codebase by configuring themes via environment variables.

## Quick Start

### 1. Configure Your Theme

Add theme configuration to your `.env` file:

```env
APP_NAME="My Affiliate Site"
SITE_THEME=default
SITE_PRIMARY_COLOR=#3B82F6
SITE_SECONDARY_COLOR=#8B5CF6
SITE_LOGO=logo-default.png
SITE_FAVICON=favicon-default.ico
SITE_TAGLINE="Your Affiliate Site Tagline"
SITE_DESCRIPTION="SEO-optimized description of your affiliate site"
```

### 2. Add Your Assets

Place your logo and favicon files in:
- Logos: `public/images/logos/`
- Favicons: `public/images/favicons/`

### 3. Use Theme Functions

In your Blade templates:

```blade
{{-- Get site name --}}
{{ theme()->name() }}

{{-- Get tagline --}}
{{ theme()->tagline() }}

{{-- Get logo URL --}}
<img src="{{ theme()->logo() }}" alt="{{ theme()->name() }}">

{{-- Get specific color --}}
<div style="background-color: {{ theme()->color('primary') }}">

{{-- Get any theme value using dot notation --}}
{{ theme('colors.primary') }}
{{ theme('social.twitter') }}
```

## Theme Configuration

### Available Environment Variables

```env
# Basic Site Info
APP_NAME=Site Name
SITE_THEME=default
SITE_TAGLINE="Your tagline"
SITE_DESCRIPTION="Your SEO description"

# Branding Assets
SITE_LOGO=logo.png
SITE_FAVICON=favicon.ico

# Colors (Hex values)
SITE_PRIMARY_COLOR=#3B82F6
SITE_SECONDARY_COLOR=#8B5CF6
SITE_ACCENT_COLOR=#10B981
SITE_BACKGROUND_COLOR=#F3F4F6
SITE_TEXT_COLOR=#1F2937

# Fonts
SITE_FONT_HEADING=Figtree
SITE_FONT_BODY=Figtree

# Social Media
SITE_TWITTER=https://twitter.com/yoursite
SITE_FACEBOOK=https://facebook.com/yoursite
SITE_INSTAGRAM=https://instagram.com/yoursite
SITE_LINKEDIN=https://linkedin.com/company/yoursite

# Analytics
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
GOOGLE_TAG_MANAGER_ID=GTM-XXXXXXX
```

### Defining Custom Themes

You can define multiple theme presets in `config/theme.php`:

```php
'themes' => [
    'default' => [
        'name' => env('APP_NAME', 'Haven'),
        'colors' => [
            'primary' => env('SITE_PRIMARY_COLOR', '#3B82F6'),
            // ...
        ],
    ],

    'tech-reviews' => [
        'name' => 'Tech Reviews Pro',
        'tagline' => 'Best Tech Product Reviews',
        'colors' => [
            'primary' => '#0EA5E9',
            'secondary' => '#6366F1',
        ],
        'logo' => 'logo-tech.png',
    ],
],
```

Then switch themes by setting: `SITE_THEME=tech-reviews`

## Theme Service Methods

### Basic Methods

```php
theme()->name()           // Get site name
theme()->tagline()        // Get tagline
theme()->description()    // Get description
theme()->current()        // Get current theme name
theme()->config()         // Get full theme config array
```

### Assets

```php
theme()->logo()           // Get logo URL
theme()->favicon()        // Get favicon URL
```

### Colors

```php
theme()->colors()         // Get all colors array
theme()->color('primary') // Get specific color
theme()->color('accent', '#000000') // With default fallback
```

### Other

```php
theme()->social()         // Get all social links
theme()->analytics()      // Get analytics config
theme()->fonts()          // Get fonts config
theme()->cssVariables()   // Generate CSS variables string
```

### Generic Get Method

```php
// Use dot notation to access any nested value
theme()->get('colors.primary')
theme()->get('social.twitter')
theme()->get('analytics.google_analytics')
```

## CSS Variables

The theme system automatically generates CSS variables in the `<x-theme-styles />` component:

```css
:root {
    --color-primary: #3B82F6;
    --color-secondary: #8B5CF6;
    --color-accent: #10B981;
    --color-background: #F3F4F6;
    --color-text: #1F2937;
}
```

Pre-defined utility classes:
- `.bg-primary`, `.bg-secondary`, `.bg-accent`
- `.text-primary`, `.text-secondary`, `.text-accent`
- `.border-primary`, `.border-secondary`, `.border-accent`
- `.hover:bg-primary`, `.hover:text-primary`

## Creating New Affiliate Sites

### Option 1: Same Codebase, Different .env

1. Copy your `.env` file to `.env.site2`
2. Update all `SITE_*` variables
3. Point your web server to use the different env file

### Option 2: Separate Deployments

1. Clone/copy the codebase
2. Update `.env` with new theme settings
3. Add new logo/favicon files
4. Deploy to new domain

### Option 3: Database-per-Site

1. Use the same codebase
2. Configure different `DB_DATABASE` in each `.env`
3. Run migrations for each database
4. Configure web server to route domains to appropriate env files

## Analytics Integration

Google Analytics is automatically integrated when you set:

```env
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
```

The tracking code is automatically included in all public-facing pages.

## Best Practices

1. **Asset Naming**: Use descriptive names for multi-site assets:
   - `logo-techsite.png`
   - `logo-homesite.png`
   - `favicon-techsite.ico`

2. **Color Consistency**: Use your theme colors consistently throughout your site for brand recognition

3. **SEO**: Always set meaningful `SITE_DESCRIPTION` and `SITE_TAGLINE` for each site

4. **Testing**: Test theme switching locally before deploying new sites

5. **Version Control**: Keep different site configs in separate `.env.example.sitename` files for reference
