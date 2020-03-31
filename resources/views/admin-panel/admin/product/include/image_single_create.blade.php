<div class="box box-danger box-solid">
    <div class="box-header">
        <h3 class="box-title">
            Базовое изображение
        </h3>
    </div>
    <div class="box-body" id="image" style="text-align: center; position: relative">
        <img id="preview_image" width="50%" height="50%">
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
        <a href="javascript:removeFile()" style="text-decoration: none; color: red;">
            <i class="glyphicon glyphicon-trash"></i>
            Удалить
        </a>
    </p>
    <input type="file" id="file" style="display: none;">
    <input type="hidden" id="file_name">
    <p style="text-align: center">
        <small>Рекомендуемые размеры 125x200</small>
    </p>
</div>