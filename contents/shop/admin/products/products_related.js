$j(function () {
    $j('.js-checkbox').click(function() {
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
    });
});