<?php

namespace Database\Seeders;

use App\Models\Order_items;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Stocks;
use App\Models\Warehouses;
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
        // \App\Models\User::factory(10)->create();User::factory()
        Products::factory()
            ->count(50)
            ->create();
        Warehouses::factory()
        ->count(40)
        ->create();
        Orders::factory()
        ->count(100)
        ->create();
        Order_items::factory()
            ->count(200)
            ->create();
        Stocks::factory()
            ->count(200)
            ->create();
    }
}
