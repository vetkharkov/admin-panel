@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Добавление пользователя
            @endslot

            @slot('parent')
                Главная
            @endslot

            @slot('active')
                <b>Добавление пользователя</b>
            @endslot

        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('adminzone.admin.users.store') }}" method="post"
                          data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="name">Имя</label>
                                <input type="text" name="name" class="form-control" id="name"
                                       placeholder="Имя пользователя" required
                                       value="{{ old('name') }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="">Пароль</label>
                                <input type="password" name="password" class="form-control" id="password"
                                       placeholder="Введите пароль" required
                                       value="{{ old('password') }}">
                            </div>

                            <div class="form-group has-feedback">
                                <label for="">Подтверждение пароля</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                                       placeholder="Введите пароль" required
                                       value="{{ old('password_confirmation') }}">
                            </div>

                            <div class="form-group has-feedback">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="Введите почтовый ящик" required
                                       value="{{ old('email') }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="address">Роль</label>
                                <select name="role" class="form-control" id="role" required>
                                    <option value="1">Disabled</option>
                                    <option value="2" selected>Пользователь</option>
                                    <option value="3">Администратор</option>
                                </select>
                            </div>


                            <div class="footer">
                                <input type="hidden" name="id" value="">
                                <button type="submit" class="btn btn-success">Сохранить</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



@endsection
