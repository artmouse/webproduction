$j(window).bind('ready resize', function(){
    welcomeHeight();
});

function welcomeHeight() {
    var blockHeight = $j(window).height() - $j('.shop-admin-navi').height();
    $j('.js-welcome-wrap').height(blockHeight);
    $j('.js-welcome-wrap .slide-wrap').height(blockHeight);
}

$j(function() {
    $j('.js-welcome-wrap .line').jCarouselLite({
        btnNext: '.next',
        btnPrev: '.prev',
        btnGo: $j('.js-welcome-wrap .control span'),
        visible: 1,
        autoWidth: true,
        responsive: true
    });
});