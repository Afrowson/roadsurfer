<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListLocationController extends Controller
{
    public function __invoke(Request $request)
    {
        $locations = Location::paginate();

        return LocationResource::collection($locations);
    }
}
