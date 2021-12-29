<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

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

//Route::get('module/{module_name}', [\App\Http\Controllers\ApiController::class, 'index']);
//Route::get('module/{module_name}/{id}', [\App\Http\Controllers\ApiController::class, 'getById']);
//Route::post('contacts', [\App\Http\Controllers\ApiController::class, 'storeContact']);



Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});

// Teams
Route::get('teams', [TeamController::class, 'index'])->name('teams.index');
