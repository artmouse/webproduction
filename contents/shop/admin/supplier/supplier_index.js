$j(function () {
    $j('.js-checkbox').change(function () {
        var ids = '';

        $j('.js-checkbox').each(function (i, e) {
            if (e.checked) {
                ids += $j(e).val();
                ids += ',';
                $j(this).closest('.element').addClass('selected');
            } else {
                $j(this).closest('.element').removeClass('selected');
            }
        });

        $j('#id-supplier').val(ids);
    });

    $j(function () {
        $j('.js-checkbox').each(function (i, checkbox) {
            $j(checkbox).click(function() {
                recalculate_checkbox();
            });
        });
    });

// пересчитываем checkbox'ы
    function recalculate_checkbox() {
        var s = '';
        $j('.js-checkbox').each(function (i, checkbox) {
            if (checkbox.checked) {
                s++;
            }
        });

        $j('#id-checkboxes').text(s);
    }
});