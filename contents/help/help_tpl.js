$j(function() {
    // быстрый поиск по меню
    $j('.js-search-helper').keyup(function() {
        jQueryFilter.categorySearch('.js-menu-wrap li', this);
        $j('.js-menu-wrap .expand').addClass('open');
        $j('.js-menu-wrap ul').show();
        setTimeout("cookieFromDocMenu();", 500);
    });

    // menu expand
    $j('.js-menu-wrap .expand').click(function(){
        $j(this).toggleClass('open');
        $j(this).next().slideToggle();
    });

    // открытия дерева
    $j('.js-menu-wrap .selected').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open');

    // прокрутка к текущему пункту меню
    var currentLinkOffset = $j(".js-menu-wrap .selected").offset().top;
    var linkWrapOffset = $j(".js-menu-wrap").offset().top;
    var scrollToPosition = currentLinkOffset - linkWrapOffset;
    //console.log(scrollToPosition);
    $j(".js-menu-wrap").animate({
        scrollTop: scrollToPosition - 5
    }, 500);

    // прокрутка по странице
    var allowScroll = true;
    $j('.js-menu-wrap .navi a').click(function(){
        allowScroll = false;
        var $this = $j(this);
        var currentBlock = $this.data('id');
        var currentScroll = $j(".js-content-wrap").scrollTop();

        scrollToCaption = $j('.js-content-wrap #'+ currentBlock).offset().top;
        $j(".js-content-wrap").animate({
            scrollTop: scrollToCaption + currentScroll - 35
        }, 500);

        $j('.js-menu-wrap .navi a').removeClass('selected');
        $this.addClass('selected');

        allowScroll = false;
        setTimeout(function(){
            allowScroll = true;
        }, 600);

        return false;
    });

    // выделение по прокрутке
    $j('.js-content-wrap').bind('load scroll', function(){
        var currentScroll = $j(".js-content-wrap").scrollTop();
        var currentBlock = 1;
        $j('.js-content-wrap h2').each(function(){
            var blockPosition = $j(this).offset().top + currentScroll;
            if (($j('.js-content-wrap').scrollTop() + 50) > blockPosition ) {
                currentBlock = $j(this).attr('id');
            }
        });

        if (allowScroll) {
            $j('.js-menu-wrap .navi a').removeClass('selected');
            $j('.js-menu-wrap .navi a[data-id="'+ currentBlock +'"]').addClass('selected');
        }
    });

    // block toggle
    $j('.js-link-toggle').click(function(){
        $j(this).next('.block-toggle').slideToggle(300);
        return false;
    });
});

// layers height
$j(window).bind('load ready resize', function(){
    var pageHeight = $j('body').height();
    var contentPadding = 20;

    $j('.js-content-wrap').height(pageHeight - contentPadding*4);
    $j('.js-menu-wrap').height(pageHeight - contentPadding*4 - 100 - 40);
});