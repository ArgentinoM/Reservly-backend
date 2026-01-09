<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\PaymentIntent;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature,
                config('services.stripe.webhook_secret')
            );
        } catch (\Exception $e) {
            Log::error('Invalid Stripe webhook', [
                'error' => $e->getMessage()
            ]);

            return response('Invalid payload', 400);
        }

        $paymentIntent = $event->data->object;

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            switch ($event->type) {

                case 'payment_intent.succeeded':

                    $reservationId = $paymentIntent->metadata->reservation_id ?? null;

                    if (!$reservationId) {
                        return response('Missing reservation_id', 400);
                    }

                    $reservation = Reservation::find($reservationId);

                    if (!$reservation) {
                        return response('Reservation not found', 404);
                    }

                    $receiptUrl = null;

                    if (!empty($paymentIntent->latest_charge)) {
                        $charge = Charge::retrieve($paymentIntent->latest_charge);
                        $receiptUrl = $charge->receipt_url ?? null;
                    }

                    Payments::updateOrCreate(
                        ['stripe_id' => $paymentIntent->id],
                        [
                            'amount'         => $paymentIntent->amount ?? 0,
                            'currency'       => $paymentIntent->currency ?? 'mxn',
                            'status'         => 'confirmado',
                            'payment_method'=> $paymentIntent->payment_method ?? 'card',
                            'receipt_url'   => $receiptUrl,
                            'reservation_id'=> $reservation->id,
                            'user_id'        => $reservation->user_id,
                            'raw'            => json_encode($paymentIntent),
                        ]
                    );


                    $reservation->update([
                        'status' => 'confirmado',
                    ]);


                    $conflictingReservations = Reservation::where('id', '!=', $reservation->id)
                        ->where('services_id', $reservation->services_id)
                        ->where('status', 'pendiente')
                        ->where('start_date', '<', $reservation->end_date)
                        ->where('end_date', '>', $reservation->start_date)
                        ->get();

                    foreach ($conflictingReservations as $conflict) {

                        if ($conflict->payment_intent_id) {
                            try {
                                $intent = PaymentIntent::retrieve(
                                    $conflict->payment_intent_id
                                );

                                if (!in_array($intent->status, ['succeeded', 'canceled'])) {
                                    $intent->cancel();
                                }

                            } catch (\Exception $e) {
                                Log::error('Error cancelando PaymentIntent en conflicto', [
                                    'reservation_id' => $conflict->id,
                                    'error' => $e->getMessage(),
                                ]);
                            }
                        }

                        $conflict->update([
                            'status' => 'cancelado',
                        ]);
                    }

                    break;


                case 'payment_intent.payment_failed':
                case 'payment_intent.canceled':

                    $reservationId = $paymentIntent->metadata->reservation_id ?? null;

                    if ($reservationId) {
                        $reservation = Reservation::find($reservationId);

                        if ($reservation) {
                            $reservation->update([
                                'status' => 'cancelado',
                            ]);
                        }
                    }

                    break;

                default:
                    Log::info("Unhandled Stripe event type: {$event->type}");
            }

            return response('OK', 200);

        } catch (\Exception $e) {
            Log::error('Stripe webhook processing error', [
                'error' => $e->getMessage(),
            ]);

            return response('Internal server error', 500);
        }
    }
}
