<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('PaginasWeb.busqueda');
});

Route::get('/user/activation/{token}',
'UserController@userActivation');


Route::get('registro', function(){
      return view('PaginasWeb.registro');
});

Route::get('login', function(){
      return view('PaginasWeb.login');
});

Route::get('busqueda', function(){
      return view('PaginasWeb.busqueda');
});
