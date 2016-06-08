$j(function() {
    //colorpicjer init
    $j('.js-color').each(function(){
        var input = $j(this);
        var currentColor = input.val();
        input.css({
            'background-color' : currentColor
        });

        input.ColorPicker({
            color: currentColor,
            onShow: function (colpkr) {
                $j(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $j(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                input.css({
                    'background-color' : '#' + hex
                });
                input.val('#' + hex);
            }
        });
    });
    
});