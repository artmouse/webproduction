$j(window).load(function(){
    $j(document).on('change', 'input[type="text"], input[type="tel"], input[type="email"], input[type="password"], textarea, select', function(){
        var val = $j(this).val();
        var name = $j(this).attr('name');
        form_hendler(name, val);
    });
    init_data();
    form_data();
});

function form_hendler($name, $val){
    localStorage.setItem($name, $val);
}

function init_data(){
    $j('form').each(function(){
        $j('input[type="text"], input[type="tel"], input[type="email"], input[type="password"], textarea', this).each(
            function(){
            var name = $j(this).attr('name');
            var val = $j(this).val();
            form_hendler(name, val);
        });
    });    
}

function form_data(){
    $j('form').each(function(){
        $j('input[type="text"], input[type="tel"], input[type="email"], input[type="password"], textarea', this).each(
            function(){
            var name = $j(this).attr('name');
            var val = localStorage.getItem(name);
            $j(this).val(val);
        });

        $j('select', this).each(function(){
            var name = $j(this).attr('name');
            var val = localStorage.getItem(name);
            $j('option[value="'+val+'"]', this).attr('selected', true);
        });
    });
}

//function form_data_clear(form){
//    $j('#'+form).each(function(){
//        $j('input, textarea', this).each(function(){
//            var name = $j(this).attr('name');
//            localStorage.removeItem(name);
//        });
//
//        $j('select', this).each(function(){
//            var name = $j(this).attr('name');
//            localStorage.removeItem(name);
//        });
//    });
//}