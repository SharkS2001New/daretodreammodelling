<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
    */
    public function up()
    {
        Schema::table('linked_accounts', function (Blueprint $table) {
            $table->text('tiktok_access_token')->nullable();
            $table->text('tiktok_refresh_token')->nullable();
            $table->string('tiktok_open_id')->nullable();
            $table->timestamp('tiktok_token_expires_at')->nullable();
            // Remove the old tiktok_connected boolean since we can check if access_token exists
        });
    }

    public function down()
    {
        Schema::table('linked_accounts', function (Blueprint $table) {
            $table->dropColumn([
                'tiktok_access_token',
                'tiktok_refresh_token',
                'tiktok_open_id',
                'tiktok_token_expires_at'
            ]);
        });
    }
};
