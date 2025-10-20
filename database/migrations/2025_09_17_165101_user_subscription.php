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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subscription_plan_id');
            $table->date('start_date'); 
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('payment_method');
            $table->string('transaction_id');
            $table->decimal('amount_paid');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans')->onDelete('cascade');
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
