<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Location;
use Illuminate\Http\Request;

class ListLocationBookingsController extends Controller
{
    public function __invoke(Request $request, Location $location)
    {
        $date = $request->get('date');

        $query = $location->bookings();
        if (isset($date)) {
            $query->where('booked_at', $date);
        }
        $bookings = $query->paginate();

        return BookingResource::collection($bookings);
    }
}
