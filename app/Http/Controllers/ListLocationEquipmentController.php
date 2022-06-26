<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentResource;
use App\Models\Location;
use Illuminate\Http\Request;

class ListLocationEquipmentController extends Controller
{
    public function __invoke(Request $request, Location $location)
    {
        $date = $request->get('date');

        $query = $location->equipment();
        if (isset($date)) {
            $query->whereDoesntHave('bookings', function ($query) use ($date) {
                $query->where('booked_at', $date);
            });
        }
        $equipment = $query->paginate();

        return EquipmentResource::collection($equipment);
    }
}
