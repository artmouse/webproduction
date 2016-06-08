function updateSort() {
    $j('.js-productmerge-list').find('.js-productmerge-sort').each(function(i, e) {
        $j(e).val(i + 1);
    });
}

$j(function() {
    $j('.js-productmerge-product').click(function(event) {
        event.preventDefault();

        var productID = $j(this).data('productid');

        if (!$j('.js-productmerge-list').find('[data-productid="' + productID + '"]').length) {
            var $element = $j(this).clone();
            $element.insertBefore('.js-productmerge-button-merge');
            $j('.js-productmerge-button-merge').show();
            $j('.js-productmerge-button-clear').show();
            updateSort();
        }
    });

    $j('.js-productmerge-list').sortable({
        items: ".js-productmerge-product",
        helper: 'clone',
        stop: function (event, ui) {
            updateSort();
        }
    });

    $j('.js-productmerge-button-clear').click(function(){
        $j('.js-productmerge-list .js-productmerge-product').remove();
        $j('.js-productmerge-button-merge').hide();
        $j('.js-productmerge-button-clear').hide();
    });

    $j('.js-productmerge-button-merge').click(function(event){
        if (!confirm('Точно склеить товары? Отменить операцию будет невозможно.')) {
            event.preventDefault();
        } else {
            var content = $j('.js-productmerge-filter-form').html();
            $j('.js-productmerge-list-hidden').append(content);
        }
    });
});