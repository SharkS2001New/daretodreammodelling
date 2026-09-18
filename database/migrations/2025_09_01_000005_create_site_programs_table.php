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
        if (Schema::hasTable('site_programs')) {
            return;
        }

        Schema::create('site_programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_programs');
    }
};
