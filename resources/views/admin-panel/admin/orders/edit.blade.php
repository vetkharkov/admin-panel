@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Редактирование заказа № {{ $item->id }}
            @endslot

            @slot('parent')
                Главная
            @endslot

            @slot('order')
                Список заказов
            @endslot

            @slot('active')
                Заказ № {{ $item->id }}
            @endslot

        @endcomponent

        <h1>
            {{-- Если заказ новый и не обработан то выводим и передаём status 1 --}}
            @if(!$order->status)
                <a href="{{ route('adminzone.admin.orders.change', $item->id) }}/?status=1" class="btn btn-success btn-xs">Одобрить</a>
                <a href="" class="btn btn-warning btn-xs order-edit">Редактировать</a>
            @else
                <a href="{{ route('adminzone.admin.orders.change', $item->id) }}/?status=0" class="btn btn-default btn-xs">Вернуть на доработку</a>
            @endif
            <a href="" class="btn btn-xs">
                <form id="delform" method="post" action="{{ route('adminzone.admin.orders.destroy', $order->id) }}"
                      style="float:none">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-xs delete">Удалить</button>
                </form>
            </a>
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <form method="post" action="{{ route('adminzone.admin.orders.save', $order->id) }}">
                                @csrf
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                    <tr>
                                        <td>Номер заказа</td>
                                        <td>{{ $order->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Дата заказа</td>
                                        <td>{{ $order->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>Дата изменения заказа</td>
                                        <td>{{ $order->updated_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>Колличество позиций в заказе</td>
                                        <td>{{ count($order_products) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Сумма</td>
                                        <td>{{ $order->sum }} {{ $order->currency }}</td>
                                    </tr>
                                    <tr>
                                        <td>Имя заказчика</td>
                                        <td>{{ $order->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Комментарий</td>
                                        <td>
                                            <input type="text"
                                                   name="comment"
                                                   value="@if(isset($order->note)) {{ $order->note }} @endif"
                                                   placeholder="@if(!isset($order->note)) комментариев нет @endif">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <input type="submit"
                                       name="submit"
                                       value="Сохранить"
                                       class="btn btn-warning">
                            </form>
                        </div>
                    </div>
                </div>
                <h3>Детали заказа</h3>
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Колличество</th>
                                    <th>Цена</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $qty = 0 @endphp
                                @foreach($order_products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->qty, $qty+=$product->qty }}</td>
                                        <td>{{ $product->price }}</td>
                                    </tr>
                                @endforeach

                                <tr class="active">
                                    <td colspan="2">
                                        <b>Итого:</b>
                                    </td>
                                    <td>
                                        <b>{{ $qty }}</b>
                                    </td>
                                    <td>
                                        <b>{{ $order->sum }} {{ $order->currency }}</b>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
