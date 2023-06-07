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

Auth::routes();

Route::get('/admin/{vue_capture?}', ['middleware' => 'auth', 'uses' => 'Admin\AdminController@getApp'])->where('vue_capture', '[\/\w\.-]*');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('descargar-excell', ['as' => 'admin.download-excell', 'middleware' => 'auth', 'uses' => 'Admin\AdminController@downloadExcell']);

Route::get('citas/{id}/descargar-excell', ['as' => 'admin.download-excell-by-date', 'middleware' => 'auth', 'uses' => 'Admin\AdminController@downloadExcellByDate']);

Route::get('/{vue_capture?}', 'Website\WebsiteController@getApp')->where('vue_capture', '[\/\w\.-]*');




