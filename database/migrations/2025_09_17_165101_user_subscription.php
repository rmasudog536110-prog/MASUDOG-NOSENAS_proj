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
            Schema::create('user_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('plan_id')->constrained('subscription_plans')->onDelete('cascade');
                $table->date('start_date');
                $table->date('end_date');
                $table->enum('status', ['pending', 'active', 'cancelled','expired', 'null'])->default('null');
                $table->text('admin_notes')->nullable()->after('payment_status');
                $table->timestamp('approved_at')->nullable()->after('admin_notes');
                $table->foreignId('approved_by')->nullable()->constrained('users')->after('approved_at');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
