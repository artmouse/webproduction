//fixed tabs//
$j(function() {
    if ($j('.js-product-tabs').length) {
        var fBlock = $j('.js-product-tabs');
        var fBlockPosition = fBlock.offset().top;
        var fBlockPadding = 0;
        var tabPadding = 60;

        $j('.js-product-tabs a').click(function(){
            var cTab = $j(this).data('nav');
            var goToOffset = $j('.'+cTab).offset().top - fBlockPadding - tabPadding - 1;
            $j("html, body").animate({scrollTop:goToOffset}, 250).animate({scrollTop:goToOffset + 1}, 1);
            return false;
        });

        fixedBlock();
        $j(window).scroll(function(){
            fixedBlock();
        });
        $j(window).bind('resize', function() {
            fixedBlock();
        });
    }

    function fixedBlock(){
        if ($j(window).scrollTop() + fBlockPadding > fBlockPosition) {
            fBlock.css({
                'position':'fixed',
                'z-index':'12',
                'top':fBlockPadding
            });
            $j('.js-product-tabs-place').show();
        }else{
            fBlock.css({'position':'static'});
            $j('.js-product-tabs-place').hide();
        }
    }
});