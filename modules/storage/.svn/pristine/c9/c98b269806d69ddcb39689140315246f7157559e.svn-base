$j(function () {
    if ($j('#id-product').length) {
        $j('#id-product').click(function (event) {
            selectwindow_init('w1', 'id-name', 'id-value', {
                productsearch: true
            });

            event.preventDefault();
        });
    }

    $j('#id-product-name').click(function(e){
        $j('#id-product').click();
        e.preventDefault();
    });
});