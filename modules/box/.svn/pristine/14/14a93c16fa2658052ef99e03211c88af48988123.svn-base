$j(function() {
    // my only init
    $j('.js-notify-my-toggle').on('click', function(){
        var type = $j(this).data('acl');
        var $commentAll = $j('.js-notification-element');
        var $commentMy = $j('.js-notification-element').find('.marked').closest('.list-element');
        var $captionAll = $j('.js-notify-wrap').find('.type-caption');
        var $captionMy = $j('.js-notify-wrap').find('.marked').closest('.js-notify-wrap').find('.type-caption');

        if(type==1){
            $commentAll.hide();
            $captionAll.hide();
            $commentMy.show();
            $captionMy.show();
        }

        if(type==0){
            $commentAll.show();
            $captionAll.show();
        }

        // updating notify panel
        $j('.js-notify-scroll-block').animate({
            scrollTop: 0
        }, 0);
        $j('.js-stat-element').removeClass('active');
    });


    $j('.js-notification-toggle').click(function(){
        if ($j(this).hasClass('js-empty')) {
            return false;
        }
        $j('.js-notification-list').toggleClass('enable');
        $j('body').toggleClass('blured-notification');
        $j('.js-wrap-notification').fadeToggle(300);

        if ($j('.js-slide-tabs').length) {
            setTimeout(function(){
                jsSlidePosition($j('.js-slide-tabs .selected'));
            }, 500);
        }

        $j('.js-loader').hide();
    });

    $j('.js-search-close').click(function(){
        searchWrapClose();
    });

    if ($j('.js-wrap-search').length) {
        $j(document).keyup(function(e) {
            if (e.keyCode == 27) {
                searchWrapClose();
            }
        });
    }

    // быстрый поиск по вертикальному меню
    $j('.js-search-helper').keyup(function() {
        jQueryFilter.categorySearch('.js-search-line', this);
        $j('.js-search-line').find('.sub').slideDown(300);
        $j('.js-search-line').find('.expand').addClass('open');
    });
});

// search wrap hide
function searchWrapClose() {
    $j('.js-wrap-search').fadeOut(300);
    $j('body').removeClass('blured-search');
}

// autocomplete with custom render
$j.widget("custom.boxsearchcomplete", $j.ui.autocomplete, {
    options: {
        suggest: false
    },

    _suggest: function(items) {
        if ($j.isFunction(this.options.suggest)) {
            return this.options.suggest(items);
        }
        this._super(items);
    },

    _close: function(e) {

    }

});

$j(function() {
    // search button
    $j('.js-searchpopup-toggle').unbind('click');
    $j('.js-searchpopup-toggle').click(function() {
        $j('.js-wrap-search').fadeIn(300);
        $j('#js-search-custom-input').focus();
        $j('body').addClass('blured-search');
        $j('.nb-wrap-menuvertical').hover();
        searchResultHeight();
    });

    // search with custom autocomplete
    $j("#js-search-custom-input").boxsearchcomplete({
        delay: 500,
        source: function(request, response) {
            $j('.js-search-loading').fadeIn(300);
            $j.ajax({
                url: "/admin/shop/search/custom/ajax/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function(data) {
                    if (data == 'badLen') {
                        return false;
                    }

                    if (data == null) {
                        response(null);
                    }

                    response($j.map(data, function(item) {
                        return {
                            value: item
                        }
                    }));
                }
            });
        },
        minLength: 3,
        suggest: function(items) {
            var $div = $j("#js-search-custom-input-result-div").empty();
            $j.each(items, function() {
                if (this.value) {
                    element = '<div class="column">' + this.value + '</div>';
                    $div.append(element);
                }
            });
            $j('.js-search-loading').fadeOut(300);
            $j('.js-search-theadrow').html('');
            $j('#js-search-custom-input-result-div .elements-caption').each(function(){
                $j(this).appendTo('.js-search-theadrow').wrap('<div class="column"></div>');
            });
            searchResultHeight();
            // #2012099594
            //animation('.ob-wrap-search .element', 'blind-search');
        }
    });

    // hide animation when less than 3
    $j('#js-search-custom-input').keypress(function(){
        var $this = $j(this);

        setTimeout(function(){
            if($this.val().length < 3) {
                $j('.js-search-loading').fadeOut(300);
            }
        }, 1000);
    });

    //cheking os
    var os = $j('body').attr('data-os');
    if(os === 'windows' || os === 'linux'){
        $j('.js-search-result').perfectScrollbar();
    }

});

$j(window).bind('resize', function(){
    searchResultHeight();
});

// search result list
function searchResultHeight(){
    if ($j('.js-search-result').is(':visible')) {
        $j('.js-search-result').css({
            'height' : $j(window).height() - $j('.js-search-field').height() - $j('.js-search-field').offset().top - $j('.search-thead').height()
        });
    }
}

function box_voip_transfer(callID, phone) {
    $j.ajax({
        url: '/admin/voip-call/transfer/',
        data: {
            callid: callID,
            phone: phone
        },
        success: function (html) {

        }
    });
}

function box_voip_reject(callID, phone) {
    $j.ajax({
        url: '/admin/voip-call/reject/',
        data: {
            callid: callID,
            phone: phone
        },
        success: function (html) {

        }
    });
}

// соедениться с телефоном
function box_voip_originate(phone) {
    $j.ajax({
        url: '/admin/voip-call/originate/',
        data: {
            phone: phone
        },
        success: function (text) {
            console.log(text);
        }
    });
}

// сохранить примечание о звонке
function box_voip_call_comment(callID, comment) {
    $j('.js-call-comment-result').html('');

    if (!comment) {
        return false;
    }

    $j('.js-call-comment-result').html('Сохранение...');

    $j.ajax({
        url: '/admin/voip-call/save/',
        data: {
            callid: callID,
            comment: comment
        },
        success: function () {
            $j('.js-call-comment-result').html('Комментарий успешно сохранен.');
        }
    });

    return false;
}

// закрыть окно и не долбать уведомлениями
function box_voip_call_close(callID) {
    $j.ajax({
        url: '/admin/voip-call/close/',
        data: {
            callid: callID
        },
        success: function () {
            $j('.js-voip-call').removeClass('open');
            setTimeout(function(){
                $j('.js-voip-call').remove();
            }, 500);
        }
    });

    return false;
}

// создать контакт для формы call in
function box_voip_call_contact_edit_phone() {

    $j.ajax({
        url: '/admin/voip-call/contact/edit/phone/',
        data: {
            phone: $j('.js-call-phone').val(),
            userid: $j('#js-call-client-value').val(),
            edit: 1
        },
        success: function (html) {
            $j('.js-call-contact-block').html(html);
        }
    });

    return false;
}

// создать контакт для формы call in
function box_voip_call_contact() {
    var nameFirst = $j('.js-call-namefirst').val();
    var phone = $j('.js-call-phone').val();

    if (!nameFirst) {
        messagePush('Пожалуйста, укажите имя.', 'error');
        return;
    }

    if (!phone) {
        messagePush('Пожалуйста, укажите телефон.', 'error');
        return;
    }

    $j.ajax({
        url: '/admin/voip-call/contact/',
        data: {
            namefirst: nameFirst,
            namelast: $j('.js-call-namelast').val(),
            namemiddle: $j('.js-call-namemiddle').val(),
            company: $j('.js-call-company').val(),
            source: $j('.js-call-source').val(),
            title: $j('.js-call-title').val(),
            phone: phone,
            typesex: $j('.js-call-typesex').val(),
            groupid: $j('.js-call-groupid').val()
        },
        success: function (html) {
            $j('.js-call-contact-block').html(html);
        }
    });

    return false;
}

// окно входящего звонка (call window)
function box_voip_call_window() {
    // окно уже есть, выходим
    if ($j('.js-voip-call').length > 0) {
        return false;
    }

    // один раз запрашиваем окшно
    $j.ajax({
        url: '/admin/voip-call/',
        success: function (html) {
            html = html.trim();
            if (html) {
                $j('body').append(html);
            }
        }
    });
}

// мониторинг входящих звонков
function box_voip_call() {
    var vis = (function(){
        var stateKey, eventKey, keys = {
            hidden: "visibilitychange",
            webkitHidden: "webkitvisibilitychange",
            mozHidden: "mozvisibilitychange",
            msHidden: "msvisibilitychange"
        };
        for (stateKey in keys) {
            if (stateKey in document) {
                eventKey = keys[stateKey];
                break;
            }
        }
        return function(c) {
            if (c) document.addEventListener(eventKey, c);
            return !document[stateKey];
        }
    })();

    // gives current state
    var visible = vis();

    vis(function(){
        // document.title = vis() ? 'Visible' : 'Not visible';
        visible = vis();
    });

    if (visible) {
        // сначала отправляем ajax к voip.json, потому что он отдается быстро.
        // Так мы поймем нужно ли нам вообще вызывать окошко и нагружать сервер.
        $j.ajax({
            url: '/media/notification/voip.json',
            dataType: "json",
            cache: false,
            background: false, // не задалбываем лоадингом
            success: function (json) {
                console.log(callWindowUserID);
                if (json) {
                    $j(json.userArray).each(function (i, userID) {
                        if (userID == callWindowUserID) {
                            // наш пользователь есть, инициируем окошко
                            box_voip_call_window();
                        }
                    });
                }

                setTimeout(box_voip_call, callWindowTimeout);
            },
            error: function () {
                setTimeout(box_voip_call, callWindowTimeout);
            }
        });
    } else {
        setTimeout(box_voip_call, callWindowTimeout);
    }
}

$j(function() {
    // call
    $j(document).on('click', '.js-call-originate', function (event) {
        var phone = $j(event.target).data('phone');
        box_voip_originate(phone);
        return false;
    });
});