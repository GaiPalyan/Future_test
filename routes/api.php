<?php

use App\Http\Controllers\Api\NotebookController;
use App\Http\Controllers\Auth\AuthController;
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
Route::group([
    'prefix' => 'v1',
    'as' => 'api.',
    'middleware' => ['auth:sanctum']
],function () {

    Route::get('/notebook', [NotebookController::class, 'index'])->name('index');
    Route::post('/notebook', [NotebookController::class, 'store'])->name('person.store');
    Route::get('/notebook/{person}', [NotebookController::class, 'show'])->name('person.show');
    Route::post('/notebook/{person}', [NotebookController::class, 'update'])->name('person.update');
    Route::delete('/notebook/{person}', [NotebookController::class, 'destroy'])->name('person.delete');

    Route::post('/logout', [AuthController::class, 'logOut'])->name('logout');
});


