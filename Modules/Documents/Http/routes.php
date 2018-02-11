<?php
Route::group(['middleware' => ['web', 'auth', 'user', 'prevent_back_history'], 'namespace' => 'Modules\Documents\Http\Controllers'], function() 
{
	Route::resource('documents', 'DocumentsController')->except(['destroy']);
	Route::delete('documents/{documents}', 'DocumentsController@destroy')->name('documents.destroy')->middleware('admin');
	Route::resource('transactions', 'TransactionsController')->except(['destroy']);
	Route::delete('transactions/{transactions}', 'TransactionsController@destroy')->name('transactions.destroy')->middleware('admin');	
});
