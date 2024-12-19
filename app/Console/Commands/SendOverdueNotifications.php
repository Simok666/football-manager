<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Mail\CustomEmail;

class SendOverdueNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:send-overdue-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for overdue payments after the 5th of the month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Begin database transaction
            DB::beginTransaction();

            // Get the current date
            $now = now();
            $currentMonth = $now->month;
            $currentYear = $now->year;

            // Find users with 'On Bill' payments that are now overdue
            $overduePayments = Payment::where('payment_confirmation', 'On Bill')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->whereHas('user', function ($query) {
                    $query->where('is_verified', true);
                })
                ->get();

            foreach ($overduePayments as $payment) {
                // Check if payment is overdue (after the 5th of the month)
                if ($now->day > 5) {
                    // Update payment status to 'Overdue'
                    $payment->update([
                        'payment_confirmation' => 'Overdue'
                    ]);

                    // Send overdue notification email
                    if ($payment->user && $payment->user->email) {
                        Mail::to($payment->user->email)->send(new CustomEmail(
                            "Overdue Payment Notification",
                            "Dear {$payment->user->name},\n\nYour payment is now overdue. Please complete the payment as soon as possible to avoid additional late fees."
                        ));
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            $this->info('Overdue payment notifications sent successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Log the error
            \Log::error('Overdue payment notification failed: ' . $e->getMessage());
            $this->error('Failed to send overdue payment notifications: ' . $e->getMessage());
        }
    }
}
