var jQueryTabs = {};

jQueryTabs.TabMenu = function (tab, selected) {
    if (!selected || selected == 'undefined') {
        selected = 'false';
    }

    // обработчик click
    $j(tab).click(function(event) {
        // прячем все текущие tabы
        $j(tab).each(function (index, e) {
            $j($j(e).data('rel')).hide();
        });

        $j(tab).removeClass('selected');
        $j(this).addClass('selected');
        $j($j(this).data('rel')).show();

        event.preventDefault();
    });

    // по умолчанию показываем первый таб
    if (selected == 'false') {
        $j(tab).each(function (index, e) {
            if (index == 0) {
                $j(e).click();
            }
        });
    } else {
        $j(tab).each(function (index, e) {
            if (index == selected) {
                $j(e).click();
            }
        });
    }

}