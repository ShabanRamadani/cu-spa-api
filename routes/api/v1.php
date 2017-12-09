<?php

Route::resource('/users', 'UsersController', ['only' => ['index', 'show']]);