<?php

namespace App\Services;

use App\Data\PaymetnsData;
use App\Models\Reservation;
use App\Models\Services;
use Carbon\Carbon;
use App\Exceptions\ApiException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createReservationWithPayment(PaymetnsData $data): PaymentIntent
    {
        $service = Services::findOrFail($data->service_id);

        $startDate = Carbon::parse($data->start_date);
        $endDate   = $startDate->copy()->addHours($service->duration);

        $hasConflict = Reservation::where('services_id', $service->id)
            ->whereIn('status', ['pendiente', 'completado'])
            ->where('start_date', '<', $endDate)
            ->where('end_date', '>', $startDate)
            ->exists();

        if ($hasConflict) {
            throw new ApiException('Ya existe una reservación en ese horario');
        }

        $reservation = Reservation::create([
            'start_date'  => $startDate,
            'end_date'    => $endDate,
            'user_id'     => auth()->id(),
            'services_id' => $service->id,
            'status'      => 'pendiente',
        ]);

        $intent = PaymentIntent::create([
            'amount' => $service->price * 100,
            'currency' => 'mxn',
            'automatic_payment_methods' => ['enabled' => true],
            'metadata' => [
                'reservation_id' => $reservation->id,
            ],
        ]);

        $reservation->update([
            'payment_intent_id' => $intent->id,
        ]);

        return $intent;
    }

    public function continuePayment(int $reservationId): PaymentIntent
    {
        $reservation = Reservation::where('id', $reservationId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($reservation->status !== 'pendiente') {
            throw new ApiException('Esta reservación ya no puede pagarse');
        }

        if (!$reservation->payment_intent_id) {
            throw new ApiException('No existe intento de pago');
        }

        $intent = PaymentIntent::retrieve($reservation->payment_intent_id);

        if (in_array($intent->status, ['succeeded', 'canceled'])) {
            throw new ApiException('Este intento de pago ya no es válido');
        }

        return $intent;
    }
}
