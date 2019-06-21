<?php

/*
|--------------------------------------------------------------------------
| Module Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth', 'permission:shift.index'], 'prefix' => 'shifts'], function (){

    Route::get('/', function (){
        return view('Shift::index');
    })->name('shifts.index');

    Route::group(['middleware' => [
        'permission:shift.create', 'permission:shift.edit', 'permission:shift.delete'
    ]], function (){

        Route::resource('/locals', 'LocalController', ['as' => 'shifts']);

        Route::resource('/tasks', 'TaskController', ['as' => 'shifts']);

        Route::resource('/activities', 'ActivityController', ['as' => 'shifts']);

    });

});