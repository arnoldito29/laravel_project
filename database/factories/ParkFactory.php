<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Park>
 */
class ParkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transport_id' => Transport::factory(),
            'model_id'  => Model::factory(),
            'fuel_tank_capacity' => fake()->randomFloat(4, 50, 9999),
            'average_fuel' => fake()->randomFloat(2, 3, 40),

        ];
    }
}
