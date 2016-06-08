var pageSize = 20;
$j(function() {
    $j('#js-user-filter').select2({
        //placeholder: {title: "Search for a movie", id: "s"},
        //Does the user have to enter any data before sending the ajax request
        minimumInputLength: 0,
        allowClear: true,
        multiple: true,
        ajax: {
            //How long the user has to pause their typing before sending the next request
            quietMillis: 150,
            //The url of the json service
            url: "/admin/shop/orders/contact/jsonautocomplete/select2/",
            dataType: 'json',
            //Our search term and what page we are on
            data: function (term, page) {
                return {
                    pageSize: pageSize,
                    pageNum: page,
                    searchTerm: term,
                    arrUserId: $j('#arrUserId').val()
                };
            },
            results: function (data, page) {
                //Used to determine whether or not there are more results available,
                //and if requests for more data should be sent in the infinite scrolling
                var more = (page * pageSize) < data.Total;
                return { results: data.Results, more: more };
            }
        }
    });
});

$j(function() {
        $j('.js-checkbox').change(function () {
            var ids = '';
            $j('.js-checkbox').each(function (i, e) {
                if (e.checked) {
                    ids += $j(e).val();
                    ids += ',';             
                }
            });
        $j('#id-user').val(ids);
    });
})