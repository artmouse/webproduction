$j(function () {
    //таймер для инициализаций внутри блоков
    setTimeout(function () {
        $j('.js-data-element').each(function() {
            var $this = $j(this);

            // инициализация
            $this.find('.js-disabled').attr('disabled', true);

            $this.find('.ob-link-edit').click(function () {
                var elem = $this.find('.js-disabled');
                elem.removeAttr("disabled");
                elem.focus();
            });

            $this.find('.ob-link-delete').click(function () {
                $this.find('.js-disabled').attr('disabled', true);
            });
        });
    }, 500);

});