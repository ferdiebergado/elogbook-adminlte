<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Modules\Users\Http\Controllers'], function()
{
	Route::get('users/{user}', 'UsersController@show')->name('users.show');
	Route::match(['put','patch'], 'users/{user}', 'UsersController@update')->name('users.update');
	Route::get('users/{user}/edit', 'UsersController@edit')->name('users.edit');
	Route::resource('users', 'UsersController')->except(['show', 'update', 'edit'])->middleware('admin');
	Route::post('user/{user}/avatar', 'UsersController@avatar')->name('user.avatar');
	Route::match(['put','patch'], 'user/{user}/changepassword', 'UsersController@updatePassword')->name('user.changepassword');	
});
