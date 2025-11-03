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
        Schema::create('workout_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('training_program_id')->nullable()->constrained()->onDelete('set null');
            $table->date('workout_date');
            $table->integer('sets')->nullable();
            $table->integer('reps')->nullable();
            $table->decimal('weight', 8, 2)->nullable()->comment('Weight in kg');
            $table->integer('duration_minutes')->nullable();
            $table->decimal('distance', 8, 2)->nullable()->comment('Distance in km');
            $table->integer('calories_burned')->nullable();
            $table->text('notes')->nullable();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->nullable();
            $table->integer('rating')->nullable()->comment('1-5 rating');
            $table->timestamps();
            
            $table->index(['user_id', 'workout_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_logs');
    }
};
