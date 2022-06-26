<?php

namespace App\Http\Requests;

use App\Models\Insurance;
use Illuminate\Validation\Rule;

/**
 * @property int $equipmentId
 * @property string $bookedFrom
 * @property string $bookedTo
 */
class StoreBookingsRequest extends BaseApiRequest
{

    public function rules(): array
    {
        return [
            'equipmentId' => [
                'required',
                Rule::exists('equipment', 'id'),
            ],
            'bookedFrom'  => [
                'required',
                'date',
            ],
            'bookedTo'    => [
                'required',
                'date',
                'after:bookedFrom'
            ],
        ];
    }
}
