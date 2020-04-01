@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Новый фильтр
            @endslot

            @slot('parent')
                Главная
            @endslot

            @slot('attrs_filter')
                Список фильтров
            @endslot

            @slot('active')
                <b>Новый фильтр</b>
            @endslot

        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ url('/admin/filter/attr-add') }}" method="post"
                          data-toggle="validator" id="addattrs">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="value">Наименование атрибута</label>
                                <input type="text" name="value" class="form-control" id="value"
                                       placeholder="Наименование атрибута" required
                                       value="{{ old('value') }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group">
                                <label for="attr_group_id">Группа</label>
                                <select name="attr_group_id" class="form-control" id="attr_group_id" required>
                                    <option>-- Выберите группу --</option>
                                    @foreach($group as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="footer">
                                <input type="hidden" name="id" value="">
                                <button type="submit" class="btn btn-success">Добавить</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



@endsection
