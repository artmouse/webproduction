$j(function() {
    favoriteCheck();
    favoriteToggle();

});

function favoriteToggle() {
    $j('.js-shop-favorite').live('click',function(){
        alert(111);
        if (!$j(this).data('auth')) {
            popupOpen('.js-popup-auth-block');
        }
        $j.ajax({
            url:"/ajax/favorite_toggle/",
            dataType:"json",
            data:{
                productid:$j(this).data('productid')
            },
            success:function (data) {
                if (data) {
                    $j('.js-shop-favorite[data-productid='+ data.id+']').toggleClass('favorite').html(data.name);
                }
            },
            complete:function () {

            }
        });
    });
}

function favoriteCheck() {
    var productIdArray = new Array();
    $j('.js-shop-favorite').each(function(index, e) {
        productIdArray[productIdArray.length] = $j(this).data('productid');
    });
    if (productIdArray.length > 0) {
        $j.ajax({
            url:"/ajax/favorite_check/",
            dataType:"json",
            data:{
                productid_str:productIdArray.join(',')
            },
            success:function (data) {
                if (data) {
                    $j(data).each(function(index, e) {
                        $j('.js-shop-favorite[data-productid='+ e.id+']').addClass(e.element_class).
                            attr('data-auth', e.auth).html(e.name).show();
                    });
                }
            },
            complete:function () {

            }
        });
    }
}