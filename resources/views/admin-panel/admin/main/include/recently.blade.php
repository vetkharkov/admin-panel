<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Последние добавленные продукты</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

    <div class="box-body">
        <ul class="products-list product-list-in-box">
            @foreach($last_products as $product)
                <li class="item">
                    <div class="product-img">
                        @if(!empty($product->img))
                            <img src="{{ asset('uploads/single/' . $product->img) }}" alt="image">
                        @else
                            <img src="{{ asset('images/no_images.png') }}" alt="no-image">
                        @endif
                    </div>
                    <div class="product-info">
                        <a href="{{ route('adminzone.admin.products.edit', $product->id) }}" class="product-title">
                            {{ $product->title }}
                            <span class="label label-warning pull-right">{{ $product->price }} грн.</span>
                        </a>
                        <span class="product-description">{{ $product->description }}</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="box-footer clearfix">
        <a href="{{ route('adminzone.admin.products.index') }}" class="btn btn-sm btn-info btn-flat pull-left">Все продукты</a>
    </div>
</div>
