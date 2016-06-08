$j(function() {
    $j(".js-datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        firstDay: 1
    });
    
    $j(document).click(function (event) {
        if (!$j(event.target).is(".js-block-export .link") &&
        !$j(event.target).is(".js-block-export .link span") &&
         $j('.js-block-export .options').is(":visible")) {
            $j('.js-block-export .options').toggle();
        }
    });
});