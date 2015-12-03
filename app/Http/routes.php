<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',[
    'as' => 'index',
    'uses' => 'TODOController@index'
]);

Route::get('/about',[
    'as' => 'about',
    'uses' => 'TODOController@about'
]);

Route::get('/inscription',[
    'as' => 'inscription',
    'uses' => 'TODOController@inscription'
]);

Route::get('/home',[
    'as' => 'home',
    'uses' => 'TODOController@index'
]);

Route::post('/addListe','TODOController@addListe');



Route::get('/deleteListe/{name_liste}',[
    'as'=>'deleteListe',
    'uses'=>'TODOController@deleteListe'
]);

Route::post('/addTask/{name_liste}',[
    'as'=>'addTask',
    'uses'=>'TODOController@addTask'
]);

Route::get('/deleteTache/{name_liste}/{tache}',[
    'as'=>'deleteTask',
    'uses'=>'TODOController@deleteTask'
]);


Route::get('/valideTask/{name_liste}/{tache}',[
    'as'=>'valideTask',
    'uses'=>'TODOController@valideTask'
]);



Route::post('/editTask/{name_liste}/{tache}',[
    'as'=>'editTask',
    'uses'=>'TODOController@editTask'
]);

Route::post('/editList/{name_liste}',[
    'as'=>'editList',
    'uses'=>'TODOController@editList'
]);

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');