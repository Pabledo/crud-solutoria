<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndicatorController;
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

Auth::routes();

Route::get('/', [IndicatorController::class, 'index'])->name('index');

Route::resource('indicators', IndicatorController::class);