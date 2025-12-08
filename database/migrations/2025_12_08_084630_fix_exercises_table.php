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
        Schema::table('exercises', function (Blueprint $table) {
            // Make img_url nullable since not all exercises need images
            $table->string('img_url')->nullable()->change();
            
            // Make video_url nullable to match controller validation
            $table->string('video_url')->nullable()->change();
            
            // Rename instruction to instructions to match controller and form
            $table->renameColumn('instruction', 'instructions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            // Revert changes
            $table->string('img_url')->nullable(false)->change();
            $table->string('video_url')->nullable(false)->change();
            $table->renameColumn('instructions', 'instruction');
        });
    }
};