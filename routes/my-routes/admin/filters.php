<?php

/** Group Filter */

Route::get('/filter/group-filter', 'FilterController@attributeGroup')->name('adminzone.admin.filters.group-filter');

Route::get('/filter/group-create', 'FilterController@groupCreate')->name('adminzone.admin.filters.group-create');
Route::post('/filter/group-add-group', 'FilterController@groupAdd')->name('adminzone.admin.filters.group-add');

Route::get('/filter/group-edit/{id}', 'FilterController@groupEdit')->name('adminzone.admin.filters.group-edit');
Route::post('/filter/group-edit/{id}', 'FilterController@groupUpdate')->name('adminzone.admin.filters.group-update');

Route::get('/filter/group-delete/{id}', 'FilterController@groupDelete')->name('adminzone.admin.filters.group-delete');

/** Attributes filter */

Route::get('/filter/attributes-filter', 'FilterController@attributeFilter')->name('adminzone.admin.filters.attributes-filter');

Route::get('/filter/attr-add', 'FilterController@attributeAdd')->name('adminzone.admin.filters.attr-add');
Route::post('/filter/attr-add', 'FilterController@attributeStore')->name('adminzone.admin.filters.attr-store');

Route::get('/filter/attr-edit/{id}', 'FilterController@attributeEdit')->name('adminzone.admin.filters.attr-edit');
Route::post('/filter/attr-edit/{id}', 'FilterController@attributeUpdate')->name('adminzone.admin.filters.attr-update');

Route::get('/filter/attr-delete/{id}', 'FilterController@attributeDelete')->name('adminzone.admin.filters.attr-delete');



