$j(function () {
    $j('#id-product').click(function(e){
        selectwindow_init('w1', 'id-name', 'id-value', {
            productsearch: true,
            productadd: true
        });
        e.preventDefault();
    });

    $j('.js-orderlist-editable').click(function(){
        $j('.js-order-table').find('.js-data-group .ob-link-edit').click();

        if ($j(this).text() == 'отменить все') {
            // отменяем изменения
            $j('input[data-original]').each(function(i, elem) {
                $j(elem).val($j(elem).data('original'));
            });

            $j('textarea[data-original]').each(function(i, elem) {
                $j(elem).html($j(elem).data('original'));
                $j(elem).text($j(elem).data('original'));
                $j(elem).val($j(elem).data('original'));
            });

            $j('select[data-original]').each(function(i, elem) {
                $j(elem).val($j(elem).data('original')).trigger("change");
            });
        }

        $j(this).html($j(this).text() == 'отменить все' ? 'редактировать все' : 'отменить все');
        return false;
    });

    productListInit();
});

function productListInit() {
    $j('.js-oders-sort').sortable({
        handle: ".move",
        axis: "y",
        update: function () {
            var productIdArray = [];
            var order_id = $j('.js-oders-sort').data('orderid');
            $j('.js-oders-sort tr').each(function () {
                productIdArray.push($j(this).data('productid'));
            });
            $j.ajax({
                url: '/admin/shop/orders/products/sort/ajax/',
                data: {
                'productsIdArray': productIdArray,
                'orderId': order_id
                }
            });
        }
    });

    $j('.js-product-sort').tablesorter().bind("sortEnd",function(){
        var productIdArray = [];
        var order_id = $j('.js-oders-sort').data('orderid');
        $j('.js-oders-sort tr').each(function () {
            productIdArray.push($j(this).data('productid'));
        });
        $j.ajax({
            url: '/admin/shop/orders/products/sort/ajax/',
            data: {
                'productsIdArray': productIdArray,
                'orderId': order_id
            }
        });
    });

    $j('.js-product-remove').click(function(){
        $j(this).next().click();
        $j(this).closest('tr').toggleClass('row-deleted');
        return false;
    });

    $j('.js-storage-reserve-block').click(function(event) {
        $target = $j(event.target);

        // резервирование
        if ($target.is('.js-storage-reserve')) {
            event.preventDefault();

            var balanceID = $target.attr('data-balanceid');
            var orderProductID = $target.attr('data-orderproductid');
            var $link = $target;

            $j.ajax({
                url: '/storage/reserve/ajax/',
                method: 'post',
                data: {
                    balanceid: balanceID,
                    orderproductid: orderProductID
                },
                dataType:'json',
                success: function(json){
                    if (json.status == 'success') {
                        var amountReserved = json.result.amount;

                        $block = $link.closest('.js-storage-reserve-block');

                        var str=" (";
                        jQuery.each(json.result.storageLinked, function (i, elem) {
                            str+=elem.storageName+':'+elem.amount+';';
                        });

                        str = str.slice(0, -1);

                        str+=')';
                        $block.html('<strong>Зарезервировано ' + amountReserved + str +'</strong>');
                        $block.append(' <a href="#" data-orderproductid="' + orderProductID + '" class="js-storage-cancel-reserve" >отменить</a>');

                        if (json.result.ok) {
                            try {
                                $block.closest('tr').addClass('green');
                            } catch (e) {

                            }
                        } else {
                            $block.append(' <a href="#" data-balanceid="" data-orderproductid="' + orderProductID + '" class="js-storage-reserve" >резервировать</a>');
                        }
                    }
                    storageSelectInit(orderProductID);
                }
            });

        }

        // отменить резервирование
        if ($target.is('.js-storage-cancel-reserve')) {
            event.preventDefault();

            var orderProductID = $target.attr('data-orderproductid');
            var $link = $target;

            $j.ajax({
                url: '/storage/reserve/cancel/ajax/',
                method: 'post',
                data: {
                    orderproductid: orderProductID
                },
                dataType:'json',
                success: function(json){
                    if (json.status == 'success') {
                        var balance = json.result.balance;

                        $block = $link.closest('.js-storage-reserve-block');

                        try {
                            $block.closest('tr').removeClass('green');
                        } catch (e) {

                        }
                        $block.html(' <a href="#" data-balanceid="' + balance.id + '" data-orderproductid="' + orderProductID + '" class="js-storage-reserve" >резервировать</a>');
                    }

                    storageSelectInit(orderProductID);
                }
            });
        }
    });
}

function submitProductID(id) {
    $j.ajax({
        url: '/admin/shop/orders/add/product/ajax/',
        type: "POST",
        data: {
            productid: id,
            id: $j('.js-product-autocomplete-input').data('orderid'),
            ajax: 1,
            ok: 1
        },
        dataType : "html",
        success: function (data, textStatus) {
            $j('.js-order-table').replaceWith(data);
            productListInit();
            dataGroupInit('.js-order-table');
        }
    });
}

$j(function () {
    $j('.js-product-autocomplete-input').keydown(function(event) {
        if (event.which == 13) {
            event.preventDefault();

            setTimeout(function() {
                console.log($j('.js-product-autocomplete-input').data('autocomplete-selected'));

                if (!$j('.js-product-autocomplete-input').data('autocomplete-selected')) {
                    var id = $j('.js-product-autocomplete-input').val();
                    $j('.js-product-autocomplete-input').val('');
                    submitProductID(id);
                }
            }, 1000);
        } else {
            $j('.js-product-autocomplete-input').data('autocomplete-selected', false);
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

            $j('.js-product-autocomplete-input').data('autocomplete-selected', true);
            $j('.js-product-autocomplete-input').val('');

            if (ui.item.add == true) {
                selectwindow_init('w1', 'id-name', 'id-value', {
                    productsearch: true,
                    productadd: true,
                    selectedTab: 1,
                    productAddDefault: id
                });
            } else {
               
                if ($j('.js-oders-sort .data-edit').is(':visible')) {
                    $j('form').submit();
                    submitProductID(id);
                } else {
                    submitProductID(id); 
                }
            }

            event.preventDefault();
        }
    }).autocomplete("widget").removeClass().addClass("ob-autocomplete");
});

// калькулятор цены
$j(function () {
    if ($j('.js-price-base').length) {
        // price popup
        $j('.js-price-edit-open').click(function(){
            $j(this).next().fadeIn(300);
        });

        $j('.js-price-edit-close').click(function(){
            $j(this).parent().fadeOut(300);
        });

        // делаем пересчет цены в зависимости от закупочной цены и наценки
        $j('.js-price-margin, .js-price-base').keyup(function() {
            var margin = parseFloat($j(this).closest('.js-price-edit').find('.js-price-margin').val());
            var priceBase = parseFloat($j(this).closest('.js-price-edit').find('.js-price-base').val());
            var price = parseFloat(priceBase * (100 + margin) / 100);
            if (price > 0) {
                $j(this).closest('.js-price-edit').find('.js-price-edit-open').val(price.toFixed(2));
            }
        });
    }
});

$j(function () {

    storageNameInit();

    $j('.js-storage-name').change(function () {
        storageNameInit(this);
    });

    // Цвет поставщиков
    function formatSelection(item) {
        var dataColor = $j(item.element).data('color');
        return '<span style="color: '+ dataColor +';">'+ item.text +'</span>';
    }

    function formatResult(item) {
        var dataColor = $j(item.element).data('color');
        return '<span style="color: '+ dataColor +';">'+ item.text +'</span>';
    }

    $j('.js-select-supplier-color').select2({
        formatSelection: formatSelection,
        formatResult: formatResult
    });

    $j(function () {
        // Первичная Инициализация
        if ($j('.js-select-supplier-current').length) {
            $j(".js-select-supplier-current").each(function (index, e) {
                var option_supplier;
                var span;
                option_supplier = $j(e);
                span = option_supplier.parent().parent().find('span');
                var dataColor = option_supplier.data('color');
                var text = span.html();
                var text = '<span style="color: '+ dataColor +';">'+ text +'</span>';
                span.html(text);
            });
        }
    })
});

function  storageNameInit(elem) {
    if (elem) {
        elem = $j(elem).find(':selected');
        elem = $j(elem);
        $j('.js-storage-reserve[data-orderproductid='+elem.data('orderproductid')+']').attr('data-balanceid', elem.val());
    } else {
        var options = $j('.js-storage-name :selected');
        $j(options).each(function (i, elem) {
            elem = $j(elem);
            $j('.js-storage-reserve[data-orderproductid='+elem.data('orderproductid')+']').attr('data-balanceid', elem.val());
        });
    }
}

function  storageSelectInit(orderProductId) {
    if (!orderProductId) {
        return false;
    }

    $j.ajax({
        url: '/shop/storage/select/init/ajax/',
        method: 'post',
        data: {
            orderproductid: orderProductId
        },
        dataType:'json',
        success: function(json){
            var selectObj = $j('.js-storage-name[name=storage'+orderProductId+']');
            balanceID = selectObj.val();
            selectObj.empty();
            jQuery.each(json, function(i, elem) {
                if (elem.id == balanceID) {
                    selectObj.append($j('<option value="'+elem.id+'" data-orderproductid="'+orderProductId+'" selected>'+elem.name+': '+elem.count+'</option>'));
                } else {
                    selectObj.append($j('<option value="'+elem.id+'" data-orderproductid="'+orderProductId+'">'+elem.name+': '+elem.count+'</option>'));
                }
            });

            storageNameInit();
        }
    });
}