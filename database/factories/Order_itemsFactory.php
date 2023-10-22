<?php

namespace Database\Factories;

use App\Models\Order_items;
use Illuminate\Database\Eloquent\Factories\Factory;

class Order_itemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Order_items::class;
    public function definition()
    {
        return [
            'order_id' => $this->faker->biasedNumberBetween(1,100),
            'product_id' => $this->faker->biasedNumberBetween(1,50),
            'count' => $this->faker->biasedNumberBetween(1,300),
        ];
    }
}
