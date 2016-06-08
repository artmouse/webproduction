var jQueryFilter = {};

jQueryFilter.categorySearch = function( item ,e){
    if ($j(e).val() !== '') {
        // скрываем блоки в которых нет данного запроса
        $j(item).hide();

        // для каждой категории проверяем наличие запроса
        $j(item).each(function(){
            var a = $j(this).html().toLowerCase().replace(/\s/g, "");

            // показываем категорию если удовлетворять запрос
            if(a.match($j(e).val().toLowerCase().replace(/\s/g, ""))){
                $j(this).show();
            }
        })
    } else {
        $j(item).show();
    }
}