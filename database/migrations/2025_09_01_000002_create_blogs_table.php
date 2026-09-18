<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Backfilled: this table existed in production before it was ever migrated,
// so the create is guarded to stay a no-op there. The model/photographer/
// magazine/brand columns are added by 2025_09_16_085108.
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('blogs')) {
            return;
        }

        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('image')->nullable();
            $table->foreignId('blogs_category_id')->constrained('blogs_categories')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('read_time')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
