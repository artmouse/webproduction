//высота левого блока
$j(function() {
    moduleLeftlayerHeight();
});
setInterval(function() { 
    moduleLeftlayerHeight();
}, 1000);
function moduleLeftlayerHeight(){
    $j('.shop-module-leftlayer .inner-layer').css(
        'min-height', 0
    );
    var bodyHeight = $j(document).height();
    var menuHeight = $j('.shop-admin-navi').outerHeight();
    $j('.shop-module-leftlayer .inner-layer').css(
        'min-height', bodyHeight - menuHeight
    );
}