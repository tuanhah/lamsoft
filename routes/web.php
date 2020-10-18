<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Room;

Route::get('staff','SensorController@getStaff');
Route::get('admin/login','UserController@getLoginAdmin');
Route::post('admin/login','UserController@postLoginAdmin');
Route::get('admin/logout','UserController@getDangxuatAdmin');

Route::group(['prefix'=>'admin'],function(){
	Route::group(['prefix'=>'dashboard'],function(){
		Route::get('inf_level1','DashboardController@getInfLevel1');
		Route::get('inf_level0','DashboardController@getInfLevel0');
	});
	Route::group(['prefix'=>'profile'],function(){
		Route::get('inf/{id}','ProfileController@getInf');
		Route::post('inf/{id}','ProfileController@postInf');
	});
	Route::group(['prefix'=>'room'],function(){
		Route::get('list','RoomController@getList');
		Route::get('edit/{id}','RoomController@getEdit');
		Route::post('edit/{id}','RoomController@postEdit');
		Route::get('add','RoomController@getAdd');
		Route::post('add','RoomController@postAdd');
		Route::get('delete/{id}','RoomController@getDelete');
	});
	Route::group(['prefix'=>'sensor'],function(){
		Route::get('list','SensorController@getList');
		Route::get('edit/{id}','SensorController@getEdit');
		Route::post('edit/{id}','SensorController@postEdit');
		Route::get('add','SensorController@getAdd');
		Route::post('add','SensorController@postAdd');
		Route::get('delete/{id}','SensorController@getDelete');
	});
	Route::group(['prefix'=>'user'],function(){
		Route::get('list','UserController@getList');
		Route::get('edit/{id}','UserController@getEdit');
		Route::post('edit/{id}','UserController@postEdit');
		Route::get('add','UserController@getAdd');
		Route::post('add','UserController@postAdd');
		Route::get('delete/{id}','UserController@getDelete');
	});
});

Route::get('sensor/{id}','Sensor_infController@sensor');