$j(function () {
    $j('.js-product-autocomplete-input').autocomplete({
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $j.ajax({
                url: "/admin/products/report/autocomtlite/ajax/",
                dataType: "json",
                data: {
                    name: request.term
                },
                success: function( data ) {
                    if (data == null) {
                        response(null);
                    }
                    response($j.map(data, function(item) {
                        var name = item.name;
                        return {
                            label: name,
                            value: name
                        }
                    }));
                }
            });
        }
    }).autocomplete("widget").removeClass().addClass("ob-autocomplete");
});