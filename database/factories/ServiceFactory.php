<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference' => $this->faker->unique()->word(1),
            'name' => $this->faker->word(2),
            'price' => $this->faker->randomDigit,
            'isLimited' => $this->faker->boolean,
            'image' => 'null'
        ];
    }
}
