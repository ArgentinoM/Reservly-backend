<?php

namespace App\Http\Controllers;

use App\Data\PaymetnsData;
use App\Http\Requests\Payments\PaymentsRequest;
use App\Services\PaymentService;
use Exception;
use Stripe\Exception\OAuth\InvalidRequestException;
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

            $paymentIntent = $this->paymentService->cratePaymentIntent(
                PaymetnsData::from([
                    'service_id' => $validaData['service_id'],
                    'start_date' => $validaData['start_date'],
                    'end_date' => $validaData['end_date'],
                ])
            );

            return response()->json([
                'message' => 'Solicitud exitosa',
                'client_id' => $paymentIntent->client_secret
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function cancelPaymentIntent(string $payment_id)
    {
        try {
            $paymentIntent = $this->paymentService->cancelPaymentIntent($payment_id);

            return response()->json([
                'message' => 'Pago cancelado correctamente',
                'status' => $paymentIntent->status,
            ]);
        } catch (InvalidRequestException $e) {
            return response()->json([
                'exists' => false,
                'error' => 'El ID no existe o no es válido'
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
