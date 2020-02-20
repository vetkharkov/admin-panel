@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')
            @slot('title')
                Панель управления
            @endslot
            @slot('parent')
                Главная
            @endslot
            @slot('active')

            @endslot


        @endcomponent
    </section>

@endsection
