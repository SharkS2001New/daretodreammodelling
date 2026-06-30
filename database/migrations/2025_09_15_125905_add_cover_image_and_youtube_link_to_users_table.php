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
        Schema::table('testimonials', function (Blueprint $table) {
            if (! Schema::hasColumn('testimonials', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('profile_picture');
            }
            if (! Schema::hasColumn('testimonials', 'youtube_link')) {
                $table->string('youtube_link')->nullable()->after('cover_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'youtube_link']);
        });
    }
};
