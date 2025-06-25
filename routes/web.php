<?php

use App\Http\Controllers\PositionWebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/positions', [PositionWebController::class, 'index'])->name('positions.index');
Route::get('/positions/create', [PositionWebController::class, 'createPosition'])->name('positions.create');
Route::get('/positions/edit/{id}', [PositionWebController::class, 'editPosition'])->name('positions.edit');
