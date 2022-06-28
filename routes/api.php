<?php

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


Route::post('login',[App\Http\Controllers\UserController::class,'login'])->name('login');
Route::group(['middleware'=>'auth:sanctum'],function($route){
    Route::post('logout',[App\Http\Controllers\UserController::class,'logout'])->name('logout');
    Route::get('me',[App\Http\Controllers\UserController::class,'me'])->name('me');

    Route::apiResource('companies', App\Http\Controllers\CompanyController::class)->names('company');
});