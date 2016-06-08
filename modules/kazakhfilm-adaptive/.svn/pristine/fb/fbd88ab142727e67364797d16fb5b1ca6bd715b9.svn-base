$j(function() {
    $j('div.kzh-room-preview-block').each(function(index){
        $j('a.grup-'+parseInt(index + 1)).colorbox({});
    });

    $j('.kzh-btn-default').click(function(){
        $j('.sbOptions').find('li a[rel="'+$j(this).data('id')+'"]').click();
    });

    $j('.js-toggle-currency-link').click(function(){
        $j(this).closest('.room-preview-price').find('.js-toggle-currency').toggle();
    });



});