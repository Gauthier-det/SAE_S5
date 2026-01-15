<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'ADD_POSTAL_CODE' => fake()->postcode(),
            'ADD_CITY' => fake()->city(),
            'ADD_STREET_NAME' => fake()->streetName(),
            'ADD_STREET_NUMBER' => fake()->buildingNumber(),
        ];
    }
}
