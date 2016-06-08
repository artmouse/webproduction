$j(function() {
    // utm to cookie
    var utm_source = getUrlParameter('utm_source');
    var utm_medium = getUrlParameter('utm_medium');
    var utm_campaign = getUrlParameter('utm_campaign');
    var utm_content = getUrlParameter('utm_content');
    var utm_term = getUrlParameter('utm_term');
    var utm_referrer = document.referrer;

    var currentdate = new Date();
    var utm_date = "" + currentdate.getFullYear() + "-"
        + (currentdate.getMonth()+1)  + "-"
        + currentdate.getDate() + " "
        + currentdate.getHours() + ":"
        + currentdate.getMinutes() + ":"
        + currentdate.getSeconds();

    if ($j.cookie('utm_date') == undefined) {
        $j.cookie('utm_date', utm_date, { expires: 365, path: '/' });
    }

    if (utm_source != '') {
        $j.cookie('utm_source', utm_source, { expires: 365, path: '/' });
    }
    if (utm_medium != '') {
        $j.cookie('utm_medium', utm_medium, { expires: 365, path: '/' });
    }
    if (utm_campaign != '') {
        $j.cookie('utm_campaign', utm_campaign, { expires: 365, path: '/' });
    }
    if (utm_content != '') {
        $j.cookie('utm_content', utm_content, { expires: 365, path: '/' });
    }
    if (utm_term != '') {
        $j.cookie('utm_term', utm_term, { expires: 365, path: '/' });
    }
    if (!$j.cookie('utm_referrer') && utm_referrer != '') {
        $j.cookie('utm_referrer', utm_referrer, { expires: 365, path: '/' });
    }
});

$j(function() {
    // lazy load

    $j('img').lazyload({
        effect: 'fadeIn'
    });
});

$j(function() {
    // search
    //если используем блок
    if($j('#id-search').length){
        $j('#id-search').autocomplete({
            source: function( request, response ) {
                $j.ajax({
                    url: "/search/jsonautocomplete/",
                    dataType: "json",
                    data: {
                        name: request.term
                    },
                    background: true,
                    success: function (data) {
                        if (data==null) {
                            response(null);
                        }
                        response( $j.map( data, function( item ) {
                            return {
                                label: item.name,
                                image: item.image,
                                description: item.description,
                                url: item.url
                            }
                            return item.name;
                        }));
                    }
                });
            },
            select: function (event, ui) {
                document.location = ui.item.url;
            },
            minLength: 2
        }).data('ui-autocomplete')._renderItem = function (ul, item) {
            var inner_html = '<a><span class="shop-autocoplete-element"><span class="image"><span>';
            if (item.image != false) {
                inner_html += '<img src="' + item.image + '">';
            }
            inner_html +=  '</span></span><span class="description"><span class="label">' + item.label + '</span>' + item.description +
                '</span><span class="clear"></span></span></a>';
            ul.css('z-index','9999');
            return $j( "<li></li>" )
                .data( "item.autocomplete", item )
                .append(inner_html)
                .appendTo( ul );
        };
    }
});

//$j(function() {
//    // попап os-popup-block
//    $j(document).on('click', '.os-popup-block .close, .os-popup-block .dark', function (event) {
//        $j(event.target).closest('.os-popup-block').fadeOut();
//        return false;
//    });
//});

$j(function() {
    // ajs-code
    $j('.ajs').val('ready');
});

/*var brandSelected = '{|$brandSelected|}';
 if (brandSelected) {
 $j('#id-tab-brands').click();
 }*/

$j(function() {
    // баннера слева/справа
    if ($j('.os-columnbanner-carousel .line').length) {
        $j('.os-columnbanner-carousel .line').each(function(index, e) {
            $j(e).jCarouselLite({
                btnNext: $j(e).parent().find('.next'),
                btnPrev: $j(e).parent().find('.prev'),
                circular: true,
                visible: 1,
                speed: 500,
                auto: true,
                timeout: 5000
            });
        });
    }
});

$j(function() {
    // Инициализация каруселей
    // отдельно, чтобы не было глюков
    if ($j('.os-product-carousel .line').length) {
        $j('.os-product-carousel .line').each(function(index, e) {
            var $auto = $j(e).data('auto') ? true : false;
            $j(e).jCarouselLite({
                btnNext: $j(e).parent().parent().find('.next'),
                circular: true,
                visible: 6,
                speed: 500,
                auto: $auto,
                timeout: 5000
            });
        });
    }
});

$j(function() {
    // filter toggle
    $j('.js-filter-toggle').click(function(){
        $j('.js-filter-toggle, .js-filter-block').slideToggle(300);
    });
});

$j(function() {
    // первый раз загружаем корзину
    shop_basket_load();
});

$j(function() {
    // ajax покупка товаров
    $j('.js-shop-buy-action').live('click', function (event) {
        shop_basket_buy(event);
    });
});

$j(function() {
    // price from select
    $j('.shop-select').change(function(event){
        $j('.button-refresh').click();
    });
});

$j(function() {
    // в фильтре товаров - самбит через 3 секунды автоматически
    $j('.os-filter-block input, .os-filter-block select').live('change', function(){
        setTimeout(shop_filter_submit, 3000);
    });
});

$j(function() {
    // @todo: wtf?
    $j('a.comment-link').click(function(){
        commentPress();
    });
});

$j(function() {
    // инициализация tabs-menu
    if ($j('#id-tabs').length) {
        jQueryTabs.TabMenu($j('#id-tabs a'));
    }
});

$j(function() {
    // product compare
    $j('.js-shop-compare-action').click(shop_compare_add);
    shop_compare_load();
});

$j(function() {
    // product page
    try {
        commentParser();
    } catch (e) {}

    try {
        rproductRating = new ratingAdd();
    } catch (e) {}

});

$j(function() {
    // menu toggle
    $j('.js-navi .device-main').click(function(){
        if ($j(this).next().is(':visible')) {
            $j('.js-navi .sub').removeClass('open');
        } else {
            $j('.js-navi .sub').removeClass('open');
            $j(this).next().addClass('open');
        }
        return false;
    });
});

//$j(function() {
//    //изменяем цену по опциям
//    if ($j('#canAddMarkup').val()) {
//        $j('.js-shop-buy-option').change(function () {
//            var optionMarkup = 0;
//            $j('.js-shop-buy-option').each(function (i, e) {
//                var optionID = $j(e).data('optionid');
//                var optionValue = $j(e).val();
//                if (optionValue) {
//                    optionMarkup += parseFloat($j('#'+'option'+optionID+'hidden'+hex_md5(optionValue)).val());
//                }
//            });
//            var price = parseFloat($j('#canAddMarkup').val());
//            $j('#priceSpan').html(price + optionMarkup);
//        });
//    }
//});

// добавить товар к сравнению
function shop_compare_add(event) {
    var productID = $j(event.target).closest('.js-shop-compare').data('productid');
    shop_compare_load(productID);

    event.preventDefault();
}

// загрузить сравнения
function shop_compare_load(productID) {
    if (productID == undefined) {
        productID = 0;
    }
    $j.ajax({
        url: "/ajax/compare/",
        dataType: "json",
        data: {
            productid: productID
        },
        success: function (data) {
            // обновляем все кнопки
            if (data.productArray) {
                $j(data.productArray).each(function (i, e) {
                    var $button = $j('.js-shop-compare[data-productid='+e.id+']');
                    $button.html(e.text);
                });

                var compareBlock = $j(".js-compare-list");
                compareBlock.html(data.html);
            }

            // клик на блок корзины
            /*$j('#id-shop-basket').click(function () {
                shop_basket_popup();
            });*/
        }
    });
}

function deleteCompare (productId) {
    $j.ajax({
        url: "/ajax/compare/",
        dataType: "json",
        data: {
            'delete': productId
        },
        success: function (data) {
            if (data.count == 0) {
                location.reload();
            } else {
                shop_compare_load();
                $j(".id-"+productId).hide(400);
            }
        }
    });
}

var ratingAdd = function () {
    var activeDistance;
    var currentClass = 'rating-0';

    $j(".rating-estimate-body .ratin-buttons a").hover(function (){
        $j('#rating-estimate-stars').removeClass();
        $j("#rating-estimate-stars").addClass('rating-'+($j(this).index()+1));
    },function() {
        $j('#rating-estimate-stars').removeClass();
        $j("#rating-estimate-stars").addClass(currentClass);
    });

    $j(".rating-estimate-body .ratin-buttons a").click(function (){
        currentClass = $j('#rating-estimate-stars').attr('class');
        $j('#rating-estimate-stars').removeClass();
        $j("#rating-estimate-stars").addClass('rating-'+($j(this).index()+1));
        $j('#ratingValue').val(($j(this).index()+1));
        return false;
    })
}

// @todo: refactoring
function commentParser() {
    var index = 'false';

    //document.location.href = '#';

    var commentIndex  = $j.cookie('comment');
    if (commentIndex == 'true' ) {
        $j.cookie('comment', index, {
            path: "/"
        });
        $j('.tab-content').hide();
        $j('.shop-block-comments').show();
        $j('.shop-tab-block a').removeClass('selected');
        $j("[data-rel = '.shop-block-comments']").addClass('selected');
        document.location.href='#id-tabs';
    }
}

function shop_filter_submit() {
    $j('.os-filter-block .os-submit').click();
}

// @todo: wtf?
function commentPress() {
    var index = 'true';
    $j.cookie('comment', index, {
        path: "/"
    });
}

// обработчик: клик на кнопку Купить (в корзину)
function shop_basket_buy(event) {
    var productID = $j(event.target).closest('.js-shop-buy').data('productid');
    var action = $j(event.target).closest('.js-shop-buy').data('action');
    var productCount = $j('.js-shop-buy-count').val();

    // опции заказа

    var productOptions = '';

    $j('.js-shop-buy-option').each(function (i, e) {
        var optionID = $j(e).data('optionid');
        var optionValue = $j(e).val();

        productOptions += optionID + ':' + optionValue + ';';
    });

    if (action == 'exchange') {
        if ($j('.js-rtm-buy-exchange-option').length) {
            var optionID = $j('.js-rtm-buy-exchange-option').data('optionid');
            var optionValue = $j('.js-rtm-buy-exchange-option').val();
            if (optionID != undefined) {
                productOptions += optionID + ':' + optionValue + ';';
            }

        } else {
            var optionID = $j(event.target).closest('.js-shop-buy').data('weightid');
            var optionValue = $j(event.target).closest('.js-shop-buy').data('weightname');
            productOptions += optionID + ':' + optionValue + ';';
        }
    }

    shop_basket_load(productID, productCount, productOptions, action);

    event.preventDefault();
}

// показать содержимое корзины
function shop_basket_popup() {
    popupOpen('.js-basket-popup');
}

// загрузить корзину
function shop_basket_load(productID, productCount, productOptions, action) {
    if (productID == undefined) {
        productID = 0;
    }
    if (productCount == undefined) {
        productCount = 1;
    }
    if (productOptions == undefined) {
        productOptions = '';
    }

    $j.ajax({
        url: "/ajax/basket/",
        dataType: "json",
        data: {
            productid: productID,
            productcount: productCount,
            productoptions: productOptions,
            action: action
        },
        success: function (data) {
            // обновляем корзину
            $j('.js-basket').html(data.html);

            // отображаем блок покупок
            if (data.productID > 0) {
                shop_basket_popup();
            }

            // обновляем все кнопки
            if (data.productIDArray) {

                var productID = parseInt($j('#productPage').val());
                if (productID) {
//                    $j(data.optionArray).each(function (z, e) {
//
//                        for (var key in e) {
//                            if (key == productID ) {
//                                for (var ke in e[key]) {
//                                    if (e[key][ke]['filtervalue']) {
//                                        //находим селект по имени и сразу вызываем событие изменения селекта для подсчёта суммы товара
//                                        $j('select.js-shop-buy-option[name=option-'+e[key][ke]['filterid']+']').val(e[key][ke]['filtervalue']).change();
//                                    }
//                                }
//                            }
//                        }
//                    });
                }
            }
        }
    });
}

// @todo: use jquery toggleClass()
function toggleElement(e){
    if ($j(e).is('.selected')) {
        $j(e).removeClass('selected');
    } else {
        $j(e).addClass('selected');
    }
}

function productsNoticeOfAvailability() {
    var email = $j('#email').val();
    var name =  $j('#name').val();
    var productid =  $j('#productid').val();
    $j.ajax({
        url: '/noticeofavailabilityajax/',
        type:'POST',
        dataType: "json",
        data: {
            productid: productid,
            email: email,
            name: name
        },

        success: function(x) {
            if (x.send == true) {
                popupOpen('#id-notice-of-availability-success');
                popupClose('#id-notice-of-availability');
            } else {
                popupOpen('#id-notice-of-availability');
                $j('#id-notice-of-availability-error').show();
                $j('#id-notice-of-availability-error-name').hide();
                $j('#id-notice-of-availability-error-email').hide();
                if (x.error == 'name') {
                    $j('#id-notice-of-availability-error-name').show();
                }
                if (x.error == 'email') {
                    $j('#id-notice-of-availability-error-email').show();
                }
            }
        },
        fail: function() {
            alert('Request failed');
        }
    });
}

//content replace for seo
$j(function() {
    $j('.rtm-seo-block').appendTo('section').height('auto');
});

// скрыть содержимое корзины
function shop_basket_popup_close() {
    $j('.os-popup-block .close').click();
    return false;
}

//phone formating
$j(function() {
    $j('.js-phone-formatter').mask("+99 (999) 999-99-99");
});


// попап os-popup-block open
function popupOpen(e) {
    $j(e).fadeIn();
    var scrltp = $j(window).scrollTop();
    var popupBlock = $j(e).find('.popup-block');
    var popupHeight = popupBlock.height();
    popupBlock.css({
        'top' : - popupHeight
    });
    popupBlock.animate({
        'top': 0
    }, 500);
}

// попап os-popup-block close
function popupClose(e) {
    var scrltp = $j(window).scrollTop();
    var popupBlock = $j(e).find('.popup-block');
    var popupHeight = popupBlock.height();
    var popupTopPadding = 100;
    popupBlock.animate({
        'top': - popupHeight - popupTopPadding
    }, 500);
    setTimeout(function(){
        $j(e).fadeOut();
    }, 500);
}

$j(function() {
    // mobile menu toggle
    $j('.js-menu-toggle').click(function(){
        $j('.rtm-navigation').slideToggle();
    });
});



//auto focus in input
$j(function() {
    $j("form input").eq(0).focus();

    $j('.js-focus-login').click(function() {
        $j(".rtm-popup-block .auth-block").find('input').first().focus();
    });

    $j('.js-focus-register').click(function() {
        $j(".rtm-popup-block .register-block").find('input').first().focus();
    });

    $j('.js-focus-order').click(function() {
        $j("#shop-popup-basket-block .register-block").find('input').first().focus();
    });

});

//инициализация просмотра картинок
$j(function() {
    $j('.colorbox').colorbox({
        rel:'gal',
        maxWidth: '95%',
        maxHeight: '95%',
        current : false
    });
});

$j(document).ready(function(){

    if ($j('.rtm-index-carousel .line').length) {
        $j('.rtm-index-carousel .line').each(function(index, e) {
            $j(e).jCarouselLite({
                btnNext: $j(e).parent().find('.next'),
                btnPrev: $j(e).parent().find('.prev'),
                btnGo: $j('.bullets a'),
                visible: 5,
                scroll: 1
            });
        });
    }

    $j('.jsFilterToggle').click(function() {
        filterToggler(true, $j(this));
    });

    $j('.js-f-left').click( function() {
        if (parseInt($j('#check').val()) == 0) {
            filterToggler(true, $j('.jsFilterToggle'));
        }
    } );

    $j('.js-f-right').click( function() {
        if (parseInt($j('#check').val()) == 1) {
            filterToggler(true, $j('.jsFilterToggle'));
        }
    } );

    if (location.pathname.indexOf('_check=1') != -1) {
        filterToggler(false,  $j('.jsFilterToggle'));
    }

    // Dropdown menu
    //$j('#menu').dropdownMenu({ mode: 'slide', dropdownSelector: 'div.dropdown'});

    //---------------------------Мягкая пагинация---------------------------------//
    var $number = $j('.js-onpage-bottom').val();
    var pageNumber = $j('.js-rtm-paginator .active').data('key');
    if ($j('.rtm-paginator a').length) {
        updatePaginatorDots();
    }

    var $process = false;
    var seoHeight = 0;
    if ($j('.rtm-seo-block').length) {
        seoHeight = $j('.rtm-seo-block').height();
    }
    $j(window).scroll(function () {
        if ((($j(window).scrollTop() + $j(window).height()) >= $j(document).height() - 330 - seoHeight) && !$process && $j('.js-rtm-product-list').data('id') != '') {
            $process = true;
            pageNumber++;
            // Пишем урл в куки
            var url = getNextPageUrl(pageNumber);
            if (!url) {
                return false;
            }
            var date = new Date();
            var minute = 1000*60 ;
            date.setTime(date.getTime() + (minute));
            $j.cookie('product-list-url', url, { expires: date, path: '/' });

            // Меняем урл
            window.history.replaceState("object or string", "Title", url );

            $j.ajax({
                beforeSend: function () {
                    $process = true;
                },
                url: '/ajax/shop-product-list/'+$j('.js-rtm-product-list').data('id')+'/',
                data: {
                    'number' : $number
                }
            }).done (function (data) {
                $j('.rtm-seo-block').remove();
                seoHeight = 0;
                try {
                    $number = $number + $j('.js-onpage-bottom').val();
                    $process = false;
                    var new_item = $j(data).hide();
                    $j('.js-rtm-product-list').append(new_item);
                    new_item.slideDown('slow');
                } catch (e) {
                }
            });
        }

    });
    //---------------------------------------------------------------------------------//

});

$j(function () {
    $j('.js-onpage-bottom').change(function () {
        if ($j(this).attr('name') == 'onpage_select') {
            //выставляем везде одинаковый онпейдж
            $j('.js-onpage-val').val($j(this).val());
        }
        setOrderPage();
    });
});

var prevPage = -1;

/**
 * Возвращает url страници @pageNumber и делает эту страницу активной
 * @param pageNumber
 */
function getNextPageUrl(pageNumber) {
    pageNumber = parseInt(pageNumber);
    if (prevPage === pageNumber) {
        return false;
    } else {
        prevPage = pageNumber;
    }
    var prev = pageNumber - 1;
    var next = pageNumber + 1;

    if ($j('.js-rtm-paginator a[data-key="'+pageNumber+'"]').length) {
        // меняем с небольшой задержкой урл страници
        setTimeout(function() {
            $j('.js-rtm-paginator a').removeClass('active');
            $j('.js-rtm-paginator a[data-key="'+pageNumber+'"]').addClass('active');
            var openArray = [];
            $j('.js_paginator_hidden').hide();
            for (j = pageNumber-3; j <= pageNumber+3; j++) {
                if (j > 0) {
                    $j('.js-rtm-paginator a[data-key="'+j+'"]').show();
                }
            }
            updatePaginatorDots();
        }, 700);

        setDirectionUrl(prev, 'prev');
        setDirectionUrl(next, 'next');

        return $j('.js-rtm-paginator a[data-key="'+pageNumber+'"]').attr('href');
    } else {
        return false;
    }

}

function updatePaginatorDots(){
    if (!$j('.rtm-paginator').find('a:eq(2)').is(':visible')) {
        $j('.js_stepper_dots_first').show();
    } else {
        $j('.js_stepper_dots_first').hide();
    }
    // alert($j('.rtm-paginator').find('a:eq(2)').html());
    if (!$j('.rtm-paginator').find('a:eq(-3)').is(':visible')) {
        $j('.js_stepper_dots_last').show();
    } else {
        $j('.js_stepper_dots_last').hide();
    }
}




/**
 * Устанавливает ссылки prev next для пагинации
 * @param index
 * @param direction
 */
function setDirectionUrl(index, direction) {
    if ($j('.js-rtm-paginator a[data-key="'+index+'"]').length) {
        $j('.js-rtm-paginator a[data-rel="'+direction+'"]').attr('href', $j('.js-rtm-paginator a[data-key="'+index+'"]').attr('href'));
    } else {
        $j('.js-rtm-paginator a[data-rel="'+direction+'"]').hide();
    }
}

function setOrderPage() {

    var url = '';

    var sort = 'sort='+$j('select[name="sort"]').val();

    var onpage = 'onpage='+$j('.js-onpage-val').val();

    var pathname = location.pathname;

    if (pathname.indexOf('/filter') != -1) { // фильтра уже есть

        url = pathname;
        url = makeFiltersUrl('sort', url, sort);
        url = makeFiltersUrl('onpage', url, onpage);

    } else {
        url = pathname + '/filter' + '_' + sort + '_' + onpage;
    }
    url = url.replace('//', '/');
    location.href = url;

}

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
    return '';
}

/**
 * Функция, если есть, меняет на новый, если нету, то добавляет нужный параметр в урл.
 *
 * @param filter
 * @param url
 * @param value
 * @returns {string}
 */
function makeFiltersUrl(filter, url, value) {

    var oldFiltersArray = url.split("_");
    var newFiltersArray =[];

    var index;
    var findValue = false;
    // Меняем старые значения filter
    for (index = 0; index < oldFiltersArray.length; ++index) {
        if (oldFiltersArray[index].indexOf(filter) !== -1) {
            newFiltersArray[index] = value;
            findValue = true;
        } else {
            newFiltersArray[index] = oldFiltersArray[index];
        }
    }
    // Если не нашли старых, добавляем в конец новое значение.
    if (!findValue) {
        newFiltersArray[index] = value;
    }

    return newFiltersArray.join("_");

}


function filterToggler(clear, element) {
    if (clear) {
        $j('#minCost').val('');
        $j('#maxCost').val('');
    }

    $j('.js-slider-price').hide();
    $j('.js-slider-price-product').hide();
    if (element.hasClass('animated')) {
        $j('#check').val(0);
        element.animate({right: '90px'}, 200).removeClass('animated');
        $j('.js-price-name').text('Цена');
        $j('.js-slider-price-product').show();
    } else {
        $j('#check').val(1);
        element.animate({right: '117px'}, 200).addClass('animated');
        $j('.js-price-name').text('Цена за работу');
        $j('.js-slider-price').show();
    }
}

$j(function() {
    // scroll to top page
    $j(".js-scroll-top").hide();

    $j(function () {
        $j(window).scroll(function () {
            if ($j(this).scrollTop() > 300) {
                $j('.js-scroll-top').fadeIn();}
            else {$j('.js-scroll-top').fadeOut();}
        });
        $j('.js-scroll-top').click(function () {
            $j('body,html').animate({scrollTop: 0}, 200);
            return false;
        });
    });
});

//для активных-неактивных кнопок меню
$j(function () {
    // подключение на события изменения полей, которые должны быть заполнены
    // для активации кнопки отправки submit
    
    // shop_forms_bonus_cart.html
    $j('.rtm-check-fill01').click(function (){
         checkParams('01');
    });
    $j('.rtm-check-fill01').change(function (){
         checkParams('01');
    });
    $j('.rtm-check-fill01').keyup(function (){
         checkParams('01');
    });
    checkParams('01');
    
    // shop_basket.html
    $j('.rtm-check-fill02').click(function (){
         checkParams('02');
    });
    $j('.rtm-check-fill02').change(function (){
         checkParams('02');
    });
    $j('.rtm-check-fill02').keyup(function (){
         checkParams('02');
    });
    checkParams('02');
    
    // block_feedback.html
    $j('.rtm-check-fill03').click(function (){
         checkParams('03');
    });
    $j('.rtm-check-fill03').change(function (){
         checkParams('03');
    });
    $j('.rtm-check-fill03').keyup(function (){
         checkParams('03');
    });
    checkParams('03');
    
    // shop_tpl.html .js-popup-auth-block
    $j('.rtm-check-fill04').click(function (){
         checkParams('04');
    });
    $j('.rtm-check-fill04').change(function (){
         checkParams('04');
    });
    $j('.rtm-check-fill04').keyup(function (){
         checkParams('04');
    });
    checkParams('04');

    // block_menu_textpage.html
    $j('.rtm-check-fill05').click(function (){
         checkParams('05');
    });
    $j('.rtm-check-fill05').change(function (){
         checkParams('05');
    });
    $j('.rtm-check-fill05').keyup(function (){
         checkParams('05');
    });
    checkParams('05');
    
    // error401.html
    $j('.rtm-check-fill06').click(function (){
         checkParams('06');
    });
    $j('.rtm-check-fill06').change(function (){
         checkParams('06');
    });
    $j('.rtm-check-fill06').keyup(function (){
         checkParams('06');
    });
    checkParams('06');
    
});

function checkParams(ss) {
    classfield = '.rtm-check-fill';
    classsubmit = '.rtm-submit-fill';
    
    classfield += ss;
    classsubmit += ss;
    //console.log(classfield);
    //console.log(classsubmit);
    flag = true;
    $j(classfield).each(function(){
        //console.log($j(this).val());
        strField = '';
        strField +=  $j(this).val();
        if (strField.length === 0) {
            flag = false;
        }
        if ($j(this).hasClass("js-phone-formatter") && strField.indexOf('_')>=0) {
            flag = false;
        }
    });
    if (flag) {
        $j(classsubmit).removeAttr('disabled');
        //$j('.rtm-submit-fill').show();
    } else {
        $j(classsubmit).attr('disabled', 'disabled');
        //$j('.rtm-submit-fill').hide();
    }
}
