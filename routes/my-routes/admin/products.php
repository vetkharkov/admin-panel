<?php

Route::get('/products/related', 'ProductController@related')->name('adminzone.admin.products.related');

Route::match(['get', 'post'],'/products/ajax-image-upload', 'ProductController@ajaxImage')->name('adminzone.admin.products.ajaxImage');

Route::delete('/products/ajax-image-remove/{filename}','ProductController@deleteImage')->name('adminzone.admin.products.deleteImage');

Route::post('/products/gallery', 'ProductController@gallery')->name('adminzone.admin.products.gallery');
Route::post('/products/delete-gallery', 'ProductController@deleteGallery')->name('adminzone.admin.products.deletegallery');

Route::get('/products/return-status/{id}', 'ProductController@returnStatus')->name('adminzone.admin.products.return-status');
Route::get('/products/delete-status/{id}', 'ProductController@deleteStatus')->name('adminzone.admin.products.delete-status');

Route::get('/products/delete-product/{id}', 'ProductController@deleteProduct')->name('adminzone.admin.products.delete-product');


Route::resource('products', 'ProductController')->names('adminzone.admin.products');


