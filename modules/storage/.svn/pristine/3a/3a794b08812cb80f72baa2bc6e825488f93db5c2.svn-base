$j(function () {
    // инициализация формы добавления
    ajaxproductsearch_init('id-form-order-product-add', '/admin/shop/storage/ajax/product/list/');
    
    // добавление товара
    $j('#id-form-order-product-add').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/order/ajax/addproduct/',
            type: "POST",
            data: $j('#id-form-order-product-add').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-order-products').html(data.content);
                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);

                    bind_check_all();
                }
            }
        });

        event.preventDefault();

    });

    // редатирование списка товаров
    $j('#id-order-products').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/order/ajax/update/',
            type: "POST",
            data: $j('#id-order-products').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-order-products').html(data.content);
                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);

                    bind_check_all();
                }
            }
        });

        event.preventDefault();

    });

    bind_check_all();
    
});

// галочки выделить/снять все
function bind_check_all() {
    if ($j('#id-check-all').length) {
        $j('#id-check-all').bind('click', function() {
            $j('.table-checkbox').prop('checked', $j('#id-check-all').prop('checked'));
        });
    }
}

function delete_messages() {
    $j('#js-message-div').html('');
}