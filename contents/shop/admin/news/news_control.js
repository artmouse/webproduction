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
                        result = item.id;
                        name = item.name;

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