<?php

/*
|--------------------------------------------------------------------------
| Module Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth', 'permission:shift.index'], 'prefix' => 'shifts'], function (){

    Route::resource('/calendar', 'CalendarController', ['as' => 'shifts']);

    Route::get('/calendar/data/source', 'CalendarController@source')->name('shifts.calendar.source');

    Route::group(['middleware' => [
        'permission:shift.create', 'permission:shift.edit', 'permission:shift.delete'
    ]], function (){

        Route::resource('/locals', 'LocalController', ['as' => 'shifts']);

        Route::resource('/tasks', 'TaskController', ['as' => 'shifts']);

        Route::resource('/activities', 'ActivityController', ['as' => 'shifts']);

        Route::resource('/templates', 'TemplateController', ['as' => 'shifts']);

    });

});