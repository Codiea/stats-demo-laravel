<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/",[WelcomeController::class,"welcome"]);
Route::get("/stats",[WelcomeController::class,"stats"]);

Route::get("/add-sales",[WelcomeController::class,"addSales"]);
Route::post("/add-sales",[WelcomeController::class,"postSales"]);
