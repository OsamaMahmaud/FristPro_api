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

//all api must be auth ,'check-password'

Route::group(['middleware'=>['api','change-language'],'namespace'=>'App\Http\Controllers\Api'],function (){

    Route::post('get-main-categories', 'Admin\AuthController@index');
    Route::post('get-category-byId', 'CategoriesController@getCategoryById');
    Route::post('change-category-status', 'CategoriesController@changeStatus');

    Route::group(['prefix' => 'admin','namespace'=>'Admin'],function (){
        Route::post('login', 'AuthController@login');
        Route::resource('employee', 'EmployeeController') ;
        Route::resource('category', 'CategoriesController') ;
        Route::resource('car', 'CarController') ;
        Route::post('logout','AuthController@logout') -> middleware(['auth.guard:admin-api']);
        //invalidate token security side

        //broken access controller user enumeration
    });
//user register&login&logout
    Route::group(['prefix' => 'user','namespace'=>'User'],function (){
        Route::post('register','RegisterController@register') ;
        Route::post('login','AuthController@Login') ;
        Route::resource('profile', 'ProfileController') ;
        Route::post('logout','AuthController@Logout')-> middleware(['auth.guard:user-api']);
    });





});

Route::group(['middleware'=>['api','change-language','CheckAdminToken:admin-api'],'namespace'=>'App\Http\Controllers\Api'],function (){

    Route::post('checkadmintoken', 'CategoriesController@index');


});


Route::middleware('jwt.auth')->group( function(){

} );
