<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomProductID = mt_rand(1,Product::count());

        return [
            'order_id' => Order::factory(),
            'product_id' => $randomProductID,
            'price' => Product::find($randomProductID)->price,
            'quantity' => $this->faker->numberBetween(1, 5),
        ];
    }
}
