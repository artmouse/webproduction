$j(function () {
    initStorageBasketForm();
});

function initStorageBasketForm() {
    // галочки выделить/снять все
    if ($j('#id-check-all').length) {
        $j('#id-check-all').bind('click', function() {
            $j('.table-checkbox').prop('checked', $j('#id-check-all').prop('checked'));
        });
    }

    // редактирование товаров
    $j('.js-storage-basket-form-button-update').click(function(event) {
        $j.ajax({
            url: '/admin/shop/storage/basket/update/ajax/',
            type: "POST",
            data: $j('.js-storage-basket-table-form').serialize(),
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    $j('.js-storage-basket-table-form').replaceWith(data.content);
                    $j('.js-storage-message-div').append(data.message);
                    initStorageBasketForm();
                }
            }
        });

        event.preventDefault();
    });

    // окно привязок
    $j('.js-link').click(function(event) {
        var id = this.id;
        linkwindow_init('w2', 'id-linked-amount-'+id, id);
    });

    // кнопка провести операцию
    if ($j('.js-storage-basket-table-form table').length) {
        $j('#js-button-process').prop('disabled', false);
    } else {
        $j('#js-button-process').prop('disabled', true);
    }

    // убрать сообщения
    setTimeout(function() {
        $j('.js-storage-message-div').html('');
    }, 5000);
}

// добавление товаров
function submitProductID(productid) {
    $j.ajax({
        url: '/admin/shop/storage/basket/add/ajax/',
        type: "POST",
        data: {
            productid: productid,
            type: $j('.js-storage-basket-add-form').find('input[name="type"]').val(),
            storagenameid: $j('.js-storage-basket-add-form').find('input[name="storagenameid"]').val()
        },
        dataType : "json",
        success: function (data, textStatus) {
            if (!data.error) {
                $j('.js-storage-basket-table-form').replaceWith(data.content);
                $j('.js-storage-message-div').append(data.message);
                initStorageBasketForm();
            }
        }
    });
}

$j(function () {
    $j('#id-product').click(function(e){
        selectwindow_init('w1', 'id-name', 'id-value', {
            productsearch: true,
            productadd: true
        });
        e.preventDefault();
    });

    $j('.js-product-autocomplete-input').keydown(function(event) {
        if (event.which == 13 && !$j('.js-product-autocomplete-input').data('is_open')) {
            var id = $j('.js-product-autocomplete-input').val();
            $j('.js-product-autocomplete-input').val('');
            submitProductID(id);

            event.preventDefault();
        }
    });

    $j('.js-product-autocomplete-input').change(function(event) {
        $j('.js-product-autocomplete-input').focus();
    });

    $j('.js-product-autocomplete-input').autocomplete({
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $j.ajax({
                url: "/admin/products/json/autocomtlite/ajax/",
                dataType: "json",
                data: {
                    name: request.term
                },
                success: function( data ) {
                    if (data == null) {
                        response(null);
                    }

                    response($j.map(data, function(item) {
                        var result = item.id;
                        var name = item.name;

                        if (item.price) {
                            name += ' ' + item.price + ' ' + item.currency + ' ' + ((item.count)?'В налиии':'');
                        }

                        return {
                            label: name,
                            value: (result == 0) ? request.term : result,
                            add: (result == 0)
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            var id = ui.item.value;

            $j('.js-product-autocomplete-input').val('');

            if (ui.item.add == true) {
                selectwindow_init('w1', 'id-name', 'id-value', {
                    productsearch: true,
                    productadd: true,
                    selectedTab: 1,
                    productAddDefault: id
                });
            } else {
                submitProductID(id);
            }

            event.preventDefault();
        }
    });

    $j('.js-product-autocomplete-input').bind('autocompleteopen', function(event, ui) {
        $j(this).data('is_open',true);
    });

    $j('.js-product-autocomplete-input').bind('autocompleteclose', function(event, ui) {
        $j(this).data('is_open',false);
    });
});