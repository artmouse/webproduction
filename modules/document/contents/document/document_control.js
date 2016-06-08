$j(function () {
    // галочка + текущая дата
    $j('.js-document-checkbox-date').click(function(event) {
        if ($j(this).is(':checked')) {
            var date = new Date();

            function _formatDate(d) {
                return ((d < 10) ? '0' : '') + d;
            }

            var year = date.getFullYear();
            var month = _formatDate(date.getMonth() + 1);
            var day = _formatDate(date.getDate());
            var hour = _formatDate(date.getHours());
            var minute = _formatDate(date.getMinutes());
            var second = _formatDate(date.getSeconds());
            var dateString = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;

            $j(this).next('input').val(dateString);
        } else {
            $j(this).next('input').val('');
        }
    });
});

$j(function () {
    // переключение табов
    $j('.js-document-tabs a').click(function(){
        $j('.js-div-document, .js-div-editor, .js-div-original, .js-div-scan').hide();
        $j('.js-div-'+ $j(this).data('div')).show();
    });
});

// переключение на нужный таб
$j(window).bind('load', function(){
    $j('.js-document-tabs a').each(function(){
        var $this = $j(this);
        if ($this.find('.ob-icon-done').length) {
            $this.click();
            return false;
        }
    });
});

$j(function () {
    $j('.js-document-form-edit').submit(function(e) {
        // сохранение полей-инпутов из iframe-а
        var iframe = document.getElementById('js-document-iframe');
        var doc = iframe.contentDocument || iframe.contentWindow.document;

        $j(doc.body).find('input').each(function() {
            var name = $j(this).attr('name');
            var value = $j(this).val();
            $j('.js-document-form-edit').append('<input type="hidden" name="' + name + '" value="' + value + '" />');
        });

        // сохранение шаблона
        return iframe_save();
    });
});

$j(function () {
    // iframe редактирования шаблона
    var iframe = document.getElementById('js-editor-iframe');
    var doc = iframe.contentDocument || iframe.contentWindow.document;

    //doc.body.innerHTML = iframe.textContent || iframe.innerHTML;
    doc.body.innerHTML = $j('#js-editor').val();

    // Make IFRAME editable
    if (doc.body.contentEditable) {
        doc.body.contentEditable = true;
    }
});

// сохранение шаблона
function iframe_save() {
    var iframe = document.getElementById('js-editor-iframe');
    var doc = iframe.contentDocument || iframe.contentWindow.document;

    $j('#js-editor').val(doc.body.innerHTML);

    return true;
}