<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Products::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->firstName(null),
            "price" => $this->faker->randomFloat(2, 10, 100),
            "size" => $this->faker->randomElement(['P', 'M', 'G', 'GG', 'P;M;G;GG', 'P;M;G', 'P;M', 'M;G', 'M;G;GG']),
            "color" => $this->faker->colorName(),
            "category" => $this->faker->firstName(null),
            "availability" => $this->faker->randomElement([0,1]),
            "status" => $this->faker->randomElement([0,1]),
            "description" => $this->faker->text(),
            "image" => $this->faker->imageUrl(200, 300, 'clothes'),
        ];
    }
}
