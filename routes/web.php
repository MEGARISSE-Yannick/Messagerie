<?php
Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::get('/home', 'ConversationsController@index')->name('home');

Route::get('/conversations', 'ConversationsController@index')->name('conversations');

Route::get('/conversations/{user}', 'ConversationsController@show')

    ->name('conversations.show');

Route::post('/conversations/{user}', 'ConversationsController@store');
