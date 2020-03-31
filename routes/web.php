<?php

Route::get('/test', function () {
//    ini_set('post_max_size', '10M');
//    ini_set('upload_max_filesize', '10M');
    phpinfo();
});

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**  ADMIN ZONE   */

Route::group(['midleware' => ['auth', 'status']], function () {
    $groupData = [
        'namespace' => 'AdminZone\Admin',
        'prefix' => 'admin',
    ];

    Route::group($groupData, function () {

        /**  Main menu */

        require_once 'my-routes/admin/main_index.php';

        /**  Orders */

        require_once 'my-routes/admin/orders.php';

        /**  Menu Category */

        require_once 'my-routes/admin/menu_categories.php';

        /**  Users */

        require_once 'my-routes/admin/users.php';

        /**  Products */

        require_once 'my-routes/admin/products.php';


    });


});

Route::get('/user/index', 'AdminZone\User\MainController@index');
