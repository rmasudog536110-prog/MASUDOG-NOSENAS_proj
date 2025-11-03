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
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('end_date');
            $table->enum('payment_status', ['pending', 'approved', 'rejected'])->default('pending')->after('payment_proof');
            $table->text('admin_notes')->nullable()->after('payment_status');
            $table->timestamp('approved_at')->nullable()->after('admin_notes');
            $table->foreignId('approved_by')->nullable()->constrained('users')->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['payment_proof', 'payment_status', 'admin_notes', 'approved_at', 'approved_by']);
        });
    }
};
