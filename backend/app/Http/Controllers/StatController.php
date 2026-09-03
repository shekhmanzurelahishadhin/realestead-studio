<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatResource;
use App\Models\Stat;

class StatController extends Controller
{
    public function index()
    {
        return StatResource::collection(
            Stat::orderBy('sort_order')->orderBy('id')->get()
        );
    }
}
