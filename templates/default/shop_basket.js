$j(function() {
    $j('#id-addproduct').autocomplete({
        delay: 500,
        source: function( request, response ) {
            $j.ajax({
                url: "/search/jsonautocomplete/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        var result = name = '';
                        if (item.box == true) {
                            result = 'box: ' + item.id;
                            name = 'Коробка: ' + item.name;
                        } else {
                            result = item.id;
                            name = item.name;
                        }

                        return {
                            label: name,
                            value: result
                        }
                    }));
                }
            });
        }
    });

});

//coupon formating
$j(function() {
    $j('.js-coupon-formatter').mask("****-****-****-****");
});