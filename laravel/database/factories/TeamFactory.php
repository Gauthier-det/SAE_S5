<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        return [
            'USE_ID' => User::factory(),
            'TEA_NAME' => $this->faker->company() . ' Team',
            'TEA_IMAGE' => $this->faker->imageUrl(),
        ];
    }
}