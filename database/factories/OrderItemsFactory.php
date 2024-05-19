<?php

namespace Database\Factories;

use App\Enums\OrderItemStatus;
use App\Enums\OrderItemType;
use App\Models\Order;
use App\Models\orderItems;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderItemsFactory extends Factory
{
    protected $model = orderItems::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'type' => OrderItemType::PIZZA,
            'amount' => $this->faker->randomFloat(2, 10, 30),
            'instructions' => $this->faker->sentences(2, true),
            'status' => OrderItemStatus::ORDERED,

            'order_id' => Order::factory(),
        ];
    }
}
