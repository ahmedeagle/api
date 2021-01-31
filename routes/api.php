<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;

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

//all routes / api here must be api authenticated
Route::group(['middleware' => ['api','checkPassword','changeLanguage'], 'namespace' => 'Api'], function () {
    Route::post('get-main-categories', 'CategoriesController@index');
    Route::post('get-category-byId', 'CategoriesController@getCategoryById');
    Route::post('change-category-status', 'CategoriesController@changeStatus');

    Route::group(['prefix' => 'admin','namespace'=>'Admin'],function (){
        Route::post('login', 'AuthController@login');

        Route::post('logout','AuthController@logout') -> middleware(['auth.guard:admin-api']);
          //invalidate token security side

         //broken access controller user enumeration
    });

    Route::group(['prefix' => 'user','namespace'=>'User'],function (){
        Route::post('login','AuthController@Login') ;
    });


    Route::group(['prefix' => 'user' ,'middleware' => 'auth.guard:user-api'],function (){
       Route::post('profile',function(){
           return 'Only authenticated user can reach me';
       }) ;
    });

});

Route::get('test',function (){

     //convert token user
    return JWTAuth::toUser('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGktdHV0b3JpYWwubG9jYWxcL2FwaVwvdjFcL3VzZXJcL2xvZ2luIiwiaWF0IjoxNjEyMTE5ODI3LCJleHAiOjE2MTIxMjM0MjcsIm5iZiI6MTYxMjExOTgyNywianRpIjoiSUhiU0xnbGw4dHdRR2xRMSIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.BOLGbwj8H3XHUqrzQa1SFmusmDJv7UDz3jTsfUPXo7g');
});


Route::group(['middleware' => ['api','checkPassword','changeLanguage','checkAdminToken:admin-api'], 'namespace' => 'Api'], function () {
    Route::get('offers', 'CategoriesController@index');
});
