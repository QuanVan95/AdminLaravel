<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
	]);

Route::group(['prefix'=>'admin','middleware'=>'auth'],function (){ //middleware kiểm tra login
	Route::group(['prefix' => 'cate'], function(){
		Route::get('add',['as'=>'admin.cate.getAdd','uses' => 'CateController@getAdd']);
		Route::post('add',['as'=>'admin.cate.postAdd','uses' => 'CateController@postAdd']);
		Route::get('list',['as'=>'admin.cate.list','uses' => 'CateController@getList']); 
		Route::get('delete/{id}',['as'=>'admin.cate.getDelete','uses' => 'CateController@getDelete']);
		Route::get('edit/{id?}',['as'=>'admin.cate.getEdit','uses' => 'CateController@getEdit']); // Phải truyền vào $id bên method getEdit bên CateController
		Route::post('edit/{id}',['as'=>'admin.cate.postEdit','uses' => 'CateController@postEdit']);
	});
	Route::group(['prefix' => 'product'], function() {
		Route::get('add',['as'=>'admin.product.getAdd','uses' => 'ProductController@getAdd']);
		Route::post('add',['as'=>'admin.product.getPost','uses' => 'ProductController@postAdd']);
		Route::get('list',['as'=>'admin.product.getList','uses'=>'ProductController@getList']);
		Route::get('delete/{id}',['as'=>'admin.product.getDelete','uses'=>'ProductController@getDelete']);
		Route::get('edit/{id}',['as'=>'admin.product.getEdit','uses'=>'ProductController@getEdit']);
		Route::post('edit/{id}',['as'=>'admin.product.postEdit','uses'=>'ProductController@postEdit']);
		Route::get('delimg/{id}',['as'=>'admin.product.getDelImg','uses'=>'ProductController@getDelImg']);
	});
	Route::group(['prefix' => 'user'], function(){
		Route::get('add',['as'=>'admin.user.getAdd','uses'=> 'UserController@getAdd']);
		Route::post('add',['as'=>'admin.user.postAdd','uses'=>'UserController@postAdd']);
		Route::get('list',['as'=>'admin.user.getList','uses'=>'UserController@getList']);
		Route::get('delete/{id}',['as'=>'admin.user.getDelete','uses'=>'UserController@getDelete']);
		Route::get('edit/{id}',['as'=>'admin.user.getEdit','uses'=>'UserController@getEdit']);
		Route::post('edit/{id}',['as'=>'admin.user.postEdit','uses'=>'UserController@postEdit']);
	
	});



	
});

Route::get('ho-chi-minh',['as'=>'taolaobidao',function(){
	echo "I'm checking...!";
}]);

Route::get('testDinhDanh','CateController@checkName');

Route::get('admin/list',function(){
	return view('admin.cate.list',compact('lalaa'));
});
Route::get("hello/{vari}/{baro}",function()
{
	return "i'm bi ";
});

Route::get("bi/{vari?}",function($vari = "DefaultHiihiii")
{
	return "$vari"."kakakaa";
});

Route::get('testcontroller','WelcomeController@checkcontroller');

Route::get('thong-tin',function(){
	$hoten='VHQ';
	$bonus='oakk';

	return view('thongtin',compact('oak','bonus'));
});

Route::get('x', function () {
	echo"Văn Hồng Quân";
});

Route::get('thongtin','WelcomeController@showinfo');

Route::group(['prefix'=>'thuc-don'],function(){
	Route::get('bun-bo', function () {
		echo"Đây là bún bò";
	});
	Route::get('bun-rieu', function () {
		echo"Đây là bún riêu";
	});
	
});