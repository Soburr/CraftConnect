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
        Schema::create('artisans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('hall_of_residence')->nullable();
            $table->string('skill_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('years_of_experience')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('faculty')->nullable();
            $table->string('department')->nullable();
            $table->string('room_number')->nullable();
            $table->string('matric_no')->nullable();
            $table->longText('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artisans');
    }
};
