<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use App\Models\ServiceRating;
use App\Models\Services;
use Symfony\Component\HttpFoundation\Response;

class ServiceRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PaginateRequest $request, Services $service)
    {
        $validateData = $request->validated();

        $serviceRating = ServiceRating::where('service_id', $service->id);

        if (!$serviceRating) {
            return response()->json([
                'error' => 'No se encontro rating del servicio',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $serviceRating->paginate($validateData['perPage'] ?? 10);

        return response()->json([
            'message' => 'Solicitud exitosa',
            'data' => $serviceRating
        ], Response::HTTP_OK);
    }
}
