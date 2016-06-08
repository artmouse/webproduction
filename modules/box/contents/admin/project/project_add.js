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
            $j("#managerid").select2("val", ui.item.manager);
        }
    });
});

$j(function () {
    var query = '';
    $j('#id-clientid-name').autocomplete({
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
                            value: name,
                            phone: item.phone,
                            email: item.email,
                            skype: item.skype,
                            whatsapp: item.whatsapp
                        }
                    }));
                }
            });
        },
        select: function (event, ui) {
            $j('#id-clientid-value').val(ui.item.id);
            $j('#js-client-phone').val(ui.item.phone);
            $j('[name=contact_email]').val(ui.item.email);
            $j('[name=contact_skype]').val(ui.item.skype);
            $j('[name=contact_whatsapp]').val(ui.item.whatsapp);
        },
        minLength:3
    }).data('ui-autocomplete')._renderItem = function (ul, item) {
        ul.removeClass().addClass("ob-autocomplete");
        var inner_html = '<span>'+item.label+'</span>';
        if (item.id === 0) {
            inner_html = '<span class="ob-link-add ob-link-dashed">'+item.label+'</span>';
            return $j( "<li onclick='addUserInSelectWindow2(\""+htmlspecialchars(query)+"\")'></li>" )
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
});

function addUserInSelectWindow2(name) {
    selectwindow_init('w2', 'id-clientid-name', 'id-clientid-value', {
        usersearch: true,
        useradd: true,
        selectedTab:1,
        userAddDefault:name
    });
}

$j(function () {
    $j('.js-workflowid').change(function () {
        var workflowID = $j(this).val();

        $j.ajax({
            url: '/admin/issue/workflow-preview/',
            datetype: "json",
            data: {
                workflowid: workflowID
            },
            success: function (data) {
                var obj = $j.parseJSON(data);
                if (obj) {
                    $j('.js-workflow-container').html(obj.html);

                    var defaultIssueName = $j('.js-default-issuename').val();
                    var defaultManagerID = $j('.js-default-managerid').val();
                    var defaultDateTo = $j('.js-default-dateto').val();

                    if ($j('.js-issuename').val() == '') {
                        $j('.js-issuename').val(defaultIssueName);
                    }

                    if (obj.userid > 0) {
                        $j('.js-managerid').select2('val', obj.userid);
                    } else {
                        $j('.js-managerid').select2('val', $j('#js-user-id').val());
                    }

                    $j('.js-managerid').change();

                    if (defaultDateTo != '') {
                        $j('.js-dateto').val(defaultDateTo);
                    }
                    $j('#divStatusDefaultIssue').show();
                }

            }
        });

        $j.ajax({
            url: '/admin/issue/workflow-fields/',
            data: {
                workflowid: workflowID
            },
            success: function (html) {
                $j('.js-fields-container').html(html);
            }
        });
    });

    $j('.js-workflowid').trigger('change');
});

$j(function () {
    $j('.js-issuename').focus();
});

function workflow_preview (workflowID) {

    if (!workflowID) {
        workflowID = $j('#js-workflow').val();
    }

    $j.ajax({
        url: '/admin/issue/workflow-preview/',
        datetype: "json",
        data: {
            workflowid: workflowID
        },
        success: function (data) {
            var obj = $j.parseJSON(data);
            if (obj) {
                $j('.js-workflow-container').html(obj.html);

                var defaultIssueName = $j('.js-default-issuename').val();
                var defaultManagerID = $j('.js-default-managerid').val();
                var defaultDateTo = $j('.js-default-dateto').val();

                if ($j('.js-issuename').val() == '') {
                    $j('.js-issuename').val(defaultIssueName);
                }

                if (obj.userid > 0) {
                    $j('.js-managerid').select2('val', obj.userid);
                } else {
                    $j('.js-managerid').select2('val', $j('#js-user-id').val());
                }

                $j('.js-managerid').change();

                if (defaultDateTo != '') {
                    $j('.js-dateto').val(defaultDateTo);
                }
                $j('#divStatusDefaultIssue').show();
            }

        }
    });
}