$j(function(){
    // инициализируем событие нажатия клавиши
    $j('input#id_search').keyup(function() {
        $j('.js-block-tree ul').show();
        $j('.js-block-tree .expand').addClass('open');
        jQueryFilter.categorySearch('.js-block-tree li', this);
    });
});