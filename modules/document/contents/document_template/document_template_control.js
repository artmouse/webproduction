var time = 0;
var refresh = 0;

$j(function () {

    // при смене типа, обнуляем найденый контакт/заказ
    $j('#js-type').change(function () {
        $j('#js-object-id').val(0);
    });

    textChange();

    $j('#js-textarea').change(function () {
        textChange();
    });

    $j('#js-textarea').keyup(function () {
        textChange();
    });

    $j('#js-textarea').mouseup(function () {
        textChange();
    });

});

function textChange () {
    timeNew = new Date().getTime()/1000;
    if (refresh && timeNew < (time+5) ) {
        return;
    }

    time = timeNew;
    refresh = 1;

    $j('#js-frame').css('height', $j('#js-textarea').css('height'));

    $j.ajax({
        url: "/admin/shop/document/templates/view/ajax/",
        dataType: "json",
        type: 'POST',
        data: {
            content: $j('#js-textarea').val(),
            type: $j('#js-type').val(),
            id: $j('#js-object-id').val()
        },
        background: true,
        success: function (data) {
            if (data.error) {
                $j('#js-frame').contents().find('body').html(data.error);
            } else {
                $j('#js-frame').contents().find('body').html(data.content);
                $j('#js-object-id').val(data.id);
            }

            refresh = 0;
        }
    });
}

$j(function () {
    // переключение табов
    $j('.js-document-tabs a').click(function(){
        $j('.js-div-view, .js-div-edit').hide();
        $j('.js-div-'+ $j(this).data('div')).show();
    });
});