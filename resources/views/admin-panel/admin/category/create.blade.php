@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Создание новой меню категории
            @endslot
            @slot('parent')
                Главная
            @endslot
            @slot('category')
                Список категорий
            @endslot
            @slot('active')
                Создание меню категорий
            @endslot

        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('adminzone.admin.categories.store', $item->id) }}" method="post"
                          data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование категории</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       placeholder="Наименование категории" required
                                       value="{{ old('title', $item->title) }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="parent_id">Наименование категории</label>
                                <select name="parent_id" class="form-control" id="parent_id" required>
                                    <option value="0">-- самостоятельная категория --</option>
                                    @include('admin-panel.admin.category.include.edit_categories_all_list', ['categories' => $categories])
                                </select>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="keywords">Ключевые слова</label>
                                <input type="text" name="keywords" class="form-control" id="keywords"
                                       placeholder="Ключевые слова" required
                                       value="{{ old('keywords', $item->keywords) }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="description">Описание</label>
                                <input type="text" name="description" class="form-control" id="description"
                                       placeholder="Описание" required
                                       value="{{ old('description', $item->description) }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="footer">
                                <button type="submit" class="btn btn-success">Добавить</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
