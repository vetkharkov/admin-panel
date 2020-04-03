<?php

/** Currency */

Route::get('/currency/index', 'CurrencyController@index')->name('adminzone.admin.currency.index');

/** Add */

Route::get('/currency/add', 'CurrencyController@currencyAdd')->name('adminzone.admin.currency.add');
Route::post('/currency/add', 'CurrencyController@currencyStore')->name('adminzone.admin.currency.store');

/** Edit */

Route::get('/currency/edit/{id}', 'CurrencyController@currencyEdit')->name('adminzone.admin.currency.edit');
Route::post('/currency/edit/{id}', 'CurrencyController@currencyUpdate')->name('adminzone.admin.currency.update');

/** Delete */

Route::get('/currency/delete/{id}', 'CurrencyController@currencyDelete')->name('adminzone.admin.currency.delete');
