$j(function() {
    //ie detection
    if (!!navigator.userAgent.match(/Trident\/7\./)) {
        $j("html").addClass("ie11");
    }
    if ($j.browser.msie && $j.browser.version == 10) {
        $j("html").addClass("ie10");
    }
    if ($j.browser.msie && $j.browser.version == 9) {
        $j("html").addClass("ie9");
    }

    // nav toggle menu
    if ($j('.js-toggle-cat-menu').length) {
        menuHover();
    }

    //menu hover dropdown function
    function menuHover() {
        var $navElement = $j('.js-toggle-cat-menu').find('li');

        $navElement.hover(function(){
            var $this = $j(this);
            $this.addClass('js-hover');
            setTimeout(function(){
                if ($this.hasClass('js-hover')) {
                    $this.find('.dropdown-menu').slideDown(150);
                    $this.addClass('hover');
                }
            }, 500);
        }, function(){
            var $this = $j(this);
            $this.removeClass('js-hover');
            setTimeout(function(){
                if ($this.hasClass('js-hover')) {
                    return;
                } else {
                    $this.find('.dropdown-menu').slideUp(150);
                    $this.removeClass('hover');
                }
            }, 500);
        });

        if ((pgwBrowser.os.group == 'Android') || (pgwBrowser.os.group == 'Windows Phone') || (pgwBrowser.os.group == 'iOS') || (pgwBrowser.os.group == 'BlackBerry')) {
            $j('.js-toggle-cat-menu>li>a').click(function(){
                if ($j(this).next('.dropdown-menu').length) {
                    $j(this).next('.dropdown-menu').fadeToggle();
                    return false;
                }
            });
        }
    }

    $j('.js-toggle-nav-button').live('click', function(){
        $j('.js-mobile-nav').slideToggle(200);
    });

    $j('.js-toggle-search').live('click', function(){
        $j(this).next().slideToggle(200);
    });

    // select
    $j('.chzn-select').select2();

    // block rating
    if ($j('.js-block-rating').length) {
        $j('.js-block-rating span').hover(function(){
            var $ratingBlock = $j(this).closest('.cl-block-rating');
            var newValue = $j(this).data('count');
            $ratingBlock.find('.inner').css({'width' : newValue*20+'%'});
        },function(){
            var $ratingBlock = $j(this).closest('.cl-block-rating');
            var currentValue = $ratingBlock.find('input').val();
            $ratingBlock.find('.inner').css({'width' : currentValue*20+'%'});
        });

        $j('.js-block-rating span').click(function(){
            var $ratingBlock = $j(this).closest('.cl-block-rating');
            var newValue = $j(this).data('count');
            $ratingBlock.find('input').val(newValue);
            $ratingBlock.find('.text').html(newValue + ' из 5');
        });

        $j('.js-rating-clear').click(function(){
            var $ratingBlock = $j(this).closest('.cl-block-rating');
            $ratingBlock.find('input').val('');
            $ratingBlock.find('.inner').css({'width' : '0'});
            $j(this).html('');
        });
    }

    //slider in product card
    $j('.js-prod-slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 300,
        arrows: true,
        infinite: false,
        fade: false,
        asNavFor: '.js-prod-slider-nav'
    });
    $j('.js-prod-slider-nav').slick({
        slidesToShow: 6,
        infinite: false,
        slidesToScroll: 1,
        asNavFor: '.js-prod-slider-for',
        dots: false,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 1601,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 1280,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 960,
                settings: {
                    slidesToShow: 4
                }
            }
        ]
    });
    $j('.js-prod-slider-nav .slick-slide').click(function () {
        if ($j(this).hasClass('current')) {
            $j('.js-prod-slider-nav .slick-slide').removeClass('current');
            $j(this).removeClass('current');
        } else {
            $j('.js-prod-slider-nav .slick-slide').removeClass('current');
            $j(this).addClass('current');
        }
    });

    // scroll to top
    $j(".js-to-top").hide();

    $j(window).scroll(function () {
        if ($j(this).scrollTop() > 250) {
            $j('.js-to-top').fadeIn();}
        else {$j('.js-to-top').fadeOut();
        }
    });
    $j('.js-to-top').click(function () {
        $j('body,html').animate({scrollTop: 0}, 600);
        return false
    });

    // инциируем баннер на всю ширину
    $j('.js-fullwidth-slider').slick({
        arrows: true,
        infinite: true,
        dots: true,
        speed: 500,
        autoplay: true,
        autoplaySpeed: 6000,
        pauseOnHover: false,
        adaptiveHeight: true
    });

    $j('.js-tabs > a').on('click', function(){
        var dataTab = $j(this).data('tab');

        $j('.js-tabs > a').removeClass('selected');
        $j(this).addClass('selected');

        $j('.cl-block-tabs .tabs-content').hide();
        $j('.js-tab-'+dataTab).show();
    });

    //content replace for seo
    $j('.js-append-seo').appendTo('.js-seo-wrapper').height('auto');

    // custom selectt
    $j('select').uniform({
        selectClass: 'cl-select'
    });
});

$j(window).on("ready load resize", function(){
    // проставляем ширину контейнера для баннера на всю ширину
    $j('.js-fullwidth-slider').width($j(window).width());

    if ($j(window).width() > 641 ) {
        if ($j('.js-mobile-nav').is(':hidden') ) {
            $j('.js-mobile-nav').removeAttr('style');
        }

        if ($j('.js-toggle-search').next().is(':hidden') ) {
            $j('.js-toggle-search').next().removeAttr('style');
        }
    }
});
