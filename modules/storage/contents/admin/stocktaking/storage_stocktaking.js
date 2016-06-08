$j(function () {
    // инициализация формы добавления
    ajaxproductsearch_init('id-form-stocktaking-add', '/admin/shop/storage/ajax/product/list/');

    // добавление товара
    $j('#id-form-stocktaking-add').submit(function (event) {
        var parameters = $j('#id-form-stocktaking-add').serialize();
        $j('#id-form-stocktaking-add').find('input[name="productid"]').val('');

        $j.ajax({
            url: '/admin/shop/storage/stocktaking/ajax/add/',
            type: "POST",
            data: parameters,
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-products').html(data.content);
                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);

                    $j('.js-sortable').tablesorter();
                    bind_check_all();
                }
            }
        });

        event.preventDefault();

    });

    // подгрузка товара со склада
    $j('#id-form-stocktaking-load').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/stocktaking/ajax/load/',
            type: "POST",
            data: $j('#id-form-stocktaking-load').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-products').html(data.content);
                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);

                    $j('.js-sortable').tablesorter();
                    bind_check_all();
                }
            }
        });

        event.preventDefault();

    });

    // редактирование товаров
    $j('#id-products').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/stocktaking/ajax/update/',
            type: "POST",
            data: $j('#id-products').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-products').html(data.content);
                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);

                    $j('.js-sortable').tablesorter();
                    bind_check_all();
                }
            }
        });

        event.preventDefault();

    });

    $j('#id-form-stocktaking-add').find('input[name="productid"]').focus();
    
    $j('.js-sortable').tablesorter();
    bind_check_all();
});

// галочки выделить/снять все
function bind_check_all() {
    console.log(2);
    if ($j('#id-check-all').length) {
        $j('#id-check-all').bind('click', function() {
            $j('.table-checkbox').prop('checked', $j('#id-check-all').prop('checked'));
        });
    }

    if ($j('#id-products table').length) {
        $j('#js-button-process').prop('disabled', false);
    } else {
        $j('#js-button-process').prop('disabled', true);
    }
}

function delete_messages() {
    $j('#js-message-div').html('');
}