<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\FavoriteServicesResorces;
use App\Models\FavoritService;
use Symfony\Component\HttpFoundation\Response;

class FavoritServiceController extends Controller
{
    public function index(PaginateRequest $request)
    {
        $validateData = $request->validated();

        $favorits = FavoritService::where('user_id', auth()->id())
            ->paginate($validateData['perPage'] ?? 10);


        if (!isset($favorits)) {
            return response()->json([
                'message' =>  'No hay registros',
                'data' =>  []
            ], Response::HTTP_OK);
        }


        return response()->json([
            'message' =>  'Solicitud exitosa',
            'data' =>  FavoriteServicesResorces::collection($favorits)
        ], Response::HTTP_OK);
    }
}
