<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Floats;
use Nette\Utils\Random;

class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Products::class;
    public function definition()
    {
        return [
            'name' => "PRODUCT_".$this->faker->name(),
            'price' =>  $this->faker->randomFloat(2,0,100000),
        ];
    }
}
