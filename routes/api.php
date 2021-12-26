<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;

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


Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [AuthController::class, 'index']);
    Route::post('users/register', [AuthController::class, 'register']);
    Route::put('users/{user}', [AuthController::class, 'update']);

    Route::resource('roles', RolesController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('units', UnitController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::resource('items', ItemController::class);


    // Orders
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('movements', [OrderController::class, 'movements']);

    Route::post('orders/move', [OrderController::class, 'move']);
    Route::post('orders/purchase', [OrderController::class, 'purchase']);
    Route::post('orders/transfer', [OrderController::class, 'transfer']);
    Route::get('movements/{trans}', [OrderController::class, 'trans']);
    Route::get('storage', [OrderController::class, 'storage']);
    Route::get('item/{code}', [OrderController::class, 'item']);
});



Route::post('/login', [AuthController::class, 'login']);
