<?php

namespace App\Http\Resources;

use App\Enums\EquipmentType;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LocationResource extends BaseResource
{
    public function data(Request $request): array
    {
        return [
            'name' => $this->name,
            $this->mergeWhenCollection([
                'equipmentOne'   => $this->equipment
                    ->filter(fn(Equipment $equipment) => $equipment->type === EquipmentType::TYPE_ONE)
                    ->count(),
                'equipmentTwo'   => $this->equipment
                    ->filter(fn(Equipment $equipment) => $equipment->type === EquipmentType::TYPE_TWO)
                    ->count(),
                'equipmentThree' => $this->equipment
                    ->filter(fn(Equipment $equipment) => $equipment->type === EquipmentType::TYPE_THREE)
                    ->count(),
            ]),
            $this->mergeWhenResource([
                'equipment' => EquipmentResource::collection($this->equipment)
            ]),
        ];
    }
}
