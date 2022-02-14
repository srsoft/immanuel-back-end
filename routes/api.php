<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PreparationController;

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

// Cms test
Route::get('module/{module_name}', [\App\Http\Controllers\ApiController::class, 'index']);
Route::get('module/{module_name}/{id}', [\App\Http\Controllers\ApiController::class, 'getById']);
Route::post('contacts', [\App\Http\Controllers\ApiController::class, 'storeContact']);

// Common
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

// Auth
Route::middleware('auth:sanctum')->group(function (){
    Route::get('user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});

// Teams
Route::get('teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('teams/{id}', [TeamController::class, 'show'])->name('teams.show');
Route::post('teams', [TeamController::class, 'store'])->name('teams.store');
Route::put('teams/{team}', [TeamController::class, 'update'])->name('teams.update');
Route::delete('teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');

// Notes
Route::get('notes', [NoteController::class, 'index'])->name('notes.index');
Route::get('notes/{id}', [NoteController::class, 'show'])->name('notes.show');
Route::post('notes', [NoteController::class, 'store'])->name('notes.store');
Route::put('notes/{note}', [NoteController::class, 'update'])->name('notes.update');
Route::delete('notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

// Preparations
Route::get('preparations', [PreparationController::class, 'index'])->name('preparations.index');
Route::get('preparations/{id}', [PreparationController::class, 'show'])->name('preparations.show');
Route::post('preparations', [PreparationController::class, 'store'])->name('preparations.store');
Route::put('preparations/{preparation}', [PreparationController::class, 'update'])->name('preparations.update');
Route::delete('preparations/{preparation}', [PreparationController::class, 'destroy'])->name('preparations.destroy');



