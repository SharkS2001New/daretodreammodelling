<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Backfilled: these columns were added to production by hand before being
// migrated, so each is guarded to stay a no-op there.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('name');
            }
            if (! Schema::hasColumn('users', 'last_login')) {
                $table->timestamp('last_login')->nullable()->after('remember_token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['slug', 'last_login']);
        });
    }
};
