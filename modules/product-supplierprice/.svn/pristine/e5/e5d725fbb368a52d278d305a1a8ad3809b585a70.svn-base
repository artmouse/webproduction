$j(function() {

   // search products
    $j('.js-filter-product-search').on('click', function(){
        var formData = $j('.js-filter-product-form').serialize();
        $j.ajax({
            url: '/admin/shop/supplier/search/products',
            data: formData,
            dataType: 'json'
        }).done(function(data){
            $j('.block-produts-search').html('');
            $j(data).each(function(index,item) {
               var itemHtml = '' +
                   '<div' + ' class="supplier-product-element js-draggable" data-id="'+item.id+'">' +
                        '<span>'+item.id+'</span>' +
                        '<span class="full-width">'+item.name+'</span>' +
                        '<span>'+item.price + item.currency +'</span>' +
                   '</div>';
               $j('.block-produts-search').append(itemHtml);
                $j('.supplier-products-container .js-draggable').draggable(
                    { revert: "invalid",
                    helper: function(){
                        var copy = $j(this).clone();
                        return copy;
                    },
                    appendTo: 'body',
                    scroll: false}
                );
            });
        });
    });
});

$j(function(){
    $j('.js-draggable').live('mouseup',function(){
        var dropOn = $j('.droppable-hover');
        var movable = $j(this);
        if (dropOn.length && movable.length){
            $j(movable).hide('slow');

            var droponId = dropOn.find('td').attr('data-pkv');
            //
            var mevedId = movable.attr('data-id');

            $j.ajax({
                url: '/admin/shop/supplier/binding/products',
                data: {
                    dropOnId: droponId,
                    movedId: mevedId,
                },
                dataType: 'json',
                success: function(data) {
                    if (data && data != 'error') {

                    } else {
                        alert('Произошла ошибка');
                    }
                    movable.remove();
                    // new product data
                    var obj = dropOn.find('.js-product-preview');
                    obj.attr('href', data.url);
                    obj.attr('data-id', data.id);
                    obj.html(data.name);
                    var objMatch = dropOn.find('[data-fk="matchreason"]');
                    objMatch.html('Ручной выбор');
                }
            });
        }
    });
});

$j(function () {
    $j('.js-checkbox').change(function () {
        var ids = '';

        $j('.js-checkbox').each(function (i, e) {
            if (e.checked) {
                ids += $j(e).val();
                ids += ',';
            }
        });

        $j('.js-id-products').val(ids);
    });
});

