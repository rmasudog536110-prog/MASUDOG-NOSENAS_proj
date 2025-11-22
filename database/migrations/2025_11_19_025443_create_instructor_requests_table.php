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
        Schema::create('instructor_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->string('preferred_date')->nullable(); // YYYY-MM-DD
            $table->time('preferred_time')->nullable(); // HH:MM
            $table->string('exercise_type')->nullable(); // strength, cardio, yoga, etc.
            $table->text('goals')->nullable(); // customer goals and requirements
            $table->enum('status', ['pending', 'accepted', 'declined', 'completed', 'cancelled'])->default('pending');
            $table->text('instructor_notes')->nullable(); // instructor notes when responding
            $table->timestamp('scheduled_at')->nullable(); // actual scheduled session time
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // who created this request
            $table->timestamps();
            
            // Indexes for efficient queries
            $table->index(['status', 'created_at']);
            $table->index('customer_id');
            $table->index('instructor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_requests');
    }
};