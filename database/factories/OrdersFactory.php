<?php

namespace Database\Factories;

use App\Models\Orders;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Orders::class;
    public function definition()
    {
        return [
            'customer' => $this->faker->name(),
            'created_at' => $this->faker->dateTime($max = 'now', $timezone = null),
            'warehouse_id' => $this->faker->biasedNumberBetween(1,25),
            'status' => $this->faker->randomElement($array=['active','completed','canceled']),
        ];
    }
}
