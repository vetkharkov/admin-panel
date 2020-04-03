@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Редактирование группы
            @endslot

            @slot('parent')
                Главная
            @endslot

            @slot('group_filter')
                Группа фильтров
            @endslot

            @slot('active')
                <b>Редактирование группы</b>
            @endslot

        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ url('/admin/filter/group-edit', $group->id) }}" method="post"
                          data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование группы</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       placeholder="Наименование группы" required
                                       value="{{ $group->title }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="footer">
                                <input type="hidden" name="id" value="">
                                <button type="submit" class="btn btn-success">Изменить</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



@endsection
