<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;

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

        ///////////////Start register&login////////////////////////////////////////////////
        Route::post('register','RegisterController@register') ;
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('sendEmail', 'MailController@sendEmail');
        Route::post('sendPasswordResetLink', 'PasswordResetRequestController@sendEmail');
        Route::post('resetPassword', 'ChangePasswordController@passwordResetProcess');
        ///////////////End register&login///////////////////////////////////////////////////


        /////////////Srart Employee////////////////////////////////////////////////////////
        Route::resource('employee', 'EmployeeController') ;//employee
        Route::get('getdepofemployee/{emp_id}','EmployeeController@getDepartmentOfEmp');///button عرض صفحه الاقسام
        Route::get('getallemployee','EmployeeController@getAllEmployee');///get all employee
        Route::get('getalldepartment','EmployeeController@getAllDepartment');///get all employee
        Route::post('savedeptofemp','EmployeeController@saveDeptOfEmployee');///save dept of employee
        Route::get('getdepartment','EmployeeController@getdepartment');///save dept of employee

        Route::get('getemp-dept','EmployeeController@EmployeeWithDepartment');///get all employee with dept
        /////////////End Employee////////////////////////////////////////////////////////


        Route::resource('category', 'CategoriesController') ;//category
        Route::resource('car', 'CarController') ;//car

        ////////////start create factory/////////////////////////////////////////////////////
        Route::resource('factory', 'FactoryController') ;//factory
        Route::get('getcategory', 'FactoryController@getCategory') ;//many to many//get all category
        Route::get('getfactory', 'FactoryController@getFactory') ;//many to many//get all factory
        Route::get('getCategoresOfFactory/{fact_id}', 'FactoryController@getCategoresOfFactory') ;//many to many//get all factory
        Route::post('saveServicesToDoctors', 'FactoryController@saveServicesToDoctors') ;//many to many//save categores to factory
        Route::get('getallcategory', 'FactoryController@getAllCategory') ;//get all category new
        ////////////End Factory///////////////////////////////////////////////////////////////

        Route::resource('Store', 'TrashStoreController');//store
        Route::resource('area', 'AddareaController');//add area

        Route::resource('department', 'DepartmentController');//add department



        Route::post('logout','AuthController@logout') -> middleware(['auth.guard:admin-api']);
        //invalidate token security side

        //broken access controller user enumeration


        ################## Begin one To many Relationship #####################

        Route::get('getHospitalDoctors','EmployeeController@getHospitalDoctors');


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

Route::post('sendEmail', 'App\Http\Controllers\MailController@sendEmail');




Route::middleware('jwt.auth')->group( function(){

} );
