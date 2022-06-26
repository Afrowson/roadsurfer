<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class EquipmentResource extends BaseResource
{

    public function data(Request $request): array
    {
        return [
            'type' => $this->type,
            'valueOne' => $this->value_one,
            'valueTwo' => $this->value_two,
        ];
    }
}
