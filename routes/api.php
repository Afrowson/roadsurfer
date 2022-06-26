<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/location', \App\Http\Controllers\ListLocationController::class);
Route::get('/location/{location}', \App\Http\Controllers\ShowLocationController::class);
Route::get('/location/{location}/equipment', \App\Http\Controllers\ListLocationEquipmentController::class);
Route::get('/location/{location}/booking', \App\Http\Controllers\ListLocationBookingsController::class);
Route::post('/booking', \App\Http\Controllers\StoreBookingsController::class);
