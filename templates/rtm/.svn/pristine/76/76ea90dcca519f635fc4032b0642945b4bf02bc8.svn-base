function contentTransform(){
    var rightAsideHeight = $j('aside.right-layer').height();
    var rightAsideTop = $j('aside.right-layer').position().top;
    var rightAsideBottom = rightAsideTop + rightAsideHeight + 90;
    if ($j('.os-productthumb-list').length) {
        var productThumbsTop = $j('.os-productthumb-list').position().top;
        $j('.empty-element-big').height(rightAsideHeight - (productThumbsTop - rightAsideTop));
    }

    $j(function() {
        rightAsideTransform();
    });

    $j(window).scroll(function(){
        rightAsideTransform();
    });

    function rightAsideTransform(){
        var pagePosition = $j(window).scrollTop();
        if (pagePosition > rightAsideBottom) {
            $j('aside.right-layer').hide();
            $j('section').addClass('full');
            if ($j('.os-productthumb-list').length) {
                $j('.empty-element-big').show();
            }
        } else {
            $j('aside.right-layer').show();
            $j('section').removeClass('full');

            if ($j('.os-productthumb-list').length) {
                $j('.empty-element-big').hide();
            }
        }
    }
}

function filterTransform(){
    var filterColumn = $j('aside.left-layer');
    var leftAsideHeight = filterColumn.height(); //высота блока фильтров
    var leftAsideTop = filterColumn.position().top; //верхняя точка блока фильтров
    var leftAsideBottom = leftAsideTop + leftAsideHeight; //нижняя точка блока фильтров

    $j(function() {
        leftAsideTransform();
    });

    $j(window).scroll(function(){
        leftAsideTransform();
    });

    $j(window).bind('resize', function() {
        leftAsideTransform();
    });

    function leftAsideTransform(){
        var bodyHeight = $j(window).height(); //высота всего контента
        var pagePositionTop = $j(window).scrollTop(); //высота скролла
        var pagePositionBottom = pagePositionTop + bodyHeight; //
        var contentHeight = $j(document).height(); //высота видимой части браузера
        var productContentHeight = $j('.os-product-layer').height(); //высота продуктлиста

        if (productContentHeight > leftAsideHeight) {
            if (bodyHeight > leftAsideHeight) {
                if (pagePositionTop > leftAsideTop - 50) {
                    filterColumn.addClass('fixed-top');
                    filterColumn.removeClass('fixed-bottom');
                    filterColumn.removeClass('fixed-bottom-footer');
                } else {
                    filterColumn.removeClass('fixed-top');
                }
            } else {
                if (pagePositionBottom > leftAsideBottom) {
                    filterColumn.addClass('fixed-bottom');
                    filterColumn.removeClass('fixed-top');
                    filterColumn.removeClass('fixed-bottom-footer');
                } else {
                    filterColumn.removeClass('fixed-bottom');
                }
                if (pagePositionBottom === contentHeight) {
                    filterColumn.addClass('fixed-bottom-footer');
                } else {
                    filterColumn.removeClass('fixed-bottom-footer');
                }
            }
        }
    }
}