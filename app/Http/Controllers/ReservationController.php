<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\ReservationsResources;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{
    public function index(PaginateRequest $request)
    {
        $validateData = $request->validated();
        $user = auth()->user();

        $query = Reservation::query();

        if ($user->rol_id === 2) {
            $query->where('user_id', $user->id);
        }

        if ($user->rol_id === 1) {
            $query->whereHas('service', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

        }

        $reservations = $query->paginate($validateData['perPage']);

        return response()->json([
            'message' => 'Solicitud exitosa',
            'data' => ReservationsResources::collection($reservations),
            'meta' => [
                'current_page' => $reservations->currentPage(),
                'last_page' => $reservations->lastPage(),
                'per_page' => $reservations->perPage(),
                'total' => $reservations->total()
            ]
        ], Response::HTTP_ACCEPTED);

    }

    public function byService(PaginateRequest $request ,int $service_id)
    {
        $validateData = $request->validated();

        $reservation = Reservation::where('services_id', $service_id)
            ->paginate($validateData['perPage']);

        return response()->json([
            'message' => 'Solicitud exitosa',
            'data' => ReservationsResources::collection($reservation)
        ], Response::HTTP_ACCEPTED);

    }

    public function status(int $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'error' => 'Reservación no encontrada'
            ], 404);
        }

        return response()->json([
            'message' => $reservation->status
        ]);
    }

    public function cancelPaymentIntent(int $id)
    {
        $reservation = Reservation::where([
            'id' => $id,
            'user_id' => auth()->id(),
        ])->first();


        if (!$reservation) {
            return response()->json([
                'error' => 'Reservación no encontrada'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($reservation->status !== 'pendiente') {
            return response()->json([
                'error' => 'Solo se pueden cancelar reservaciones pendientes'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$reservation->payment_intent_id) {
            return response()->json([
                'error' => 'Esta reservación no tiene un intento de pago'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::retrieve(
                $reservation->payment_intent_id
            );

            if (!in_array($paymentIntent->status, ['succeeded', 'canceled'])) {
                $paymentIntent->cancel();
            }

            $reservation->update([
                'status' => 'cancelado',
            ]);

            return response()->json([
                'message' => 'Intento de pago cancelado correctamente'
            ]);

        } catch (\Exception $e) {

            Log::error('Error cancelando PaymentIntent manualmente', [
                'reservation_id' => $reservation->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'No se pudo cancelar el intento de pago'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
