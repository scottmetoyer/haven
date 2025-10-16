# Review Generation Pipeline

## Overview
Automated system for scraping affiliate sites, detecting new content, and generating AI-powered reviews that are published as articles on the site.

## Architecture

### 1. Scheduled Laravel Job
- **Execution**: Runs at regular intervals via hosting scheduler process
- **Purpose**: Orchestrate the entire review generation workflow

### 2. Content Discovery Phase

#### Scraping Strategies (Hybrid Approach)
The system supports multiple scraping methods per affiliate site:

1. **RSS/Atom Feeds** (Preferred - most reliable)
   - Use standard feed URLs
   - Built-in timestamps via `<pubDate>` tags
   - No custom parsing needed

2. **CSS Selector Scraping** (For simple HTML sites)
   - Configure selectors in admin UI per site
   - Extract: content list, item containers, titles, URLs, dates
   - Good for straightforward site structures

3. **XPath Scraping** (For complex HTML)
   - More powerful than CSS selectors
   - Handles complex DOM structures and attributes
   - Steeper learning curve for admins

4. **Custom Scraper Classes** (For APIs & complex sites)
   - PHP classes implementing `ScraperInterface`
   - Handle authentication, pagination, API calls
   - Examples: `YouTubeChannelScraper`, `VimeoScraper`
   - Requires code deployment for new scrapers

#### New Content Detection (Content Fingerprinting)
Uses URL-based duplicate detection instead of date parsing:

**Detection Algorithm:**
1. Scraper fetches current content list from affiliate site
2. Extract content URLs and/or unique identifiers (video IDs, SKUs, etc.)
3. Query database: Find URLs that don't exist in `ScrapedContent` table
4. New URLs = new content to process
5. Update `AffiliateSite.last_scraped_at` timestamp

**Benefits:**
- No complex date parsing needed
- Handles sites with inconsistent date formats
- Prevents duplicate processing
- Enables retry of failed items
- Maintains historical record

**Fallback for Date-Based Detection:**
- If unique URLs aren't available, configure date selector
- Store `latest_content_date` on AffiliateSite model
- Process only items newer than this threshold

### 3. Data Storage

#### ScrapedContent Model
Tracks all discovered content and processing status:
- `affiliate_site_id` - Foreign key to source site
- `content_url` - Full URL to the content (unique per site)
- `content_identifier` - Optional unique ID (video ID, SKU, slug)
- `title` - Extracted content title
- `discovered_at` - Timestamp when first found
- `processed_at` - Nullable, when review generation completed
- `status` - Enum: pending, processing, completed, failed
- `error_message` - Nullable, stores failure reasons
- `article_id` - Nullable, foreign key to generated article

### 4. AI Review Generation

#### RunPod Integration
- **Service**: RunPod Serverless API
- **Input**:
  - Content URL
  - Custom prompt for review generation
- **Process**:
  1. Pass URL to RunPod API
  2. AI analyzes the content
  3. AI generates review article

#### Review Prompt Structure
- Request AI to create a review for the linked content
- Include affiliate context
- Maintain SEO optimization guidelines

### 5. Article Publication

#### Auto-Publishing
- Receive AI-generated review content from RunPod
- Create new article in database
- **Include**: Affiliate links to source content
- Set appropriate metadata (tags, categories, etc.)

## Business Goal
**Traffic & Revenue Generation**
- Automatically publish reviews of new affiliate content
- Drive traffic to affiliate sites via embedded links
- Generate commission revenue from affiliate program

## Multi-Site Support
- Pipeline supports multiple Haven sites via environment configuration
- Each site can have its own:
  - List of affiliate sites to scrape
  - AI prompt templates
  - Publishing rules

## Future Enhancements
- Email notifications for new reviews published
- Quality checks before auto-publishing
- Manual review queue option
- Performance analytics per affiliate site
- A/B testing for review formats

## Technical Stack
- **Framework**: Laravel scheduled jobs
- **Scraping**: TBD (Laravel HTTP client, Guzzle, or specialized scraper)
- **AI Service**: RunPod Serverless API
- **Storage**: Laravel Eloquent models
- **Scheduling**: Hosting provider's cron/scheduler

## Admin Configuration
All pipeline settings will be managed through the admin backend UI:

### Affiliate Sites Management
Admin UI for managing monitored sites:

**Basic Settings:**
- Site name and base URL
- Enable/disable toggle
- Scraping interval (hourly, daily, weekly, custom cron)
- Last scraped timestamp (read-only)

**Scraping Strategy Configuration:**
- Strategy selector: RSS Feed / CSS Selectors / XPath / Custom Class
- **If RSS Feed:**
  - Feed URL input field
- **If CSS Selectors:**
  - Content list selector
  - Content item selector
  - Title selector
  - URL selector
  - Date selector (optional)
- **If XPath:**
  - Similar fields but for XPath expressions
- **If Custom Class:**
  - Class name dropdown (e.g., YouTubeChannelScraper)
  - Custom configuration JSON field

**Affiliate Settings:**
- Affiliate program ID/tracking code
- Link insertion rules
- Custom metadata for this source

### RunPod API Settings
- API endpoint URL
- API credentials/tokens
- Timeout settings
- Rate limiting configuration

### Review Generation Settings
- Custom AI prompt templates (editable text)
- Review format preferences
- SEO keyword guidelines
- Auto-publish vs. draft mode toggle

### Processing Rules
- Auto-publish thresholds
- Content filters/blacklists
- Affiliate link insertion rules
- Category/tag assignment rules

### Database Models & Schema

#### AffiliateSite Model
```php
- id
- name (string)
- base_url (string)
- is_enabled (boolean, default: true)
- scrape_strategy (enum: 'rss', 'css', 'xpath', 'custom')
- scrape_interval (string, cron expression)
- last_scraped_at (timestamp, nullable)

// Strategy-specific config (JSON columns)
- rss_config (json, nullable)
  // { feed_url: "..." }
- css_config (json, nullable)
  // { list_selector: "...", item_selector: "...", title_selector: "...", url_selector: "...", date_selector: "..." }
- xpath_config (json, nullable)
  // Similar to css_config but with xpath expressions
- custom_config (json, nullable)
  // { scraper_class: "YouTubeChannelScraper", options: {...} }

// Affiliate tracking
- affiliate_program_id (string, nullable)
- affiliate_tracking_code (string, nullable)
- link_insertion_rules (json, nullable)

// Fallback date tracking
- latest_content_date (timestamp, nullable)

- created_at
- updated_at
```

#### ScrapedContent Model
```php
- id
- affiliate_site_id (foreign key)
- content_url (string, unique composite with affiliate_site_id)
- content_identifier (string, nullable) // video ID, SKU, etc.
- title (string, nullable)
- discovered_at (timestamp)
- processed_at (timestamp, nullable)
- status (enum: 'pending', 'processing', 'completed', 'failed')
- error_message (text, nullable)
- article_id (foreign key, nullable)
- created_at
- updated_at

// Indexes
- Index on: affiliate_site_id, status
- Unique index on: affiliate_site_id, content_url
```

#### ReviewGenerationSetting Model
```php
- id
- setting_key (string, unique)
- setting_value (json)
- created_at
- updated_at

// Example settings:
// - runpod_api_endpoint
// - runpod_api_key
// - default_review_prompt_template
// - auto_publish_enabled
// - rate_limit_per_hour
```

#### Article Model Extension
Add new fields:
```php
- is_ai_generated (boolean, default: false)
- scraped_content_id (foreign key, nullable)
```

## Status
**Planning Phase** - Architecture documented, implementation pending
