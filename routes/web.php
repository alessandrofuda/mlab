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


// redirect catcher
// Route::get('action/{param}', function ($param){
//	return ??tinker.php??;
// });


// public pages
Route::get('/', function () {
    return view('welcome');
});




// Auths
Auth::routes();
Route::group(['middleware' => 'auth'], function() {

	// admin
	Route::group(['prefix' => 'admin' , 'middleware' => 'admin'], function() {		 
		// admin dashboard
		Route::get('home', 'AdminController@dashboard');
		// Users CRUD operation
		Route::get('users', 'AdminController@index');
		Route::post('user/create', 'AdminController@create');
		// Route::post('user/store', 'AdminController@store');
		Route::get('user/{user_id}/edit', 'AdminController@edit');
		Route::post('user/{user_id}/update', 'AdminController@update');
		Route::get('user/{user_id}/destroy', 'AdminController@destroy');
		// Route::post('user/{user_id}/reset-psw', 'AdminController@reset_psw');
		// dashboard customization
		Route::get('dashboards-customization', 'AdminController@dashboards_customization');
		// export data
		Route::get('exports', 'AdminController@exports');
	});



	// users
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('my-profile', 'UserController@my_profile')->name('myprofile');
	Route::get('change-my-psw', 'UserController@change_my_psw')->name('changeMyPsw');



});


