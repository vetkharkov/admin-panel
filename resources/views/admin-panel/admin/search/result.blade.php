@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('admin-panel.admin.components.breadcrumb')

            @slot('title')
                Поиск по запросу: "{{ $query }}"
            @endslot

            @slot('parent')
                Главная
            @endslot

            @slot('active')
                <b>Поиск</b>
            @endslot

        @endcomponent

    </section>

    <section class="content">
        <div class="bs-example">
            <div class="row">

                @if($products)
                    @foreach($products as $product)

                        <div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                                @if(empty($product->img))
                                    <img src="{{ asset('/images/no_images.png') }}" alt=""></a>
                                @else
                                    <img src="{{ asset('/uploads/single/'.$product->img) }}" alt=""></a>
                                @endif

                                <div class="caption">
                                    <h3 class="text-center">
                                        {{ \Illuminate\Support\Str::limit($product->title, 15) }}
                                    </h3>
                                    <p>
                                        {{ \Illuminate\Support\Str::limit($product->description,50) }}
                                    </p>
                                    <h4>
                                        <span class="item-p">{{ $currency->symbol_left }} {{ $product->price * $currency->value }} {{ $currency->symbol_right }}</span>
                                        @if($product->old_price)
                                            <small>
                                                <del>
                                                    {{ $currency->symbol_left }} {{ $product->price * $currency->value }} {{ $currency->symbol_right }}
                                                </del>
                                            </small>
                                        @endif

                                    </h4>
                                    <div class="row">
                                        <div class="col-sm-6">

                                            <a href="{{ route('adminzone.admin.products.edit', $product->id) }}"
                                               class="btn btn-primary"
                                               role="button">
                                                Редактировать
                                            </a>
                                        </div>

                                        <div class="col-sm-6">
                                            @if($product->status == 0)
                                                <a href="{{ route('adminzone.admin.products.return-status', $product->id) }}"
                                                   title="Перевести статус = on" class="btn btn-success delete">
                                                    Вернуть на сайт
                                                    <i class="fa fa-fw fa-refresh"></i>
                                                </a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                            @else
                                                <a href="{{ route('adminzone.admin.products.delete-status', $product->id) }}"
                                                   title="Перевести статус = off"
                                                   class="btn btn-danger delete">
                                                    Убрать с сайта
                                                    <i class="fa fa-fw fa-close"></i>
                                                </a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                    <div class="clearfix"></div>

                @endif


            </div>
        </div>
    </section>


@endsection