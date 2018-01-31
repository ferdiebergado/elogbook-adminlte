<?php

Route::group(['middleware' => 'web', 'prefix' => 'auth', 'namespace' => 'Modules\Auth\Http\Controllers'], function()
{ 

    Route::get('login', 'LoginController@showLoginForm')->name('login');

    Route::post('login', 'LoginController@login');

    Route::post('logout', 'LoginController@logout')->name('logout');

    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');

    Route::post('password/reset', 'ResetPasswordController@reset');

    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');

    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');

    Route::post('register', 'RegisterController@register');

    Route::redirect('/', 'login');

    // Route::get('/', 'AuthController@index');
});
