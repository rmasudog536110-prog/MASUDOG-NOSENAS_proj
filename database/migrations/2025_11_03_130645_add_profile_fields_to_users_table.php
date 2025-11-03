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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('profile_picture');
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable()->after('date_of_birth');
            $table->text('bio')->nullable()->after('gender');
            $table->decimal('height', 5, 2)->nullable()->after('bio')->comment('Height in cm');
            $table->decimal('weight', 5, 2)->nullable()->after('height')->comment('Weight in kg');
            $table->string('fitness_goal')->nullable()->after('weight');
            $table->string('experience_level')->nullable()->after('fitness_goal');
            $table->boolean('email_notifications')->default(true)->after('experience_level');
            $table->boolean('sms_notifications')->default(false)->after('email_notifications');
            $table->timestamp('last_login_at')->nullable()->after('sms_notifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_picture',
                'date_of_birth',
                'gender',
                'bio',
                'height',
                'weight',
                'fitness_goal',
                'experience_level',
                'email_notifications',
                'sms_notifications',
                'last_login_at'
            ]);
        });
    }
};
