$j(function () {
    // инициализация формы добавления
    ajaxproductsearch_init('id-form-production-add', '/admin/shop/storage/ajax/product/passport/list/');

    // добавление товара
    $j('#id-form-production-add').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/production/ajax/add/',
            type: "POST",
            data: $j('#id-form-production-add').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-products').html(data.content_products);
                    $j('#id-materials').html(data.content_materials);
                    $j('#id-passports').html(data.content_passports);
                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);
                    
                    bind_link_window();
                    bind_check_all();
                }
            }
        });

        event.preventDefault();

    });
    
    // редактирование паспортов
    $j('#id-passports').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/production/ajax/update/',
            type: "POST",
            data: $j('#id-passports').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-products').html(data.content_products);
                    $j('#id-materials').html(data.content_materials);
                    $j('#id-passports').html(data.content_passports);
                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);

                    bind_check_all();
                    bind_link_window();
                }
            }
        });

        event.preventDefault();

    });
    
    bind_link_window();
    bind_check_all();
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