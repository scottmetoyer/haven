# Haven - Laravel Article Site

## Project Overview
This is a Laravel-based **affiliate site template** designed for SEO-optimized content and affiliate traffic generation.

### Purpose
- **Base template** for creating multiple affiliate sites (blogs with external links)
- Sites will be copied and customized from this base
- Focus on SEO optimization and traffic generation
- **Multi-site architecture**: Single codebase supports multiple sites via environment variables

### Key Features
- Admins can login and create articles
- Unauthenticated front end for viewing articles
- **Scheduled jobs** for automated content management:
  - Scrape affiliated sites for new content
  - Send summary emails with new content alerts
  - AI-powered article generation (planned)
- **Theme system**: Environment-based configuration for:
  - Site themes and colors
  - Logo images
  - Other branding assets
  - All assets stored in single project

## Development Environment
- **Backend**: Docker on dev workstation
- **Artisan alias**: `a` (ALWAYS use `a` instead of `php artisan`)

## Commands
- `a migrate` - Run migrations
- `a make:model` - Create models
- `a make:controller` - Create controllers
- `a tinker` - Laravel REPL
- `a test` - Run tests
- `a test --filter=TestName` - Run specific test
