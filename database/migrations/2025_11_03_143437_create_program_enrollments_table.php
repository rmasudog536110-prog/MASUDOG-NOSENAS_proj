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
        Schema::create('program_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->constrained('training_programs')->onDelete('cascade');
            $table->date('enrolled_at');
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->json('completed_days')->nullable();
            $table->int('progress');
            $table->date('last_activity');
            $table->timestamps();
            
            $table->unique(['user_id', 'program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_enrollments');
    }
};
