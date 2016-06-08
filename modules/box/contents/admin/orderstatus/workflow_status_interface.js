$j(function() {
    checkMenu();

    $j(".js-block-list, .js-droppable").sortable({
        connectWith: ".js-block-list, .js-droppable"
    });

    $j('#js-form').submit(function () {
        var arr = [];
        $j('.temp-content').each(function (i, elem) {
            var arr2 = [];
            $j(elem).children('.block-element').each(function (i2, elem2) {
                arr2[i2] = $j(elem2).data('id');
            });

            arr[$j(elem).data('id')] = arr2;
        });

        $j('#js-block-value').val(JSON.stringify(arr));
    });

    $j('.js-block-helper').keyup(function() {
        jQueryFilter.categorySearch('.js-block-list .block-element', this);
    });

    $j('.js-menu-parent').change(function () {
        checkMenu();
    });

    // remove block to list
    $j('.js-block-remove').click(function(){
        $j(this).closest('.block-element').appendTo('.js-block-list');
    });
});

function checkMenu () {
    var elem = $j('.js-menu-parent');
    if (elem.prop('checked')) {
        $j('.js-other-menu').hide();
    } else {
        $j('.js-other-menu').show();
    }
}