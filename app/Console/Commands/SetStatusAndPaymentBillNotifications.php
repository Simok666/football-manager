<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Models\Status;
use App\Mail\CustomEmail;

class SetStatusAndPaymentBillNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:set-status-and-payment-bill-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Status Payment user and send payment bill notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Begin database transaction
            DB::beginTransaction();

            // Get all active users
            $activeUsers = User::where('is_verified', true)->get();

            foreach ($activeUsers as $user) {
                // Check if user already has an existing 'On Bill' payment this month
                $existingOnBillPayment = Payment::where('user_id', $user->id)
                    ->where('payment_confirmation', 'On Bill')
                    ->orWhere('payment_confirmation', 'Paid Off')
                    ->orWhere('payment_confirmation', 'Overdue')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->exists();

                // If no existing 'On Bill' payment, create a new one
                if (!$existingOnBillPayment) {
                    Payment::create([
                        'user_id' => $user->id,
                        'id_statuses' => $user->id_statuses,
                        'payment_confirmation' => 'On Bill',
                        'date_payment' => null,
                        'proof_payment' => null,
                    ]);

                    // Send notification email
                    Mail::to($user->email)->send(new CustomEmail(
                        "Monthly Payment Bill",
                        "Dear {$user->name},\n\nYour monthly payment bill is now due. Please complete the payment before the due date to avoid any late fees."
                    ));
                }
            }

            // Commit the transaction
            DB::commit();

            $this->info('Payment bills created and notifications sent successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Log the error
            \Log::error('Payment bill creation failed: ' . $e->getMessage());
            $this->error('Failed to create payment bills: ' . $e->getMessage());
        }
    }
}
