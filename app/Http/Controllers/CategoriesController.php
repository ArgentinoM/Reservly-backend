<?php

namespace App\Http\Controllers;


use App\Http\Requests\PaginateRequest;
use App\Models\Categories;
use Symfony\Component\HttpFoundation\Response;


class CategoriesController extends Controller
{
    public function showAll()
    {
        $categories = Categories::all();

        return response()->json(['message' => 'Solicitud exitosa', 'data' => $categories], Response::HTTP_OK);
    }
}
