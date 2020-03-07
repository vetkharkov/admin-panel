<?php


Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**  ADMIN ZONE   */

Route::group(['midleware' => ['auth', 'status']], function () {
    $groupData = [
        'namespace' => 'AdminZone\Admin',
        'prefix'    => 'admin',
    ];

    Route::group($groupData, function () {

        Route::resource('index', 'MainController')->names('adminzone.admin.index');

        /**  Orders */
        Route::resource('orders', 'OrderController')->names('adminzone.admin.orders');
        Route::get('/orders/change/{id}', 'OrderController@change')->name('adminzone.admin.orders.change');
        Route::post('/orders/save/{id}', 'OrderController@save')->name('adminzone.admin.orders.save');
        Route::get('/orders/forcedestroy/{id}', 'OrderController@forcedestroy')->name('adminzone.admin.orders.forcedestroy');

        /**  Menu Category */

        Route::get('/categories/mydel', 'CategoryController@myDel')->name('adminzone.admin.categories.mydel');
        Route::resource('categories', 'CategoryController')->names('adminzone.admin.categories');

        /**  Users */

        Route::resource('users', 'UserController')->names('adminzone.admin.users');



    });


});

Route::get('/user/index', 'AdminZone\User\MainController@index');
