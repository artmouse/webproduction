$j(function () {
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

            $j(this).parent().next('input.js-date').val(dateString);
        } else {
            $j(this).parent().next('input.js-date').val('');
        }
    });
});