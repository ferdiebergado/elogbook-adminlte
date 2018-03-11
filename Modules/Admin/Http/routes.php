<?php

Route::group(['middleware' => ['web', 'auth', 'user', 'prevent_back_history', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
	Route::redirect('/', 'environment');
    Route::get('info', 'AdminController@info')->name('admin.info');
    Route::get('environment', 'AdminController@environment')->name('admin.environment');
    Route::get('dependencies', 'AdminController@dependencies')->name('admin.dependencies');
    Route::view('commands', 'admin::artisan')->name('admin.commands');
    Route::post('run', 'AdminController@run_command')->name('admin.run_command');
    Route::get('documents', 'AdminController@documents')->name('admin.documents');
    Route::get('transactions', 'AdminController@transactions')->name('admin.transactions');
});
