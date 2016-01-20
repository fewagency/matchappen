<?php

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => trans('general.workplaces')], function () {
    Route::get('/', 'WorkplaceController@index');
    Route::get('{workplace}/edit', 'WorkplaceController@edit');
    Route::post('{workplace}/update', 'WorkplaceController@update');
});
Route::get(trans('general.workplace') . '/{workplace}', 'WorkplaceController@show');

Route::group(['prefix' => trans('general.opportunities')], function () {
    Route::get('/', 'OpportunityController@index');
    Route::get('create', 'OpportunityController@create');
    Route::post('store', 'OpportunityController@store');
    Route::get('{opportunity}/edit', 'OpportunityController@edit');
    Route::post('{opportunity}/update', 'OpportunityController@update');
    Route::get('{opportunity}/boka', 'OpportunityController@booking');
    Route::post('{opportunity}/boka', 'BookingController@store');
    Route::get('{opportunity}', 'OpportunityController@show');
});

Route::group(['prefix' => 'bokning'], function () {
    Route::get('reserverad', 'BookingController@reserved');
    Route::get('klar', 'BookingController@completed');
    Route::get('{booking}', 'BookingController@show');
});

// Dashboard for workplaces and admins
Route::get('hem', 'UserController@dashboard')->name('dashboard');

// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('registrering', 'Auth\AuthController@getRegister');
Route::post('registrering', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Token authentication routes...
Route::group(['prefix' => 'token'], function () {
    Route::get('logout', 'Auth\EmailTokenController@getLogout');
    Route::get('email', 'Auth\EmailTokenController@getEmail');
    Route::post('email', 'Auth\EmailTokenController@postEmail');
    Route::get('{token}/{email?}', 'Auth\EmailTokenController@getLogin'); //TODO: validate token length in route?
    Route::post('{token}', 'Auth\EmailTokenController@postLogin'); //TODO: validate token length in route?
});