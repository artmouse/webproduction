$j(function () {
    jQueryTabs.TabMenu($j('.settings-tab'), $j('.js-tabselect').val());

    $j('.js-cash-clear-no').click(function(e) {
       $j("[data-rel='#settings-tab-0']").click();
    });

    // быстрый поиск по настройкам
    $j('.js-setting-helper').keyup(function() {
        jQueryFilter.categorySearch('.js-setting-list li', this);
    });

    // autosize reinit
    $j('.settings-tab').click(function(){
        setTimeout(function(){
            $j('.js-autosize').trigger('autosize.resize');
        }, 50);
    });
});