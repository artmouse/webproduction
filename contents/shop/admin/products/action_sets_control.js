$j(function () {
    $j('#id-product').click(function(e){
        selectwindow_init('w1', 'id-name', 'id-value', {
            productsearch: true,
            productadd: true
        });
        e.preventDefault();
    });

    $j('#id-product-clear').click(function(e){
        $j('#js-product-tag').tagit("removeAll");
        e.preventDefault();
    });
});

$j(function() {
    $j('#js-product-tag').tagit({
        singleField: true,
        singleFieldNode: $j($j('#js-product-tag').data('input')),
        allowSpaces: true,
        autocomplete: {
            delay: 0,
            minLength: 3,
            source: function( request, response ) {
                var query = request.term;
                $j.ajax({
                    url: "/admin/products/json/autocomtlite/ajax/",
                    dataType: "json",
                    data:{
                        name: query
                    },
                    success: function( data ) {
                        if (data==null) response(null);
                        response( $j.map( data, function( item ) {
                            var result = name = '';

                            if (item.id==0) {
                                result = '#0';
                            } else {
                                result = '#'+item.id+' '+item.name;
                            }
                            var name = item.name;

                            return {
                                label: name,
                                value: result
                            }
                        }));
                    },
                    complete : function () {
                        $j('.tagit-autocomplete').each(function(){
                            var positionLeft = $j('#js-product-tag').offset().left + 1;
                            var positionTop = $j('#js-product-tag').offset().top + $j('#js-product-tag').innerHeight();
                            $j(this).css({
                                'left' : positionLeft,
                                'top' : positionTop,
                                'width' : 'auto'
                            })
                            var el = $j(this).children(':last');
                            el.attr("onClick","addProductInSelectWindow(\""+query+"\"); setTimeout(function(){$j('#js-product-tag').tagit(\"removeTagByLabel\", \"#0\");},200);");
                            var elemtext = el.text();
                            el.text('');
                            el.append('<span class="ob-link-add ob-link-dashed">'+elemtext+'</span>');
                        });
                    }
                })
            }
        }
    });
});


function addProductInSelectWindow (name) {
    $j('#js-add-query').val(name);
    selectwindow_init('w1','id-name','id-value',{
        productadd:true,
        productsearch:true,
        selectedTab:1,
        productAddDefault:name
    });

}