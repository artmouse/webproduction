function shop_issue_ajax(url, parameters, callback) {
    $j.ajax({
        url: url,
        type: 'post',
        data: parameters,
        dataType: 'json',
        success: function(json) {
            if (json.status == 'success') {
                callback(json.result);
            } else {
                //alert('Error result');
            }
        },
        fail: function() {
            //alert('Error call');
        }
    });
}

function shop_issue_add(parameters, callback) {
    shop_issue_ajax('/admin/mind/issue/ajax/add/', parameters, callback);
}

function shop_issue_update_parent(parameters, callback) {
    shop_issue_ajax('/admin/mind/issue/ajax/update/', parameters, callback);
}

function shop_issue_delete(parameters, callback) {
    shop_issue_ajax('/admin/mind/issue/ajax/delete/', parameters, callback);
}

function shop_issue_get(parameters, callback) {
    shop_issue_ajax('/admin/mind/issue/ajax/get/', parameters, callback);
}

function shop_issue_edit(parameters, callback) {
    shop_issue_ajax('/admin/mind/issue/ajax/edit/', parameters, callback);
}