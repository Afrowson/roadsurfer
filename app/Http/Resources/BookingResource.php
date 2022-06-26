<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class BookingResource extends BaseResource
{
    public function data(Request $request): array
    {
        return [
            'bookedAt'  => $this->booked_at,
            'equipment' => EquipmentResource::make($this->equipment),
        ];
    }
}
