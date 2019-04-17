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
    return view('contenido/contenido');
});


Route::resource('categorias','CategoriasController');
Route::put('categoria/activar/{id}','CategoriasController@activar')->name('categorias.activar');
Route::put('categoria/desactivar/{id}','CategoriasController@desactivar')->name('categorias.desactivar');
