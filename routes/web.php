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
//        Route::resource('users', 'UserController')->names('adminzone.admin.users');





    });


});

Route::get('/user/index', 'AdminZone\User\MainController@index');
