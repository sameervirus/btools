<?php

use App\Http\Resources\DetailMoveResources;
use App\Http\Resources\MoveItemResources;
use App\Http\Resources\StockResources;
use App\Models\Item;
use App\Models\TransferDetails;
use App\Models\TransferHeader;
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

Route::get('/', function () {
    return DetailMoveResources::collection(TransferDetails::with('headers')->where('item_id', 100314)->get());
});

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
