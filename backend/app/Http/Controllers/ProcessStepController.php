<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProcessStepResource;
use App\Models\ProcessStep;

class ProcessStepController extends Controller
{
    public function index()
    {
        return ProcessStepResource::collection(
            ProcessStep::orderBy('sort_order')->orderBy('id')->get()
        );
    }
}
