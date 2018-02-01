<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'documents', 'namespace' => 'Modules\Documents\Http\Controllers'], function()
{
    Route::get('/', 'DocumentsController@index');
});
