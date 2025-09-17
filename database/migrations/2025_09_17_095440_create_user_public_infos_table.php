<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_public_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('display_name')->nullable();
            $table->integer('age')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('hair')->nullable();
            $table->string('eye')->nullable();
            $table->string('height')->nullable();
            $table->string('shoes')->nullable();
            $table->string('chest')->nullable();
            $table->string('waist')->nullable();
            $table->string('hips')->nullable();
            $table->string('jacket')->nullable();
            $table->string('trousers')->nullable();
            $table->string('collar')->nullable();
            $table->string('location')->nullable();

            // Extra fields you mentioned
            $table->string('nationality')->nullable();
            $table->string('languages')->nullable();
            $table->string('disciplines')->nullable();
            $table->text('about_me')->nullable();

            $table->string('profile_picture')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_public_infos');
    }
};
