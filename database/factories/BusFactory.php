<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bus>
 */
class BusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $agents= ['1','2'];
        return [
            'travels_name' => $this->faker->word(),
            'image' => $this->faker->word(),
            // 'no_plate' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'agent_id' => $this->faker->randomElement($agents),
            // 'price' => $this->faker->numberBetween($min = 800, $max = 1300),
            // 'from' => $this->faker->word(),
            // 'to' => $this->faker->word(),
            // 'default_price' => $this->faker->numberBetween($min = 1000, $max = 1500),
            // 'drop_points' => $this->faker->time(),
            // 'pickup_points' => $this->faker->time(),
            'status' => $this->faker->randomElement(['A','D'])
        ];
    }
}
