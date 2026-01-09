<?php

namespace App\Http\Controllers;

use App\Http\Requests\Favorites\FavoritesRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\FavoriteServicesResorces;
use App\Models\FavoritService;
use App\Models\Services;
use Symfony\Component\HttpFoundation\Response;

class FavoritServiceController extends Controller
{
    public function index(PaginateRequest $request)
    {
        $validateData = $request->validated();

        $favorits = FavoritService::where('user_id', auth()->id())
            ->paginate($validateData['perPage'] ?? 10);

        if ($favorits->isEmpty()) {
            return response()->json([
                'message' => 'No hay registros',
                'data' => [],
                'meta' => null
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Solicitud exitosa',
            'data' => FavoriteServicesResorces::collection($favorits->items()),
            'meta' => [
                'current_page' => $favorits->currentPage(),
                'last_page' => $favorits->lastPage(),
                'per_page' => $favorits->perPage(),
                'total' => $favorits->total()
            ]
        ], Response::HTTP_OK);
    }

    public function store(FavoritesRequest $request)
    {

        $validateData = $request->validated();

        $favorite = FavoritService::create([
            'user_id' => auth()->id(),
            'service_id' => $validateData['service_id']
        ]);

        return response()->json([
            'message' => 'Se agrego a tus favoritos',
            'data' => new FavoriteServicesResorces($favorite)
        ]);
    }

    public function delete(int $service_id)
    {
        $favorite =  FavoritService::where('user_id', auth()->id())
            ->where('service_id', $service_id)->first();

        if (!$favorite) {
            return response()->json([
                'error' => 'No se encuentra el registro',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $favorite->delete();

        return response()->json([
            'message' => 'Se elimino de tus favoritos',
        ], Response::HTTP_ACCEPTED);
    }
}
