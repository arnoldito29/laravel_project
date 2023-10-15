<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transport>
 */
class TransportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $string = fake()->regexify('[A-Z]{3}');
        $number = fake()->biasedNumberBetween(100, 999);
        $name = sprintf('%s%d', $string, $number);
        $tankCapacity = fake()->randomFloat(4, 50, 9999);
        $average = fake()->randomFloat(2, 3, 40);

        return [
            'license_plate' => $name,
            'model_id' => Model::factory(),
            'fuel_tank_capacity' => $tankCapacity,
            'average_fuel' => $average,
            'estimated_distance' => $tankCapacity / $average * 100,
        ];
    }
}
