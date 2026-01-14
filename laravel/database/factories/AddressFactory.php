<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'ADD_POSTAL_CODE' => $this->faker->postcode(),
            'ADD_CITY' => $this->faker->city(),
            'ADD_STREET_NAME' => $this->faker->streetName(),
            'ADD_STREET_NUMBER' => $this->faker->buildingNumber(),
        ];
    }
}
