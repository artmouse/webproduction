function shop_product_search(query, categoryID, callback) {
    $j.ajax({
        url: '/api/product/search',
        data: {
            query: query,
            categoryid: categoryID
        },
        dataType : "json",
        success: function (json) {
            if (json.status == 'success') {
                callback(json.result);
            } else {
                alert('Error result');
            }
        },
        error: function () {
            alert('Error call API product search');
        }
    });
}

function shop_product_add(parameters, callback) {
    $j.ajax({
        url: '/api/product/add',
        data: parameters,
        dataType : "json",
        success: function (json) {
            if (json.status == 'success') {
                callback(json.result);
            } else {
                alert(json.errors);
                // alert('Error result');
            }
        },
        error: function () {
            alert('Error call API product add');
        }
    });
}

function shop_user_search(query, callback, companyOnly) {
    $j.ajax({
        url: '/api/user/search',
        data: {
            query: query,
            companyonly: companyOnly
        },
        dataType : "json",
        success: function (json) {
            if (json.status == 'success') {
                callback(json.result);
            } else {
                alert('Error result');
            }
        },
        error: function () {
            alert('Error call API user search');
        }
    });
}

function shop_user_add(parameters, callback) {
    $j.ajax({
        url: '/api/user/add',
        data: parameters,
        dataType : "json",
        success: function (json) {
            if (json.status == 'success') {
                callback(json.result);
            } else {
                var errorMessage = "Error result\n";
                $j(json.errors).each(function (key, item) {
                    errorMessage+= item;
                });
                alert(errorMessage);
            }
        },
        error: function () {
            alert('Error call API user add');
        }
    });
}