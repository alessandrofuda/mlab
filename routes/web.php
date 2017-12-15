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


// public pages
Route::get('/', function () {
    return view('welcome');
});


// ajax calls (ony public?)
Route::post('ajax/dashboard', 'AjaxDashboardController@repositioning');
Route::post('/ajax/deactivate-widget', 'AjaxDashboardController@deactivate_widget');
// Route::post('/ajax/activate-widget', 'AjaxDashboardController@activate_widget');


// Auths
Auth::routes();
Route::group(['middleware' => 'auth'], function() {

	// admin only
	Route::group(['prefix' => 'admin' , 'middleware' => 'admin'], function() {		 
		// admin dashboards
		Route::get('home', 'AdminController@dashboard');			// verificare correttezza: --> più routes verso stesso controller e Metodo
		Route::get('dashboard-{id?}', 'AdminController@dashboard');  
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


		// testing route
		// Route::get('test-{user_id}', 'AdminController@init_widgets');


	});



	// users or admins
	Route::get('home', 'UserController@index')->name('home');
	Route::get('dashboard-{id?}', 'UserController@index');   // verificare correttezza: --> più routes verso stesso controller e Metodo
	Route::get('my-profile', 'UserController@my_profile')->name('myprofile');
	Route::get('change-my-psw', 'UserController@change_my_psw')->name('changeMyPsw');





});


