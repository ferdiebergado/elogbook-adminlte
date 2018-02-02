<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Modules\Documents\Http\Controllers'], function()
{
	Route::view('documents/create', 'documents::create')->name('documents.create');
	Route::delete('documents/{documents}', 'DocumentsController@destroy')->name('documents.destroy')->middleware('admin');
	Route::resource('documents', 'DocumentsController')->except(['create', 'destroy']);
});
