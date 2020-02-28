<?php

namespace App\Http\Controllers\AdminZone\Admin;

use App\Http\Controllers\AdminZone\Admin\AdminBaseController;
use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\OrderRepository;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Http\Request;
use MetaTag;

class MainController extends AdminBaseController
{
    private $orderRepository;
    private $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->orderRepository = app(OrderRepository::class);
        $this->productRepository = app(ProductRepository::class);
    }

    public function index()
    {

        $last_orders = $this->orderRepository->getAllOrders(5);
        $last_products = $this->productRepository->getLastProducts(3);


        $countOrders     = MainRepository::getCountOrders();
        $countUsers      = MainRepository::getCountUsers();
        $countCategories = MainRepository::getCountCategories();
        $countProducts   = MainRepository::getCountProducts();

        MetaTag::setTags(['title' => 'Админ панель']);

        return view('admin-panel.admin.main.index',
            compact('countCategories','countOrders',
                'countProducts',
                'countUsers', 'last_orders',
                'last_products'));
    }
}
