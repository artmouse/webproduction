////fixed tabs
//$j(function() {
//    var fBlock = $j('.js-product-tabs');
//    var fBlockPosition = fBlock.offset().top;
//    var fBlockPadding = 40;
//    var tabPadding = 60;
//
//    $j('.js-product-tabs a').click(function(){
//        var cTab = $j(this).data('nav');
//        var goToOffset = $j('.'+cTab).offset().top - fBlockPadding - tabPadding;
//        $j("html, body").animate({scrollTop:goToOffset}, '500');
//        return false;
//    });
//
//    fixedBlock();
//    $j(window).scroll(function(){
//        fixedBlock();
//    });
//    $j(window).bind('resize', function() {
//        fixedBlock();
//    });
//
//    function fixedBlock(){
//        if ($j(window).scrollTop() + fBlockPadding > fBlockPosition) {
//            fBlock.css({
//                'position':'fixed',
//                'z-index':'5',
//                'width':'702px',
//                'top':fBlockPadding
//            });
//            $j('.js-product-tabs-place').show();
//        }else{
//            fBlock.css({'position':'static'});
//            $j('.js-product-tabs-place').hide();
//        }
//    }
//});

$j(document).ready(function () {
    $j('.js-master-info').click(function(){
        $j('.js-master-view').show();
        $j('.js-trade-view').hide();
        $j('.js-productvideo-view').hide();
    });

    $j('.js-trade-info').click(function(){
        $j('.js-master-view').hide();
        $j('.js-trade-view').show();
        $j('.js-productvideo-view').hide();
    });

    $j('.js-productvideo-thumb').click(function(){
        $j('.js-master-view').hide();
        $j('.js-productvideo-view').show();
        $j('.js-trade-view').hide();
    });

    $j('.js-zoom-small').click(function(){
        $j('.js-master-view').hide();
        $j('.js-productvideo-view').hide();
        $j('.js-trade-view').hide();
    });

});

$j(document).bind('load ready', function(){

    $j('.js-master-block').hover(function() {
        var $this = $j(this);
        $this.addClass('js-hover');
        setTimeout(function() {
            if ($this.hasClass('js-hover')) {
                $this.animate( {
                    width: 353
                } );
            }
        }, 500);
    }, function() {
        var $this = $j(this);
        $this.removeClass('js-hover');
        setTimeout(function() {
            if ($this.hasClass('js-hover')) {
                return;
            } else {
                $this.animate( {
                    width: 106
                });
            }
        }, 500);
    });


    // Замена характеристик товара в зависимости от размера
    $j('.js-shop-buy-option').change(function() {
        var key = $j('.js-shop-buy-option option:selected').data('optionkey');
        var productId = $j('input[data-activekey="'+key+'"]').data('id');

        $j.ajax( {
            url: "/load/product/properties/",
            dataType: "json",
            data: {
                id: productId
            },
            success: function (property) {
                if (property) {

                    // Меняем цену за работу
                    $j('.js-price').html(property.price);
                    $j('.js-price-old').html(property.priceOld + ' ' +property.currency );

                    // Меняем цену товара
                    $j('.js-price-product').html(property.priceProduct);
                    $j('.js-price-product-old').html(property.priceProductOld + ' ' + property.currency );

                    // Меняем вес
                    $j('.js-weight').html(property.weight);
                    $j('.js-weight-exchange').html(property.exchangeWeightChar);
                    $j('.js-rtm-buy-exchange-option').val(property.exchangeWeight);

                    // Меняем ид товара
                    $j('.js-shop-buy-action').each( function(i, item) {
                        $j(this).attr('data-productid', property.id);
                    } );

                    // Меняем имя товара
                    $j('.js-name').html(property.name);

                    // Меняет инвентарный номер товара
                    $j('.js_inventar_number').find('span').html(property.inventarNumber);

                    // Меняем метатеги
                    $j('meta[property="og:title"]').attr('content',property.title);
                    $j('meta[name="keywords"]').attr('content',property.metakewords);
                    $j('meta[name="description"]').attr('content',property.metaDescription);
                    document.title = property.title;

                    // Меняем урл товара
                    window.history.replaceState("object or string", "Title",  property.url );

                }
            }
        } );

    })
});