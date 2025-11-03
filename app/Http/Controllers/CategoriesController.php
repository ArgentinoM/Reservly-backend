<?php

namespace App\Http\Controllers;


use App\Http\Requests\PaginateRequest;
use App\Models\Categories;
use Symfony\Component\HttpFoundation\Response;


class CategoriesController extends Controller
{
    public function index(PaginateRequest $paginate)
    {
        $validateData = $paginate->validated();

        $perPage = $validateData['perPage'] ?? 10;

        $categories = Categories::paginate($perPage);

        return response()->json(['message' => 'Solicitud exitosa', 'data' => $categories], Response::HTTP_OK);
    }

    // public function store(CategoriesRequest $categories)
    // {
    //     $validateData = $categories->validated();

    //     $categories = Categories::create([
    //         'name' => $validateData['name'],
    //         'desc' => $validateData['desc'] ?? null,
    //     ]);

    //     return response()->json(['message' => 'Solicitud exitosa', 'data' => $categories], Response::HTTP_OK);
    // }

    // public function delete(Categories $cat_id)
    // {
    //     if (!isset($cat_id)) {
    //         return response()->json(['error' => 'La categoria no existe'], Response::HTTP_UNPROCESSABLE_ENTITY);
    //     }

    //     $cat_id->delete();

    //     return response()->json(['message' => 'La categoria fue eliminada'], Response::HTTP_ACCEPTED);
    // }
}
