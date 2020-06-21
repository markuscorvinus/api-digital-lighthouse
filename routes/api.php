<?php

use App\Models\UserManagement\User;
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

Route::prefix('v1')->group(function(){

    /** 
     * Registration/Login Routes      
     */
    Route::post('/register', 'Api\v1\Auth\RegisterController@register')->name('register');
    //Route::post('/login', 'Api\v1\Auth\LoginController@login')->name('login');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::post('/logout', 'Api\v1\Auth\LoginController@logout')->name('logout');
    Route::post('/logout/passwordrecover', 'Api\v1\Auth\LoginController@passwordRecover')->name('passwordrecover');

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/users', function(){
            return User::all();
        });
    });   
});