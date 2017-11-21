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

//publics
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Auths
Route::group(['middleware' => 'auth'], function() {

	// admin
	Route::group(['prefix' => 'admin' , 'middleware' => 'admin'], function() {		
		Route::get('/', function() {
			return 'ok';
		});  // to be copleted
	});

	// users
	Route::get('/home', 'HomeController@index')->name('home');

});


