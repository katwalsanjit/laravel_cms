<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('categories', 'CategoriesController');
    Route::resource('posts', 'PostsController');
    Route::resource('tags', 'TagsController');

    Route::get('trashed-posts', 'PostsController@trashed')->name('trashed-posts.index');

    Route::put('restore-post/{post}', 'PostsController@restore')->name('restore-posts');

    Route::get('items', 'ItemController@index')->name('items');
    Route::post('items/import', 'ItemController@import')->name('import_files');
    Route::get('items/export', 'ItemController@export')->name('export_files');


});

Route::middleware(['auth', 'admin'])->group(function(){
    Route::get('users', 'UsersController@index')->name('users.index');
    Route::post('users/{user}/make-admin', 'UsersController@makeAdmin')->name('users.make-admin');

});




