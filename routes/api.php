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

Route::patch('/saveUpdate/{token}', [
    'uses' => 'UserController@update'
]);

Route::post('/user/login', [
    'uses' => 'UserController@login'
]);

/* Route::patch('/user/{id}',[
    'uses' => 'UserController@update',
    'middleware' => 'auth.jwt'
]); */

Route::get('/services',[
    'uses' => 'ServiceController@index'
]);

Route::get('/serviceClient/{token}',[
    'uses' => 'ServiceController@myService'
]);

Route::get('/service/{id}',[
    'uses' => 'ServiceController@show'
]);

Route::get('/serviceName/{name}',[
    'uses' => 'ServiceController@showByName'
]);

Route::post('/service/{token}',[
    'uses' => 'ServiceController@store'
]);

Route::patch('/service/{id}',[
    'uses' => 'ServiceController@update'
]);

Route::delete('/serviceUpdate/{id}',[
    'uses' => 'ServiceController@destroy'
]);


Route::get('/comments',[
    'uses' => 'CommentController@index'
]);

Route::get('/comment/{id}',[
    'uses' => 'CommentController@show'
]);

Route::post('/comment/{token}',[
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


Route::get('/collaborators/search/{id}',[
    'uses' => 'CollaboratorController@searchByService'
]);

Route::post('/collaborator',[
    'uses' => 'CollaboratorController@store'
]);

Route::patch('/collaborator/{id}',[
    'uses' => 'CollaboratorController@update',
    'middleware' => 'auth.jwt'
]);


Route::get('getUser/{token}',[
    'uses' => 'UserController@detallesUser'
]);

Route::delete('/collaborator/delete/{id}',[
    'uses' => 'CollaboratorController@destroy'
]);

// Route::patch('/user/userActivation/{token}',[
//     'uses' => 'UserController@userActivation'
// ]);


/* Route::post('storeService/{id}',[
    'uses' => 'CollaboratorController@storeFromService'
]); */



Route::group(['prefix' => 'service'], function(){
  Route::get('/storeService/{id}/{token}',[
    'uses' => 'CollaboratorController@storeFromService'
  ]);
});
