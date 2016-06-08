$j(function () {
    // навешиваем select2 на select-ы
    $j('select').each(function(){
        if ( !$j(this).hasClass("chzn-select") ){
            $j(this).addClass("chzn-select");
            $j(this).css('width','20%');
        }
    });
});