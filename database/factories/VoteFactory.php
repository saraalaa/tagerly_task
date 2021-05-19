<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vote' => $this->faker->numberBetween(1, 5),
            'product_id' => $this->faker->numberBetween(1, Product::count()),
            'user_id' => $this->faker->numberBetween(1, User::count()),
        ];
    }
}
