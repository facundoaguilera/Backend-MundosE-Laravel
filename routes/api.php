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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>['cors']],function(){

Route::get('/comments', "App\Http\Controllers\Api\CommentController@index");
Route::post('/comments', "App\Http\Controllers\Api\CommentController@store");
Route::put('/comments/{id}', "App\Http\Controllers\Api\CommentController@update");
Route::delete('/comments/{id}', "App\Http\Controllers\Api\CommentController@destroy");

});
