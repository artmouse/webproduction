$j(function() {
    // ajs-code
    $j('.ajs').val('ready');

    // tpl_column
    if( !$j.trim( $j('.js-aside-right').html() ).length ) {
        $j('.js-section').addClass('full');
        $j('.js-aside-right').hide();
    }

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

    // Инициализация каруселей
    // отдельно, чтобы не было глюков
    if ($j('.os-product-carousel .line').length) {
        $j('.os-product-carousel .line').each(function(index, e) {
            var $auto = $j(e).data('auto') ? true : false;
            $j(e).jCarouselLite({
                btnNext: $j(e).parent().parent().find('.next'),
                circular: true,
                visible: 10,
                speed: 500,
                auto: $auto,
                timeout: 5000,
                start: -1
            });
        });

        // фикс для маленького кол-ва слайдов
        $j('.os-product-carousel .next').click();
    }

    if ($j('.os-productaction-carousel').length) {
        $j('.js-action-carousel').slick();
    }

    // block banner top init
    if ($j('.js-block-slider').length) {
        bannerTopSlider();
    }

    function bannerTopSlider() {
        $j('.js-block-slider .line').jCarouselLite({
            btnGo: $j('.js-block-slider .control span'),
            auto: true,
            timeout: 8000,
            visible: 1
        });
    }

    // block banner top resize reinit
    $j(window).bind('resize', function(){
        window.resizeEvt;
        $j(window).resize(function(){
            clearTimeout(window.resizeEvt);
            window.resizeEvt = setTimeout(function(){
                $j('.js-block-slider .line').trigger('endCarousel');
                $j('.js-block-slider .line, .js-block-slider ul, .js-block-slider li').attr('style', '');

                bannerTopSlider();
            }, 250);
        });
    });

    // block slick-banners top init
    if ($j('.js-block-slick-slider').length) {
        $j('.js-block-slick-slider').slick({
            dots: true,
            speed: 300,
            autoplay: true,
            autoplaySpeed: 6000,
            adaptiveHeight: true,
            slidesToShow: 1
        });
    }


    // первый раз загружаем корзину
    shop_basket_load();

    // ajax покупка товаров
    $j( 'div' ).on( 'click', '.js-shop-buy-action', function(event) {
      shop_basket_buy(event);
    });
    // price from select
    $j('.shop-select').change(function(event){
        $j('.button-refresh').click();
    });

    // в фильтре товаров - самбит через 3 секунды автоматически
    $j('.js-block-filter input, .js-block-filter select').live('change', function() {
        setTimeout(shop_filter_submit, 3000);
    });

    $j('.js-block-filter label a').live('click', function() {
        $j(this).parent().find('input').attr('checked', 'checked');
        $j('.js-block-filter .js-submit-filter').click();
        return false;
    });

    $j('.js-remove-filter').click(function(){
        $j('.js-block-filter').addClass('load');
    });

    // @todo: wtf?
    $j('a.comment-link').click(function(){
        commentPress();
    });

    // инициализация tabs-menu
    if ($j('#id-tabs').length) {
        jQueryTabs.TabMenu($j('#id-tabs a'));

        $j('#id-tabs a').click(function(){
            // product thumb size
            productThumbSize();
        });
    }

    // product compare
    $j('.js-shop-compare-action').click(shop_compare_add);
    shop_compare_load();

    // product page
    try {
        commentParser();
    } catch (e) {}

    //изменяем цену по опциям
    if ($j('#canAddMarkup').val()) {
        $j('.js-shop-buy-option').change(function () {
            var discount = 0;
            if ($j('#dataDiscount').length) {
                discount = $j('#dataDiscount').val();
            }
            var optionMarkup = 0;
            $j('.js-shop-buy-option').each(function (i, e) {
                var optionID = $j(e).data('optionid');
                var optionValue = $j(e).val();
                if (optionValue) {
                    optionMarkup += parseFloat($j('#'+'option'+optionID+'hidden'+hex_md5(optionValue)).val());
                }
            });
            // учитываем скидку для наценок по опциям
            //console.log(optionMarkup / 100 * discount);
            optionMarkup = optionMarkup - optionMarkup / 100 * discount;
            var price = parseFloat($j('#canAddMarkup').val());
            price = price + optionMarkup;
            price =  price.toFixed(2);
            $j('#priceSpan').html(price);
        });
    }

    //content replace for seo
    $j('.os-seo').appendTo('section').height('auto');

    //phone formating
    if ($j('.js-phone-mask').length && $j('.js-phone-mask').text()) {
        $j('.js-phone-formatter').mask($j('.js-phone-mask').text());
    }

    //инициализация просмотра картинок
    $j('.colorbox').colorbox({
        rel:'gal',
        maxWidth: '95%',
        maxHeight: '95%',
        returnFocus: false,
        trapFocus: false
    });

    //go to top button
    if ($j('.js-gototop').length) {
        var buttonToTop = $j('.js-gototop');
        buttonToTop.click(function(){
            $j('html, body').animate({
                scrollTop: 0
            }, 1000);
            return false;
        });
        $j(window).scroll(function() {
            var screenHeight = $j(window).height();
            var buttonPosition = buttonToTop.offset().top;
            if (buttonPosition > screenHeight) {
                buttonToTop.fadeIn();
            }else{
                buttonToTop.fadeOut();
            }
        });
    }

    // required fields verification
    if ($j('.js-form-validation').length) {
        $j('.js-form-validation').click(function(){
            var error = false;
            var formElement = $j(this).closest('form').find('.js-required');
            formElement.removeClass('required-field');
            // email
            var rCheckEmail = /^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/i;
            var email = $j(this).closest('form').find('.js-check-email');
            if (email) {
                email.removeClass('required-field');
                if (email.val() && !rCheckEmail.test(email.val())) {
                    email.addClass('required-field');
                    fielsdRequiredCheck();
                    error = true;
                }
            }
            formElement.each(function(){
                if (!$j.trim($j(this).val())) {
                    $j(this).addClass('required-field');
                    fielsdRequiredCheck();
                    error = true;
                }
            });

            if (error == true) {
                return false;
            }

            $j('.required-field-message').remove();
        });
    }
    
    if ($j('#welcomeBannerId').val()) {
        var result = true;
        var bannerId = $j('#welcomeBannerId').val();
        if ($j.cookie('popup-welcome')) {
            var id = $j.cookie('popup-welcome');
            id = id.split(';');
            $j(id).each(function(i, j){
                if (bannerId == j) {
                    result = false;
                }
            });
        }

        if (result && bannerId) {
            popupOpen('.js-popup-welcome-block');
        }
    }
    
    if (!$j.cookie('popup-pageinterval')) {
        $j.cookie('popup-pageinterval', 1, {path: '/'});
    } else {
        $j.cookie('popup-pageinterval', parseInt($j.cookie('popup-pageinterval')) + 1, {path: '/'});
        $j.get('/block/ajax/banner/pageinterval/', {
        }, function (data) {
            if (data) {
                $j('#block_banner_pageinterval').append(data);

            }
        });
    }

    if ($j('#pageIntervalBannerId').val() && $j('#pageIntervalBannerId').length) {
            popupOpen('.js-popup-pageinterval-block');
    }

    // block rating
    if ($j('.js-block-rating').length) {
        $j('.js-block-rating span').hover(function(){
            var $ratingBlock = $j(this).closest('.os-block-rating');
            var newValue = $j(this).data('count');
            $ratingBlock.find('.inner').css({'width' : newValue*20+'%'});
        },function(){
            var $ratingBlock = $j(this).closest('.os-block-rating');
            var currentValue = $ratingBlock.find('input').val();
            $ratingBlock.find('.inner').css({'width' : currentValue*20+'%'});
        });

        $j('.js-block-rating span').click(function(){
            var $ratingBlock = $j(this).closest('.os-block-rating');
            var newValue = $j(this).data('count');
            $ratingBlock.find('input').val(newValue);
            $ratingBlock.find('.text').html(newValue + ' из 5');
        });

        $j('.js-rating-clear').click(function(){
            var $ratingBlock = $j(this).closest('.os-block-rating');
            $ratingBlock.find('input').val('');
            $ratingBlock.find('.inner').css({'width' : '0'});
            $j(this).html('');
        });
    }

    menuHover();

    headerTransform();

    productAutocomplete();

    productThumbSize();

    // ckEditor table & link color styles handler
    $j(function(){
        var $container = $j('.js-ckEditor-container');
        var $table = $container.find('table');
        var $link = $container.find('a');

        // table handler
        $table.each(function(index){
            var tableBorderWidth =
                $j(this).attr('border');
            var tableBorderPadding =
                $j(this).attr('cellpadding');
            var tableBorderSpacing =
                $j(this).attr('cellspacing');

            var tableBorderColor = $j(this).attr('id');

            // reseting table attributes
            if(tableBorderSpacing==0){
                $j(this).attr({
                    'border':'0',
                    'cellspacing':'0',
                    'cellpadding': '0'
                }).css({
                    "border-collapse": "collapse"
                });
            } else {
                $j(this).attr({
                    'border':'0',
                    'cellspacing':'0',
                    'cellpadding': '0'
                }).css({
                    "border-spacing": tableBorderSpacing+"px"
                });
            }

            // handling border & padding via css
            $j(this).find('td, th').css({
                "border": tableBorderWidth+"px solid",
                // color taking from ID field of ckEditor
                "border-color": tableBorderColor,
                "padding": tableBorderPadding
            });

            // links color handler
            $link.each(function(index){
                var childStyle = $j(this).find('span').attr('style');
                $j(this).attr("style",childStyle);
                console.log (childStyle);
            });
        });
    });
});

$j(document).ready(function() {

    // Bind to StateChange Event IE 8 support
    History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
        var State = History.getState(); // Note: We are using History.getState() instead of event.state
    });

    softPagination();
});

// валидация форм
function fielsdRequiredCheck() {
    $j('.required-field-message').remove();
    $j('.required-field').each(function(){
        if ($j(this).data('error')) {
            var errorMessage = $j(this).data('error');
        } else {
            var errorMessage = 'Обязательное поле.'
        }
        $j(this).after('<div class="required-field-message">'+ errorMessage +'</div>');
    });
}

function fielsdRequiredRemove() {
    $j('.required-field').removeClass('required-field');
}

/**
 * Загрузка товаров ajax-ом
 */
function softPagination() {
    var nextLink = $j('.js-stepper .selected').next();
    if (nextLink.data('type') != 'page') {
        $j('.js-show-more').hide();
    }

    $j('.js-show-more').click(function(){
        $j('.js-show-more').addClass('active');

        if ($j('.js-product-list-group-id').length) {
            var id = $j('.js-product-list-group-id').data('id');
            var key = $j('.js-product-list-group-id').data('key');

            nextLink = $j('.js-stepper .selected').next();
            if (nextLink == undefined || nextLink.data('rel') == 'next') {
                nextLink.hide();
                return false;
            }

            var url = nextLink.attr('href');
            if (!url) {
                return false;
            }

            configurePagination(nextLink);

            // Меняем урл
            History.pushState({}, $j(document).find("title").text(), url);

            var elementSelector = '.js-productthumb-element';
            var containerSelector = '.js-product-list-ajax-add';
            var show = $j('#js-product-list-show').val();

            if (!$j(elementSelector).length) {
                elementSelector = '.js-os-productline-element';
            }

            url =  decodeURIComponent(url);
            var tmpUrl = url;
            tmpUrl = tmpUrl.match(/p-(\d+?)\//).toString().split(',');
            var page = tmpUrl[1];

            dataJson = getUrlVars(
                url,
                {
                    'id' : id,
                    'key' : key,
                    'showtype': show
                }
            );

            $j.ajax({
                url: '/shop-product-list/ajax/p-'+page+'/',
                data: dataJson,
                background: true
            }).done (function (data) {
                var new_item = $j(data);
                new_item.find(elementSelector).each( function(index, item) {
                    $j(containerSelector).before(' ').before(item).before(' '); // spaces for inline-block elements
                });

                $j('.js-stepper-next-count').text(new_item.find('.js-stepper-next-count').text());

                $j('.js-show-more').removeClass('active');
                nextLink = $j('.js-stepper .selected').next();
                if (nextLink.data('type') != 'page') {
                    $j('.js-show-more').hide();
                    nextLink.hide();
                }

                productThumbSize();
            });
        }
        
    });
}

// url format => json format
function getUrlVars(url, params) {
    var hash;
    var paramsJson = params;

    var hashes = url.slice(url.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        paramsJson[hash[0]] = hash[1];
    }
    return paramsJson;
}


/**
 * Изменяем отображения блока пагинации, после загрузки товаров ajax-ом
 * @param nextLink
 */
function configurePagination( nextLink ) {
    // Меняем предидущую ссылку
    var prevUrl = $j('.js-stepper .selected').attr('href');
    if ( $j('a[data-rel="prev"]').length ) {
        $j('a[data-rel="prev"]').attr( 'href', prevUrl );
    } else {
        $j('.js-stepper').prepend('<a class="prev" href="' + prevUrl + '"id="back" data-rel="prev">&larr;Назад</a>')
    }

    // Меняем выбранную ссылку
    $j('.js-stepper a').removeClass('selected');
    nextLink.addClass('selected');

    // Меняем следующую ссылку
    if (nextLink.next() != 'undefined' &&  $j('a[data-rel="next"]').length) {
        $j('a[data-rel="next"]').attr('href', nextLink.next().attr('href'));
    }

    if (!nextLink.is(':visible')) {
        $j('.js-stepper a').each( function(index, item) {
            if (index > 0 && $j(this).is(':visible')) {
                $j(this).hide();
                return false;
            }
        });
        nextLink.show();
    }
}

$j(window).bind('load resize', function(){
    //menu
    if ($j('.js-category-nav').length) {
        //menu transformation
        var $nav = $j('.js-category-nav');
        var $sub = $nav.find('.sub');
        var navRightCoord = $nav.offset().left + $nav.width();

        $sub.show();
        menuCategoryRefactor();
        $sub.each(function(){
            var subTransition = parseInt($j(this).css('left')) * -1;
            var subRightCoord = $j(this).offset().left + $j(this).width();
            if (navRightCoord < (subRightCoord + subTransition)) {
                $j(this).css({
                    'left' : - (subRightCoord + subTransition - navRightCoord)
                });
            } else {
                $j(this).css({
                    'left' : 0
                });
            }
        });
        $sub.hide();
    }
});

// product thumb size
$j(window).bind('load', function(){
    productThumbSize();
    // filterTransform();
});

function productThumbSize() {
    if ($j('.js-productthumb-element').length) {
        // высота наличия
        var availMaxHeight = 0;
        $j('.js-productthumb-element').each(function(){
            var availCurrentHeight = $j(this).find('.avail').height();
            if (availMaxHeight < availCurrentHeight) {
                availMaxHeight = availCurrentHeight;
            }
        });
        $j('.js-productthumb-element .js-avail').height(availMaxHeight);

        // высота всего блока
        var elementMaxHeight = 0;
        $j('.js-productthumb-element .js-expanded').addClass('hidden');
        $j('.js-productthumb-element').each(function(){
            var elementCurrentHeight = $j(this).find('.wrapper').height();
            if (elementMaxHeight < elementCurrentHeight) {
                elementMaxHeight = elementCurrentHeight;
            }
        });
        $j('.js-productthumb-element').height(elementMaxHeight);
        $j('.js-productthumb-element .js-wrapper').css({'min-height' : elementMaxHeight});
        $j('.js-productthumb-element .js-expanded').removeClass('hidden');

        setTimeout(function(){
            $j('.js-productthumb-element').addClass('visible');
        }, 1000);
    }
}

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
    var html = '';
    $j.ajax({
        url: "/ajax/compare/",
        dataType: "json",
        data: {
            productid: productID
        },
        success: function (data) {
            // обновляем все кнопки
            if (data.count > 0) {
                html += '<div class="os-block-compare">';
                $j(data.productArray).each(function (i, e) {
                    var $button = $j('.js-shop-compare[data-productid='+e.id+']');
                    $button.find('.js-shop-compare-action').hide();
                    $button.find('.js-shop-compared').show();

                    html += '<div class="element">';
                    html += '<a href="javascript: deleteCompare('+e.id+');" class="remove">&nbsp;</a>';
                    html += '<a href="'+ e.url+'" data-productId="'+e.id+'">'+e.name+'</a>';
                    html += '</div>';
                });
                html = '<div class="os-block-caption">В сравнении</div>'+html;
                html += '<div class="more"><a href="/compare/" class="os-submit">Сравнить</a></div>';
                html += '</div>';

                $j('.js-compare-list').show();
                var compareBlock = $j(".js-compare-list");
                compareBlock.html(html);
            }
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
            var $button = $j('.js-shop-compare[data-productid='+productId+']');
            $button.find('.js-shop-compare-action').show();
            $button.find('.js-shop-compared').hide();
            shop_compare_load();
            $j(".id-"+productId).hide(400);
            if (data.count == 0) {
                $j('.js-compare-list').hide();
            }

            setTimeout(function(){
                $j(".id-"+productId).remove();
            }, 1000);
        }
    });
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
    $j('.js-block-filter').addClass('load');
    $j('.js-block-filter .js-submit-filter').click();
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
    // набор
    var setID = $j(event.target).closest('.js-shop-buy').data('setid');
    var productCount = $j('.js-shop-buy-count').val();

    // опции заказа
    var productOptions = '';
    $j('.js-shop-buy-option').each(function (i, e) {
        var optionID = $j(e).data('optionid');
        var optionValue = $j(e).val();

        productOptions += optionID + ':' + optionValue + ';';
    });

    shop_basket_load(productID, setID, productCount, productOptions);
    event.preventDefault();
}

// показать содержимое корзины
function shop_basket_popup() {
    popupOpen('.js-basket-popup');
}

// загрузить корзину
function shop_basket_load(productID, setID, productCount, productOptions) {
    if (productID == undefined) {
        productID = 0;
    }
    if (setID == undefined) {
        setID = 0;
    }
    if (productCount == undefined) {
        productCount = 1;
    }
    if (productOptions == undefined) {
        productOptions = '';
    }

    var productsArray = false;

    $j.ajax({
        async: false,
        url: "/ajax/basket/",
        dataType: "json",
        data: {
            productid: productID,
            setid: setID,
            productcount: productCount,
            productoptions: productOptions
        },
        success: function (data) {
            productsArray = data.productsArray;
            // обновляем корзину
            $j('.js-basket').html(data.html);

            // отображаем блок покупок
            if (data.productID > 0 || data.setID > 0) {
                shop_basket_popup();
            }

            // обновляем все кнопки
            if (data.productIDArray) {
                var $buttonTemplate = $j('.js-basket-button-inbasket').html();

                $j(data.productIDArray).each(function (i, e) {
                    var $button = $j('.js-shop-buy[data-productid='+e+']');
                    $button.html($buttonTemplate);
                    $button.find('.js-shop-buy-action').on('click', shop_basket_buy);
                });
                // set
                if (data.setID) {
                    var $button = $j('.js-shop-buy[data-setid='+data.setID+']');
                    $button.html($buttonTemplate);
                    $button.find('.js-shop-buy-action').on('click', shop_basket_buy);
                }


                //выставляем селекты опций - это актуально только для страницы товара
                $j(data.productIDArray).each(function (i, e) {
                    var $button = $j('.js-shop-buy[data-productid='+e+']');
                    $button.html($buttonTemplate);
                    $button.find('.js-shop-buy-action').on('click', shop_basket_buy);
                });

                var productID = parseInt($j('#productPage').val());
                if (productID) {
                    $j(data.optionArray).each(function (z, e) {

                        for (var key in e) {
                            if (key == productID ) {
                                for (var ke in e[key]) {
                                    if (e[key][ke]['filtervalue']) {
                                        //находим селект по имени и сразу вызываем событие изменения селекта для подсчёта суммы товара
                                        $j('select.js-shop-buy-option[name=option-'+e[key][ke]['filterid']+']').val(e[key][ke]['filtervalue']).change();
                                    }
                                }
                            }
                        }
                    });
                }
            }

            // клик на блок корзины
            $j('#id-shop-basket .js-basketpopup-toggle').click(function () {
                shop_basket_popup();
                return false;
            });
        }
    });

    return productsArray;

}

// попап os-block-popup open
function popupOpen(e) {
    $j(e).fadeIn();
    var scrltp = $j(window).scrollTop();
    var popupBlock = $j(e).find('.block-popup');
    var popupHeight = popupBlock.height();
    popupBlock.css({
        'top' : - popupHeight
    });
    popupBlock.animate({
        'top': 0
    }, 500);
}

// попап os-block-popup close
function popupClose(e) {
    var scrltp = $j(window).scrollTop();
    var popupBlock = $j(e).find('.block-popup');
    var popupHeight = popupBlock.height();
    var popupTopPadding = 100;
    popupBlock.animate({
        'top': - popupHeight - popupTopPadding
    }, 500);
    setTimeout(function(){
        $j(e).fadeOut();
    }, 500);
}

// скрыть содержимое корзины
function shop_basket_popup_close() {
    $j('.os-block-popup .close').click();
    return false;
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

// @todo: use jquery toggleClass()
function toggleElement(e){
    if ($j(e).is('.selected')) {
        $j(e).removeClass('selected');
    } else {
        $j(e).addClass('selected');
    }
}

// функция скрывает попап, который появляется при первом посещение сайта
// и записывает куку
function popup_welcome_close(id){
    popupClose('.js-popup-welcome-block');
    $j.cookie('popup-welcome', $j.cookie('popup-welcome')+id+';',
        {
            expires: 360,
            path: '/'
        }
    );
}

// функция скрывает попап, и записывает куку
function popup_pageinterval_close(){
    popupClose('.js-popup-pageinterval-block');
    $j.cookie('popup-pageinterval', parseInt($j.cookie('popup-pageinterval')),
        {
            path: '/'
        }
    );
}

//menu hover dropdown function
function menuHover() {
    var $navElement = $j('.js-category-nav').find('.nav-element');

    $navElement.hover(function(){
        var $this = $j(this);
        $this.addClass('js-hover');
        setTimeout(function(){
            if ($this.hasClass('js-hover')) {
                $this.find('.sub').fadeIn(200);
                $this.addClass('hover');
            }
        }, 500);
    }, function(){
        var $this = $j(this);
        $this.removeClass('js-hover');
        setTimeout(function(){
            if ($this.hasClass('js-hover')) {
                return;
            } else {
                $this.find('.sub').fadeOut();
                $this.removeClass('hover');
            }
        }, 500);
    });

    if ((pgwBrowser.os.group == 'Android') || (pgwBrowser.os.group == 'Windows Phone') || (pgwBrowser.os.group == 'iOS') || (pgwBrowser.os.group == 'BlackBerry')) {
        $navElement.find('.element-inner>a').click(function(){
            if ($j(this).next('.sub').length) {
                $j(this).next('.sub').fadeToggle();
                return false;
            }
        });
    }
}

function menuCategoryRefactor() {
    $j('.js-category-list').each(function(){
        var maxGridSize = 4;
        var columnLength = 10;
        var categoryCount = $j(this).find('.level-1, .level-2').length;
        var categoryLevelFirstCount = $j(this).find('.level-1').length;
        if (categoryLevelFirstCount < maxGridSize) {
            maxGridSize = categoryLevelFirstCount;
        }

        var gridSize = Math.ceil(categoryCount / columnLength);
        if (gridSize > maxGridSize) {
            gridSize = maxGridSize;
        }

        $j(this).addClass('x'+ gridSize);
    });

    $j('.js-category-list').masonry({
        itemSelector: 'li'
    });
}

// filter transform
function filterTransform(){
    if ($j('.js-wrap-filter').length) {
        var $wrap = $j('.js-wrap-filter');

        if ($wrap.length) {


            var $filter = $j('.js-block-filter');
            var filterHeight = $filter.height();
            var filterTop = $filter.offset().top;
            var filterBottom = filterHeight + filterTop;

            var filterBottomCompensate = 0;

            $j(window).bind('ready resize scroll', function() {
                leftAsideTransform();
            });
        }
    }

    function leftAsideTransform(){
        var wrapTop = $wrap.offset().top;
        console.log(wrapTop);
        var $productList = $j('.js-product-list');
        var productListHeight = $productList.height();

        if (productListHeight > filterHeight) {
            productListHeight = $productList.height();
            $wrap.height(productListHeight);

            var wrapHeight = $wrap.height();
            var wrapBottom = wrapTop + wrapHeight;

            var frame = $j(window);
            var frameTop = frame.scrollTop();
            var frameHeight = frame.height();
            var frameBottom = frameTop + frameHeight;

            if (frameTop > wrapTop) {
                $filter.addClass('slideable');
            } else {
                $filter.removeClass('slideable');
            }

            if (wrapBottom < frameBottom) {
                filterBottomCompensate = frameBottom - wrapBottom;
            } else {
                filterBottomCompensate = 0;
            }

            if (frameBottom > filterBottom) {
                $filter.css({
                    'top' : frameBottom - filterBottom - filterBottomCompensate
                });
            }
        }
    }
}

function basket_order_quick (productId, productName) {
   $j('input[name="productid"]').val(productId);
   $j('#quickOrderProductName').text(productName);
    popupOpen('.js-popup-quickorder');
}

// header transformation
function headerTransform() {
    if ($j('.js-header').length) {
        if ((pgwBrowser.os.group == 'Android') || (pgwBrowser.os.group == 'Windows Phone') || (pgwBrowser.os.group == 'iOS') || (pgwBrowser.os.group == 'BlackBerry')) {
            return false; // отключаем для мобильных девайсов
        }

        var headerHeight = $j('.js-header').outerHeight();
        var $headerWraper = $j('.js-header-wrap');

        // fix for resize
        $j(window).bind('ready resize', function(){
            var headerHeight = $j('.js-header').outerHeight();
            var $headerWraper = $j('.js-header-wrap');
            if ($headerWraper.hasClass('os-transform-header')) {
                return;
            } else {
                $headerWraper.height(headerHeight);
            }
        });

        var headerStartPoint = $j('.js-header-wrap').offset().top;
        var headerEndPoint = $j('.js-header-wrap').height() + $j('.js-header-wrap').offset().top;

        var lastScrollTop = 0;
        var revert = false;
        $j(window).scroll(function(event){
            var currentScrollTop = $j(this).scrollTop();

            if (currentScrollTop > lastScrollTop){
                // вниз
                if (currentScrollTop > headerEndPoint) {
                    $headerWraper.addClass('os-fixed-header');
                    $headerWraper.addClass('os-transform-header');
                    revert = true;
                }

                $headerWraper.removeClass('show');

                lastScrollTop = currentScrollTop - 1; // fix for ie
            } else {
                //вверх
                if (currentScrollTop < headerEndPoint) {
                    $headerWraper.removeClass('os-transform-header');
                }
                if (currentScrollTop > headerStartPoint) {
                    if (revert) {
                        $headerWraper.addClass('os-fixed-header');
                    }
                } else {
                    $headerWraper.removeClass('os-fixed-header');
                }

                $headerWraper.addClass('show');

                if (currentScrollTop == 0) {
                    revert = false;
                }

                lastScrollTop = currentScrollTop;
            }

            if ($j('.js-input-search').length) {
                var autocompleteTopTrue = $j('.js-input-search').outerHeight() + $j('.js-input-search').offset().top;
                if ($j('.js-search-autocomplete').length) {
                    var autocompleteTop = $j('.js-search-autocomplete').offset().top;
                    if (autocompleteTop > autocompleteTopTrue) {
                        $j('.js-input-search').autocomplete("close");
                    }
                }
            }
        });
    }
}

function productAutocomplete() {
    // search
    // если используем блок
    if($j('.js-input-search').length){
        $j('.js-input-search').each(function(){
            $j(this).autocomplete({
                delay: 500,
                source: function( request, response ) {

                    $j.ajax({
                        url: "/search/jsonautocomplete/",
                        dataType: "json",
                        data: {
                            name: request.term,
                            categoryid: $j('#js_search_category').val()
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
                                    url: item.url,
                                    isproduct: item.isproduct,
                                    avail: item.avail,
                                    price: item.price,
                                    currency: item.currency,
                                    availtext: item.availtext
                                }
                                return item.name;
                            }));
                        }
                    });
                },
                select: function (event, ui) {
                    document.location = ui.item.url;
                },
                minLength: 3
            }).data('ui-autocomplete')._renderItem = function (ul, item) {
                ul.removeClass().addClass("os-search-autocomplete js-search-autocomplete");
                var imageHtml = '';
                if (item.image) {
                    imageHtml = '<img src="' + item.image + '" />';
                } else {
                    imageHtml = '<img src="/media/shop/stub.jpg" style="max-width: 50px; max-height: 50px;" />';
                }

                var inner_html = '<a class="product-element"><span class="image">'+imageHtml+'<span></span></span>';
                inner_html += '<span class="description"><span class="name">' + item.label + '</span>';
                if (item.isproduct) {
                    var availClass = (item.avail > 0) ? 'available' : 'unavailable';

                    inner_html += '<span class="os-price-' + availClass + '">' + item.price + ' ' + item.currency + '</span>';
                    inner_html += '<span class="os-' + availClass + '">' + item.availtext + '</span><br />';
                }
                inner_html += item.description + '</span><span class="clear"></span></a>';

                ul.css('z-index','9999');

                return $j( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append(inner_html)
                    .appendTo( ul );
            };
        });
    }
}