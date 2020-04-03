<?php


/** Search admin panel */

Route::get('/search/result', 'SearchController@index')->name('adminzone.admin.search.index');

Route::get('/autocomplete', 'SearchController@search')->name('adminzone.admin.search.search');