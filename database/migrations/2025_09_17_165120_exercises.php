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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('category', ['warmup', 'strength', 'cardio', 'core', 'flexibility','weightlifting', 'functional', 'plyometrics']);
            $table->enum('difficulty', ['beginner', 'intermediate', 'expert']);
            $table->string('equipment');
            $table->text('instruction');
            $table->string('video_url');
            $table->string('img_url');
            $table->string('icon')->nullable();
            $table->string('muscle_group')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
