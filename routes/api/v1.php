<?php

Route::post('/login', [
    'uses' => 'AuthenticationController@login',
    'as'   => 'api.v1.login',
]);

//Route::group(['middleware' => ['jwt.auth']], function () {

    Route::post('/logout', [
        'uses' => 'AuthenticationController@logout',
        'as'   => 'api.v1.logout',
    ]);

    Route::get('/me', [
        'uses' => 'AuthenticationController@me',
        'as'   => 'api.v1.me',
    ]);

    Route::resource('/users', 'UsersController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

    Route::resource('/locations', 'LocationsController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

//});

