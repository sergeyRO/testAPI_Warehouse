<?php

namespace Database\Factories;

use App\Models\Warehouses;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehousesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Warehouses::class;
    public function definition()
    {
        return [
            'name' => "WareHouses_".$this->faker->name()
        ];
    }
}
