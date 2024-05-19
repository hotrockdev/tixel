<?php

namespace Database\Seeders;

use App\Models\OrderItems;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderItems::factory(15)->create();
    }
}
