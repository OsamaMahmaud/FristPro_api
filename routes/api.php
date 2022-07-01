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

    Route::resource('get', 'RolesController');

        ///////////////Start register&login///////////////////////////////////////
        Route::post('register','RegisterController@register') ;
        Route::post('login', 'AuthController@login');
        Route::get('getAll', 'AuthController@getAll');
        Route::post('logout', 'AuthController@logout');
        Route::post('sendEmail', 'MailController@sendEmail');
        Route::post('sendPasswordResetLink', 'PasswordResetRequestController@sendEmail');
        Route::post('resetPassword', 'ChangePasswordController@passwordResetProcess');
        ///////////////End register&login//////////////////////////////////////////

        ////////////start area/////////////////////////////////////////////////////,'middleware' => 'can:area'
        Route::group(['prefix' => 'area'], function () {
        Route::resource('/', 'AddareaController');//add area
        });
        ////////////End area///////////////////////////////////////////////////////

         /////////////Srart car////////////////////////////////////////////////////,'middleware' => 'can:car'
         Route::group(['prefix' => 'car'], function () {
         Route::resource('/', 'CarController') ;//car
         Route::get('getdeptofcar','CarController@getDeptOfCar');
        });
         /////////////end car///////////////////////////////////////////////////////

        /////////////Srart categores////////////////////////////////////////////////
        Route::group(['prefix' => 'category'], function () {
          Route::resource('/', 'CategoriesController') ;//category
        });
        /////////////end categores//////////////////////////////////////////////////

        ////////////End department//////////////////////////////////////////////////,'middleware' => 'can:department'
        Route::group(['prefix' => 'department'], function () {
          Route::resource('/', 'DepartmentController');//add department
        });
        ////////////End department//////////////////////////////////////////////////

        /////////////Srart Employee/////////////////////////////////////////////////,'middleware' => 'can:employee'
        Route::group(['prefix' => 'employee'], function () {
        Route::resource('/', 'EmployeeController') ;//employee
        Route::get('getdepofemployee/{emp_id}','EmployeeController@getDepartmentOfEmp');///button عرض صفحه الاقسام
        Route::get('getallemployee','EmployeeController@getAllEmployee');///get all employee no
        Route::get('getalldepartment','EmployeeController@getAllDepartment');///get all employee  no
        Route::post('savedeptofemp','EmployeeController@saveDeptOfEmployee');///save dept of employee  no
        Route::get('getdepartment','EmployeeController@getdepartment');///save dept of employee yes
        Route::get('getemp-dept','EmployeeController@EmployeeWithDepartment');///get all employee with dept no
        });
        /////////////End Employee////////////////////////////////////////////////////

        ////////////start create factory///////////////////////////////////////////// , 'middleware' => 'can:factory'
        Route::group(['prefix' => 'factory'], function () {
        Route::resource('/', 'FactoryController') ;//factory
        Route::get('getcategory', 'FactoryController@getCategory') ;//many to many//get all category  no
        Route::get('getfactory', 'FactoryController@getFactory') ;//many to many//get all factory     no
        Route::get('getCategoresOfFactory/{fact_id}', 'FactoryController@getCategoresOfFactory') ;//many to many//get all factory  no
        Route::post('saveServicesToDoctors', 'FactoryController@saveServicesToDoctors') ;//many to many//save categores to factory  no
        Route::get('getallcategory', 'FactoryController@getAllCategory') ;//get all category new
        });
        ////////////End Factory///////////////////////////////////////////////////////

         ////////////start feedback///////////////////////////////////////////////////
         Route::group(['prefix' => 'feedback'], function () {
         Route::resource('/', 'FeedbackController');//add feedback
         });
         ////////////End feedback/////////////////////////////////////////////////////

        ////////////start get_quentitiy/////////////////////////////////////////////// new
        Route::group(['prefix' => 'get_quentitiy'], function () {
         Route::get('/{ssn}', 'GetquantityController@get_quentitiy') ;//get quentitiy of metal,palistic,pepar
        });
        ////////////End get_quentitiy/////////////////////////////////////////////////

        ////////////start store//////////////////////////////////////////////////////new
        Route::resource('Store', 'TrashStoreController');//store
        Route::get('getallquantity', 'StoreController@metal') ;//get all metal for store
        ////////////End store////////////////////////////////////////////////////////
        Route::post('logout','AuthController@logout') -> middleware(['auth.guard:admin-api']);  //invalidate token security side



        ////////////Start accountant////////////////////////////////////////////////////////
        Route::group(['prefix' => 'accountant'],function (){
            Route::resource('/', 'SuppliesController');
            Route::get('getuser', 'SuppliesController@getuser');
            Route::get('getcategory', 'SuppliesController@getcategory');
            Route::get('getquantity', 'SuppliesController@getquantity');
        });
        ////////////end accountant////////////////////////////////////////////////////////


        ////////////Start Bill////////////////////////////////////////////////////////
        Route::group(['prefix' => 'bill'],function (){
            Route::resource('/', 'BillController');
            Route::get('getderivers', 'BillController@getderivers');
            Route::get('get_acco_name', 'BillController@getAccoName');
            Route::get('getcarid', 'BillController@getCarId');
            Route::get('getallquantity', 'BillController@getallquantity');
            Route::get('getquantityofbill/{ssn}', 'BillController@getquantityofbill');

        });
        ////////////end Bill////////////////////////////////////////////////////////

         ////////////start roles////////////////////////////////////////////////////////
         Route::group(['prefix' => 'roles'], function () {
            Route::get('/', 'RolesController@index');
            Route::get('create', 'RolesController@create');
            Route::post('store', 'RolesController@saveRole');
            Route::get('/edit/{id}', 'RolesController@edit');
            Route::post('update/{id}', 'RolesController@update');
         });
        ////////////End roles////////////////////////////////////////////////////////

    });

    // Route::group(['prefix' => 'addAdmin' ], function () {
    //     Route::get('/', 'AddadminController@index');
    //     Route::get('/create', 'AddadminController@create');
    //     Route::post('/store', 'AddadminController@store');
    // });

    //user register&login&logout
    Route::group(['prefix' => 'user','namespace'=>'User'],function (){
        Route::post('register','RegisterController@register') ;
        Route::post('login','AuthController@Login') ;
        Route::resource('profile', 'ProfileController') ;//////////////
        // Route::get('getquantity/{user_id}', 'ProfileController@getquantity') ;//////////////
        Route::get('photo/{ssn}','ProfileController@getPhoto');
        Route::get('points/{ssn}','ProfileController@points');
        Route::get('getkillos/{ssn}','ProfileController@getKillos');
        Route::get('gettotal/{ssn}','ProfileController@getTotal');
        Route::get('getLastMonthRecords/{ssn}','ProfileController@getLastMonthRecords');
        Route::post('uploadImage', 'ProfileController@uploadImage') ;/////////
        Route::get('getalluser', 'AuthController@get_All_User') ;
        Route::post('logout','AuthController@Logout')-> middleware(['auth.guard:user-api']);
    });



});












Route::group(['middleware'=>['api','change-language','CheckAdminToken:admin-api'],'namespace'=>'App\Http\Controllers\Api'],function (){

    Route::post('checkadmintoken', 'CategoriesController@index');


});

Route::post('sendEmail', 'App\Http\Controllers\MailController@sendEmail');

Route::middleware('jwt.auth')->group( function(){

} );









################## Begin one To many Relationship #####################

        // Route::get('getHospitalDoctors','EmployeeController@getHospitalDoctors');
