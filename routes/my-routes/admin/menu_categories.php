<?php

Route::get('/categories/mydel', 'CategoryController@myDel')->name('adminzone.admin.categories.mydel');
Route::resource('categories', 'CategoryController')->names('adminzone.admin.categories');

