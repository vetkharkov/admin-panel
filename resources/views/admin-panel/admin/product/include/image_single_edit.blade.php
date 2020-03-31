<div class="box box-danger box-solid">
    <div class="box-header">
        <h3 class="box-title">
            Базовое изображение
        </h3>
    </div>
    <div class="box-body" id="image" style="border: 1px solid whitesmoke; text-align: center; position: relative">
        @if($product->img == null)
            <img id="preview_image" width="50%" height="50%" src="{{ asset('images/no_images.png') }}">
        @else
            <img id="preview_image" width="50%" height="50%" src="{{ asset('uploads/single/' . $product->img) }}">
        @endif

        <i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw"
           style="position: absolute; left: 40%; top: 40%; display: none;">
        </i>
    </div>
    <p style="text-align: center">
        <a href="javascript:changeProfile()" style="text-decoration: none;" data-name="single">
            <i class="glyphicon glyphicon-edit"></i>
            Загрузить
        </a>
        &nbsp;&nbsp;
        @if($product->img == null)
            <a href="javascript:removeFile()" style="text-decoration: none; color: red;" class="nothing">
                <i class="glyphicon glyphicon-trash"></i>
                Удалить
            </a>
        @else
            <a href="javascript:removeFileImg()" style="text-decoration: none; color: red;"
               class="myimg" data-name="{{ $product->img }}">
                <i class="glyphicon glyphicon-trash"></i>
                Удалить
            </a>
        @endif

    </p>
    <input type="file" id="file" style="display: none;">
    <input type="hidden" id="file_name">
    <p style="text-align: center">
        <small>Рекомендуемые размеры 125x200</small>
    </p>
</div>