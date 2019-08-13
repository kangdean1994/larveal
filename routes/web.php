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
Route::get('/Index/ticket_list','Index@ticket_list');




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
	
	//后台车票添加
	Route::get('/Admin/ticket_create','Admin@ticket_create');
	Route::post('/Admin/ticket_save','Admin@ticket_save');
	
	//后台题库添加
	Route::get('/Admin/question_add','Admin@question_add');
	Route::post('/Admin/do_add','Admin@do_add');
    Route::get('/Admin/addPagers.blade.php','Admin@addPagers.blade.php');
    Route::get('/Admin/question_index','Admin@question_index');
    Route::get('/Admin/papers','Admin@addPagers');
    Route::get('/Admin/testDetail','Admin@testDetail');
    Route::get('/Admin/testlist','Admin@testlist');

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




 Route::get('/Search/search_add','Search@search_add');
 Route::get('/Search/search_question','Search@search_question');
 Route::post('/Search/question_add','Search@question_add');
 Route::post('/Search/do_add','Search@do_add');
 Route::get('/Search/search_dan','Search@search_dan');
 Route::get('/Search/search_fu','Search@search_fu');
 Route::post('/Search/dan_add','Search@dan_add');
 Route::post('/Search/fu_add','Search@fu_add');
 Route::get('/Search/search_list','Search@search_list');
 Route::get('/Search/question_delete','Search@question_delete');
 Route::get('/Search/search_order','Search@search_order');


 Route::get('/Cai/create','Cai@create');
 Route::post('/Cai/save','Cai@save');
 Route::get('/Cai/list','Cai@list');
 Route::get('/Cai/delete','Cai@delete');
 Route::get('/Cai/add','Cai@add');
 Route::post('/Cai/do_add','Cai@do_add');
 Route::get('/Cai/order_list','Cai@order_list');
 Route::get('/Cai/do_look','Cai@do_look');
 Route::get('/Cai/cai_result','Cai@cai_result');
 Route::post('/Cai/do_result','Cai@do_result');

  Route::get('/Car/create','Car@create');
  Route::get('/Car/add','Car@add');
  Route::post('/Car/do_add','Car@do_add');
  Route::get('/Car/list','Car@list');
  Route::get('/Car/update','Car@update');
  Route::get('/Car/car_list','Car@car_list');



    Route::get('/Car/address','Car@address');
    Route::post('/Car/do_address','Car@do_address');
    Route::get('/Car/list_address','Car@list_address');






//留言板登录
 Route::get('/Message/login','Message@login');
 Route::post('/Message/do_login','Message@do_login');
Route::group(['middleware' => ['message']], function(){

//留言板添加
  // Route::get('/Message/create','Message@create');

});
Route::post('message_info','Message@message_info');
Route::get('/Message/add','Message@add');
 Route::post('/Message/save','Message@save');
 Route::get('/Message/delete','Message@delete');






	
////////////////////////////////////////////////////
 Route::get('/Wechat/get_access_token','Wechat@get_access_token');
 Route::get('/Wechat/get_user_list','Wechat@get_user_list');
 Route::get('/Wechat/get_user_info','Wechat@get_user_info');
 Route::get('/Wechat/pro','Wechat@pro');

 Route::get('/Wechat/login','Wechat@login');
 Route::get('/Wechat/code','Wechat@code');

 Route::get('/Wechat/template_list','Wechat@template_list');
 Route::get('/Wechat/del_template','Wechat@del_template');
 Route::get('/Wechat/push_template','Wechat@push_template');
 Route::get('/Wechat/upload_source','Wechat@upload_source');
 Route::post('/Wechat/do_upload','Wechat@do_upload');

 Route::get('/Wechat/add_tag','Wechat@add_tag');
 Route::post('/Wechat/do_add_tag','Wechat@do_add_tag');
 Route::get('/Wechat/tag_list','Wechat@tag_list');
 Route::get('/Wechat/del_tag','Wechat@del_tag');
 Route::get('/Wechat/set_tag','Wechat@set_tag');
 Route::get('/Wechat/user_tag_list','Wechat@user_tag_list');
 Route::get('/Wechat/user_list','Wechat@user_list');
 Route::get('/Wechat/push_message','Wechat@push_message');
 Route::get('/Wechat/message','Wechat@message');
 Route::get('/Wechat/message_list','Wechat@message_list');
 Route::get('/Wechat/event','Wechat@event');
 Route::get('/Wechat/seconds_user_list','Wechat@seconds_user_list');
 Route::get('/Wechat/seconds_qr','Wechat@seconds_qr');

 
  






  

////////////////////////////////////////////////////

 