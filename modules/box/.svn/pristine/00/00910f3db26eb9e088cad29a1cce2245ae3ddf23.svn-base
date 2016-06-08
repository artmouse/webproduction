$j(function() {
    //workflow sages sort
    $j('.js-fields-sort').sortable({
        handle: '.move',
        axis: "y",
        update: function() {
            var sort = 0;
            $j('.js-fields-sort .js-sort-value').each(function(){
                sort = sort + 1
                $j(this).val(sort);
            });
        }
    });
    
    $j("#select-type-forms").change(function () {
        $j("#select-type-forms option:selected").each(function() {
            if ($j("#select-type-forms option:selected").val() == 'checkbox'){
                $j('#checkid').hide();
            } else {
                $j('#checkid').show();
            }
        });
    });
});