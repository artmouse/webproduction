$j(function () {
    // инициализация формы добавления товара-цели
    ajaxproductsearch_init('id-form-passport-product-add', '/admin/shop/storage/ajax/product/list/');

    // добавление товара
    $j('#id-form-passport-product-add').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/passport/ajax/addproduct/',
            type: "POST",
            data: $j('#id-form-passport-product-add').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-passport-products').html(data.content);

                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);

                    bind_check_all();
                }
            }
        });

        event.preventDefault();

    });

    $j('.js-save-target').click(function () {
        $j.ajax({
            url: '/admin/shop/storage/passport/target/ajax/update/',
            type: "POST",
            data: {
                passportid: $j('#js-passport-id').val(),
                saveok: 'ok',
                productid: $j('#js-product-id').val(),
                count: $j('#js-product-count').val()
            },
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    messagePush(data.message, 'success');
                    $j('#js-message-div').html(data.message);
                    setTimeout('delete_messages()', 5000);

                    bind_check_all();
                }
            }
        });
    });

    // редатирование списка товаров-целей
    $j('#id-passport-products').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/passport/ajax/update/',
            type: "POST",
            data: $j('#id-passport-products').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-passport-products').html(data.content);
                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);

                    bind_check_all();
                }
            }
        });

        event.preventDefault();

    });

    // инициализация формы добавления товара-материала
    ajaxproductsearch_init('id-form-passport-material-add', '/admin/shop/storage/ajax/product/list/');

    // добавление товара
    $j('#id-form-passport-material-add').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/passport/ajax/addproduct/',
            type: "POST",
            data: $j('#id-form-passport-material-add').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-passport-materials').html(data.content);
                    $j('#js-message-div').append(data.message);
                    setTimeout('delete_messages()', 5000);

                    bind_check_all();
                }
            }
        });

        event.preventDefault();

    });

    // редатирование списка товаров-материала
    $j('#id-passport-materials').submit(function (event) {
        $j.ajax({
            url: '/admin/shop/storage/passport/ajax/update/',
            type: "POST",
            data: $j('#id-passport-materials').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('#id-passport-materials').html(data.content);
                    $j('#js-message-div').append(data.message);
                    messagePush(strip_tags(data.message), 'success');

                    setTimeout('delete_messages()', 5000);

                    bind_check_all();
                }
            }
        });

        event.preventDefault();

    });

    bind_check_all();

});

function strip_tags( str ){ // Strip HTML and PHP tags from a string
    return str.replace(/<\/?[^>]+>/gi, '');
}


// галочки выделить/снять все
function bind_check_all() {
    if ($j('.js-check-all').length) {
        $j('.js-check-all').bind('click', function() {
            $j('.table-checkbox').prop('checked', $j('.js-check-all').prop('checked'));
        });
    }
}

function delete_messages() {
    $j('#js-message-div').html('');
}