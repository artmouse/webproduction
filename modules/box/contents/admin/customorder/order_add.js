$j(function() {
    // инициализация полей доставки
    select_delivery();

    $j( "#js-parent-name" ).catcomplete({
        delay: 500,
        source: function( request, response ) {
            $j.ajax({
                url: "/admin/issue/searchajax/select2/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data=='badLen') return false;
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        var id = group = name = '';
                        id = item.id;
                        name = item.name;
                        category = item.category;
                        manager = item.manager;

                        return {
                            id: id,
                            label: name,
                            category: category,
                            manager: manager
                        }
                    }));
                }
            });
        },
        select: function( event, ui ) {
            $j('#js-parent-value').val(ui.item.id);
            $j("#managerid").select2("val", ui.item.manager);
        }
    });
});

$j(function() {
    $j('#js-product-tag').each(function (i, e) {
        var $ul = $j(e);
        $ul.tagit({
            singleField: true,
            singleFieldNode: $j($ul.data('input')),
            allowSpaces: true,
            autocomplete: {
                delay: 0,
                minLength: 2,
                source: function( request, response ) {
                    $j.ajax({
                        url: "/admin/products/json/autocomtlite/ajax/",
                        dataType: "json",
                        data:{
                            name: request.term,
                            add: 'no'
                        },
                        success: function( data ) {
                            if (data==null) response(null);
                            response( $j.map( data, function( item ) {
                                var result = name = '';

                                result = '#'+item.id+' '+item.name;
                                var name = item.name;

                                return {
                                    label: name,
                                    value: result
                                }
                            }));
                        }
                    })
                }
            }
        });
    });

});

$j(function () {
    $j('.js-content-delivery-ajax').click(function () {
        $j.ajax({
            url: "/ajax/content/delivery/",
            dataType: "json",
            data:{
                id: $j(this).val(),
                admin:true
            },
            success: function(data) {
                $j('#js-content-delivery-block').html(data);
            }
        });
    });
});

$j(function() {
    $j('#js-delivery-city-select').click(function() {
        $j('#js-delivery-office-select').select2('data', {});
        $j('#js-delivery-office-select').empty();
        var city = $j('#js-delivery-city-select').val();
        if (city != '0') {
            $j.ajax({
                url: "/shop/novapostha/get/offices/ajax/",
                dataType: "json",
                data:{
                    city: city
                },
                success: function(data) {
                    $j(data).each(function(key, item) {
                        $j('#js-delivery-office-select').append($j('<option>', {value:item, text: item}));
                    });

                }
            });
        }
    });
});

$j(function() {
    $j('#js-delivery').click(function() {
        var price = $j('#js-delivery option:selected').attr('data-price');
        $j('#js-price-delivery').text(price+' uah');
        $j('#js-price-delivery-value').val(price);
        recalculate_price();
        select_delivery();
    });

    $j('#js-dashed-docs-list').click(function () {
        setTimeout(function() {
            if ($j('.js-docs-list').css('display') == 'none') {
                $j.cookie('docs-list', 'ok',
                {
                    expires: 360,
                    path: '/'
                }
                );
            } else {
                $j.cookie('docs-list', 'no',
                {
                    expires: 360,
                    path: '/'
                }
                );
            }
        }, 500);


    });
});

$j(function() {
    $j('#js-client-phone').autocomplete({
        delay: 500,
        source: function( request, response ) {
            query = request.term;
            $j.ajax({
                url: "/admin/shop/users/phone/ajax/autocomplete/select2/",
                dataType: "json",
                data:{
                    phone: request.term
                },
                success: function( data ) {
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        name = item.name;
                        phone = item.phone;
                        return {
                            id: item.id,
                            label: phone+' ('+name+')',
                            value: phone,
                            name: item.name,
                            email: item.email,
                            skype: item.skype,
                            whatsapp: item.whatsapp
                        }
                    }));
                }
            });
        },
        select: function (event, ui) {
            $j('#id-clientid-value').val(ui.item.id);
            $j('#id-clientid-name').val(ui.item.name);
            $j('[name=contact_email]').val(ui.item.email);
            $j('[name=contact_skype]').val(ui.item.skype);
            $j('[name=contact_whatsapp]').val(ui.item.whatsapp);
        }
    });
});

$j(function() {
    $j.ajax({
        url: "/shop/novapostha/get/cities/ajax/",
        dataType: "json",
        success: function(data) {
            $j(data).each(function(key, item) {
                $j('#js-delivery-city-select').append($j('<option>', {value:item, text: item}));
            });
        }
    });
});

function init_products (workflowid) {
    $j('.delete').each(function() {
        $j(this).click();
    });

    $j.ajax({
        url: "/admin/issue/ajax/init/products/",
        dataType: "json",
        data:{
            workflowId: workflowid
        },
        success: function( data ) {
            if (data) {
                var count = Number($j('#js-count-products').val());

                $j.each(data, function (key, item) {
                    count += 1;

                    var html = '<tr class="js-tr-product-table"><td><input type="hidden" name="add_product_'+count+'" value="'+item.id+'"> <span class="cat-name">'+ item.categoryName+'</span> <br>'+'<a href="'+item.url+'">'+item.name+'</a></td>';
                    html+= '<td class="align_center"><input onblur="recalculate_price();" class="align_center js-price-value" name="price_product_'+count+'" type="text" style="width: 70px;" value="'+item.price+'"/></td>';
                    html+= '<td class="align_center"><input onblur="recalculate_price();" class="align_center js-count-value" name="count_product_'+count+'" type="text" style="width: 40px;" value="1"/></td>';
                    html+= '<td class="align_right price">'+item.price+' uah</td>';
                    html+= '<td class="align_center"><a class="ob-link-delete delete" href="javascript:void(0);" onclick="$j(this).parent().parent().remove(); recalculate_price();"></a></td></tr>';

                    $j('#issue-add-product-table').prepend(html);
                    $j('#js-count-products').val(count);

                    recalculate_price();
                });
            }

        }
    });

}

function issue_add_product (id, name, categoryName, price, url, serial, linkkey) {
    var count = Number($j('#js-count-products').val());
    count += 1;
    var html = '<tr class="js-tr-product-table"><td>';
    if (serial) {
        html+= '<input type="hidden" name="serial_product_'+count+'" value="'+serial+'">';
    }

    html+= '<input type="hidden" name="linkkey_product_'+count+'" value="'+linkkey+'">';

    html+= '<input type="hidden" name="add_product_'+count+'" value="'+id+'"> <span class="cat-name">'+categoryName+'</span> <br>'+'<a href="'+url+'">'+name+'</a></td>';
    html+= '<td class="align_center"><input onblur="recalculate_price();" class="align_center js-price-value" name="price_product_'+count+'" type="text" style="width: 70px;" value="'+price+'"/></td>';
    html+= '<td class="align_center"><input onblur="recalculate_price();" class="align_center js-count-value" name="count_product_'+count+'" type="text" style="width: 40px;" value="1"/></td>';
    html+= '<td class="align_right price">'+price+' uah</td>';
    html+= '<td class="align_center"><a class="ob-link-delete delete" href="javascript:void(0);" onclick="$j(this).parent().parent().remove(); recalculate_price();"></a></td></tr>';

    $j('#issue-add-product-table').prepend(html);
    $j('#js-count-products').val(count);
    recalculate_price();
}

function recalculate_price () {
    var price = 0;
    $j('.js-tr-product-table').each(function() {
        amount = Number($j(this).find('.js-price-value').val());
        count = Number($j(this).find('.js-count-value').val());
        sum = Number(amount*count);
        price+= sum;
        $j(this).find('.price').text(sum.toFixed(2)+' uah');
    });

    price+= Number($j('#js-price-delivery-value').val());
    $j('#js-price-total').text(price.toFixed(2)+' uah');
}

function select_delivery() {
    var logic = $j('#js-delivery option:selected').data('class');
    if (logic == 'Нова Пошта') {
        if (!$j('#js-delivery-city-select').parent().is(':visible')) {
            $j('#js-delivery-city-select').parent().show();
            $j('#js-delivery-office-select').parent().show();
            $j('#js-delivery-city-input').hide();
            $j('#js-delivery-office-input').hide();
        }
    } else {
        if ($j('#js-delivery-city-select').parent().is(':visible')) {
            $j('#js-delivery-city-select').parent().hide();
            $j('#js-delivery-office-select').parent().hide();
            $j('#js-delivery-city-input').show();
            $j('#js-delivery-office-input').show();
        }
    }

}

$j(function () {
    $j('.js-discount-link').click(function(){
        $j('.js-discount-link').removeClass('active');
        $j(this).addClass('active');
    });
});

$j(function () {
    var query = '';
    $j('#id-clientid-name').autocomplete({
        delay: 500,
        source: function( request, response ) {
            query = request.term;
            $j.ajax({
                url: "/admin/shop/users/ajax/autocomplete/select2/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        name = item.name;
                        return {
                            id: item.id,
                            label: name,
                            value: name,
                            phone: item.phone,
                            email: item.email,
                            skype: item.skype,
                            whatsapp: item.whatsapp
                        }
                    }));
                }
            });
        },
        select: function (event, ui) {
            $j('#id-clientid-value').val(ui.item.id);
            $j('#js-client-phone').val(ui.item.phone);
            $j('[name=contact_email]').val(ui.item.email);
            $j('[name=contact_skype]').val(ui.item.skype);
            $j('[name=contact_whatsapp]').val(ui.item.whatsapp);
        },
        minLength:3
    }).data('ui-autocomplete')._renderItem = function (ul, item) {
        ul.removeClass().addClass("ob-autocomplete");
        var inner_html = '<span>'+item.label+'</span>';
        ul.css('z-index','9999');
        if (item.id === 0) {
            inner_html = '<span class="ob-link-add ob-link-dashed">'+item.label+'</span>';
            return $j( "<li onclick='addUserInSelectWindow2(\""+htmlspecialchars(query)+"\")'></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
        } else {
            return $j( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
        }
    };
});

function addUserInSelectWindow2 (name) {
    selectwindow_init('w2', 'id-clientid-name', 'id-clientid-value', {
        usersearch: true,
        useradd: true,
        selectedTab:1,
        userAddDefault:name
    });
}

$j(function () {
    $j('.js-workflowid').change(function() {
        var workflowID = $j(this).val();
        workflow_preview(workflowID);

        $j.ajax({
            url: '/admin/issue/workflow-fields/',
            data: {
                workflowid: workflowID
            },
            success: function (html) {
                $j('.js-fields-container').html(html);
            }
        });

        // подгружаем продукты
        init_products(workflowID);

    });

    $j('.js-workflowid').trigger('change');
});

/*$j(function () {
    $j(window).keydown(function(event) {
        var $target = $j(event.target);

        if (!$target.is('#js-product-name-input')) {
            return;
        }

        var keyUp = 38;
        var keyDown = 40;
        var keyEnter = 13;

        if (event.which == keyDown) {
            // стрелка вниз - выделить следующий элемент
            event.preventDefault();
            var $selected = $j('.js-order-table-product-search-result.selected').first();
            if ($selected.length) {
                var $next = $selected.next('.js-order-table-product-search-result');
                if ($next.length) {
                    $selected = $next;
                } else {
                    var $next = $selected.parents('.shop-table').first().nextAll().find('.js-order-table-product-search-result').first();
                    if ($next.length) {
                        $selected = $next;
                    }
                }
            } else {
                $selected = $j('.js-order-table-product-search-result').first();
            }

            $j('.js-order-table-product-search-result.selected').removeClass('selected');
            $selected.addClass('selected');

        } else if (event.which == keyUp) {
            // стрелка вверх - выделить предыдущий элемент
            event.preventDefault();
            var $selected = $j('.js-order-table-product-search-result.selected').first();
            if ($selected.length) {
                var $prev = $selected.prev('.js-order-table-product-search-result');
                if ($prev.length) {
                    $selected = $prev;
                } else {
                    var $prev = $selected.parents('.shop-table').first().prevAll().find('.js-order-table-product-search-result').last();
                    if ($prev.length) {
                        $selected = $prev;
                    }
                }
            } else {
                $selected = $j('.js-order-table-product-search-result').last();
            }

            $j('.js-order-table-product-search-result.selected').removeClass('selected');
            $selected.addClass('selected');

        } else if (event.which == keyEnter) {
            $selected = $j('.js-order-table-product-search-result.selected');
            if ($selected.length) {
                event.preventDefault();
                $j('.js-order-table-product-search-result.selected').trigger('click');
            }
        }
    });
});*/

function workflow_preview (workflowID) {

    if (!workflowID) {
        workflowID = $j('#js-workflow').val();
    }

    $j.ajax({
        url: '/admin/issue/workflow-preview/',
        datetype: "json",
        data: {
            workflowid: workflowID
        },
        success: function (data) {
            var obj = $j.parseJSON(data);
            if (obj) {
                $j('.js-workflow-container').html(obj.html);

                var defaultIssueName = $j('.js-default-issuename').val();
                var defaultManagerID = $j('.js-default-managerid').val();
                var defaultDateTo = $j('.js-default-dateto').val();

                if ($j('.js-issuename').val() == '') {
                    $j('.js-issuename').val(defaultIssueName);
                }

                if (obj.userid > 0) {
                    $j('.js-managerid').select2('val', obj.userid);
                } else {
                    $j('.js-managerid').select2('val', $j('#js-user-id').val());
                }

                $j('.js-managerid').change();

                if (defaultDateTo != '') {
                    $j('.js-dateto').val(defaultDateTo);
                }
                $j('#divStatusDefaultIssue').show();

                // замена статусов в select-е
                $j('.js-order-add-statusid').select2('destroy');
                $j('.js-order-add-statusid').html('');
                var statusDefaultID = obj.statusDefaultID;
                $j.each(obj.statusArray, function(key, value) {
                    $j('.js-order-add-statusid').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $j('.js-order-add-statusid').select2();
                $j('.js-order-add-statusid').select2('val', statusDefaultID);
                $j('.js-order-add-statusid').change();
            }

        }
    });
}

$j(function () {
    var query = '';
    if ($j('.js-custom-field-search').length) {
        $j('.js-custom-field-search').autocomplete({
            delay: 500,
            source: function (request, response) {
                query = request.term;
                $j.ajax({
                    url: "/admin/shop/users/ajax/autocomplete/custom/field/select2/",
                    dataType: "json",
                    data: {
                        name: request.term,
                        key: $j(this.element).data('key')
                    },
                    success: function (data) {
                        if (data == null) response(null);
                        response($j.map(data, function (item) {
                            name = item.name;
                            return {
                                id: item.id,
                                label: item.label,
                                value: item.searchField,
                                phone: item.phone,
                                name: item.name,
                                email: item.email,
                                skype: item.skype,
                                whatsapp: item.whatsapp,
                                customField: item.customFields
                            }
                        }));
                    }
                });
            },
            select: function (event, ui) {
                $j('#id-clientid-value').val(ui.item.id);
                $j('#id-clientid-name').val(ui.item.name);
                $j('#js-client-phone').val(ui.item.phone);
                $j('[name=contact_email]').val(ui.item.email);
                $j('[name=contact_skype]').val(ui.item.skype);
                $j('[name=contact_whatsapp]').val(ui.item.whatsapp);

                // кастомные поля
                jQuery.each(ui.item.customField, function (i, item) {
                    $j('.js-custom-field-search[data-key="' + i + '"]').val(item);
                });
            },
            minLength: 3
        }).data('ui-autocomplete')._renderItem = function (ul, item) {
            ul.removeClass().addClass("ob-autocomplete");
            var inner_html = '<span>' + item.label + '</span>';
            ul.css('z-index', '9999');
            if (item.id === 0) {
                inner_html = '<span class="ob-link-add ob-link-dashed">' + item.label + '</span>';
                return $j("<li onclick='addUserInSelectWindow2(\"" + htmlspecialchars(query) + "\")'></li>")
                    .data("item.autocomplete", item)
                    .append(inner_html)
                    .appendTo(ul);
            } else {
                return $j("<li></li>")
                    .data("item.autocomplete", item)
                    .append(inner_html)
                    .appendTo(ul);
            }
        };
    }
});