<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\CustomEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendPaymentBillNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:send-bill-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send payment bill notifications to users on the 25th of each month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         // Get all active users
        $users = User::where('is_verified', true)->get();
       
        foreach ($users as $user) {
            // Check if user has an outstanding payment
            $hasOutstandingPayment = $user->payments()
                ->where('payment_confirmation', 'On Bill')
                ->exists();
                
            \Log::info("{$hasOutstandingPayment}");

            if ($hasOutstandingPayment) {
                try {
                    Mail::to($user->email)->send(new CustomEmail(
                        "Payment Bill Reminder",
                        "Dear {$user->name},\n\nThis is a friendly reminder that you have an outstanding payment bill. Please settle your payment as soon as possible to avoid any late fees."
                    ));

                    // Optional: Log the sent notification
                    \Log::info("Payment bill notification sent to {$user->email}");
                } catch (\Exception $e) {
                    \Log::error("Failed to send payment bill notification to {$user->email}: " . $e->getMessage());
                }
            }
        }

        $this->info('Payment bill notifications sent successfully.');
    }
}
