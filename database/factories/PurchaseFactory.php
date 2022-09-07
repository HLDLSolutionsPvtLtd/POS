<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'supplier' => $this->faker->company(),
            'supplier_gst_no' => 'GST' . Str::random(8),
            'supplier_invoice' =>  'INVC' . Str::random(10),
            'total_with_gst' => (string)$this->faker->numberBetween(500, 1500),
            'total_without_gst' => (string)$this->faker->numberBetween(500, 1500),
            'payment_method' => $this->faker->randomElement(['upi', 'bank_transfer', 'cash', 'card']),
            'transaction_id' => Str::random(10),
            'payment_date' => $this->faker->date(),
        ];
    }
}
