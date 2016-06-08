$j(function () {
    // инициализация формы добавления
    ajaxproductsearch_init('id-form-sale-add', '/admin/shop/storage/ajax/product/storage/list/');

    // добавление товара
    $j('#id-form-sale-add').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/sale/ajax/add/',
            type: "POST",
            data: $j('#id-form-sale-add').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-products').html(data.content);
                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);

                    bind_check_all();
                    bind_link_window();
                }
            }
        });

        event.preventDefault();

    });

    // редактирование товаров
    $j('#id-products').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/sale/ajax/update/',
            type: "POST",
            data: $j('#id-products').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-products').html(data.content);
                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);

                    bind_check_all();
                    bind_link_window();
                }
            }
        });

        event.preventDefault();

    });

    bind_check_all();
    bind_link_window();
});

function bind_link_window() {
    // окно привязок
    $j('.js-link').click(function(event) {
        var id = this.id;
        linkwindow_init('w2', 'id-linked-amount-'+id, id);
    });
}

// галочки выделить/снять все
function bind_check_all() {
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