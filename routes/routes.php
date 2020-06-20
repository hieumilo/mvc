<?php

Route::get('/', 'HomeController@index');
Route::get('/work', 'WorkController@index');
Route::get('/work/create', 'WorkController@create');
Route::post('/work', 'WorkController@store');
Route::get('/work/{id}/edit', 'WorkController@edit');
Route::post('/work/{id}/update', 'WorkController@update');
Route::post('/work/delete', 'WorkController@delete');

Route::get('/calendar', 'CalendarController@index');
