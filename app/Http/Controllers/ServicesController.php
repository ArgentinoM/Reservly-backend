<?php

namespace App\Http\Controllers;

use App\Data\ServiceData;
use App\Filters\ServicesFilter;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\services\ServicesRequest;
use App\Http\Requests\Services\UpdateService;
use App\Http\Resources\ServicesResorces;
use App\Models\Services;
use App\Services\ServicesProcesses;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ServicesController extends Controller
{

    public function __construct(
        protected ServicesProcesses $serviceProcessor
    ) {}

    public function index(PaginateRequest $paginate)
    {
        $validateData = $paginate->validated();

        $perPage = $validateData['perPage'] ?? 10;

        $query = Services::query();

        $query->with('rating');

        $query = (new ServicesFilter(request()))->apply($query);

        // $query->inRandomOrder();


        $services = $query->paginate($perPage);

        ServicesResorces::collection($services);

        return response()->json([
            'message' => 'Solicitud exitosa',
            'data' => ServicesResorces::collection($services->items()),
            'meta' => [
                'current_page' => $services->currentPage(),
                'last_page' => $services->lastPage(),
                'per_page' => $services->perPage(),
                'total' => $services->total()
            ]
        ], Response::HTTP_OK);
    }

    public function searchById(int $service_id)
    {
        $service = Services::find($service_id);

        if (!$service) {
            return response()->json([
                'error' => 'El serivico no existe'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'message' => 'Solicitud exitosa',
            'data' => new ServicesResorces($service)

        ], Response::HTTP_ACCEPTED);
    }

    public function store(ServicesRequest $request)
    {
        $validateData = $request->validated();

        $services = $this->serviceProcessor->createService(
            ServiceData::from([
                'name' => $validateData['name'],
                'desc' => $validateData['desc'],
                'price' => $validateData['price'],
                'duration' => $validateData['duration'],
                'img' => $request->file('img'),
                'category_id' => $validateData['category_id'],
            ])
        );

        return response()->json([
            'message' => 'Solicitud exitosa',
            'data' => new ServicesResorces($services)
        ], Response::HTTP_ACCEPTED);
    }

    public function update(UpdateService $request, int $service_id)
    {
        $validateData = $request->validated();

        $services = $this->serviceProcessor->updateService(
            ServiceData::from([
                'name' => $validateData['name'],
                'desc' => $validateData['desc'],
                'price' => $validateData['price'],
                'duration' => $validateData['duration'],
                'img' => $request->file('img'),
                'category_id' => $validateData['category_id'],
            ]),
            $service_id
        );

        return response()->json([
            'message' => 'Solicitud exitosa',
            'data' => $services
        ], Response::HTTP_ACCEPTED);
    }

    public function delete(Services $services_id)
    {

        $services_id->delete();

        return response()->json(['message' => 'Se elimino temporalmente'], Response::HTTP_ACCEPTED);
    }

    public function cancelDelete(int $service_id)
    {
        $service = Services::withTrashed()->find($service_id);

        if (!$service) {
            return response()->json(['message' => 'Servicio no encontrado'], Response::HTTP_NOT_FOUND);
        }

        if ($service->trashed()) {
            $service->restore();
            return response()->json(['message' => 'Servicio restaurado correctamente'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'El servicio no estaba eliminado'], Response::HTTP_BAD_REQUEST);
    }

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $services = Services::onlyTrashed()
                ->where('deleted_at', '<=', now()->subMonth())
                ->get();

            foreach ($services as $service) {
                Storage::disk('cloudinary')->delete($service->img);
                $service->forceDelete();
            }
        })->daily();
    }
}
