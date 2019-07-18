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


//前台注册
Route::get('/Index/register','Index@register');
Route::post('/Index/do_register','Index@do_register');
//前台登录
Route::get('/Index/login','Index@login');
Route::post('/Index/do_login','Index@do_login');		
		//前台列表展示
Route::get('/Index/index','Index@index');
Route::get('/Index/list','Index@list');
Route::get('/Index/cart_save','Index@cart_save');
Route::get('/Index/cart_list','Index@cart_list');
Route::get('/Index/cart_delete','Index@cart_delete');
Route::get('/Index/cart_buy','Index@cart_buy');
Route::get('/Index/buy_delete','Index@buy_delete');
Route::get('/Index/order_create','Index@order_create');
Route::get('/Index/order_list','Index@order_list');





//后台注册
Route::get('/Admin/register','Admin@register');
Route::post('/Admin/do_register','Admin@do_register');

	//后台登录
Route::get('/Admin/login','Admin@login');

Route::post('/Admin/do_login','Admin@do_login');


Route::group(['middleware' => ['login']], function(){
	//后台
	Route::get('/Admin/index','Admin@index');	
	Route::get('/Admin/create','Admin@create');
	Route::post('/Admin/save','Admin@save');
	Route::get('/Admin/delete','Admin@delete');
	
	//后台管理员添加
	Route::get('/Admin/user_create','Admin@user_create');
	Route::post('/Admin/user_save','Admin@user_save');
	Route::get('/Admin/user_index','Admin@user_index');

	Route::get('/Admin/exit','Admin@exit');
	

	
});

	// Route::get('/Admin/update','Admin@update');
	// Route::post('/Admin/do_update','Admin@do_update');
	// 后台修改限制
Route::group(['middleware' => ['goods']], function () {
	//后台
	Route::get('/Admin/update','Admin@update');
	Route::post('/Admin/do_update','Admin@do_update');

});
Route::get('pay', 'PayController@do_pay');
Route::get('return_url', 'PayController@return_url');//同步
Route::post('notify_url', 'PayController@notify_url');//异步
