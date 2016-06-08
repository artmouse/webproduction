$j(function() {
    $j( "#js-parent-name" ).catcomplete({
        delay: 500,
        source: function( request, response ) {
            $j.ajax({
                url: "/admin/issue/searchajax/select2/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data=='badLen') return false;
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        var id = group = name = '';
                        id = item.id;
                        name = item.name;
                        category = item.category;
                        manager = item.manager;

                        return {
                            id: id,
                            label: name,
                            category: category,
                            manager: manager
                        }
                    }));
                }
            });
        },
        select: function( event, ui ) {
            $j('#js-parent-value').val(ui.item.id);
        }
    });
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

$j(function(){
    $j('.js-user-edit').hide();
    $j('.js-user-view').show();
    $j('.js-user-edit-button').click(function () {
        $j('.js-user-edit').slideToggle();
        return false;
    });
});

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