<?php

Route::post('/login', [
    'uses' => 'AuthenticationController@login',
    'as'   => 'api.v1.login',
]);

Route::group(['middleware' => ['jwt.auth']], function () {

    Route::resource('/users', 'UsersController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

});

