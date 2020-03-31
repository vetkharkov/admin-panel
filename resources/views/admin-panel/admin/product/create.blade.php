@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Добавление нового товара
            @endslot
            @slot('parent')
                Главная
            @endslot
            @slot('product')
                Список товаров
            @endslot
            @slot('active')
                Новый товар
            @endslot

        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('adminzone.admin.products.store', $item->id) }}" method="post"
                          data-toggle="validator" id="add">
                        @csrf

                        <div class="box-body">

                            <div class="form-group has-feedback">
                                <label for="title">Наименование товара</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       placeholder="Наименование товара" required
                                       value="{{ old('title') }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="parent_id">Наименование категории</label>
                                <select name="parent_id" class="form-control" id="parent_id" required>
                                    <option>-- Выберите категорию --</option>
                                    @include('admin-panel.admin.product.include.edit_categories_all_list')
{{--  @include('admin-panel.admin.product.include.edit_categories_all_list', ['categories' => $categories])--}}
                                </select>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="keywords">Ключевые слова</label>
                                <input type="text" name="keywords" class="form-control" id="keywords"
                                       placeholder="Ключевые слова" required
                                       value="{{ old('keywords') }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="description">Описание</label>
                                <input type="text" name="description" class="form-control" id="description"
                                       placeholder="Описание" required
                                       value="{{ old('description') }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="price">Цена</label>
                                <input type="text" name="price" class="form-control" id="price"
                                       placeholder="Цена" required
                                       pattern="^[0-9.]{1,}$"
                                       data-error="Допускаются цифры и десятичная точка"
                                       value="{{ old('price') }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="old_price">Старая цена</label>
                                <input type="text" name="old_price" class="form-control" id="old_price"
                                       placeholder="Старая цена" required
                                       pattern="^[0-9.]{1,}$"
                                       data-error="Допускаются цифры и десятичная точка"
                                       value="{{ old('old_price') }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="content">Контент</label>
                                <textarea type="text" name="content" class="form-control" id="editor1"
                                       placeholder="Описание" required
                                       cols="80" rows="10">
                                {{ old('content') }}
                                </textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group">
                                <label for="status">Статус</label>
                                <input type="checkbox" name="status" checked>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group">
                                <label for="hit">Хит</label>
                                <input type="checkbox" name="hit">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="related">Связаные товары</label>
                                <p><small>Начните вводить наименование товара</small></p>
                                <select name="related[]" id="related" class="select2 form-control" multiple>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="filter">Фильтры</label>
                                {{ Widget::run('filter', ['tpl' => 'widgets.filter', 'filter' => null]) }}
                            </div>

                            <div class="form-group">
                                {{--<label for="img">Изображение</label>--}}
                                <div class="col-md-4">
                                    @include('admin-panel.admin.product.include.image_single_create')
                                </div>
                                <div class="col-md-8">
                                    @include('admin-panel.admin.product.include.image_gallery_create')
                                </div>
                             </div>

                            <input type="hidden" id="_token" value="{{ csrf_token() }}">

                            <div class="box-footer">
                                <button type="submit" class="btn btn-success">Добавить</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection
