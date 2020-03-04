@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Панель управления
            @endslot

            @slot('parent')
                Главная
            @endslot

            @slot('active')
               <b>Список заказов</b>
            @endslot

        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Покупатель</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($paginator as $order)
                                    @php $class = $order->status ? 'success' : '' @endphp
                                    <tr class="{{ $class }}">
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>
                                            @if($order->status == 0) Новый @endif
                                            @if($order->status == 1) Завершен @endif
                                            @if($order->status == 2) <b style="color: red">Удалён</b>  @endif
                                        </td>
                                        <td>{{ $order->sum }} {{ $order->currency }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('adminzone.admin.orders.edit', $order->id) }}" title="Редактировать">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                            <a href="{{ route('adminzone.admin.orders.forcedestroy', $order->id) }}" title="Удалить">
                                                <i class="fa fa-fw fa-close text-danger deletebd"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">
                                            <h2>Заказов нет</h2>
                                        </td>
                                    </tr>

                                @endforelse
                                </tbody>

                            </table>
                        </div>
                        <div class="text-center">
                            <p>{{ count($paginator) }} заказа (ов) из {{ $countOrders }}</p>

                            @if($paginator->total() > $paginator->count())
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                {{ $paginator->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
