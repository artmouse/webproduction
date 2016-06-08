$j(function () {
    initIssueParentAutocomplete();
});

function initIssueParentAutocomplete() {
    if ($j(".js-issue-parent-autocomplete").length) { alert(1);
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