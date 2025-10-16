<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('affiliate_sites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('base_url');
            $table->boolean('is_enabled')->default(true);
            $table->enum('scrape_strategy', ['rss', 'css', 'xpath', 'custom']);
            $table->string('scrape_interval')->default('0 */6 * * *'); // Every 6 hours by default
            $table->timestamp('last_scraped_at')->nullable();

            // Strategy-specific config (JSON columns)
            $table->json('rss_config')->nullable();
            $table->json('css_config')->nullable();
            $table->json('xpath_config')->nullable();
            $table->json('custom_config')->nullable();

            // Affiliate tracking
            $table->string('affiliate_program_id')->nullable();
            $table->string('affiliate_tracking_code')->nullable();
            $table->json('link_insertion_rules')->nullable();

            // Fallback date tracking
            $table->timestamp('latest_content_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_sites');
    }
};
