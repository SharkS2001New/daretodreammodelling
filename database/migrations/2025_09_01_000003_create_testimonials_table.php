<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Backfilled: this table existed in production before it was ever migrated,
// so the create is guarded to stay a no-op there. The cover_image/youtube_link
// columns are added by 2025_09_15_125905.
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('testimonials')) {
            return;
        }

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('job_title')->nullable();
            $table->string('profile_picture')->nullable();
            $table->text('testimony');
            $table->unsignedTinyInteger('ratings')->default(5);
            $table->string('media_type')->default('cover');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
