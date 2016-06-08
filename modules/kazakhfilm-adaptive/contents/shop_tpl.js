$j(function() {
    $j(window).on('load resize', function(){
        var $pageWrap = $j('.js-page-wrap');
        var $pageBuffer = $j('.js-page-buffer');
        var footHeigh = $j('.js-footer-height').height();

        $pageWrap.css({
            'margin-bottom': -(footHeigh)
        });

        $pageBuffer.css({
            'height': footHeigh + 30
        });
    });

    // ajs-code
    $j('.ajs').val('ready');

    //show modal by name
    $j('.booking-button-block>a , .tpl-contacts-call-us-back>div , .add-feedback-btn>a, a.js_menu_booking').click(function(){
        var modalName = $j(this).attr('data-caption');
        var currentHeight = $j(document).scrollTop()+50;
        var docHeight = $j(document).height();
        var docWidth = $j(document).width();

        $j('.'+ modalName).show();

        var modalWidth = $j('.kzh-modal').width();
        var lastSpace = docWidth - modalWidth;
        var modalLeft =  lastSpace/2-6;
        var phoneModal = $j('.callusModal .kzh-modal').width();
        var lastSpacePhone = (docWidth - phoneModal)/2-8;


        function modalMobilePosition (){
            if (docWidth< 960) {
                $j('.'+ modalName+'>.kzh-modal').css({top: currentHeight, left: modalLeft});
            } else {
                $j('.'+ modalName+'>.kzh-modal').css({top: currentHeight, left: "50%"});
            }

            if (docWidth< 960) {
                $j('.callusModal>.kzh-modal').css({top: currentHeight, left: lastSpacePhone});
            } else {
                $j('.callusModal>.kzh-modal').css({top: currentHeight, left: "50%"});
            }
        }

        modalMobilePosition ();




        //fix for fixed black modal bg on mobile devises
        $j(".modal-black-mask").css({
            height: docHeight
        });

        var resizeTimer2;

        $j(window).resize(function() {
            clearTimeout(resizeTimer2);
            resizeTimer = setTimeout(modalMobilePosition, 100);
        });

    });



    //fix for fixed in mobiles
    $j(".modal-black-mask").click(function(){
        $j(this).parent().hide();
    });

    //?showing captions
    $j('.index-preview-caption').hover(function(){
        $j(this).find('span.index-preview-caption-dropdown').css({display: 'block'})
    },function(){
        $j(this).find('span.index-preview-caption-dropdown').css({display: 'none'})
    });

    //removing colorbox if screen width less then 960px
    function colorboxBlock (){
        var docWidth = $j(document).width();
        if (docWidth< 960) {
            $j('a').removeClass("cboxElement");
        }
    }

    //restart several function on window resize
    colorboxBlock();

    var resizeTimer;

    $j(window).resize(function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(colorboxBlock, 100);
    });
});