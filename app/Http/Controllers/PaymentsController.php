<?php

namespace App\Http\Controllers;

use App\Data\PaymetnsData;
use App\Http\Requests\Payments\PaymentsRequest;
use App\Http\Resources\ReservationsResources;
use App\Models\Reservation;
use App\Services\PaymentService;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class PaymentsController extends Controller
{

    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function createPaymentIntent(PaymentsRequest $request)
    {
        try {
            $validaData = $request->validated();

            $paymentIntent = $this->paymentService->createReservationWithPayment(
                PaymetnsData::from([
                    'service_id' => $validaData['service_id'],
                    'start_date' => $validaData['start_date'],
                    'end_date' => $validaData['end_date'],
                ])
            );

            $reservation = Reservation::find($paymentIntent->metadata->reservation_id);

            return response()->json([
                'message' => 'Solicitud exitosa',
                'client_secret' => $paymentIntent->client_secret,
                'reservation' => new ReservationsResources($reservation),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function continuePaymentIntent(int $reservation_id)
    {
        $intent = $this->paymentService
            ->continuePayment($reservation_id);

        return response()->json([
            'client_secret' => $intent->client_secret,
        ]);
    }
}
