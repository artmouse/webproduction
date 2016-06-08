// высота лейера
$j(window).bind('load ready resize', function(){
    var bodyHeight = $j(window).height() - $j('.ob-button-fixed-place').height() - $j('.js-top-nav-buffer').height() ;
    $j('.js-menu-overflow').height(bodyHeight - 87);
    $j('#js-doccontent_ifr').height(bodyHeight - 98);
});

$j(function() {
    // быстрый поиск по меню
    $j('.js-menu-doc-helper').keyup(function() {
        jQueryFilter.categorySearch('.js-menu-overflow li', this);
        //$j('.js-menu-wrap .expand').addClass('open');
        //$j('.js-menu-wrap ul').show();
    });
});

// прокрутка к текущему пункту меню
$j(window).bind('load', function(){
    var currentLinkOffset = $j(".js-menu-overflow .selected").offset().top;
    var linkWrapOffset = $j(".js-menu-overflow").offset().top;
    var scrollToPosition = currentLinkOffset - linkWrapOffset;
    console.log(currentLinkOffset);
    $j(".js-menu-overflow").animate({
        scrollTop: scrollToPosition - 5
    }, 1000);
});