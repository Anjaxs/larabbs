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



Auth::routes(['verify' => true]);

Route::group(['middleware' => ['verified']], function () {
    Route::get('/', 'PagesController@root')->name('root');

    Route::resource('users', 'UsersController', [
        'only' => ['show', 'update', 'edit']
    ]);

    Route::resource('topics', 'TopicsController', [
        'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']
    ]);

    Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

    Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
});

