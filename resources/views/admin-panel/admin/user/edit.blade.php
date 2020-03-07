@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Редактирование пользователя
            @endslot

            @slot('parent')
                Главная
            @endslot

            @slot('user')
                Список пользователей
            @endslot

            @slot('active')
                Редактирование пользователя № <b>{{ $item->id }}</b>
            @endslot

        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('adminzone.admin.users.update', $item->id) }}" method="post"
                          data-toggle="validator">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="login">Логин
                                    <small style="font-size: small; font-weight: normal">меняется автоматически</small>
                                </label>
                                <input type="text" name="login" class="form-control"
                                       placeholder="{{ ucfirst($item->name) }}" disabled>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="login">Пароль</label>
                                <input type="text" name="password" class="form-control"
                                       placeholder="Введите пароль если хотите его изменить">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="">Подтверждение пароля</label>
                                <input type="text" name="password_confirmation" class="form-control"
                                       id="password_confirmation"
                                       placeholder="Подтверждение пароля" required>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="name">Имя</label>
                                <input type="text" name="name" class="form-control" id="name"
                                       placeholder="Имя пользователя" required
                                       value="{{ $item->name }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="Введите почтовый ящик" required
                                       value="{{ $item->email }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="address">Роль</label>
                                <select name="role" class="form-control" id="role" required>
                                    <option value="1" @php  if ($role->name == 'disabled') echo ' selected' @endphp>
                                        Disabled
                                    </option>
                                    <option value="2" @php  if ($role->name == 'user') echo ' selected' @endphp>
                                        Пользователь
                                    </option>
                                    <option value="3" @php  if ($role->name == 'admin') echo ' selected' @endphp>
                                        Администратор
                                    </option>
                                </select>
                            </div>

                            <div class="footer">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-success">Сохранить</button>
                            </div>

                        </div>
                    </form>
                </div>

                <h3>Заказы пользователя</h3>

                <div class="box">
                    <div class="box-body">
                        @if($count)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Статус</th>
                                        <th>Сумма</th>
                                        <th>Дата создания</th>
                                        <th>Дата изменения</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($orders as $order)
                                        @php $class = $order->status ? 'succsess' : '' @endphp
                                        <tr class="{{ $class }}">
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->status ? 'Завершен' : 'Новый' }}</td>
                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                    {{ $order->sum }} {{ $order->currency }}
                                                </div>
                                            </td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ $order->updated_at }}</td>
                                            <td><a href="{{ route('adminzone.admin.orders.edit', $order->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>

                        @else
                            <p class="text-danger">Пользователь пока ничего не заказывал</p>
                        @endif

                    </div>
                </div>

                <div class="text-center">
                    <p>{{ count($count_orders)}} заказа из {{ $count }} }}</p>

                    @if($orders->total() > $orders->count())
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        {{ $orders->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
