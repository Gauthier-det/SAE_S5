<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubFactory extends Factory
{
    protected $model = Club::class;

    public function definition()
    {
        return [
            'USE_ID' => User::factory(),
            'ADD_ID' => Address::factory(),
            'CLU_NAME' => $this->faker->company() . ' Club',
        ];
    }
}
