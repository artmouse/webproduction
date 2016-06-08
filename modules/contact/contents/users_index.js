$j(function () {
    $j('.js-checkbox').change(function () {
        var ids = '';

        $j('.js-checkbox').each(function (i, e) {
            if (e.checked) {
                ids += $j(e).val();
                ids += ',';             
            }
        });

        $j('#id-user').val(ids);
    });
    
    $j('.js-filter-contacts').on('click', function () {
        var type = $j(this).data('type');
        $j(".js-contact-type").select2('val', type);
        $j(".help-hint-filter-submit").click();
    });

});

$j(function () {
    $j('.js-checkbox').each(function (i, checkbox) {
        $j(checkbox).click(function() {
            recalculate_checkbox();
        });
    });
});

// пересчитываем checkboxы
function recalculate_checkbox() {
    var s = '';
    $j('.js-checkbox').each(function (i, checkbox) {
        if (checkbox.checked) {
            s += checkbox.value;
            s += ',';
        }
    });

    $j('#id-checkboxes').val(s);

    if (s != '') {
        $j('#id-form-delete').show();
    } else {
        $j('#id-form-delete').hide();
    }
}

$j(window).bind('resize load', function() {
    contactsLayerHeight();
});

function contactsLayerHeight() {
    var bodyHeight = $j(window).height();
    var contentPadding = 20;
    var naviHeight = $j('.shop-admin-navi').height();
    var tabsHeight = $j('.js-top-nav-buffer').height();
    var buttonsHeight = $j('.ob-button-fixed-place').height();

    $j('.js-layer-overflow').css({
        'height' : bodyHeight - contentPadding - naviHeight - tabsHeight - buttonsHeight
    });

    if($j('.shop-overflow-table').length){
        $j('.js-layer-overflow').bind('scroll', function() {
            perfectScrollposition(this);
        });
    }
}

$j(function() {
    // управление таблицей с клавиатуры
    var table = new HotKeyTable('.ob-list-usersthumb', '.ob-list-usersthumb-element', 'selected', function($table, $row) {
        $parent = $row.closest('.js-layer-overflow').first();

        $parent.animate({
            scrollTop: ($row.position().top - $parent.offset().top - $parent.find('.ob-list-usersthumb-element').first().position().top)
        }, 100);
    });
});