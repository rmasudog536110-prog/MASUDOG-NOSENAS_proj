<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User; // Ensure you have this model
// use App\Models\SubscriptionPlan; // if you have this model

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. GET THE USERS
        // We need the Customer (to subscribe) and the Admin (to approve)
        $customer = DB::table('users')->where('email', 'customer@fitclub.com')->first();
        $admin = DB::table('users')->where('role', 'admin')->first();

        if (!$customer || !$admin) {
            $this->command->info('Please seed Users first!');
            return;
        }


        // 3. CREATE THE ACTIVE SUBSCRIPTION
        // This is crucial for the user to access the site
        $subscriptionId = DB::table('user_subscriptions')->insertGetId([
            'user_id' => $customer->id,
            'plan_id' => 2,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(90),
            'payment_proof' => 'images/payments/dummy_receipt.jpg',
            'payment_method' => 'gcash',
            'transaction_reference' => 'TXN-123456789', // String format for this table
            'status' => 'active', // STATUS MUST BE ACTIVE
            'approved_at' => Carbon::now(),
            'approved_by' => $admin->id, // Approved by the Admin user
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. CREATE THE PAYMENT TRANSACTION RECORD
        DB::table('payment_transactions')->insert([
            'user_id' => $customer->id,
            'subscription_id' => $subscriptionId,
            'transaction_reference' => 123456789, // BigInteger format for this table
            'payment_method' => 'gcash',
            'amount' => 349.99,
            'currency' => 'PHP',
            'status' => 'approved',
            'payment_details' => json_encode([
                'sender_name' => 'Customer User',
                'account_number' => '09123456789',
                'timestamp' => Carbon::now()->toDateTimeString()
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}