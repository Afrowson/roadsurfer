<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingsRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Equipment;
use Illuminate\Support\Carbon;

class StoreBookingsController extends Controller
{
    public function __invoke(StoreBookingsRequest $request)
    {
        /** @var Equipment $equipment */
        $equipment = Equipment::find($request->equipmentId);
        /** @var Carbon $bookedFromDate */
        $bookedFromDate = Carbon::make($request->bookedFrom);
        /** @var Carbon $bookedToDate */
        $bookedToDate = Carbon::make($request->bookedTo);

        $doubleBooking = Booking::whereBooked($bookedFromDate, $bookedToDate)
            ->where('equipment_id', $equipment->id)
            ->first();
        if (isset($doubleBooking)) {
            return response(__('equipment.double_booked'), 422);
        }

        $bookedDays = $bookedToDate->diffInDays($bookedFromDate);

        $bookings = collect();
        $bookedFromDate->subDay();
        for ($i = 0; $i <= $bookedDays; $i++) {
            $booking = Booking::create([
                'booked_at'    => $bookedFromDate->addDay()->toDateString(),
                'equipment_id' => $equipment->id,
                'location_id'  => $equipment->location_id,
            ]);
            $bookings->push($booking);
        }

        return BookingResource::collection($bookings);
    }
}
