$j(function () {
    $j('.js-sortable').tablesorter();

    $j('.js-storage-reserve-edit-link').click(function(event) {
        event.preventDefault();

        $link = $j(this);
        $form = $j('.js-storage-reserve-edit-form-div').find('form').clone();
        $form.find('input[name="storagenameid"]').val($link.attr('data-storagenameid'));
        $form.find('input[name="productid"]').val($link.attr('data-productid'));
        $form.find('input[name="amount"]').val($j.trim($link.html()));

        $form.submit(function(e) {
            e.preventDefault();

            $targetForm = $j(this);
            $targetLink = $targetForm.prev('a');

            $j.ajax({
                url: '/admin/shop/storage/report/reserve/ajax/update/',
                type: "POST",
                data: $targetForm.serialize(),
                dataType : "json",
                success: function (data, textStatus) {
                    if (data != null) {
                        if (!data.error) {
                            $targetLink.text(data.amount);
                            $targetForm.remove();
                            $targetLink.show();

                            $j('.js-storage-reserve-percent-' + $targetLink.attr('data-storagenameid') + '-' + $targetLink.attr('data-productid')).text(data.percent + '%');
                        }
                    }
                }
            });
        });

        $form.insertAfter($link);
        $link.hide();
        $form.show();
        $form.find('input[name="rrc"]').focus();
    });

    $j('.js-storage-reserve-rrc-edit-link').click(function(event) {
        event.preventDefault();

        $link = $j(this);
        $form = $j('.js-storage-reserve-rrc-edit-form-div').find('form').clone();
        $form.find('input[name="storagenameid"]').val($link.attr('data-storagenameid'));
        $form.find('input[name="productid"]').val($link.attr('data-productid'));
        $form.find('input[name="rrc"]').val($link.attr('data-rrc'));
        $form.find('select[name="currencyid"]').val($link.attr('data-currencyid'));

        $form.submit(function(e) {
            e.preventDefault();

            $targetForm = $j(this);
            $targetLink = $targetForm.prev('a');

            $j.ajax({
                url: '/admin/shop/storage/report/reserve/ajax/update/',
                type: "POST",
                data: $targetForm.serialize(),
                dataType : "json",
                success: function (data, textStatus) {
                    if (data != null) {
                        if (!data.error) {
                            $targetLink.text(data.rrc + ' ' + data.currency);
                            $targetLink.attr('data-rrc', data.rrc);
                            $targetLink.attr('data-currencyid', data.currencyid);
                            $targetForm.remove();
                            $targetLink.show();
                        }
                    }
                }
            });
        });

        $form.insertAfter($link);
        $link.hide();
        $form.show();
        $form.find('input[name="amount"]').focus();
    });
});