$j(function() {
    var popupAction = new popupStructure('.inner-content label input', '.popup-notice', '.inner-content label');
    contentPosition();
    $j(window).resize(function(){
        contentPosition();
    })
});

function popupStructure(element, popup, container) {
    $j(element).focus(function() {
        popupFocus(this);
    });

    $j(element).blur(function() {
        popupBlur(this);
    });

    var popupFocus = function(current) {
        $j(container).has(current).children(popup).show('500');
    };

    var popupBlur = function(current) {
        $j(container).has(current).children(popup).hide('500');
    }
}

function contentPosition() {
    var topDistance = ($j(window).height() - $j('.shop-install-content').height()) / 2;
    if (topDistance > 0) {
        $j('.shop-install-content').css('padding-top', topDistance+'px');
    } else {
        $j('.shop-install-content').css('padding-top', '0');
    }
}