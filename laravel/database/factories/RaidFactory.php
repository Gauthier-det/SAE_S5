<?php

namespace Database\Factories;

use App\Models\Raid;
use App\Models\Club;
use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RaidFactory extends Factory
{
    protected $model = Raid::class;

    public function definition()
    {
        return [
            'CLU_ID' => Club::factory(),
            'ADD_ID' => Address::factory(),
            'USE_ID' => User::factory(),
            'RAI_NAME' => $this->faker->sentence(3),
            'RAI_MAIL' => $this->faker->email(),
            'RAI_PHONE_NUMBER' => $this->faker->phoneNumber(),
            'RAI_WEB_SITE' => $this->faker->url(),
            'RAI_IMAGE' => $this->faker->imageUrl(),
            'RAI_TIME_START' => now()->addDays(30),
            'RAI_TIME_END' => now()->addDays(31),
            'RAI_REGISTRATION_START' => now()->addDays(1),
            'RAI_REGISTRATION_END' => now()->addDays(29),
            'RAI_NB_RACES' => $this->faker->numberBetween(1, 10),
        ];
    }
}