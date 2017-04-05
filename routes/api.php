<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users',[
    'uses' => 'UserController@index'
]);

Route::get('/user/{id}',[
    'uses' => 'UserController@show'
]);

Route::post('/user', [
    'uses' => 'UserController@store'
]);

Route::post('/user/login', [
    'uses' => 'UserController@login'
]);

Route::patch('/user/{id}',[
    'uses' => 'UserController@update',
    'middleware' => 'auth.jwt'
]);

Route::get('/services',[
    'uses' => 'ServiceController@index'
]);

Route::get('/service/{id}',[
    'uses' => 'ServiceController@show'
]);

Route::post('/service',[
    'uses' => 'ServiceController@store'
]);

Route::patch('/service/{id}',[
    'uses' => 'ServiceController@update',
    'middleware' => 'auth.jwt'
]);


Route::get('/comments',[
    'uses' => 'CommentController@index'
]);

Route::get('/comment/{id}',[
    'uses' => 'CommentController@show'
]);

Route::post('/comment',[
    'uses' => 'CommentController@store'
]);

Route::patch('/comment/{id}',[
    'uses' => 'CommentController@update',
    'middleware' => 'auth.jwt'
]);



Route::get('/collaborators',[
    'uses' => 'CollaboratorController@index'
]);

Route::get('/collaborator/{id}',[
    'uses' => 'CollaboratorController@show'
]);

Route::post('/collaborator',[
    'uses' => 'CollaboratorController@store'
]);

Route::patch('/collaborator/{id}',[
    'uses' => 'CollaboratorController@update',
    'middleware' => 'auth.jwt'
]);


// Route::patch('/user/userActivation/{token}',[
//     'uses' => 'UserController@userActivation'
// ]);
