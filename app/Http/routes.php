<?php

//Index page has no controller class
Route::get('/', function () {
    $limit = 5;

    $opportunities = \Matchappen\Opportunity::promoted()->limit($limit)->get();
    if (!count($opportunities)) {
        $opportunities = \Matchappen\Opportunity::viewable()->get();
        if (count($opportunities) > $limit) {
            $opportunities = $opportunities->random($limit);
        }
    }

    $workplaces = \Matchappen\Workplace::promoted()->limit($limit)->get();
    if (!count($workplaces)) {
        $workplaces = \Matchappen\Workplace::published()->get();
        if (count($workplaces) > $limit) {
            $workplaces = $workplaces->random($limit);
        }
    }

    $occupations = \Matchappen\Occupation::promoted()->limit($limit)->get();
    if (!count($occupations)) {
        $occupations = \Matchappen\Occupation::published()->get();
        if (count($occupations) > $limit) {
            $occupations = $occupations->random($limit);
        }
    }

    $body_class = 'start-page';

    return view('index', compact('opportunities', 'workplaces', 'occupations', 'body_class'));
});

//Occupations
Route::group(['prefix' => trans_choice('occupation.occupation', 1)], function () {
    Route::get('/', 'OccupationController@index');
    Route::get('{occupation}', 'OccupationController@show');
});

//Workplaces
Route::group(['prefix' => trans_choice('workplace.workplace', 1)], function () {
    Route::get('/', 'WorkplaceController@index');
    Route::get('{workplace}/edit', 'WorkplaceController@edit');
    Route::post('{workplace}/update', 'WorkplaceController@update');
    Route::post('{workplace}/approve', 'WorkplaceController@approve');

    //Show is last to catch longer urls before trying this
    Route::get('{workplace}', 'WorkplaceController@show');
});

//Opportunities
Route::group(['prefix' => trans_choice('opportunity.opportunity', 1)], function () {
    Route::get('/', 'OpportunityController@index');
    Route::get('create', 'OpportunityController@create');
    Route::post('store', 'OpportunityController@store');
    Route::get('{opportunity}/edit', 'OpportunityController@edit');
    Route::post('{opportunity}/update', 'OpportunityController@update');

    //Booking opportunity
    Route::get('{opportunity}/boka', 'BookingController@create');
    Route::post('{opportunity}/boka', 'BookingController@store');

    //Show is last to catch longer urls before trying this
    Route::get('{opportunity}', 'OpportunityController@show');
});

//Bookings
// Prefix for booking urls is hardcoded because it needs to be fixed for emailed links
Route::group(['prefix' => 'bokning'], function () {
    Route::get('reserverad', 'BookingController@reserved');
    Route::get('klar', 'BookingController@completed');
    Route::post('{booking}/avboka', 'BookingController@postCancel');

    //Show is last to catch longer urls before trying this
    Route::get('{booking}', 'BookingController@show');
});

//Evaluation of opportunities
Route::group(['prefix' => trans_choice('evaluation.evaluation', 1)], function () {
    Route::get('{opportunity}', 'OpportunityEvaluationController@create');
    Route::post('{opportunity}', 'OpportunityEvaluationController@store');
});

// Dashboard for workplaces, admins, supervisors, and students too!
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
    Route::get('{token}/{email?}', 'Auth\EmailTokenController@getLogin');
    Route::post('{token}', 'Auth\EmailTokenController@postLogin');
});