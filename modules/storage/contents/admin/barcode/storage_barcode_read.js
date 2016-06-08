$j(function () {
    $j('#barcode').focus();

    // добавление товара
    $j('#barcode').bind('keydown', 'return', function() {
        barcode = $j(this).val();
        $j(this).val('');
        
        $j.ajax({
            url: '/admin/shop/storage/incoming/barcode/ajax/get/product/',
            type: "POST",
            data: {
                barcode: barcode
            },
            dataType : "json",
            success: function (data, textStatus) {
                if (!data.error) {
                    html = '<div id="js-product-' + data.id + '">';
                    html += '<input type="hidden" name="id[]" value="' + data.id + '" />';
                    html += '#' + data.id + ': ' + data.name + '&nbsp;';
                    html += '<a href="#" onclick="$j(\'#js-product-' + data.id + '\').remove(); checkBarcodeDiv(); return false;" alt="удалить" >x</a>';
                    html += '</div>';
                    $j('#js-product-list').append(html);
                    
                    checkBarcodeDiv();
                }
            }
        });
    });
});

function checkBarcodeDiv() {
    if ($j('#js-product-list').html()) {
        $j('#js-notice').hide();
    } else {
        $j('#js-notice').show();
    }
}