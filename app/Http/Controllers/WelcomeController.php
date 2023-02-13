<?php

namespace App\Http\Controllers;

use App\Events\SalesAddEvent;
use App\Models\Sale;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class WelcomeController extends Controller
{
    //

    public function welcome()
    {
        return view('welcome');
    }


    public function stats()
    {
        $subscriptions = Subscription::count();
        $sales_count = Sale::count();


        $now = Carbon::now();
        $months = collect(range(1, $now->month))->map(function ($month) use ($now) {
            return Carbon::createFromDate($now->year, $month)->format('m');
        })->toArray();


        $comparisons = [];
        $labels = [];

        $years = ["2023","2022"];
        foreach($years as $year){
            $data = [];
            foreach ($months as $m) {
                $date = Carbon::createFromDate($year, intval($m));
                $last_year = (clone $date)->subYear();
                if(!in_array($date->format("F"),$labels))
                    $labels[] = $date->format("F");
                $data[] =  Sale::whereDate("created_at", ">=", $date->startOfMonth())->whereDate("created_at", "<=", $date->endOfMonth())->sum("sale_price");
               
                // $comparisons[] = [
                //     //"label" => $date->format("F"),
                //     "data" => [
                //         Sale::whereDate("created_at", ">=", $date->startOfMonth())->whereDate("created_at", "<=", $date->endOfMonth())->sum("sale_price"),
                //         //Sale::whereDate("created_at", ">=", $last_year->startOfMonth())->whereDate("created_at", "<=", $last_year->endOfMonth())->sum("sale_price")
                //     ]
                // ];
            }

            $comparisons[] = [
                "label"=>$year,
                "backgroundColor"=>$year == 2023? '#5D3FD3': '#4BC0C0',
                //"label" => $date->format("F"),
                "data" => $data
            ];
        }


        $revenue_2022 = Sale::whereDate("created_at", ">=", now()->subYear()->startOfYear())->whereDate("created_at", "<=", now()->subYear()->endOfYear())->sum("sale_price");
        $revenue_2023 = Sale::whereDate("created_at", ">=", now()->startOfYear())->whereDate("created_at", "<=", now()->endOfYear())->sum("sale_price");


        

        


        return response()->json([
            "sub_count" => $subscriptions,
            "sales_count" => $sales_count,
            "revenue_comparisons" => [
                "labels"=>$labels,
                "datasets"=>$comparisons
            ],
            "revenue_increase"=>[
                "last_year"=>$revenue_2022,
                "curr_year"=>$revenue_2023,
                "increase_percent"=>number_format((1-$revenue_2022/$revenue_2023) * 100,2),
            ]
        ]);
    }

    public function addSales()
    {
        return view("sales-add");
    }

    public function postSales(Request $request)
    {
        $this->validate($request,[
            "product"=>"required|string",
            "user"=>"required|string",
            "sale_price"=>"required|numeric|gt:0",
            "cost"=>"required|numeric|gt:0"
        ]);

        Sale::create(array_merge($request->except("_token"),["profit"=>$request->sale_price - $request->cost,"quantity"=>1]));
        SalesAddEvent::dispatch();
        return redirect()->back()->with("alert-success","Successfully added sales");
    }
}
