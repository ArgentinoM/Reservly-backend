<?php

namespace App\Services;

use App\Data\PaymetnsData;
use App\Models\Reservation;
use App\Models\Services;
use Carbon\Carbon;
use Cloudinary\Api\Exception\ApiError;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentService
{

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPaymentIntent(PaymetnsData $data): PaymentIntent
    {
        $service = Services::find($data->service_id);

        $startDate = Carbon::parse($data->start_date);

        $endDate   = $startDate->copy()->addHours($service->duration);

        $hasConflict = Reservation::where(function ($query) use ($startDate, $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->where('start_date', '<', $endDate)
                    ->where('end_date',   '>', $startDate);
            });
        })->exists();

        if ($hasConflict) {
            throw new ApiError('Ya existe una reservación que se cruza con ese horario');
        }

        $amount = $service->price * 100;

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'mxn',
            'automatic_payment_methods' => ['enabled' => true],
            'statement_descriptor_suffix' => substr($service->name, 0, 22),
            'metadata' => [
                'service_id' => $service->id,
                'start_date' => $startDate->toDateTimeString(),
                'end_date'   => $endDate->toDateTimeString(),
            ],
        ]);

        return $paymentIntent;
    }


    public function cancelPaymentIntent(string $paymentIntentId): PaymentIntent
    {
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

        return $paymentIntent->cancel();
    }
}
