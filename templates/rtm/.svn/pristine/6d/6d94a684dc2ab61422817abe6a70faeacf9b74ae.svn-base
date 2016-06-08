$j(document).ready(function () {
    // required fields verification
    if ($j('.js-form-validation').length) {
        $j('.js-form-validation').click(function () {
            var error = false;
            var formElement = $j(this).closest('form').find('.js-required');
            formElement.css('border-color', '#818181');;
            formElement.each(function () {
                if (!$j.trim($j(this).val())) {
                    $j(this).css('border-color', 'red');
                    error = true;
                }
            });

            if (error == true) {
                return false;
            }

        });
    }
});