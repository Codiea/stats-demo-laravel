<?php

namespace Database\Factories;

use App\Models\SaleReturn;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sale;
class SaleReturnFactory extends Factory
{
    protected $model = SaleReturn::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sales = Sale::inRandomOrder()->first();
        return [
            //
            "sales_id"=>$sales->id,
            "quantity"=>1,
            "return_amount"=>$sales->sale_price,
            "created_at"=>$sales->created_at,
            "updated_at"=>$sales->updated_at
        ];
    }
}
