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
        Schema::create('body_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('measurement_date');
            $table->decimal('weight', 5, 2)->nullable()->comment('Weight in kg');
            $table->decimal('body_fat_percentage', 5, 2)->nullable();
            $table->decimal('muscle_mass', 5, 2)->nullable()->comment('Muscle mass in kg');
            $table->decimal('chest', 5, 2)->nullable()->comment('Chest in cm');
            $table->decimal('waist', 5, 2)->nullable()->comment('Waist in cm');
            $table->decimal('hips', 5, 2)->nullable()->comment('Hips in cm');
            $table->decimal('biceps_left', 5, 2)->nullable()->comment('Left bicep in cm');
            $table->decimal('biceps_right', 5, 2)->nullable()->comment('Right bicep in cm');
            $table->decimal('thigh_left', 5, 2)->nullable()->comment('Left thigh in cm');
            $table->decimal('thigh_right', 5, 2)->nullable()->comment('Right thigh in cm');
            $table->decimal('calf_left', 5, 2)->nullable()->comment('Left calf in cm');
            $table->decimal('calf_right', 5, 2)->nullable()->comment('Right calf in cm');
            $table->string('progress_photo')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'measurement_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_measurements');
    }
};
