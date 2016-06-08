function initIssueControlForm() {
    initIssueParentAutocomplete();
    initUserAutocomplete();

    $j('.js-user-edit-button').click(function() {
        $j('.js-user-edit').slideToggle();
        return false;
    });
}

function initIssueParentAutocomplete() {
    if ($j(".js-issue-parent-autocomplete").length) {
        $j(".js-issue-parent-autocomplete").catcomplete({
            delay: 500,
            source: function(request, response) {
                $j.ajax({
                    url: "/admin/issue/searchajax/select2/",
                    dataType: "json",
                    data:{
                        name: request.term
                    },
                    success: function(data) {
                        if (data == 'badLen') {
                            return false;
                        }
                        if (data == null) {
                            response(null);
                        }
                        response(
                            $j.map(
                                data,
                                function(item) {
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
                                }
                            )
                        );
                    }
                });
            },
            select: function(event, ui) {
                $j($j(this).data('input-value')).val(ui.item.id);
            }
        });
    }
}

function initUserAutocomplete() {
    var query = '';
    if ($j('.js-user-autocomplete').length) {
        $j('.js-user-autocomplete').autocomplete({
            delay: 500,
            source: function( request, response ) {
                query = request.term;
                $j.ajax({
                    url: "/admin/shop/users/ajax/autocomplete/select2/",
                    dataType: "json",
                    data:{
                        name: request.term
                    },
                    success: function(data) {
                        if (data == null) {
                            response(null);
                        }
                        response(
                            $j.map(
                                data,
                                function(item) {
                                    name = item.name;
                                    return {
                                        id: item.id,
                                        label: name,
                                        value: name
                                    }
                                }
                            )
                        );
                    }
                });
            },
            select: function (event, ui) {
                $j($j(this).data('input-value')).val(ui.item.id);
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
}

function addUserOrderInSelectWindow(name) {
    selectwindow_init('w2', 'id-user-name', 'id-user-value', {
        usersearch: true,
        useradd: true,
        selectedTab: 1,
        userAddDefault:name
    });
}