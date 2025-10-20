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
        Schema::create('training_programs', function(Blueprint $table){

            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('level', ['beginner','intermediate','expert','hardcore']);
            $table->integer('duration_weeks');
            $table->integer('workout_counts');
            $table->text('equipment_required');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_programs');
    }
};
