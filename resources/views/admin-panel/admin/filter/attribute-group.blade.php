@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Группа фильтров
            @endslot
            @slot('parent')
                Главная
            @endslot
            @slot('active')
                Группа фильтров
            @endslot

        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{ url('/admin/filter/group-create') }}" class="btn btn-primary">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить группу
                            </a>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Наименование</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($attrs_group as $attr)
                                    <tr>
                                        <td>{{ $attr->id }} &nbsp;{{ $attr->title }} </td>

                                        <td>
                                            <a href="{{ url('/admin/filter/group-edit', $attr->id) }}" title="Редактировать">
                                                <i class="fa fa-fw fa-pencil"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="{{ url('/admin/filter/group-delete', $attr->id) }}" class="delete text-danger" title="Удалить">
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


                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
