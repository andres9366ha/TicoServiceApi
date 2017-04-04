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
    return view('PaginasWeb.Busqueda');
});

Route::get('registro', function(){
      return view('PaginasWeb.registro');
});

Route::get('login', function(){
      return view('PaginasWeb.login');
});
