<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationDayResource;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;

class ShowLocationController extends Controller
{
    public function __invoke(Request $request, Location $location)
    {
        if ($request->get('date')) {
            return LocationDayResource::make($location);
        }

        return LocationResource::make($location);
    }
}
