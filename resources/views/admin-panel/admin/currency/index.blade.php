@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Валюта
            @endslot
            @slot('parent')
                Главная
            @endslot
            @slot('active')
                Валюта
            @endslot

        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{ route('adminzone.admin.currency.add') }}" class="btn btn-primary">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить валюту
                            </a>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Код</th>
                                    <th>Значение</th>
                                    <th>Базовая</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($currency as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->value }}</td>
                                        <td>
                                            @if($item->base == 1) Да @else Нет @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('adminzone.admin.currency.edit', $item->id) }}"
                                               title="Редактировать">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('adminzone.admin.currency.delete', $item->id) }}"
                                               class="delete text-danger" title="Удалить">
                                                <i class="fa fa-fw fa-close"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">
                                            <h2>Валюты нет</h2>
                                        </td>
                                    </tr>

                                @endforelse
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
