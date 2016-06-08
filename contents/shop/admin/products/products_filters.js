$j(function () {
    $j('input.js_option').click(function(){
        $j($j(this).data('id')).toggle().find('input').val('0.00');
    });

    $j('.js-product-autocomplete-input').autocomplete({
        delay: 500,
        minLength: 2,
        source: function(request, response) {
            var filterId = $j(this.element).parent().parent().find('select').val();
            $j.ajax({
                url: "/admin/product/filter/value/ajax/",
                dataType: "json",
                data: {
                    id: filterId,
                    query: request.term
                },
                success: function( data ) {
                    if (data == null) {
                        response(null);
                    }

                    response($j.map(data, function(item) {
                        return {
                            label: item,
                            value: item
                        }
                    }));
                }
            });
        }
    }).autocomplete("widget").removeClass().addClass("ob-autocomplete");

});