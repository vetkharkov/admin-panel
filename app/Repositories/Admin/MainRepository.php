<?php

namespace App\Repositories\Admin;

use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Model;

class MainRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public static function getCountOrders()
    {
        $count = \DB::table('orders')
            ->where('status', '0')
            ->get()
            ->count();

        return $count;
    }

    public static function getCountUsers()
    {
        $user = \DB::table('users')
            ->get()
            ->count();

        return $user;
    }

    public static function getCountProducts()
    {
        $products = \DB::table('products')
            ->get()
            ->count();

        return $products;
    }

    public static function getCountCategories()
    {
        $products = \DB::table('categories')
            ->get()
            ->count();

        return $products;
    }


}