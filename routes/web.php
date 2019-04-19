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

// Inicio Categorias
Route::resource('categorias','CategoriasController');
Route::put('categoria/activar/{id}','CategoriasController@activar')->name('categorias.activar');
Route::put('categoria/desactivar/{id}','CategoriasController@desactivar')->name('categorias.desactivar');
Route::get('select/categorias','CategoriasController@select')->name('categorias.select');
// Fin Categorias

// Inicio Articulos
Route::resource('articulos','ArticulosController');
Route::put('articulo/activar/{id}','ArticulosController@activar')->name('articulos.activar');
Route::put('articulo/desactivar/{id}','ArticulosController@desactivar')->name('articulos.desactivar');
// Fin Articulos
