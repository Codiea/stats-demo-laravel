<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start_date = now()->subMonth(rand(1,6))->subDays(rand(1,10));
        $end_date = (clone $start_date)->addMonth();
        return [
            //
            "user"=>$this->faker->name(),
            "amount"=>rand(5,25),
            "start_date"=>$start_date->toDateTimeString(),
            "end_date"=>$end_date->toDateTimeString(),
        ];
    }
}
