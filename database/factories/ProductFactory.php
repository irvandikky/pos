<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(100),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'stock' => $this->faker->randomNumber(2),
            'status' => $this->faker->boolean,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->categories()->create(['name' => $this->faker->text(20)]);
        });
    }
}
