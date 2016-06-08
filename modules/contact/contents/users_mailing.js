$j(function() {
    // для блока с полями для файлов
    $j('#js-toggle-files').click(function(e){
        e.preventDefault();
        $j('.js-files-block').toggle();
    });
    
    // переключение типа письма
    // при ошибке
    if ($j('.js-type-value').val() == 1) {
        $j('.js-text-editor').removeClass('selected');
        $j('.js-html-editor').addClass('selected');
        mceInint('.js-editor-custom');
    }
    // кнопки
    $j('.js-mail-type a').click(function(){
        var currentType = $j(this).data('type');
        if (currentType == 'text') {
            $j('.js-type-value').val(0);
            // disable editor
            tinymce.remove(".js-editor-custom");
        } else {
            $j('.js-type-value').val(1);
            // enable editor
            mceInint('.js-editor-custom');
        }
    });
});
