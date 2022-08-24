<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotebookController;
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

/**
 * public routs
 */

Route::post('/v1/register', [AuthController::class, 'register'])->name('register');
Route::post('/v1/login', [AuthController::class, 'logIn'])->name('login');

/*
 * protected routs
 */
Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/v1/notebook/', [NotebookController::class, 'index'])->name('index');
    Route::post('/v1/notebook/', [NotebookController::class, 'store'])->name('person.store');
    Route::get('/v1/notebook/{person}', [NotebookController::class, 'show'])->name('person.show');
    Route::post('/v1/notebook/{person}', [NotebookController::class, 'update'])->name('person.update');
    Route::delete('/v1/notebook/{person}', [NotebookController::class, 'delete'])->name('person.delete');

    Route::post('/v1/logout', [AuthController::class, 'logOut'])->name('logout');
});


