<?php
Route::group(['middleware' => ['web', 'auth', 'user', 'prevent_back_history'], 'namespace' => 'Modules\Documents\Http\Controllers'], function() 
{
	Route::resource('documents', 'DocumentsController')->except(['destroy']);
	Route::delete('documents/{documents}', 'DocumentsController@destroy')->name('documents.destroy')->middleware('admin');
	Route::get('transactions/{transactions}/receive', 'TransactionsController@receive')->name('transactions.receive');	
	Route::get('transactions/{transactions}/release', 'TransactionsController@release')->name('transactions.release');
	Route::resource('transactions', 'TransactionsController')->except(['destroy']);
	Route::delete('transactions/{transactions}', 'TransactionsController@destroy')->name('transactions.destroy')->middleware('admin');	
	Route::view('offices', 'documents::offices')->name('offices.active');
});
