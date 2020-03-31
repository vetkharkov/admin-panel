/** Удаление заказа */
$('.delete').click(function () {
    var res = confirm('Подтвердите действие!');
    if (!res) {
        return false;
    }
});

/** Редактирование заказа */

$('.order-edit').click(function () {
    var res = confirm('Вы можете изменить только комментарий');
    return false;

});

/** Удаление заказа из базы данных */

$('.deletebd').click(function () {
    var res = confirm('Подтвердите удаление!');

    if (res) {
        var result = confirm('Вы уверены?');
        if (!result) {
            return false;
        }
    }

    if (!res) {
        return false;
    }

});

/** Подсветка активного меню */

$('.sidebar-menu a').each(function () {
    var location = window.location.protocol + '//' + window.location.host + window.location.pathname;
    var link = this.href;

    if (link === location) {
        ($(this)).parent().addClass('active');
        ($(this)).closest('.treeview').addClass('active');
    }

});

/** CKEditor  */

$('#editor1').ckeditor();

// CKEDITOR.replace('editor1');

/** Сброс фильтров  */

$('#reset-filter').click(function () {
    $('#filter input[type=radio]').prop('checked', false);
    return false;
});

/** Выбор категории при создании товара  */

$('#add').on('submit', function () {
    // alert($('#parent_id').val());
    if (!isNumber($('#parent_id').val())) {
        alert('Вы должны выбрать категорию');
        return false;
    }

});

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}


