<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user's role is hrd.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function hrd()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'hrd',
            ];
        });
    }

    /**
     * Indicate that the user's role is employee.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function employee()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'employee',
            ];
        });
    }
}
