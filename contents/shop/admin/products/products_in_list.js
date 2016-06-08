$j(function(){
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

        if ( ids != '' ) {
            $j('#id-form-delete').show();
        } else {
            $j('#id-form-delete').hide();
        }

        $j('#id-checkboxes').val(ids);
    });
});