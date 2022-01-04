<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\StaffController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'v1'], function () {

    Route::get('actors/{id}/films', [FilmController::class, 'actorFilm'])->name('actor.film');
    Route::get('actors/total-films', [FilmController::class, 'totalFilmActor'])->name('actor.total-film');
    Route::put('actors/{id}/add-films', [FilmController::class, 'addActorFilm'])->name('actor.add-film');

//staff
    Route::put('stores/{id}/add-staff', [StaffController::class, 'addStaffStore'])->name('store.add-staff');

});

