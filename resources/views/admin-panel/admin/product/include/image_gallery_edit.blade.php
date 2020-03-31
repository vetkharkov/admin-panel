<div class="box box-primary box-solid file-upload">
    <div class="box-header">
        <h3 class="box-title">
            Картинки галереи
        </h3>
    </div>
    <div class="box-body" id="galleryjs">
        <div id="multi" class="btn btn-success" data-url="{{ url('admin/products/gallery') }}" data-name="multi">
            Загрузить
        </div>
        <div class="multi">
            @if(!empty($images))
                <p>
                    <small>Для удаления нажмите на картинку</small>
                </p>
                @foreach($images as $image)
                    <img src="{{ asset('uploads/gallery/'.$image) }}"
                         width="50%"
                         height="50%"
                         data-src="{{ $image }}"
                         data-id="{{ $product->id }}"
                         class="del-items"
                         alt="{{ $product->title }}"
                    >
                @endforeach
            @endif
        </div>
        <p>
            <small>Вы можете загружать по очереди любое колличество</small>
            <br>
            <small>Рекомендуемые размеры 700x1000</small>
        </p>
    </div>
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>