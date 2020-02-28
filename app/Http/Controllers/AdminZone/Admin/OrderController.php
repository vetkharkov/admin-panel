<?php

namespace App\Http\Controllers\AdminZone\Admin;

use App\Http\Requests\AdminOrderSaveRequest;
use App\Models\Admin\Order;
use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminZone\Admin\AdminBaseController;
use MetaTag;

class OrderController extends AdminBaseController
{
    private $orderRepository;

    public function __construct()
    {
        $this->orderRepository = app(OrderRepository::class);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $perpage = 10;
        $countOrders = MainRepository::getCountOrders();
        $paginator = $this->orderRepository->getAllOrders($perpage);

        MetaTag::setTags(['title' => 'Список заказов']);

        return view('admin-panel.admin.orders.index', compact('countOrders', 'paginator'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        MetaTag::setTags(['title' => "Заказ № {$id}"]);

        $item = $this->orderRepository->getId($id);
        if (empty($item)) {
            abort(404);
        }

        $order = $this->orderRepository->getOneOrder($item->id);

        if (!$order) {
            abort(404);
        }

        $order_products = $this->orderRepository->getAllOrderProductsId($item->id);

        return view('admin-panel.admin.orders.edit', compact('item', 'order', 'order_products'));

    }

    public function change($id)
    {
        $result = $this->orderRepository->changeStatusOrder($id);

        if ($result) {
            return redirect()->route('adminzone.admin.orders.edit', $id)->with(['success' => 'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка сохранения']);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $st = $this->orderRepository->changeStatusOnDeleteOrder($id);

        if ($st) {
            $result = Order::destroy($id);
            if ($result) {
                return redirect()->route('adminzone.admin.orders.index')->with(['success' => "Запись с id = $id удалена"]);
            } else {
                return back()->withErrors(['msg' => 'Ошибка удаления']);
            }
        } else {
            return back()->withErrors(['msg' => 'Статус не изменился']);
        }
    }

    public function save(AdminOrderSaveRequest $request, $id)
    {
        $result = $this->orderRepository->saveOrderComment($id);

        if ($result) {
            return redirect()->route('adminzone.admin.orders.edit', $id)
                ->with(['success' => "Запись с id = $id успешно сохранена"]);
        } else {
            return back()->withErrors(['msg' => 'Ошибка сохранения']);
        }

    }

    public function forcedestroy($id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => "Запись с id = $id не найдена"]);
        }

        $result = \DB::table('orders')->delete($id);

        if ($result) {
            return redirect()->route('adminzone.admin.orders.index')
                ->with(['success' => "Запись с id = $id успешно удалена с БД"]);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }

    }
}
