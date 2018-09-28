<?php

// routes for shared behavior. maybe even extract them us API endpoints
Route::patch('update/active/{model_name}/{model_id}', 'ModelController@updateActive');
Route::delete('seek-and-destroy/{model_name}/{model_id}', 'ModelController@destroy');

// Dashboard
Route::get('/', 'DashboardController@index')->name('admin.dashboard');