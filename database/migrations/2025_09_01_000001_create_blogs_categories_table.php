<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Backfilled: this table existed in production before it was ever migrated,
// so the create is guarded to stay a no-op there.
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('blogs_categories')) {
            return;
        }

        Schema::create('blogs_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('blogs_category_title')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs_categories');
    }
};
