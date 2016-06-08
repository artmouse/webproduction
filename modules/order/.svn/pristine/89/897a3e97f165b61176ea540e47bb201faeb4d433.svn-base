function settings_stage_popup (orderId, statusId) {
    if (!statusId || !orderId) {
        return false;
    }

    $j.get('/admin/order/workflow-setting-info/', {
        statusid: statusId,
        orderid: orderId
    }, function(data) {
        if (data) {
            $j('#js-settings-stage-popup-content').empty();
            $j('#js-settings-stage-popup-content').append(data);
            popupOpen('.js-settings-stage-popup');
        }
    });

    return false;

}