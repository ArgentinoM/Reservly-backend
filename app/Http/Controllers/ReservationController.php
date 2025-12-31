<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(PaginateRequest $rquest)
    {
        $validateData = $rquest->validated();
        
    }
}
