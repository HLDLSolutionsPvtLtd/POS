<?php

namespace Database\Factories;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Particulars>
 */
class ParticularFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'quantity' => $this->faker->numberBetween(1, 20),
            'amount' => $this->faker->numberBetween(100, 2000),
            'unit_measurement' =>  $this->faker->randomElement(['kg', 'pc', 'ml']),
            'total_amount' => (string)$this->faker->numberBetween(500, 2500),
            'purchase_id' => Purchase::factory()->create(),
            'gst_percent' => $this->faker->numberBetween(10, 30),
            'total_with_gst' => $this->faker->numberBetween(100, 2000),
        ];
    }
}
