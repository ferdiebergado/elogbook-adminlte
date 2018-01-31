<?php

    // Email confirmation 
    Route::get('confirmation/resend', 'RegisterController@resend');
    Route::get('confirmation/{id}/{token}', 'RegisterController@confirm');