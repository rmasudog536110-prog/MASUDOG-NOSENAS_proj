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
            $table->string('video_url')->nullable()->change();
            $table->string('img_url')->nullable()->change();
            $table->text('instruction')->nullable()->change();
            $table->string('icon')->nullable();
            $table->string('muscle_group')->nullable();
            $table->text('instructions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->string('video_url')->nullable(false)->change();
            $table->string('img_url')->nullable(false)->change();
            $table->text('instruction')->nullable(false)->change();
            $table->dropColumn(['icon', 'muscle_group', 'instructions']);
        });
    }
};
