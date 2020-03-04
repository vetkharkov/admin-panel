@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Список меню категорий
            @endslot
            @slot('parent')
                Главная
            @endslot
            @slot('active')
                Список меню категорий
            @endslot

        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <small style="margin-left: 70px">Для редактирования нажмите на категорию</small>
                            <small style="margin-left: 70px">Невозможно удалять категории имеющие наследника или имеющие
                                товвары
                            </small>
                        </div>
                        <br>
                        @if($menu)
                            <div class="list-group list-group-root well">

                                @include('admin-panel.admin.category.menu.customMenuItems', ['items' => $menu->roots()])

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
