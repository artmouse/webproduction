var pageSize = 20;

$j(function() {
    $j('.js-product-filter-autocomplete').select2({
        //placeholder: {title: "Search for a movie", id: "s"},
        //Does the user have to enter any data before sending the ajax request
        minimumInputLength: 0,            
        allowClear: true,
        multiple: true,
        ajax: {
            //How long the user has to pause their typing before sending the next request
            quietMillis: 150,
            //The url of the json service
            url: "/admin/shop/storage/ajax/product/filter/autocomplete/",
            dataType: 'jsonp',
            //Our search term and what page we are on
            data: function (term, page) {
                return {
                    pageSize: pageSize,
                    pageNum: page,
                    searchTerm: term
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


function product_autocomplete_init(elementID, multiple) {
    $j('#' + elementID).select2({
        minimumInputLength: 0,            
        allowClear: true,
        multiple: multiple,
        ajax: {
            quietMillis: 150,
            url: "/admin/shop/storage/ajax/product/filter/autocomplete/",
            dataType: 'jsonp',
            data: function (term, page) {
                return {
                    pageSize: pageSize,
                    pageNum: page,
                    searchTerm: term
                };
            },
            results: function (data, page) {
                var more = (page * pageSize) < data.Total; 
                return { results: data.Results, more: more };
            }
        }
    });
}