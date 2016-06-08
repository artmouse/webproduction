var username = '';
var usernamelast = '';
var usernamemiddle = '';
var useremail = '';
var userphone = '';
var useraddress = '';
var usercountry = '';

$j(function() {
    username = $j('#username').val();
    usernamelast = $j('#usernamelast').val();
    usernamemiddle = $j('#usernamemiddle').val();
    useremail = $j('#useremail').val();
    userphone = $j('#userphone').val();
    useraddress = $j('#useraddress').val();
    usercountry = $j('#usercountry').val();

    jQueryTabs.TabMenu($j('.settings-tab'));
});

$j(function() {
    
    if ($j('#js-delivery').length) {
        delivery_add_to_order ();
    } else {
        $j('#deliverySum').text('0.00');
    }

    $j('#id-client').autocomplete({
        delay: 500,
        source: function( request, response ) {
            $j.ajax({
                url: "/admin/shop/users/jsonautocomplete/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        return {
                            label: item.name,
                            value: item.id
                        }
                    }));
                }
            });
        }
    });

    /*
    // при выходе из поля - автоматическое заполнение клиента
    $j('#id-client').live('change', function (e) {
        client_info();
    });
    */

    $j('#id-client').live('keydown', function(e) {
        if (e.keyCode == 13) {
            client_info();
        }
    });

    $j('a.ui-corner-all').live('click', function(e) {
        client_info();
    });

    $j('.js-select-delivery').click(function(){
        //select_delivery();
        // скрываем все select оплаты
        $j("[name='payment']").each(function(i, j){
            $j(this).hide();
            $j(this).attr('disabled', '');
        });
        // показываем нужный
         var idDelivery = $j(this).data('id');

        $j('#payment'+idDelivery).show();
        $j('#payment'+idDelivery).removeAttr('disabled');
        if ($j('#delivery').length) {
            delivery_add_to_order();
        }
    });

    $j('.js-select-delivery').change(function(){
        if ($j('#delivery').length) {
            delivery_add_to_order();
        }
    });
});

$j(function () {
   $j('.js-content-delivery-ajax').click(function () {
       $j('.js-content-delivery-ajax').parent().removeClass('selected');
       $j(this).parent().addClass('selected');
       $j.ajax({
           url: "/ajax/content/delivery/",
           dataType: "json",
           data:{
               id: $j(this).data('id')
           },
           success: function(data) {
               $j('#js-content-delivery-block').html(data);
               fielsdRequiredRemove();
               fielsdRequiredCheck();
           }
       });

       delivery_add_to_order();
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

// инициализация полей доставки
$j(function () {
    $j('ul.delivery-ways').find('li.selected').find('a.js-content-delivery-ajax').click();
});

function tab_addNewUser_click() {
    $j('#username').val('');
    $j('#usernamelast').val('');
    $j('#usernamemiddle').val('');
    $j('#useremail').val('');
    $j('#userphone').val('');
    $j('#useraddress').val('');
    $j('#usercountry').val('');
    $j('#id-client').val('');
    $j('#id-newuser').val(1);
    return false;
}

function tab_me_click() {
    $j('#username').val(username);
    $j('#usernamelast').val(usernamelast);
    $j('#usernamemiddle').val(usernamemiddle);
    $j('#useremail').val(useremail);
    $j('#userphone').val(userphone);
    $j('#useraddress').val(useraddress);
    $j('#usercountry').val(usercountry);
    $j('#id-client').val('');
    $j('#id-newuser').val(0);
    return false;
}

function tab_client_click() {
    $j('#username').val('');
    $j('#usernamelast').val('');
    $j('#usernamemiddle').val('');
    $j('#useremail').val('');
    $j('#userphone').val('');
    $j('#useraddress').val('');
    $j('#usercountry').val('');
    $j('#id-newuser').val(0);
    return false;
}

function client_info() {
    var userId = $j('#id-client').val();

    $j.ajax({
        url: '/admin/shop/users/ajax/info/',
        type: "post",
        data: {
            id : userId
        },
        dataType : "json",
        success: function (data, textStatus) {
            if (data) {
                $j('#username').val(data.name);
                $j('#usernamelast').val(data.namelast);
                $j('#usernamemiddle').val(data.namemiddle);
                $j('#useremail').val(data.email);
                $j('#userphone').val(data.phone);
                $j('#useraddress').val(data.address);
            }
        }
    });
}

function delivery_add_to_order () {
    var sel = $j('.delivery-ways').find('.selected');
    var amount = Number($j(sel).data('amount')).toFixed(2);
    var pay = Number($j(sel).data('paydelivery')).toFixed(2);
    var allSum = document.getElementById('allSumClear').value;

    if (pay) {
        $j('#deliverySum').text(amount);
        $j('#allSum').text((Number(allSum) + Number(amount)));
    } else {
        $j('#deliverySum').text('0.00');
        $j('#allSum').text(allSum);
    }
}