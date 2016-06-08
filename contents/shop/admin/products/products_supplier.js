$j(function () {
// Контакты на поставщиков
    function formatSelection(item) {
        var dataId = $j(item.element).data('id');
        var dataUrl = $j(item.element).data('url')
        if (dataId) {
            return '<a href="' + dataUrl + '" class="js-contact-preview" data-id="' + dataId + '">' + item.text + '</a>';
        }
        return item.text;

    }


    $j('.chzn-select-supplier').select2({
        formatSelection: formatSelection
    });

    $j(function () {
        // Первичная Инициализация
        if ($j('.js-current-supplier').length) {
            $j(".js-current-supplier").each(function (index, e) {
                var option_supplier;
                var span;
                option_supplier = $j(e);
                span = option_supplier.parent().parent().find('span.select2-chosen');
                var dataId = option_supplier.data('id');
                var dataUrl = option_supplier.data('url');
                var text = span.html();
                var text = '<a href="' + dataUrl + '" class="js-contact-preview" data-id="' + dataId + '">' + text + '</a>'
                span.html(text);
            });

        }
    })
});