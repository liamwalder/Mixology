<?php

use Illuminate\Http\Request;

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
//Route::post('/cocktails', 'Api\CocktailController@getCocktails');
Route::post('/drinks/filtered', 'Api\DrinkController@filtered');
Route::get('/drinks', 'Api\DrinkController@list');

Route::get('/ingredients', 'Api\IngredientController@list');