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


// ajax calls (todo: MIDDLEWARE!!!! GROUP !!)
Route::group(['middleware' => 'ajax'], function() {
	Route::post('ajax/dashboard', 'AjaxDashboardController@repositioning');
	Route::post('/ajax/deactivate-widget', 'AjaxDashboardController@deactivate_widget');
	// Route::post('/ajax/activate-widget', 'AjaxDashboardController@activate_widget');
	Route::get('ajax/dashboard-customization/user-{user_id}', 'AjaxDashboardController@admin_select_user');
	// Route::get('ajax/dashboard-redesign/user-{user_id}/dashboard-{dashboard_id}', 'AjaxDashboardController@redesign_user_dashboard');
	// get data for google charts
	Route::get('ajax/data-widget-1', 'AjaxWidgetsController@getDataWidgetOne');
	Route::get('ajax/data-widget-2', 'AjaxWidgetsController@getDataWidgetTwo');
	Route::get('ajax/data-widget-3', 'AjaxWidgetsController@getDataWidgetThree');
	Route::get('ajax/data-widget-4', 'AjaxWidgetsController@getDataWidgetFour');
	Route::get('ajax/data-widget-5', 'AjaxWidgetsController@getDataWidgetFive');
});


// Auths
Auth::routes();
Route::group(['middleware' => 'auth'], function() {

	// admin only
	Route::group(['prefix' => 'admin' , 'middleware' => 'admin'], function() {		 
		// admin dashboards
		Route::get('home', 'AdminController@dashboard');			
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
		Route::post('dashboards-customization', 'AdminController@dashboards_customization_post');

		// export data
		Route::get('exports', 'AdminController@exports');


		
		// IMPORTANT! Service's / testing Routes
		Route::get('test', 'AjaxWidgetsController@getDataWidgetTwo');
		Route::get('regenerate-dash-widget-profile/{user_id}', 'AdminController@ .....');  // re-init user in UserDashboardWidget model (only update if not exist)
		Route::get('regenerate-subscription-profile/{user_id}', 'AdminControler@ ..... '); // re-init user in Subscription model



	});



	// users or admins
	Route::get('home', 'UserController@index')->name('home');
	Route::get('dashboard-{id?}', 'UserController@index');   
	Route::get('my-profile', 'UserController@my_profile')->name('myprofile');
	Route::get('change-my-psw', 'UserController@change_my_psw')->name('changeMyPsw');





});


