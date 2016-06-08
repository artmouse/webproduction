$j(function () {
    $j('.js-from-email').autocomplete({
        delay: 500,
        source: function (request, response) {
            query = request.term;
            $j.ajax({
                url: "/admin/shop/users/ajax/autocomplete/event/filter/",
                dataType: "json",
                data: {
                    from: request.term
                },
                success: function (data) {
                    if (data == null)
                        response(null);
                    response($j.map(data, function (item) {
                        from = item.from;
                        phone = item.phone;
                        return {
                            label: from,
                            value: from,
                        }
                    }));
                }
            });
        },
        select: function (event, ui) {
            $j('#id-clientid-value').val(ui.item.from);
        }
    });
    $j('.js-to-email').autocomplete({
        delay: 500,
        source: function (request, response) {
            query = request.term;
            $j.ajax({
                url: "/admin/shop/users/ajax/autocomplete/event/filter/",
                dataType: "json",
                data: {
                    from: request.term
                },
                success: function (data) {
                    if (data == null)
                        response(null);
                    response($j.map(data, function (item) {
                        to = item.from;
                        return {
                            label: to,
                            value: to,
                        }
                    }));
                }
            });
        },
        select: function (event, ui) {
            $j('#id-clientid-value').val(ui.item.from);
        }
    });
});