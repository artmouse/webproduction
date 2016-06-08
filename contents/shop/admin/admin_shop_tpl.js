$j(window).bind('load', function(){
    $j('.js-wait').fadeOut(300);

    // new messages
    messageFromOldToNew();
});

$j(function() {
    // убирает окно ожидания после 10 сек
    setTimeout(function(){
        $j('.js-wait').fadeOut(300);
    }, 10000);
});

// cookies for filter block
function cookieFromFilterpanel(){
    var ch = [];
    if ($j('.filter-toggle').hasClass("open")){
        ch.push(true);
    }

    $j.cookie("filterpanelCookie", ch.join(','));
}

function cookieToFilterpanel() {
    if ($j.cookie("filterpanelCookie") == null) {
        return;
    }
    var chMap = $j.cookie("filterpanelCookie");
}

function clearCookie() {
    $j.cookie("filterpanelCookie", null);
}

function shopWaitShow (text) {
    if ($j('.js-wait').length) {
        if ($j('.js-wait-text').length) {
            $j('.js-wait-text').text(text);
        }
        $j('.js-wait').fadeIn(300);
    }
}

// табы
$j(window).bind('ready resize', function() {
    fixedTabs();
});

function fixedTabs(){
    if ($j('.js-top-nav-buffer').length) {
        var tabHeigth = $j('.js-top-nav').outerHeight();
        $j('.js-top-nav-buffer').height(tabHeigth);
    }

    sidebarPosition();
}

function sidebarPosition() {
    var bodyHeight = $j('body').height();
    var sidebarPadding = 20;
    var positionTop =  $j('.js-top-nav-buffer').height();
    $j('.nb-right-sidebar').css({'top' : positionTop});
    $j('.nb-right-sidebar .toggle').css({'top' : -positionTop});
    $j('.nb-right-sidebar .inner').height(bodyHeight - positionTop - sidebarPadding);
}

// right sidebar
$j(function() {
    $j('.nb-right-sidebar .toggle').click(function(){
        $j('.nb-right-sidebar').toggleClass('open');
    });
});

$j(function () {
    // убирает окно ожидания, если ошибка
    var removeWaiting = false;
    setTimeout(function(){
        removeWaiting = true;
    }, 7000);
    $j('.js-wait').click(function(){
        if (removeWaiting) {
            $j(this).fadeOut(300);
        }
    });

    // быстрое редактирование для ячеек
    $j('td.quickedit').click(quickedit_start);

    $j('.js-tooltip').tooltipster({
        theme: 'ob-link-tooltip'
    });

    // select
    $j('.chzn-select').select2();

    // tree chzn
    $j('.chzn-select-tree').select2({
        formatResult: chznResultTree
    });

    // radio group
    if ($j('.js-radio-group').length) {
        $j('.js-radio-group label').change(function(){
            radioGroupCheck(this);
        });

        radioGroupCheck();
    }

    function radioGroupCheck(e) {
        $j(e).closest('.js-radio-group').find('label').removeClass('selected');
        $j('.js-radio-group input').each(function(){
            if ($j(this).is(':checked')) {
                $j(this).parent().addClass('selected');

                if ($j(this).parent().hasClass('success')) {
                    $j(this).closest('.js-radio-group').addClass('success');
                } else {
                    $j(this).closest('.js-radio-group').removeClass('success');
                }
            }
        });
    }


    function chznResultTree(item) {
        var datalevel = $j(item.element).data('level');
        return '<span style="display: block; padding-left: '+ datalevel*10 +'px;">'+ item.text +'</span>';
    }

    // инициализация просмотра картинок в комментариях
    if ($j('.js-colorbox-preview').length) {
        $j('.js-colorbox-preview').colorbox({
            rel:'gal',
            maxWidth: '95%',
            maxHeight: '95%',
            current: false,
            photo: true
        });
    }

    // editor init
    if ($j('.js-editor').length) {
        mceInint('.js-editor');
    }

    // ajax select2
    var select2urlDefault = "/admin/shop/users/jsonautocomplete/select2/";
    $j('.js-select2').each(function(i, e) {
        var select2url = $j(this).attr('data-url');
        if (!select2url) {
            select2url = select2urlDefault;
        }

        $j(e).select2({
            minimumInputLength: 0,
            allowClear: true,
            multiple: true,
            ajax: {
                //How long the user has to pause their typing before sending the next request
                quietMillis: 150,
                //The url of the json service
                url: select2url,
                dataType: 'jsonp',
                //Our search term and what page we are on
                data: function (term, page) {
                    return {
                        pageSize: 20,
                        pageNum: page,
                        searchTerm: term,
                        searchin: $j(e).data('type')
                    };
                },
                results: function (data, page) {
                    //Used to determine whether or not there are more results available,
                    //and if requests for more data should be sent in the infinite scrolling
                    var more = (page * 20) < data.Total;
                    return { results: data.Results, more: more };
                }
            }
        });
    });

    $j.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
        'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
        'Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        weekHeader: 'Не',
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        yearRange:"-100:+100"
    };

    $j.datepicker.setDefaults($j.datepicker.regional['ru']);

    // выбор даты
    $j('.js-date').each(function (i, e) {
        var $e = $j(e);
        var format = $e.data('dateformat');
        if (!format) {
            format = 'yy-mm-dd';
        }
        $e.datepicker({
            dateFormat: format,
            changeMonth: true,
            changeYear: true
        });
    });

    // выбор времени
    $j('.js-datetime').each(function (i, e) {
        var $e = $j(e);
        var format = $e.data('dateformat');
        if (!format) {
            format = 'yy-mm-dd';
        }

        $e.datetimepicker({
            dateFormat: format,
            changeMonth: true,
            changeYear: true,
            //showButtonPanel: false,
            timeText: 'Время',
            hourText: 'Час',
            minuteText: 'Минута'
        });
    });

    $j('.js-autosize').autosize();

    cookieToFilterpanel();

    $j('.filter-toggle').click(function(){
        $j('.shop-filter-panel').toggleClass('open');

        $j(this).toggleClass('open');
        $j('.shop-result-list .inner-list').toggleClass('filter-reserve');

        if ($j('.js-slide-tabs').length) {
            setTimeout(function(){
                jsSlidePosition($j('.js-slide-tabs .selected'));
            }, 500);
        }

        setTimeout("cookieFromFilterpanel();", 1000);
    });

    // loading при переходе между страницами
    _beetwingPageLoading();

    _clearCache();

    _loadingAjax();

    // multicheckable checkboxes
    if ($j('.js-checkbox').length) {
        var lastChecked = null;
        var checkboxLevel = 0;
        var $chkboxes = $j('.js-checkbox');
        $chkboxes.click(function(e) {
            checkboxLevel = $j(this).data('level');

            if(!lastChecked) {
                lastChecked = this;
                return;
            };

            if(e.shiftKey) {
                if (checkboxLevel) {
                    $chkboxes = $j('.js-checkbox[data-level="'+checkboxLevel+'"]');
                }
                var start = $chkboxes.index(this);
                var end = $chkboxes.index(lastChecked);
                $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).attr('checked', lastChecked.checked);
                setTimeout(function() {
                    $j('.js-checkbox').change();
                }, 200);

            }

            lastChecked = this;
        });

        if ($j('.js-checkbox').closest('.shop-table').length) {
            var $table = $j('.js-checkbox').closest('.shop-table');
            $table.find('thead td:first-child').html('<input class="js-checkbox-toggle" type="checkbox" name="" />');
        }
    }

    var checkedAll = false;
    $j('.js-checkbox-toggle').click(function(){
        if (checkedAll) {
            $j('.js-checkbox').prop('checked', true);
            $j('.js-checkbox').click();
            checkedAll = false;
            sidebarCheck();

            if ($j('.ob-list-usersthumb-element').length) {
                $j('.ob-list-usersthumb-element').removeClass('selected');
            }
        } else {
            $j('.js-checkbox').prop('checked', false);
            $j('.js-checkbox').click();
            checkedAll = true;
            sidebarCheck();

            if ($j('.ob-list-usersthumb-element').length) {
                $j('.ob-list-usersthumb-element').addClass('selected');
            }
        }
    });

    // сайдбар
    $j('.js-checkbox').change(function(){
        if ($j(this).prop('checked')) {
            $j(this).closest('tr').addClass('row-checked');
        } else {
            $j(this).closest('tr').removeClass('row-checked');
        }
        if ($j('.nb-right-sidebar').length) {
            sidebarCheck();
        }
    });
});
function sidebarCheck() {
    var sidebar = $j('.nb-right-sidebar');
    $j('.js-checkbox').each(function(){
        var attribute = $j(this).attr('checked');
        if (attribute === 'checked') {
            sidebar.removeClass('disable');
            return false;
        } else {
            sidebar.addClass('disable');
        }
    });
}


// автоматический loading div
function _loadingAjax() {
    $j(".js-loader").bind("ajaxSend", function(event, xhr, settings) {
        // для фоновых процессов лоадинг не показываем
        if (settings.background == undefined) {
            $j(this).fadeIn(300);
        }
    }).bind("ajaxComplete", function(event, xhr, settings) {
        // для фоновых процессов лоадинг не показываем
        if (settings.background == undefined) {
            $j(this).fadeOut(300);
        }
    });
};


function _clearCache() {
    // ajax clear cache
    $j('.js-clear-cache').click(function(e){
        popupOpen('.js-cache-confirm');
        //focus on form js-cache-confirm
        $j('.js-cache-clear-yes').focus();
        e.preventDefault();
    });

    //clear cache on Enter button press
    $j('.js-cache-confirm').keypress(function(e){
        if(e.which == 13){
            $j('.js-cache-clear-yes').trigger('click');
        }
    });

    // clear cache: yes
    $j('.js-cache-clear-yes').click(function(e){
        // отменяем проверку на изменения попапа
        $j('.js-cache-confirm').removeClass('js-changed');

        // закрываем попап
        popupClose('.js-cache-confirm');

        $j.ajax({
            url: '/admin/shop/clear/cache/',
            data: {
                thumbnails: $j('.js-cache-image').val()
            },
            dataType: 'json',
            success: function(json) {
                messagePush('Кэш успешно сброшен.', 'success');
                console.log(json.status);
                console.log(json.log);
            }
        });
    });

    // clear cache: no
    $j('.js-cache-clear-no').click(function(event) {
        popupClose('.js-cache-confirm');
        event.preventDefault();
    });
}

function smart_popup_open (id) {
    if (!id) {
        return false;
    }

    if ($j('#js-dynamic-workflow-type-in-menu').val()) {
        $j.get('/admin/customorder/smarty/workflow/', {
            id: id
        }, function(data) {
            if (data) {
                $j('#js-smart-workflow-popup').empty();
                $j('#js-smart-workflow-popup').append(data);
                popupOpen('#js-smart-workflow-popup');
            }
        });
    } else {
        $j.get('/admin/order/smarty/workflow/', {
            id: id
        }, function(data) {
            if (data) {
                $j('#js-smart-workflow-popup').empty();
                $j('#js-smart-workflow-popup').append(data);
                popupOpen('#js-smart-workflow-popup');
            }
        });
    }

}

function smart_issue_close(id, popup) {
    var data = $j('.js-smart-popup-form-' + id).serialize();
    $j('#js-issue-input-statusid').val('');

    if ($j('#js-dynamic-workflow-type-in-menu').val()) {
        $j.ajax({
            url: "/admin/customorder/smarty/workflow/",
            type: 'POST',
            dataType: "json",
            cache: false,
            data: data,
            success: function(data) {
                if (data.issue) {
                    $j('a[data-id='+id+']').replaceWith(data.issue);

                    var $weekElement = $j('.js-by-week a[data-id='+id+']');
                    var $monthElement = $j('.js-by-month a[data-id='+id+']');

                    $weekElement.find('.description').hide();
                    $monthElement.find('.description').hide();

                    messagePush('Изменения сохранены.', 'success');

                    if (data.changeClosed) {
                        if ($weekElement.hasClass('complete')) {
                            $weekElement.appendTo($weekElement.parent());
                        } else {
                            $weekElement.parent().find('.add-element').after($weekElement);
                        }

                        if ($monthElement.hasClass('complete')) {
                            $monthElement.appendTo($monthElement.parent());
                        } else {
                            $monthElement.parent().find('.add-element').after($monthElement);
                        }
                    }

                    // отменяем проверку на изменения попапа
                    $j(popup).removeClass('js-changed');

                    // закрываем попап
                    popupClose(popup);
                } else {
                    messagePush('Произошла ошибка.<br />' + data.error, 'error');
                }
            }
        });
    } else {
        $j.ajax({
            url: "/admin/issue/smart/closed/ajax/",
            type: 'POST',
            dataType: "json",
            cache: false,
            data: data,
            success: function(data) {
                if (data.issue) {
                    $j('a[data-id='+id+']').replaceWith(data.issue);

                    var $weekElement = $j('.js-by-week a[data-id='+id+']');
                    var $monthElement = $j('.js-by-month a[data-id='+id+']');

                    $weekElement.find('.description').hide();
                    $monthElement.find('.description').hide();

                    messagePush('Изменения сохранены.', 'success');

                    if (data.changeClosed) {
                        if ($weekElement.hasClass('complete')) {
                            $weekElement.appendTo($weekElement.parent());
                        } else {
                            $weekElement.parent().find('.add-element').after($weekElement);
                        }

                        if ($monthElement.hasClass('complete')) {
                            $monthElement.appendTo($monthElement.parent());
                        } else {
                            $monthElement.parent().find('.add-element').after($monthElement);
                        }
                    }

                    // отменяем проверку на изменения попапа
                    $j(popup).removeClass('js-changed');

                    // закрываем попап
                    popupClose(popup);
                } else {
                    messagePush('Произошла ошибка.<br />' + data.error, 'error');
                }
            }
        });
    }
}


// loading при переходе между страницами и формами
function _beetwingPageLoading() {
    $j('a').click(function (event) {
        var href = $j(event.target).attr('href');

        if ($j(event.target).prop('tagName') == 'SPAN') {
            if ($j(event.target).closest('a').length) {
                var href = $j(event.target).closest('a').attr('href');
            }
        }

        if (href == '' || href == '#' || href.toLocaleLowerCase().indexOf('javascript') === 0) {
            return;
        }

        if ($j(event.target).attr('target') == '_blank') {
            return;
        }

        if ($j(event.target).is('.select2-container')) {
            return;
        }

        if ($j(event.target).closest('.select2-container').length) {
            return;
        }

        $j('.js-loader').fadeIn(300);
        setTimeout(_beetwingPageLoadingHide, 5000);
    });

    $j('form').submit(function () {
        $j('.js-loader').fadeIn(300);
        setTimeout(_beetwingPageLoadingHide, 5000);
    });
}

function _beetwingPageLoadingHide() {
    $j('.js-loader').fadeOut(300);
}


// быстрое редактирование ячейки
function quickedit_start(event) {
    var $td;

    if (event.target.tagName != 'TD' && event.target.tagName == 'DIV') {  // Если есть внутри DIV
        $td = $j(event.target).parent();
    }else if (event.target.tagName == 'TD') {
        $td = $j(event.target);
    } else {
        return;
    }

    $j.ajax({
        url: '/admin/shop/quickedit/',
        method: 'get',
        data: {
            datasource: $td.data('ds'),
            pkvalue: $td.data('pkv'),
            fieldkey: $td.data('fk')
        },
        success: function(html) {
            // вставляем код
            $td.html(html);

            // определяем элемент контрола
            var $input;
            $input = $td.find('input');
            if (!$input.length) {
                $input = $td.find('select');
            }
            if (!$input.length) {
                $input = $td.find('textarea');
            }

            if ($input.attr('type') == 'checkbox') {
                // вешаем на него обработчик onclick
                $input.click(quickedit_end);
            } else {
                // вешаем на него обработчик onblur
                $input.blur(quickedit_end);
            }

            if ($input.attr('type') == 'text') {
                // вешаем обработчик keydown enter
                $input.keydown(function (eventPress) {
                    var keyCode = eventPress.keyCode || eventPress.which;
                    if (keyCode == 13 || keyCode == 9) {
                        quickedit_end(eventPress);
                    }
                });
            }

            // ставим фокус
            $input.focus();
        },
        error: function() {
            //messagePush('Error loading QuickEdit!', 'error');
        }
    });
}


// завершение редактирования
function quickedit_end(event) {
    var $input = $j(event.target);
    var $td = $input.closest('td');
    var $val = $input.val();
    if ($input.attr('type') == 'checkbox') {
        if ($input.prop("checked")) {
            $val = 1;
        } else {
            $val = 0;
        }
    }

    $j.ajax({
        url: '/admin/shop/quickedit/',
        method: 'get',
        data: {
            datasource: $td.data('ds'),
            pkvalue: $td.data('pkv'),
            fieldkey: $td.data('fk'),
            value: $val
        },
        success: function(html) {
            // вставляем код
            $td.html(html);
        },
        error: function() {
            messagePush('Error loading QuickEdit!', 'error');
        }
    });
}


$j(function() {
    $j('.table-filter thead td').bind("contextmenu",function(e){
        popupOpen('.js-tableview-popup');
        return false;
    });
});


// сообщения
$j(function() {
    $j('.shop-message-success.message-popup, .shop-message-error.message-popup').appendTo('.shop-message-container');
    setTimeout(function(){
        $j(".shop-message-container").fadeOut('slow');
    }, 3000);
});


//tree menu(продукты/страници/...)
$j(function() {
    // tree menu expand
    $j('.js-block-tree .expand').click(function(){
        $j(this).toggleClass('open');
        $j(this).next().slideToggle(300);
    });

    // открытия дерева
    $j('.js-block-tree .selected').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open');
});


// меню тоггл
$j(function() {
    $j('.shop-admin-navi .top-links  a').click(function(){
        if ($j(this).data('name')) {
            $j('.shop-admin-navi .blind .inner').slideUp(300);
            $j('.shop-admin-navi .top-links  a').removeClass('selected');
            if (!$j('.shop-admin-navi .blind').find('.' + $j(this).data('name')).is(':visible')) {
                $j('.shop-admin-navi .blind').find('.' + $j(this).data('name')).slideToggle(300);
                $j(this).toggleClass('selected');
            }
            return false;
        } else {
            $j('.shop-admin-navi .blind .inner').slideUp(300);
            $j('.shop-admin-navi .top-links  a').removeClass('selected');
        }
    });

    $j('.shop-admin-navi .blind a').click(function(){
        $j('.shop-admin-navi .blind .inner').slideUp(300);
        $j('.shop-admin-navi .top-links  a').removeClass('selected');
    });

    $j(document).click(function (event) {
        var $target = $j(event.target);
        if ($target.is('a') || $target.closest('a').length) {
            return;
        }
        if ($target.is('.shop-admin-navi') || $target.is('.shop-admin-navi .top-links')) {
            return;
        }

        $j('.shop-admin-navi').each(function (i, e) {
            if (!$j.contains(e, event.target)) {
                $j('.shop-admin-navi .blind .inner').slideUp(300);
                $j('.shop-admin-navi .top-links  a').removeClass('selected');
            }
        });
    });
});


//search animation
$j(function() {
    $j('.js-search-input').click(function(){
        $j(this).animate({
        'width' : '300px',
        'padding-left' : '30px'
        }, 300);
        $j(this).css({
        'cursor' : 'text'
        });
    });
    $j(document).click(function (event) {
        var $target = $j(event.target);
        if ($target.is('.js-search-input')) {
            return;
        }
        $j('.js-search-input').each(function (i, e) {
            if (!$j.contains(e, event.target)) {
                $j(this).animate({
                'width' : '0',
                'padding-left' : '14px'
                }, 300);
                $j(this).css({
                'cursor' : 'pointer'
                });
            }
        });
    });
});

// custom scrollbar for overflow tables
$j(function() {
    if ((pgwBrowser.os.group == 'Mac OS') || (pgwBrowser.os.group == 'Android') || (pgwBrowser.os.group == 'Windows Phone') || (pgwBrowser.os.group == 'iOS') || (pgwBrowser.os.group == 'BlackBerry')) {
        $j('.shop-overflow-table').css({
        'overflow' : 'auto'
        });
    } else {
        if($j('.shop-overflow-table').length){
            $j('.shop-overflow-table').perfectScrollbar({
                suppressScrollY : true
            });
            perfectScrollposition();
        }
        $j(window).bind('resize scroll', function() {
            if($j('.shop-overflow-table').length){
                perfectScrollposition();
            }
        });
    }
});

function perfectScrollposition(e){
    var psMargin = 55; // отступ скролла снизу
    if ($j('.ob-button-fixed-place').length) {
        psMargin = $j('.ob-button-fixed-place').height() + 20;
    }
    var tablePosition = $j('.shop-overflow-table').position().top;
    var tableHeight = $j('.shop-overflow-table').height();

    if (e) {
        var pagePositionTop = $j(e).scrollTop();
        var psPosition = $j(e).height() - psMargin + pagePositionTop;
    } else {
        var pagePositionTop = $j(window).scrollTop();
        var psPosition = $j(window).height() - psMargin + pagePositionTop - tablePosition;
    }

    if (tableHeight > psPosition) {
        $j('.shop-overflow-table .ps-scrollbar-x-rail').css({
        'top' : psPosition,
        'bottom' : 'auto'
        });
    } else {
        $j('.shop-overflow-table .ps-scrollbar-x-rail').css({
        'top' : 'auto',
        'bottom' : '0'
        });
    }
}

// admin search autocomplete
$j(function () {
    var contentHeight = $j(document).height();

    // fixed header and left column for tables
    $j('.js-table-fixed').each(function (i, table) {
        var height = $j(table).height();

        if (height > contentHeight) {
            height = contentHeight - 300;
        } else {
            height = 'auto';
        }
        var noSort = $j(table).data('nosort');

        try {
            var oTable = $j(table).dataTable({
            "sScrollY": height,
            "sScrollX": "100%",
            //"sScrollXInner": "15%",
            "bScrollCollapse": false,
            "sScrollCollapse": false,
            "bPaginate": false,
            "bInfo": false,
            "bFilter": false,
            "bSort": (noSort ? false:true)
            });

            var cols = $j(table).data('fixedcolumns');
            if (!cols) {
                cols = 1;
            }

            new FixedColumns( oTable, {
                iLeftColumns: cols,
                "iLeftWidth": 250
            });
        } catch (ex) {

        }


        animation('.shop-table tr', 'fade', '30');
    });
});

// filter button
$j(function() {
    $j('.shop-filter-panel input, .shop-filter-panel select').live('change', function() {
        filterButtonPosition(this);
    });
    $j('.shop-filter-panel input').keypress(function() {
        filterButtonPosition(this);
    });
    $j('.shop-filter-panel .select2-choice').click(function() {
        filterButtonPosition(this);
    });
});

function filterButtonPosition(e) {
    var $filterPanel = $j('.shop-filter-panel')
    var $filterButton = $j('.shop-filter-panel .button-orange');
    try {
        //console.log($j(e));
        if ($j(e).hasClass('chzn-select') || $j(e).hasClass('js-select2')) {
            var $element = $j(e).prev();
        } else {
            var $element = $j(e);
        }
        var elementPosition = $element.offset().top + ($element.innerHeight() / 2);
        var buttonPosition = elementPosition - ($filterButton.innerHeight() / 2) - $filterPanel.offset().top;
        $filterButton.addClass('show').css({'top' : buttonPosition});
    } catch(e) {
        return;
    }
}

$j(function() {
    // block rating
    if ($j('.js-block-rating').length) {
        $j('.js-block-rating span').hover(function(){
            var $ratingBlock = $j(this).closest('.ob-block-rating')
            var newValue = $j(this).data('count');
            $ratingBlock.find('.inner').css({'width' : newValue*20+'%'});
        },function(){
            var $ratingBlock = $j(this).closest('.ob-block-rating')
            var currentValue = $ratingBlock.find('input').val();
            $ratingBlock.find('.inner').css({'width' : currentValue*20+'%'});
        });

        $j('.js-block-rating span').click(function(event){
            var $ratingBlock = $j(this).closest('.ob-block-rating');
            var newValue = $j(this).data('count');
            $ratingBlock.find('input').val(newValue);

            // получаем парметры
            var ratingValue = newValue;
            var eventID = $j(event.target).closest('.js-block-rating').data('eventid');

            // отправляем рейтинг на сервер
            $j.ajax({
                url: '/admin/shop/event/rating/',
                data: {
                    eventid: eventID,
                    rating: ratingValue
                }
            });
        });
    }
});

$j(function() {
    $j('.js-fastlink').click(function() {
        $j(this).find('.list').slideToggle(100);
        $j(this).toggleClass('open');
    });

    $j('.js-tags').each(function (i, e) {
        var $ul = $j(e);
        var allowSpaces = false;
        if ($ul.hasClass('js-tags-allow-spaces')) {
            allowSpaces = true;
        }
        $ul.tagit({
            allowSpaces: allowSpaces,
            singleField: true,
            singleFieldNode: $j($ul.data('input'))
        });
    });

    // js textarea row add
    $j('.shop-resizable-textarea .row-add').click(function(){
        var tArea = $j(this).prev('textarea');
        tArea.trigger('autosize.destroy');
        var rowValue = tArea.attr('rows');
        rowValue = parseInt(rowValue) + 1;
        tArea.attr('rows', rowValue);
        tArea.autosize();
        return false;
    });
});

// открыть окно для написания емейла
function box_email_popup_open(to, subject, content, attachmentArray, sendDate) {
    popupOpen('.js-letteradd-popup');

    $j('#js-mail-to').focus();

    if (to != null) {
        $j('#js-mail-to').val(to);
        $j('#js-mail-subject').focus();
    }

    if (subject != null) {
        $j('#js-mail-subject').val(subject);
        $j('#js-mail-content').focus();
    }

    if (content != null) {
        $j('#js-mail-content').val(content);
        $j('#js-mail-content').caretToStart();
    }

    if (sendDate != null) {
        $j('#js-mail-send-date').val(sendDate);
        $j('#js-mail-send-date').focus();
    } else {
        var today = new Date();
        $j('#js-mail-send-date').attr('placeholder', $j.datepicker.formatDate('yy-mm-dd', today));
    }

    if (attachmentArray != null) {
        var $ac = $j('.js-letteradd-attachment-container');

        $j(attachmentArray).each(function (i, e) {
            $ac.append('<input type="checkbox" class="js-mail-attachfile" name="attachfile[]" value="'+e.hash+';'+e.type+';'+e.name+'" checked /> '+e.name+'<br>');
        });
    }

    // @todo
    //$j('#js-mail-content').autosize();

    return false;
}

// закрыть окно для написания емейла
function box_email_popup_close() {
    popupClose('.js-letteradd-popup');
    $j('#js-mail-to').val('');
    $j('#js-mail-subject').val('');
    $j('#js-mail-content').val('');
    $j('#js-mail-send-date').val('');
    return false;
}

// Отправка email
$j(function() {
    $j('#js-mail-send').click(function(){


        $j('#letterhtml').change(function(){
            if($j(this).attr('checked')){
                $j(this).val('1');
            } else {
                $j(this).val('0');
            }
        });

        var email = $j('#js-mail-to').val();
        var subject = $j('#js-mail-subject').val();
        var sendDate = $j('#js-mail-send-date').val();
        var content = $j('#js-mail-content').val();
        var from = $j('#js-mail-from').val();
        var letterhtml = $j('#letterhtml').val();
        var files = $j('#js-mail-files').get(0).files;
        var data = new FormData();
        $j.each(files, function(key, value) {
            data.append(key, value);
        });
        data.append('email', email);
        data.append('subject', subject);
        data.append('sendDate', sendDate);
        data.append('content', content);
        data.append('from', from);
        data.append('letterhtml', letterhtml);

        $j('.js-mail-attachfile').each(function (i, e) {
            data.append('attachfile[]', $j(e).val());
        });

        if (!email) {
            messagePush('Заполните, пожалуйста, адрес получателя.', 'error');
            return;
        }

        if (!subject && !content) {
            messagePush('Заполните, пожалуйста, тему или содержимое письма.', 'error');
            return;
        }

        // ajax send
        $j.ajax({
            url: "/admin/shop/sendemail/ajax/",
            type: 'POST',
            dataType: "json",
            cache: false,
            data: data,
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(result, textStatus, jqXHR) {
                if (result.status == 'success') {
                    messagePush('Ваше сообщение успешно отправлено.', 'success');

                    // отменяем проверку на изменения попапа
                    $j('.js-letteradd-popup').removeClass('js-changed');

                    // закрываем попап
                    box_email_popup_close();
                } else {
                    messagePush('Произошла ошибка.', 'error');
                }
            }
        });
    });

});

// Отправка email для smart issue
function send_email_smart (id) {
    var email = $j('#js-mail-to-'+id).val();
    var subject = $j('#js-mail-subject-'+id).val();
    var sendDate = $j('#js-mail-send-date-'+id).val();
    var content = $j('#js-mail-content-'+id).val();
    var files = $j('#js-mail-file-'+id).get(0).files;

    var data = new FormData();
    $j.each(files, function(key, value) {
        data.append(key, value);
    });
    data.append('email', email);
    data.append('subject', subject);
    data.append('sendDate', sendDate);
    data.append('content', content);

    $j('.js-mail-attachfile').each(function (i, e) {
        data.append('attachfile[]', $j(e).val());
    });

    if (!email || !subject || !content) {
        smart_issue_close(id, '.js-smart-email-popup');
    } else {
        // ajax send
        $j.ajax({
            url: "/admin/shop/sendemail/ajax/",
            type: 'POST',
            dataType: "json",
            cache: false,
            data: data,
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(result, textStatus, jqXHR) {
                if (result.status == 'success') {
                    messagePush('Ваше сообщение успешно отправлено.', 'success');
                    smart_issue_close(id, '.js-smart-email-popup');
                } else {
                    messagePush('Произошла ошибка.', 'error');
                }
            }
        });
    }


}

// открыть окно для написания sms
function sms_popup_open(to, content) {
    popupOpen('.js-smsadd-popup');

    $j('#js-sms-to').focus();

    if (to != null) {
        $j('#js-sms-to').val(to);
    }

    if (content != null) {
        $j('#js-sms-content').val(content);
    }

    return false;
}

// закрыть окно для написания sms
function sms_popup_close() {
    popupClose('.js-smsadd-popup');
    $j('#js-sms-to').val('');
    $j('#js-sms-content').val('');
    return false;
}

// Отправка sms
$j(function() {
    $j('#js-sms-send').click(function(){
        var sms = $j('#js-sms-to').val();
        var content = $j('#js-sms-content').val();

        if (!sms) {
            messagePush('Заполните, пожалуйста, телефон получателя.', 'error');
            return;
        }
        if (!content) {
            messagePush('Заполните, пожалуйста, содержимое письма.', 'error');
            return;
        }

        // ajax send
        $j.ajax({
            url: "/admin/shop/sendsms/ajax/",
            type: 'POST',
            data: {
                sms: sms,
                content: content
            },
            success: function(data) {
                if (data) {
                    messagePush('Ваше сообщение успешно отправлено.', 'success');
                    $j('#js-sms-to').val('');
                    $j('#js-sms-content').val('');

                    // отменяем проверку на изменения попапа
                    $j('.js-smsadd-popup').removeClass('js-changed');

                    // закрываем попап
                    popupClose('.js-smsadd-popup');
                } else {
                    messagePush('Произошла ошибка.', 'error');
                }
            }
        });
    });

});

//phone formating
$j(function() {
    $j('.js-phone-formatter').mask("+9 (9999) 999-99-99");
});

// Создание задачи
$j(function() {
    $j('#js-issue-create').click(function() {

        var name = $j('#js-issue-name').val();
        var process = $j('#js-issue-process').val();
        var assigned = $j('#js-issue-assigned').val();
        var content = $j('#js-issue-content').val();
        var project = $j('#js-issue-type').val();

        if ( name && process && assigned && project ) {
            $j.ajax({
                url: "/admin/shop/createissue/ajax/add",
                dataType: "json",
                data:{
                    assigned: assigned,
                    name: name,
                    process: process,
                    content: content,
                    project: project
                },

                success: function( result ) {
                    if (result.status == 'success') {
                        messagePush('Ваша задача успешно создана.', 'success');
                        $j('#js-issue-name').val('');
                        $j('#js-issue-process').val('');
                        $j('#js-issue-assigned').val('');
                        $j('#js-issue-content').val('');
                        $j('#js-issue-type').val('');
                        $j('.js-issueadd-popup').fadeToggle(300);
                    } else {
                        messagePush('Произошла ошибка.', 'error');
                    }
                }

            });
        } else {
            messagePush('Заполните, пожалуйста, поля: название задачи, бизнес-процесс, на кого назначена и проект.', 'error');
        }

    });

});

// Automatically cancel unfinished ajax requests
// when the user navigates elsewhere.
(function($) {
    var xhrPool = [];
    $(document).ajaxSend(function(e, jqXHR, options){
        xhrPool.push(jqXHR);
    });
    $(document).ajaxComplete(function(e, jqXHR, options) {
        xhrPool = $.grep(xhrPool, function(x){return x!=jqXHR});
    });

    var abort = function() {
        $.each(xhrPool, function(idx, jqXHR) {
            jqXHR.abort();
        });
    };

    var oldbeforeunload = window.onbeforeunload;
    window.onbeforeunload = function() {
        var r = oldbeforeunload ? oldbeforeunload() : undefined;
        if (r == undefined) {
            // only cancel requests if there is no prompt to stay on the page
            // if there is a prompt, it will likely give the requests enough time to finish
            abort();
        }
        return r;
    }
})(jQuery);

function company_autocomplete($input) {
    $input.autocomplete({
        delay: 500,
        source: function( request, response ) {
            $j.ajax({
                url: "/search/companyautocomplete/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        var result = name = '';

                        result = item.name;
                        var name = item.name;

                        return {
                            label: name,
                            value: result
                        }
                    }));
                }
            });
        }
    });
}

function contact_autocomplete($input, type) {
    if (type == undefined) {
        type = 'email';
    }

    $input.autocomplete({
        source: function( request, response ) {
            $j.ajax({
                url: "/admin/contact/autocomplete/",
                dataType: "json",
                data:{
                    name: request.term,
                    type: type
                },
                success: function( data ) {
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        var result = item.value;
                        var name = item.name + ' - '+item.value;

                        return {
                            label: name,
                            value: result
                        }
                    }));
                }
            });
        }
    }).data('ui-autocomplete')._renderItem = function (ul, item) {
        ul.removeClass().addClass("ob-autocomplete");
        var inner_html = item.label;
        return $j( "<li></li>" )
        .data( "item.autocomplete", item )
        .append(inner_html)
        .appendTo( ul );
    };
}

function source_autocomplete($input) {
    $input.autocomplete({
        source: function( request, response ) {
            $j.ajax({
                url: "/admin/source/autocomplete/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        var result = item.value;
                        var name = item.name + ' - '+item.value;

                        return {
                            label: name,
                            value: result
                        }
                    }));
                }
            });
        }
    }).data('ui-autocomplete')._renderItem = function (ul, item) {
        ul.removeClass().addClass("ob-autocomplete");
        var inner_html = item.label;
        return $j( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
    };
}

function recommend_init() {
    var query = '';
    $j('#id-recomended-name').autocomplete({
        delay: 500,
        source: function( request, response ) {
            query = request.term;
            $j.ajax({
                url: "/admin/shop/users/ajax/autocomplete/select2/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        name = item.name;
                        return {
                            id: item.id,
                            label: name,
                            value: name
                        }
                    }));
                }
            });
        },
        select: function (event, ui) {
            $j('#id-recomended-value').val(ui.item.id);
        },
        minLength:3
    }).data('ui-autocomplete')._renderItem = function (ul, item) {
        ul.removeClass().addClass("ob-autocomplete");
        var inner_html = '<span>'+item.label+'</span>';
        if (item.id === 0) {
            inner_html = '<span class="ob-link-add ob-link-dashed">'+item.label+'</span>';
            return $j( "<li onclick='addUserInSelectWindow(\""+query+"\")'></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
        } else {
            return $j( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
        }


    };


    $j('#id-recomended').click(function(e){
        selectwindow_init('w2', 'id-recomended-name', 'id-recomended-value', {
            usersearch: true,
            useradd: true
        });
        e.preventDefault();
    });

    if ($j('#id-delete-recomended').length) {
        $j('#id-delete-recomended').click(function (event) {
            $j('#id-recomended-name').val('');
            $j('#id-recomended-value').val('0');
            event.preventDefault();
        });
    }
}

function addUserInSelectWindow (name) {
    selectwindow_init('w2', 'id-recomended-name', 'id-recomended-value', {
        usersearch: true,
        useradd: true,
        selectedTab:1,
        userAddDefault:name
    });

}

function htmlspecialchars (str) {
    if (typeof(str) == "string") {
        str = str.replace(/&/g, "&amp;"); /* must do &amp; first */
        str = str.replace(/"/g, '\\"');
        str = str.replace(/'/g, "&#039;");
    }
    return str;
}

function htmlspecialchars_decode (str) {
    if (typeof(str) == "string") {
        str = str.replace(/&amp;/g, "&"); /* must do &amp; first */
        str = str.replace(/&quot;/g, '\"');
        str = str.replace(/&#039;/g, "'");
    }
    return str;
}

$j(function() {
    if ($j('#js-mail-to').length){
        contact_autocomplete($j('#js-mail-to'), 'email');  
    }
    
    // mail
    $j(document).on('click', '.js-email-write', function (event) {
        var email = $j(event.target).data('email');
        box_email_popup_open(email);
        return false;
    });

    // всплывающие подсказки (Клиенты)
    var cacheContactPreviewArray = new Array;
    $j(document).on('hover', '.js-contact-preview', function () {
        var element = $j(this);
        var position = false;
        element.addClass('js-hovered');
        if (element.hasClass('js-preview-bottom')) {
            position = 'bottom';
        } else {
            position = 'right';
        }
        element.tooltipster({
            theme: 'ob-block-preview',
            interactive: true,
            contentAsHTML: true,
            position: position,
            minWidth: 350,
            maxWidth: 500,
            offsetY: 0,
            onlyOne: true,
            content: '<div class="loading">Загрузка...</div>',
            updateAnimation: false,
            functionBefore: function (origin, continueTooltip) {
                setTimeout(function(){
                    if (element.hasClass('js-hovered')) {
                        continueTooltip();
                    }
                }, 1000);

                var contactID = $j(this).data('id');

                if (cacheContactPreviewArray[contactID] == null) {
                    // получаем данные
                    $j.get('/admin/contact/preview/', {
                        id: contactID
                    }, function(data) {
                        if (!data) {
                            element.tooltipster('hide');
                        }
                        origin.tooltipster('content', data);
                        cacheContactPreviewArray[contactID] = data;
                    });
                } else {
                    // берем из кеша
                    origin.tooltipster('content', cacheContactPreviewArray[contactID]);
                    if (!cacheContactPreviewArray[contactID]) {
                        element.tooltipster('hide');
                    }
                }
            }
        });

        setTimeout(function(){
            if (element.hasClass('js-hovered')) {
                element.tooltipster('show');
            }
        }, 1000);
    });
    $j(document).on('mouseleave', '.js-contact-preview', function () {
        var element = $j(this);
        element.removeClass('js-hovered');
    });

    // всплывающие подсказки (Продукты)
    var cacheProductPreviewArray = new Array;
    $j(document).on('hover', '.js-product-preview', function () {
        var element = $j(this);
        element.addClass('js-hovered');
        element.tooltipster({
            theme: 'ob-block-preview',
            interactive: true,
            contentAsHTML: true,
            position: 'right',
            minWidth: 350,
            maxWidth: 500,
            offsetY: 0,
            onlyOne: true,
            content: '<div class="loading">Загрузка...</div>',
            updateAnimation: false,
            functionBefore: function (origin, continueTooltip) {
                setTimeout(function(){
                    if (element.hasClass('js-hovered')) {
                        continueTooltip();
                    }
                }, 1000);

                var productID = $j(this).data('id');

                // получаем данные
                $j.get('/admin/product/preview/', {
                    id: productID
                }, function(data) {
                    if (!data) {
                        element.tooltipster('hide');
                    }
                    origin.tooltipster('content', data);
                    cacheProductPreviewArray[productID] = data;
                });
            }
        });

        setTimeout(function(){
            if (element.hasClass('js-hovered')) {
                element.tooltipster('show');
            }
        }, 1000);
    });
    $j(document).on('click', '.js-product-preview-click', function () {
        var element = $j(this);
        element.addClass('js-hovered');
        element.tooltipster({
            theme: 'ob-block-preview',
            interactive: true,
            contentAsHTML: true,
            position: 'right',
            minWidth: 350,
            maxWidth: 500,
            offsetY: 0,
            onlyOne: true,
            trigger: 'click',
            content: '<div class="loading">Загрузка...</div>',
            updateAnimation: false,
            functionBefore: function (origin, continueTooltip) {
                setTimeout(function(){
                    if (element.hasClass('js-hovered')) {
                        continueTooltip();
                    }
                }, 1000);

                var productID = $j(this).data('id');

                // получаем данные
                $j.get('/admin/product/preview/', {
                    id: productID
                }, function(data) {
                    if (!data) {
                        element.tooltipster('hide');
                    }
                    origin.tooltipster('content', data);
                    cacheProductPreviewArray[productID] = data;
                });
            }
        });

        setTimeout(function(){
            if (element.hasClass('js-hovered')) {
                element.tooltipster('show');
            }
        }, 1000);
    });
    $j(document).on('mouseleave', '.js-product-preview', function () {
        var element = $j(this);
        element.removeClass('js-hovered');
    });

    // всплывающие подсказки (Задачи)
    var cacheIssuePreviewArray = new Array;
    $j(document).on('hover', '.js-issue-preview', function () {
        var element = $j(this);
        element.addClass('js-hovered');
        element.tooltipster({
            theme: 'ob-block-preview',
            interactive: true,
            contentAsHTML: true,
            position: 'right',
            minWidth: 350,
            maxWidth: 500,
            offsetY: 0,
            onlyOne: true,
            content: '<div class="loading">Загрузка...</div>',
            updateAnimation: false,
            functionBefore: function (origin, continueTooltip) {
                setTimeout(function(){
                    if (element.hasClass('js-hovered')) {
                        continueTooltip();
                    }
                }, 1000);

                var contactID = $j(this).data('id');

                if (cacheIssuePreviewArray[contactID] == null) {
                    // получаем данные
                    $j.get('/admin/issue/preview/', {
                        id: contactID
                    }, function(data) {
                        if (!data) {
                            element.tooltipster('hide');
                        }
                        origin.tooltipster('content', data);
                        cacheIssuePreviewArray[contactID] = data;
                    });
                } else {
                    // берем из кеша
                    origin.tooltipster('content', cacheIssuePreviewArray[contactID]);
                    if (!cacheIssuePreviewArray[contactID]) {
                        element.tooltipster('hide');
                    }
                }
            }
        });

        setTimeout(function(){
            if (element.hasClass('js-hovered')) {
                element.tooltipster('show');
            }
        }, 1000);
    });

    $j(document).on('mouseleave', '.js-issue-preview', function () {
        var element = $j(this);
        element.removeClass('js-hovered');
    });

    $j(document).on('focus', '.js-usertextcomplete', function (event) {
        $textarea = $j(event.target);

        if ($textarea.data('textcomplete') == 'ok') {
            return;
        }

        $textarea.data('textcomplete', 'ok');

        $textarea.textcomplete([{
            mentions: $j.parseJSON($j('.js-usertextcomplete-mentions').html()),
            match: /\B@([\w\а-я]*)$/i,
            search: function (term, callback) {
                term = term.toLowerCase();
                callback($j.map(this.mentions, function (mention) {
                    return mention.toLowerCase().indexOf(term) >= 0 ? mention : null;
                }));
            },
            index: 1,
            replace: function (mention) {
                return '[' + mention.split(',')[0] + " #"+mention.split('#')[1]  + '] ';
            }
        }
        ], { appendTo: 'body' });
    });
});

$j(function() {
    $j(window).load (function() {
        var $formsButtons = $j('input[name="formsUpdate"], input[name="formsInsert"], input[name="formsDelete"]');
        $formsButtons.wrapAll("<div class='ob-button-fixed'></div>");
        if ($formsButtons.length) {
            $j('.ob-button-fixed').after("<div class='ob-button-fixed-place'></div>");
        }
        $formsButtons.addClass('ob-button');
        $j('input[name="formsUpdate"]').addClass('button-green');
    });
});

$j(function() {
    dataGroupInit('');
});

function dataGroupInit(parentSelector) {
    if (parentSelector) {
        parentSelector = parentSelector + ' ';
    }

    // data block edit
    $j(parentSelector + '.js-data-element').each(function(){
        var $this = $j(this);
        $this.find('.ob-link-edit, .ob-link-delete').click(function(){
            $j('.js-data-element .data-edit').removeClass('current');
            $this.find('.data-edit').fadeToggle(300).toggleClass('current');
            return false;
        });
        $this.find('.ob-link-edit').click(function(){
            $this.find('input, select, textarea').slice(0, 1).focus();
            $this.find('input[type="file"]').click();
            setTimeout(function(){
                $this.find('.chzn-select, .chzn-select-tree').slice(0, 1).select2('open');
            }, 100);
        });
        $this.find('.ob-link-accept').click(function(){
            $this.closest('form').submit();
            return false;
        });
    });

    ////group block hide empty lines
    $j(parentSelector + '.js-data-group .data-view').each(function(){
        var dataView = $j(this).html().trim();
        if (dataView == '') {
            $j(this).closest('.element').addClass('empty');
        }
    });

    //group block edit
    $j(parentSelector + '.js-data-group').each(function(){
        var $this = $j(this);
        $this.find('.ob-link-edit, .ob-link-delete').click(function(){
            $this.find('.data-view, .data-edit').slideToggle(300);
            $this.find('.ob-link-edit, .ob-link-delete, .ob-link-accept').toggle();
            $this.find('.empty').toggleClass('empty-temp');
            return false;
        });
        $this.find('.ob-link-accept').click(function(){
            $this.closest('form').submit();
            return false;
        });
    });

    $j(parentSelector + '.js-data-element .el-value, ' + parentSelector + '.js-data-element .el-caption').each(function(){
        if (!$j(this).closest('.js-noquickedit').length) {
            $j(this).wrapInner("<span class='js-text'></span>");
        }
    });

    // data block edit - click anywhere
    $j(parentSelector + '.js-data-element .js-text, ' + parentSelector + '.js-data-element .js-text>span, ' + parentSelector + '.js-data-element .js-text>img').click(function (event) {
        var $target = $j(event.target);

        if ($target.is('select') || $target.is('a') || $target.is('textarea')) {
            return;
        }

        $j(this).each(function (i, e) {
            if (!$j.contains(e, event.target)) {
                $j(e).closest('.ob-data-element').find('.ob-link-edit').slice(0, 1).click();
                if ($j(e).closest('.ob-data-element').find('.ob-link-edit').length) {
                    $j(e).closest('.ob-data-element').find('input, select, textarea').focus();
                    $j(e).closest('.ob-data-element').find('input[type="file"]').click();
                    setTimeout(function(){
                        $j(e).closest('.ob-data-element').find('.chzn-select, .chzn-select-tree').slice(0, 1).select2('open');
                    }, 100);
                }
            }
        });
    });

    $j(parentSelector + '.js-data-group .data-view, ' + parentSelector + '.js-data-group .el-caption').each(function(){
        $j(this).wrapInner("<span class='js-text'></span>");
    });

    // data group block edit - click anywhere
    $j(parentSelector + '.js-data-group .js-text, ' + parentSelector + '.js-data-group .js-text>span').click(function (event) {
        var $target = $j(event.target);
        if ($target.is('a') || $target.is('select') || $target.is('textarea')) {
            return;
        }

        $j(this).each(function (i, e) {
            if (!$j.contains(e, event.target)) {
                $j(e).closest('.js-data-group').find('.ob-link-edit').click();

                $j(e).closest('.element').find('.data-edit input, .data-edit select, .data-edit textarea').slice(0, 1).focus();
            }
        });
    });
}

//coupon formating
$j(function() {
    $j('.js-coupon-formatter').mask("****-****-****-****");
});

$j.widget( "custom.catcomplete", $j.ui.autocomplete, {
    _create: function() {
        this._super();
        this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
    },
    _renderMenu: function( ul, items ) {
        ul.removeClass().addClass('ob-autocomplete');
        var that = this,
        currentCategory = "";
        $j.each( items, function( index, item ) {
            var li;
            if ( item.category != currentCategory ) {
                ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                currentCategory = item.category;
            }
            li = that._renderItemData( ul, item );
            if ( item.category ) {
                li.attr( "aria-label", item.category + " : " + item.label );
            }
        });
    }
});

$j(function() {
    $j( "#search-input" ).catcomplete({
        delay: 500,
        source: function( request, response ) {
            $j.ajax({
                url: "/admin/shop/search/ajax/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data=='badLen') return false;
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        var url = group = name = '';

                        url = item.url;
                        name = item.name;
                        group = item.group;
                        category = item.category;

                        return {
                            label: name,
                            url: url,
                            category: category
                        }
                    }));
                }
            });
        },
        select: function( event, ui ) {
            window.location.href = ui.item.url;
        }
    });
});

//ctrl+enter submit fork
function ctrlEnter(event, currentForm) {
    if((event.ctrlKey) && ((event.keyCode == 0xA)||(event.keyCode == 0xD))) {
        $j(currentForm).find('.js-form-submit').click();
    }
}

// animation
function animation(target, effect, amount) {
    var $element = $j(target);
    if (effect == 'blind') {
        if (amount) {
            $element.slice(0, amount).css({'opacity' : '0', 'right' : '-1920px'});
        } else {
            $element.css({'opacity' : '0', 'right' : '-1920px'});
        }

        $element.each(function(index){
            $j(this).delay(75*index).animate({'opacity' : '1', 'right' : '0'}, 300, function(){
                $j(this).addClass('done');
            });
        });
    } else if (effect == 'blind-calendar') {
        $element.css({'opacity' : '0', 'bottom' : '-1920px'});

        $element.parent('.day').each(function(){
            $j(this).find('.day-element').each(function(index){
                $j(this).delay(175*index).animate({'opacity' : '1', 'bottom' : '0'}, 300, function(){
                    $j(this).addClass('done');
                });
            });
        });
    } else if (effect == 'blind-calendar-fast') {
        $element.css({'opacity' : '0', 'bottom' : '-500px'});

        $element.parent('.day').each(function(){
            $j(this).find('.day-element').each(function(index){
                $j(this).delay(75*index).animate({'opacity' : '1', 'bottom' : '0'}, 300, function(){
                    $j(this).addClass('done');
                });
            });
        });
    } else if (effect == 'blind-search') {
        if (amount) {
            $element.slice(0, amount).css({'opacity' : '0', 'right' : '-1920px'});
        } else {
            $element.css({'opacity' : '0', 'right' : '-1920px'});
        }

        $element.parent('.column').each(function(){
            $j(this).find('.element').each(function(index){
                $j(this).delay(75*index).animate({'opacity' : '1', 'right' : '0'}, 300, function(){
                    $j(this).addClass('done');
                });
            });
        });
    } else if (effect == 'fade') {
        if (amount) {
            $element.slice(0, amount).css({'opacity' : '0'});
        } else {
            $element.css({'opacity' : '0'});
        }

        $element.each(function(index){
            $j(this).delay(75*index).animate({'opacity' : '1'}, 300, function(){
                $j(this).addClass('done');
            });
        });
    }
}

// добавить продукт в корзину
/*
function shop_basket_load_product(productID, productCount, deleted) {
if (productID == undefined) {
return false;
}
if (productCount == undefined) {
productCount = 1;
}

$j.ajax({
url: "/ajax/basket/",
dataType: "json",
data: {
productid: productID,
productcount: productCount,
deleted: deleted
},
success: function (data) {
if (deleted) {
$j('#outBasket').hide();
$j('#inBasket').show();
} else {
$j('#inBasket').hide();
$j('#outBasket').show();
}

}
});
}
*/

// попап os-popup-block open
function popupOpen(e) {
    $j("body").addClass('no-scroll');
    $j(e).show();
    var popupBlock = $j(e).find('.popupblock');
    var popupHeight = popupBlock.height();
    $j('.shop-block-popup').removeClass('current');
    $j(e).addClass('current');
    //popupBlock.addClass('open');
    popupBlock.css({
        'top' : - popupHeight
    });
    popupBlock.animate({
        'top': 0
    }, 300);
}

// попап os-popup-block close
function popupClose(e) {
    // разфокус для заполненных полей
    $j(e).find('.close').focus();

    // проверка на заполненые поля
    if ($j(e).hasClass('js-changed')) {
        if (confirm('Вы точно хотите закрыть форму?')) {
            popupCloseActions($j(e));
            $j(e).removeClass('js-changed');
        } else {
            return false;
        }
    }
    popupCloseActions($j(e));
}

function popupCloseActions(e){
    var popupBlock = $j(e).find('.popupblock');
    var popupHeight = popupBlock.height();
    var popupTopPadding = 100;
    //popupBlock.removeClass('open');
    popupBlock.animate({
        'top': - popupHeight - popupTopPadding
    }, 300);
    setTimeout(function(){
        $j(e).hide().removeClass('current');
        $j("body").removeClass('no-scroll');
    }, 300);
}

// esc для закрытия текущего попапа
$j(document).on('keyup', function(e) {
    if (e.keyCode == 27) {
        $j('body').find('.shop-block-popup').each(function(){
            if ($j(this).is(':visible')) {
                if ($j(this).hasClass('js-selectwindow')) {
                    return false;
                }
                // разфокус для заполненных полей
                $j(this).find('.close').focus();
                if ($j(this).hasClass('js-changed')) {
                    if (confirm('Вы точно хотите закрыть форму?')) {
                        popupClose($j(this));
                        $j(this).removeClass('js-changed');
                    } else {
                        return false;
                    }
                }
                popupClose($j(this));
            }
        });
    }
});

$j(function() {
    // проверка на заполненные поля в попапах
    $j('.shop-block-popup input, .shop-block-popup select, .shop-block-popup textarea').on('change', function(){
        $j(this).closest('.shop-block-popup').addClass('js-changed');
    });
});

// новые сообщения success/error
function messagePush(text, type) {
    if (type == 'success') {
        var $element = $j('.js-success');
        messageHide($j('.js-error'));
    } else {
        var $element = $j('.js-error');
        messageHide($j('.js-success'));
    }

    $element.fadeIn(300);
    $element.find('.text').html(text);
    $element.addClass('go');

    if (type == 'success') {
        setTimeout(function(){
            messageHide($element);
        }, 5000);
    }

    $element.click(function(){
        messageHide(this);
    });
}

function messageHide(e) {
    $j(e).addClass('out');
    setTimeout(function(){
        $j(e).removeClass('go out').hide();
    }, 500);
}

// переход со старых на новые сообщения
function messageFromOldToNew() {
    if ($j('.forms-message-ok').length) {
        $j('.forms-message-ok').addClass('shop-message-success');
    }
    if ($j('.forms-message-error').length) {
        $j('.forms-message-error').addClass('shop-message-error');
    }

    if ($j('.shop-message-success').length || $j('.shop-message-error').length) {
        $j('.shop-message-success, .shop-message-error').each(function(){
            if ($j(this).hasClass('visible')) {
                return;
            } else {
                var text = $j(this).html();
                $j(this).remove();
                if ($j(this).hasClass('shop-message-success')) {
                    messagePush(text, 'success');
                } else {
                    messagePush(text, 'error');
                }
            }
        });
    }
}

function shop_product_barcode(url) {
    window.open(url, 'barcode');
    //window.open(url, 'barcode', "width=400, height=300, toolbar=no, titlebar=no, menubar=no");
}

// slide tabs
$j(function() {
    $j('.js-slide-tabs a').click(function(){
        $j(this).closest('.js-slide-tabs').find('a').removeClass('selected');
        $j(this).addClass('selected');
        jsSlidePosition(this);
        return false;
    });
});

$j(window).bind('ready resize', function(){
    if ($j('.js-slide-tabs').length) {
        $j('.js-slide-tabs').each(function(){
            jsSlidePosition($j(this).find('.selected'));
        });
    }
});

function jsSlidePosition(e) {
    var left = $j(e).position().left;
    var top = $j(e).position().top;
    var width = $j(e).innerWidth();

    $j(e).closest('.js-slide-tabs').find('.hover').css({
        'left' : left,
        'top' : top,
        'width' : width
    });
}

function filterOpen() {
    $j(window).bind('load', function(){
        if (!$j('.filter-toggle').hasClass('open')) {
            setTimeout(function(){
                $j('.filter-toggle').click();
            }, 1000);
        }
    });
}

// istruction cookie
function cookieFromInstruction(){
    var ch = '';
    if ($j.cookie("instructionCookie")) {
        ch = $j.cookie("instructionCookie");
    }

    var currentId = $j('.js-block-instruction').data('workflow');

    if ($j('.js-block-instruction').is(":visible")){
        var deleteValue = currentId + '';
    } else {
        ch += ','+currentId;
    }
    ch = ch.split(',');
    ch = unique(ch);
    delete ch[ch.indexOf(deleteValue)];
    ch.join(',');

    $j.cookie("instructionCookie", ch, { expires: 7, path: '/'});
}

function cookieToInstruction() {
    if ($j.cookie("instructionCookie") == null) {
        return;
    }
    var chMap = $j.cookie("instructionCookie");
    chMap = chMap.split(',');
    for (var i = 0; i < chMap.length; i++) {
        $j('.js-block-instruction[data-workflow="'+ chMap[i] +'"]').hide();
    }
}

function unique(arr) {
    var result = [];

    nextInput:
        for (var i = 0; i < arr.length; i++) {
            var str = arr[i]; // для каждого элемента
            for (var j = 0; j < result.length; j++) { // ищем, был ли он уже?
                if (result[j] == str) continue nextInput; // если да, то следующий
            }
            result.push(str);
        }

    return result;
}



// сохранение введенных данных в текстовое поле после перезагрузки страницы
$j(window).load(function(){
    $j(document).on('change', '.js-field-localstorage', function(){
        if ($j('.js-smart-simple-popup').is(':visible')) {
            return;
        }
        var val = $j(this).val();
        var data = $j(this).data('storage');
        var name = location.href +'-'+ data;

        form_hendler(name, val);
    });

    form_data();

    $j('.js-clear-localstorage').click(function(){
        $j('.js-field-localstorage').each(function(){
            var data = $j(this).data('storage');
            localStorage.removeItem(location.href +'-'+ data);
        })
    });
});

function form_hendler($name, $val){
    localStorage.setItem($name, $val);
}

function form_data(){
    if ($j('.js-field-localstorage').length) {
        $j('.js-field-localstorage').each(function(){
            var data = $j(this).data('storage');
            var val = localStorage.getItem(location.href +'-'+ data);
            $j(this).val(val);
        })
    }
}

// mce editor init
function mceInint($selector, $styles) {
    if (!$styles) {
        // если не указаны стили, юзаем дефолтные
        $styles = '/contents/shop/admin/admin_shop_tpl.css'
    }
    tinymce.init({
        selector: $selector,
        content_css : $styles,
        language : "ru",
        relative_urls: false,
        plugins: "code print table link image hr media fullscreen jbimages",
        menubar: false,
        toolbar : "code fullscreen print | undo redo | styleselect | bullist numlist outdent indent | link image jbimages media table hr",
    });
}

// fixed buttons height fix
$j(window).bind('load ready resize', function(){
    if ($j('.ob-button-fixed').length) {
        // reinit fixed block
        $j('.ob-button-fixed').addClass('reinit').removeClass('reinit');

        // height fix
        $j('.ob-button-fixed').each(function(){
            if ($j(this).is(':visible')) {
                $j('.ob-button-fixed-place').height($j(this).innerHeight());
            }
        });
    }
});

$j(function(){
    // скролл в вертикальном меню
    $j('.js-scroll-wrap, .js-notify-scroll-block').perfectScrollbar({
        minScrollbarLength: 20
    });

    // Тогл в меню
    $j('.js-menu-toggle').on('click', function(){
        var $menuElement = $j(this).closest('li');
        var $subMenu = $menuElement.find('.sub-nav');

        $menuElement.toggleClass('selected');
        if ($subMenu.length) {
            $subMenu.slideToggle(300);
            return false;
        }
    });

    // убираем мышь, - схлопываем раскрытые меню и скролим верх блока
    $j('.nb-block-menuvertical').on('mouseleave', function(){
        $j('.sub-nav').slideUp(300);
        $j('.nb-asidenav-drop > li').removeClass('selected');

        setTimeout(function(){
            $j('.js-scroll-wrap .ps-scrollbar-y-rail, .js-scroll-wrap .ps-scrollbar-y').attr('style', '');
            $j('.js-scroll-wrap').perfectScrollbar('update');
            $j('.js-scroll-wrap').scrollTop(0);
        },400);
    });

    // быстрый поиск по вертикальному меню
    $j('.js-search-helper').keyup(function() {
        jQueryFilter.categorySearch('.js-search-line', this);
        $j('.js-search-line').find('.sub-nav').slideDown(300);
    });

    // hover disable when body scroll
    var body = document.body,
        timer;

    window.addEventListener('scroll', function() {
        clearTimeout(timer);
        if(!body.classList.contains('disable-hover')) {
            body.classList.add('disable-hover')
        }

        timer = setTimeout(function(){
            body.classList.remove('disable-hover')
        }, 500);
    }, false);
});