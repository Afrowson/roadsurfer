<?php

namespace Database\Factories;

use App\Enums\EquipmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(EquipmentType::cases()),
            'value_one' => $this->faker->word(),
            'value_two' => $this->faker->randomDigit(),
        ];
    }
}
