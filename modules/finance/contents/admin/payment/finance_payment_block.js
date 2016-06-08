$j(function() {
    // подтверждение виртуального платежа
    $j('.js-virtual-confirm').click(function(){
        if ($j(this).is(':checked')) {
            if (!confirm('Вы уверены что хотите провести виртуальный платеж? Такие платежи не влияют на баланс счетов в финансах.')){
                return false;
            }
        }
    });

    $j('.js-probation-payment').click(function () {
        var paymentId = $j(this).data('id');
        var value = 0;

        if ($j(this).prop("checked")) {
            value = 1;
        }

        $j.ajax({
            url: '/admin/shop/finance/probation/received/ajax/',
            data: {
                paymentId: paymentId,
                value: value
            },
            dataType: 'json'
        });
    });
});