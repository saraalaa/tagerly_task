<?php

namespace Database\Seeders;

use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Vendor::factory(10)->has(Product::factory()->count(10))->create();
        \App\Models\Vote::factory(25)->create();
        \App\Models\Order::factory(10)->has(OrderDetail::factory()->count(5))->create();

    }
}
