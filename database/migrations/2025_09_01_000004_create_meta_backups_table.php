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
        if (Schema::hasTable('meta_backups')) {
            return;
        }

        Schema::create('meta_backups', function (Blueprint $table) {
            $table->id();
            $table->json('data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_backups');
    }
};
