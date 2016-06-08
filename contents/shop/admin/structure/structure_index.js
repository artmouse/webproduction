$j(function() {
    $j('.js-structure-tabs a').click(function(){
        $j('.js-block-structure, .js-block-list').hide();
        $j('.' + $j(this).data('tab')).show();
        structureAnimation();
    });

    if ($j('.js-sortable').length) {
        $j('.js-sortable').tablesorter();
    }
});

$j(window).bind('load', function(){
    structureAnimation();
});

function structureAnimation() {
    animation('.shop-table tr', 'fade', '30');
    animation('.js-block-company-structure .role', 'blind', '50');
}