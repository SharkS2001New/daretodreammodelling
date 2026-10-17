<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// tiktok_url was already in LinkedAccount::$fillable and rendered on the public
// profile, but the column was never created, so the link could never show.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('linked_accounts', function (Blueprint $table) {
            if (! Schema::hasColumn('linked_accounts', 'facebook_url')) {
                $table->string('facebook_url')->nullable()->after('user_id');
            }
            if (! Schema::hasColumn('linked_accounts', 'tiktok_url')) {
                $table->string('tiktok_url')->nullable()->after('instagram_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('linked_accounts', function (Blueprint $table) {
            $table->dropColumn(['facebook_url', 'tiktok_url']);
        });
    }
};
