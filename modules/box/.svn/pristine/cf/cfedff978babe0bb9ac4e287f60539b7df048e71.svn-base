$j(function() {
    // быстрый поиск по меню
    $j('.js-standards-helper').keyup(function() {
        $j('.js-block-tree ul').show();
        $j('.js-block-tree .expand').addClass('open');
        jQueryFilter.categorySearch('.js-block-tree li', this);
    });

    // открытия дерева
    $j('.js-block-tree .selected').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open');

    // layer height
    if ($j('.js-standard-area').length) {
        $j(window).bind('ready load resize', function(){
            var bodyHeight = $j('body').height();
            var standartHeadHeight = $j('.js-block-standard-head').height();
            var buttonsHeight = $j('.ob-button-fixed-place').height();
            var padding = 158;
            $j('.mce-container iframe').height(bodyHeight - standartHeadHeight - buttonsHeight - padding);
        });
    }
});