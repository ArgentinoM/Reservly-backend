<?php

namespace App\Jobs;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CancelExpiredReservations
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $expiredReservations = Reservation::where('status', 'pendiente')
            ->where('created_at', '<=', Carbon::now()->subHours(24))
            ->get();

        foreach ($expiredReservations as $reservation) {

            if(!$reservation->payment_intent_id){
                continue;
            }

            try {
                $paymentIntent = PaymentIntent::retrieve(
                    $reservation->payment_intent_id
                );

                if (in_array($paymentIntent->status, ['succeeded', 'canceled'])) {
                    continue;
                }

                $paymentIntent->cancel();

                $reservation->update([
                    'status' => 'cancelado',
                ]);

            } catch (\Exception $e) {
                Log::error('Error cancelando PaymentIntent', [
                    'reservation_id' => $reservation->id,
                    'error' => $e->getMessage(),
                ]);
            }

        }
    }
}
