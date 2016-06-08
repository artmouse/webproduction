// @todo: naming bug //
function deleteComplae (productId) {
    $j.ajax({
        url: "/ajax/compare/",
        dataType: "json",
        data: {
            'delete': productId
        },
        success: function (data) {
            if (data.count == 0) {
                location.reload();
            } else {
                shop_compare_load();
                $j(".id-"+productId).hide(400);
            }
        }
    });
}