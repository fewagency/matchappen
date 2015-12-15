<?php

Route::get('/', function () {
    return view('index');
});

Route::get(trans('general.workplaces'), 'WorkplaceController@index');

// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('registrering', 'Auth\AuthController@getRegister');
Route::post('registrering', 'Auth\AuthController@postRegister');

//TODO: set up password reset routes