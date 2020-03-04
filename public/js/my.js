// Удаление заказа
$('.delete').click(function () {
    var res = confirm('Подтвердите удаление!');
    if (!res) {
        return false;
    }
});

// Редактирование заказа

$('.order-edit').click(function () {
    var res = confirm('Вы можете изменить только комментарий');
    return false;

});

// Удаление заказа из базы данных

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

