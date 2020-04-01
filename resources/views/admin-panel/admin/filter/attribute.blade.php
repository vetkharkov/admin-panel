@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Фильтры
            @endslot
            @slot('parent')
                Главная
            @endslot
            @slot('active')
                Фильтры
            @endslot

        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{ url('/admin/filter/attr-add') }}" class="btn btn-primary">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить атрибут фильтра
                            </a>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Группа</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($attrs as $attr)
                                    <tr>
                                        <td>{{ $attr->id }}</td>
                                        <td>{{ $attr->value }}</td>
                                        <td>{{ $attr->title }}</td>

                                        <td>
                                            <a href="{{ url('/admin/filter/attr-edit', $attr->id) }}" title="Редактировать">
                                                <i class="fa fa-fw fa-pencil"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="{{ url('/admin/filter/attr-delete', $attr->id) }}" class="delete text-danger" title="Удалить">
                                                <i class="fa fa-fw fa-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">
                                            <h2>Фильтров нет</h2>
                                        </td>
                                    </tr>

                                @endforelse
                                </tbody>

                            </table>
                        </div>
                        <div class="text-center">
                            <p>{{ count($attrs) }} фильтров из {{ $count }}</p>

                            {{ $attrs }}

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
