<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/StudentController/login','StudentController@login');
Route::post('/StudentController/do_login','StudentController@do_login');


Route::group(['middleware' => ['login']], function () {
	
	Route::get('/StudentController/index','StudentController@index');
	Route::get('/StudentController/add','StudentController@add');
	Route::post('/StudentController/do_add','StudentController@do_add');
	Route::get('/StudentController/update','StudentController@update');
	Route::post('/StudentController/do_update','StudentController@do_update');
	Route::get('/StudentController/delete','StudentController@delete');
 	
	Route::get('/StudentController/register','StudentController@register');
	Route::post('/StudentController/do_register','StudentController@do_register');

	Route::get('/StudentController/goodsadd','StudentController@goodsadd');
	Route::post('/StudentController/do_goodsadd','StudentController@do_goodsadd');

});
