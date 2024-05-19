<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $pretax_total = $this->faker->randomFloat(2, 10, 30);
        $tax = $this->faker->randomFloat(2, 1, 5);
        $total = $pretax_total + $tax;

        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'customer_name' => $this->faker->name(),
            'pretax_total' => $pretax_total,
            'tax' => $tax,
            'total' => $total,
            'customer_phone' => $this->faker->phoneNumber(),
            'customer_email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
