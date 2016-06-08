// поиск и выбор товара
var ajaxproductsearch_selected = {};

function ajaxproductsearch_init(formID, url) {
    formID = '#' + formID;

    // инициализируем индикатор товара на котором установлен фокус
    ajaxproductsearch_selected[formID] = -1;

    $j(formID + ' #id-product-search-input').focus();

    // по умолчанию выводим все товары
    ajaxproductsearch_search(formID, url);

    // индикатор того, выбран ли товар
    $j(formID + ' #id-value').change(function (event) {
        if ($j(this).val()) {
            $j(formID + ' #id-product-input-indicator').html('<img src="/_images/icon-ok.png">');
        } else {
            $j(formID + ' #id-product-input-indicator').html('-');
        }
    });

    // если количество товара > 1 поле серийный номер делать неактивным
    $j(formID + ' #id-product-amount').change(function () {
        var value = $j(this).val();
        if (value != 1) {
            $j(formID + ' #id-product-serial').prop('disabled', true);
        } else {
            $j(formID + ' #id-product-serial').prop('disabled', false);
        }
    });
    $j('#id-product-amount').trigger('change');

    // переход вверх по списку
    $j(formID + ' #id-product-search-input').bind('keydown', 'up', function() {
        if (ajaxproductsearch_selected[formID] > 0) {
            ajaxproductsearch_selected[formID]--;
            $j(formID + '-div #id-product-table-tr-' + ajaxproductsearch_selected[formID]).trigger('click');
        }
    });

    // переход вниз по списку
    $j(formID + ' #id-product-search-input').bind('keydown', 'down', function() {
        if ($j(formID + '-div #id-product-table-tr-' + (ajaxproductsearch_selected[formID]+1)).length) {
            ajaxproductsearch_selected[formID]++;
            $j(formID + '-div #id-product-table-tr-' + ajaxproductsearch_selected[formID]).trigger('click');
        }
    });

    // удаление выбранного товара
    $j(formID + ' #id-product-search-input').bind('keydown', 'backspace', function() {
        if (!$j(this).hasClass('js-wait-backspace')) {
            $j(this).val('');
            $j(formID + ' #id-value').val('');
            $j(formID + ' #id-value').trigger('change');
        }
    });

    // отправка формы ctrl+return
    $j(document).bind('keydown', 'ctrl+return', function(event) {
        $j(formID).submit();
        $j(formID + ' #id-product-search-input').focus();

        event.stopPropagation();
    });

    $j(formID + ' input').bind('keydown', 'ctrl+return', function(event) {
        $j(formID).submit();
        $j(formID + ' #id-product-search-input').focus();

        event.stopPropagation();
    });

    // поиск при нажатии enter-a
    $j(formID + ' #id-product-search-input').bind('keydown', 'return', function() {
        ajaxproductsearch_search(formID, url);
    });
    
    // поиск при смене категории
    $j(formID + '-search-categoryid').change(function () {
        ajaxproductsearch_search(formID, url);
    });

    jQueryTabs.TabMenu($j(formID + '-div .settings-tab'));

    // добавление нового товара
    $j(formID + '-div .js-add-product').submit(function (event) {
        shop_product_add($j(this).serialize(), function (json) {
            ajaxproductsearch_search(formID, url);

            // заполняем поля
            $j(formID + ' #id-value').val(json.id);
            $j(formID + ' #id-value').trigger('change');

            $j(formID + ' #id-product-search-input').val('#' + json.id + ': ' + json.name);
            $j(formID + ' #id-price').val(json.price);
            $j(formID + ' #id-currencyid').val(json.currencyid);

            $j(formID + ' #id-product-search-input').focus();
        });
        event.preventDefault();
    });

}

// поиск товаров
function ajaxproductsearch_search(formID, url) {
    $j(formID + '-div #id-product-table').html('loading');
    ajaxproductsearch_selected[formID] = -1;

    $j.ajax({
        url: url,
        type: "POST",
        data: {
            query : $j(formID + ' #id-product-search-input').val(),
            categoryid : $j(formID + '-search-categoryid').val()
        },
        dataType : "html",
        success: function (data, textStatus) {
            if (data) {
                $j(formID + '-div #id-product-table').html(data);

                // при клике на товар, автоматически заполняем поля формы
                $j(formID + '-div .js-product-id').bind('click', function() {

                    // наводим фокус на клинутый товар
                    $j(formID + '-div .js-product-id').removeClass('selected');
                    $j(this).addClass('selected');
                    selected_product = parseInt($j(this).attr('id').replace('id-product-table-tr-', ''));

                    // анимируем скроллинг
                    $j(formID + '-div #id-product-table').animate({
                        scrollTop: (($j(this).height() + 2)*(selected_product-1)-5)
                    }, 500);

                    // заполняем поля
                    $j(formID + ' #id-value').val($j(this).find('input[name=id]').val());
                    $j(formID + ' #id-value').trigger('change');

                    $j(formID + ' #id-product-search-input').val('#' + $j(this).find('input[name=id]').val() + ': ' + $j(this).find('input[name=name]').val());
                    $j(formID + ' #id-price').val($j(this).find('input[name=price]').val());
                    $j(formID + ' #id-currencyid').val($j(this).find('input[name=currencyid]').val());
                    $j(formID + ' #id-taxid').val($j(this).find('input[name=taxid]').val());
                    $j(formID + ' #id-unit').html($j(this).find('input[name=unit]').val());
                    $j(formID + ' #id-balanceid').val($j(this).find('input[name=balanceid]').val());

                    $j(formID + ' #id-product-search-input').focus();

                    return false;
                });
            } else {
                $j(formID + '-div #id-product-table').html('Nothing was found :(');
            }
        }
    });
}