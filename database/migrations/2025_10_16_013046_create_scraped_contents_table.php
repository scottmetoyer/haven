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
        Schema::create('scraped_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_site_id')->constrained()->onDelete('cascade');
            $table->string('content_url');
            $table->string('content_identifier')->nullable(); // video ID, SKU, etc.
            $table->string('title')->nullable();
            $table->timestamp('discovered_at');
            $table->timestamp('processed_at')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->foreignId('article_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();

            // Indexes
            $table->index(['affiliate_site_id', 'status']);
            $table->unique(['affiliate_site_id', 'content_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraped_contents');
    }
};
