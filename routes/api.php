<?php

use App\Http\Controllers\AuthController;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ItemsController;
use App\Models\Bed;

Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register','AuthController@register');
    Route::get('users','AuthController@all');
    Route::post('update','AuthController@update');
    Route::delete('users/{id}', 'AuthController@destroy');
        


});


Route::get('users','AuthController@all');

Route::group(['middleware' => 'jwt.auth'], function ($router) {
  Route::get('customers','CustomerController@all');
  Route::get('customers/usercustomers/{id}','CustomerController@getUserCustomer');
  Route::get('customers/{id}','CustomerController@get');
  Route::post('customers/new','CustomerController@new');
  Route::post('customers/edit','CustomerController@edit');

});

Route::get('rooms','RoomController@index');
Route::post('rooms/create/','RoomController@store');
Route::delete('rooms/{id}','RoomController@destroy');
Route::put('rooms/update/{room}','RoomController@update');
Route::get('employees','EmployeeController@index');
Route::post('employee/create','EmployeeController@store');
Route::delete('employee/{id}','EmployeeController@destroy');


Route::post('attendance','AttendanceController@store');
Route::post('items','ItemsController@store');
Route::put('items','ItemsController@update');
Route::get('items','ItemsController@index');
Route::delete('items/{id}','ItemsController@destroy');

Route::get('beds',function(){
  $beds = Bed::all();

  return $beds;
});