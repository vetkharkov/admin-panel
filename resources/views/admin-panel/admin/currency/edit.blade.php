@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Редактирование валюты
            @endslot
            @slot('parent')
                Главная
            @endslot
            @slot('currency')
                Список валют
            @endslot
            @slot('active')
                Редактирование валюты
            @endslot

        @endcomponent

    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('adminzone.admin.currency.update', $currency->id) }}" method="post"
                          data-toggle="validator">
                        @csrf
                        <div class="box-body">

                            <div class="form-group has-feedback">
                                <label for="title">Наименование валюты</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       placeholder="Наименование валюты"
                                       value="{{$currency->title, old('title')}}"
                                       required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="code">Код валюты</label>
                                <input type="text" name="code" class="form-control" id="code"
                                       placeholder="Код валюты"
                                       value="{{$currency->code, old('code')}}"
                                       required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="symbol_left">Символ слева</label>
                                <input type="text" name="symbol_left" class="form-control" id="symbol_left"
                                       placeholder="Символ слева"
                                       value="{{$currency->symbol_left, old('symbol_left')}}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="symbol_right">Символ справа</label>
                                <input type="text" name="symbol_right" class="form-control" id="symbol_right"
                                       placeholder="Символ справа"
                                       value="{{$currency->symbol_right, old('symbol_right')}}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="value">Значение</label>
                                <input type="text" name="value" class="form-control" id="value"
                                       placeholder="Если это базовая валюта, поставьте 1"
                                       title="Если это базовая валюта, поставьте 1"
                                       data-error="Допускаются цифры и десятичная точка"
                                       pattern="^[0-9.]{1,}"
                                       value="{{$currency->value, old('value')}}"
                                       required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="value">
                                    <input type="checkbox" name="base" @if ($currency->base) checked @endif>
                                    Базовая валюта
                                </label>
                            </div>

                            <div class="footer">
                                <button type="submit" class="btn btn-success">Изменить</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
