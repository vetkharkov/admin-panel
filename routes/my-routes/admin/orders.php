<?php

Route::resource('orders', 'OrderController')->names('adminzone.admin.orders');
Route::get('/orders/change/{id}', 'OrderController@change')->name('adminzone.admin.orders.change');
Route::post('/orders/save/{id}', 'OrderController@save')->name('adminzone.admin.orders.save');
Route::get('/orders/forcedestroy/{id}','OrderController@forcedestroy')->name('adminzone.admin.orders.forcedestroy');

