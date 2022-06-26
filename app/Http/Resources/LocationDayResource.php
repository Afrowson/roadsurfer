<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LocationDayResource extends BaseResource
{
    public function data(Request $request): array
    {
        $availableEquipment = $this->equipment()->whereAvailableAt(Carbon::make($request->date))->get();
        $unavailableEquipment = $this->equipment()->whereNotAvailableAt(Carbon::make($request->date))->get();

        return [
            'name'                 => $this->name,
            'availableEquipment'   => EquipmentResource::collection($availableEquipment),
            'unavailableEquipment' => EquipmentResource::collection($unavailableEquipment),
        ];
    }
}
