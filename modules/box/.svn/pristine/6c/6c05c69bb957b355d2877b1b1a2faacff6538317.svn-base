// search autocomplete
$j(function() {
    var query = '';
    if ($j('#id-name').length) {
        $j('#id-name').autocomplete({
            delay: 500,
            source: function( request, response ) {
                query = request.term;
                $j.ajax({
                    url: "/admin/products/json/autocomtlite/ajax/",
                    dataType: "json",
                    data:{
                        name: request.term
                    },
                    success: function( data ) {
                        if (data==null) response(null);
                        response( $j.map( data, function( item ) {
                            name = item.name;
                            return {
                                id: item.id,
                                label: name,
                                value: name
                            }
                        }));
                    }
                });
            },
            select: function (event, ui) {
                $j('#id-value').val(ui.item.id);
            },
            minLength: 3
        }).data('ui-autocomplete')._renderItem = function (ul, item) {
            ul.removeClass().addClass("ob-autocomplete");
            var inner_html = '<span>'+item.label+'</span>';
            if (item.id === 0) {
                inner_html = '<span class="ob-link-add ob-link-dashed">'+item.label+'</span>';
                return $j( "<li onclick='addProductInSelectWindow(\""+query+"\")'></li>" )
                .data( "item.autocomplete", item )
                .append(inner_html)
                .appendTo( ul );
            } else {
                return $j( "<li></li>" )
                .data( "item.autocomplete", item )
                .append(inner_html)
                .appendTo( ul );
            }
        };
    }
});

$j(function() {
    var query = '';
    if ($j('#id-user-name').length) {
        $j('#id-user-name').autocomplete({
            delay: 500,
            source: function( request, response ) {
                query = request.term;
                $j.ajax({
                    url: "/admin/shop/users/ajax/autocomplete/select2/",
                    dataType: "json",
                    data:{
                        name: request.term
                    },
                    success: function( data ) {
                        if (data==null) response(null);
                        response( $j.map( data, function( item ) {
                            name = item.name;
                            return {
                                id: item.id,
                                label: name,
                                value: name
                            }
                        }));
                    }
                });
            },
            select: function (event, ui) {
                $j('#id-user-value').val(ui.item.id);
            },
            minLength:3
        }).data('ui-autocomplete')._renderItem = function (ul, item) {
            ul.removeClass().addClass("ob-autocomplete");
            var inner_html = '<span>'+item.label+'</span>';
            if (item.id === 0) {
                inner_html = '<span class="ob-link-add ob-link-dashed">'+item.label+'</span>';
                return $j( "<li onclick='addUserOrderInSelectWindow(\""+query+"\")'></li>" )
                .data( "item.autocomplete", item )
                .append(inner_html)
                .appendTo( ul );
            } else {
                return $j( "<li></li>" )
                .data( "item.autocomplete", item )
                .append(inner_html)
                .appendTo( ul );
            }
        };
    }
});

$j(function() {
    if ($j('#id-clientmanager-name').length) {
        var query = '';
        $j('#id-clientmanager-name').autocomplete({
            delay: 500,
            source: function( request, response ) {
                query = request.term;
                $j.ajax({
                    url: "/admin/shop/users/ajax/autocomplete/select2/",
                    dataType: "json",
                    data:{
                        name: request.term,
                        onlyPerson: true
                    },
                    success: function( data ) {
                        if (data==null) response(null);
                        response( $j.map( data, function( item ) {
                            name = item.name;
                            return {
                                id: item.id,
                                label: name,
                                value: name
                            }
                        }));
                    }
                });
            },
            select: function (event, ui) {
                $j('#id-clientmanager-value').val(ui.item.id);
            },
            minLength:3
        }).data('ui-autocomplete')._renderItem = function (ul, item) {
            ul.removeClass().addClass("ob-autocomplete");
            var inner_html = '<span>'+item.label+'</span>';
            if (item.id === 0) {
                inner_html = '<span class="ob-link-add ob-link-dashed">'+item.label+'</span>';
                return $j( "<li onclick='addManagerInSelectWindow(\""+query+"\")'></li>" )
                .data( "item.autocomplete", item )
                .append(inner_html)
                .appendTo( ul );
            } else {
                return $j( "<li></li>" )
                .data( "item.autocomplete", item )
                .append(inner_html)
                .appendTo( ul );
            }
        };
    }
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

function addUserOrderInSelectWindow (name) {
    selectwindow_init('w2', 'id-user-name', 'id-user-value', {
        usersearch: true,
        useradd: true,
        selectedTab:1,
        userAddDefault:name
    });

}
function addManagerInSelectWindow (name) {
    selectwindow_init('w3', 'id-clientmanager-name', 'id-clientmanager-value', {
        usersearch: true,
        useradd: true,
        selectedTab:1,
        userAddDefault:name
    });
}