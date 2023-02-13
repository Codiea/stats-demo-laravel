<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sale;
class SalesFactory extends Factory
{
    protected $model = Sale::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sale_price = rand(5, 100);
        $cost = round($sale_price - ($sale_price * 0.1));
        $profit = $sale_price - $cost;
        $day = rand(10,30);
        return [
            'product' => $this->faker->word(),
            'sale_price' => $sale_price,
            'cost' => $cost,
            "profit" => $profit,
            "user" => $this->faker->name(),
            "quantity" => 1,
            "created_at"=>"2023-02-$day 00:00:00",
            "updated_at"=>"2023-02-$day 00:00:00"
        ];
    }
}
