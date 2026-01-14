<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ADD_ID' => Address::factory(),
            'USE_MAIL' => fake()->unique()->safeEmail(),
            'USE_PASSWORD' => static::$password ??= Hash::make('password'),
            'USE_NAME' => fake()->firstName(),
            'USE_LAST_NAME' => fake()->lastName(),
            'USE_BIRTHDATE' => fake()->dateTimeBetween('-80 years', '-18 years'),
            'USE_PHONE_NUMBER' => fake()->numberBetween(100000000, 999999999),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
