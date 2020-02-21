<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Последние заказы</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Покупатель</th>
                    <th>Статус</th>
                    <th>Сумма</th>
                </tr>
                </thead>

                <tbody>
                @foreach($last_orders as $order)
                    <tr>
                        <td><a href="">{{ $order->id }}</a></td>
                        <td><a href="">{{ ucfirst($order->name) }}</a></td>
                        <td>
                            <span class="label label-success">
                                @if($order->status == 0) Новый @endif
                                @if($order->status == 1) Завершен @endif
                                @if($order->status == 2) Удалён @endif
                            </span>
                        </td>
                        <td>
                            <div class="sparkbar" data-color="#00a65a" data-height="20">
                                {{ $order->sum }} грн.
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>