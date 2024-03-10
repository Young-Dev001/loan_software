<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'supplier_id' => $this->faker->numberBetween(1, 10),
            'barcode' => $this->faker->ean13,
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'stock' => $this->faker->numberBetween(1, 100),
            'buying_price' => $this->faker->randomFloat(2, 1, 10000),
            'selling_price' => $this->faker->randomFloat(2, 1, 20000),
            'status' => $this->faker->boolean,
        ];
    }
}
