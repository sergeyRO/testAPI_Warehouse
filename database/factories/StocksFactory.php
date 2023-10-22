<?php

namespace Database\Factories;

use App\Models\Stocks;
use Illuminate\Database\Eloquent\Factories\Factory;

class StocksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Stocks::class;
    public function definition()
    {
        return [
            'warehouse_id' => $this->faker->biasedNumberBetween(1,25),
            'product_id' => $this->faker->biasedNumberBetween(1,50),
            'stock' => $this->faker->biasedNumberBetween(400,1000),
        ];
    }
}
