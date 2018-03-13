<?php
Route::name('admin.')->group(function() {
	Route::group(['middleware' => ['web', 'auth', 'user', 'prevent_back_history', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function() {
		Route::redirect('/', '/admin/environment')->name('home');
		Route::get('info', 'AdminController@info')->name('info');
		Route::get('environment', 'AdminController@environment')->name('environment');
		Route::get('dependencies', 'AdminController@dependencies')->name('dependencies');
		Route::view('commands', 'admin::artisan')->name('commands');
		Route::post('run', 'AdminController@run_command')->name('run_command');
		Route::get('documents', 'AdminController@documents')->name('documents');
		Route::get('transactions', 'AdminController@transactions')->name('transactions');
	});
});
