<?php

Route::get('/', function () {
    return view('index');
});

Route::get(trans('general.workplaces'), 'WorkplaceController@index');