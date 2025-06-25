<?php

use App\Http\Controllers\PositionAPIController;
use App\Http\Controllers\PositionWebController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::get('/positions/{id}', [PositionAPIController::class, 'show']);
Route::get('/positions-all', [PositionAPIController::class, 'showAll']);
Route::post('/positions', [PositionAPIController::class, 'store']);
Route::put('/positions/{id}', [PositionAPIController::class, 'update']);
Route::delete('/positions/{id}', [PositionAPIController::class, 'destroy']);
