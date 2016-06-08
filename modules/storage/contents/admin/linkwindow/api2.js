function shop_storage_link_add(parameters, callback) {
    $j.ajax({
        url: '/api/storage/link/add/',
        type: 'get',
        data: parameters,
        dataType: 'json',
        success: function(json) {
            if (json.status == 'success') {
                callback(json.result);
            } else {
                alert('Error result');
            }
        },
        fail: function() {
            alert('Error call API storage link add');
        }
    });
}

// @todo: отличие от shop_storage_link_add только в URL и обработке ошибок?
function shop_storage_link_delete(parameters, callback) {
    $j.ajax({
        url: '/api/storage/link/delete/',
        type: 'get',
        data: parameters,
        dataType: 'json',
        success: function(json) {
            if (json.status == 'success') {
                callback(json.result);
            } else {
                alert('Error result');
            }
        },
        fail: function() {
            alert('Error call API storage link delete');
        }
    });
}