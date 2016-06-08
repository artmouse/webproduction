$j(function() {
    updateNotificationList();

    // нажатие на крестик
    $j('.js-notification-list').click(function(event) {
        if ($j(event.target).is('.js-notification-close')) {
            event.preventDefault();

            var orderID = $j(event.target).data('id');
            var commentCount = $j(event.target).data('count');
            var $block = $j(event.target).parent('.js-notification-element');

            $j.ajax({
                url: '/admin/notification/close/',
                type: "POST",
                data: {
                    id: orderID
                },
                dataType : "json",
                success: function (data, textStatus) {
                    if (!data.error) {
                        $block.remove();

                        var notificationCount = parseInt($j('.js-notification-count').slice(0,1).text());
                        notificationCount = notificationCount - 1;
                        if (notificationCount < 0) {
                            notificationCount = 0;
                        }

                        $j('.js-notification-count').html(notificationCount);
                        if (notificationCount == '0') {
                            $j('.js-notification-count').removeClass('alert');
                            $j('.js-notification-list').removeClass('enable');
                            $j('body').removeClass('blured-notification');
                            $j('.js-notification-toggle').addClass('js-empty');
                            $j('.js-wrap-notification').hide();
                        }

                        updateNotificationCount();
                    }
                }
            });
        }
    });

    userID = $j('.js-current-user-id').text();


    // scroll to event group on stat clicking
    var $root = $j('.js-notify-scroll-block');
    $j('.js-stat-element').on('click',function(e) {
        var eldata = $j(this).data('href'),
            elTo = $j('#'+eldata);

        if($j(elTo).length){
            if($j(e.target).hasClass('active')) {
                e.stopPropagation();
            } else {
                var offsetVal = $j(elTo).offset().top;

                $root.animate({
                    scrollTop: offsetVal - $root.offset().top + $root.scrollTop()
                }, 0);

                $j('.js-stat-element').removeClass('active');
                $j(e.target).addClass('active');
            }
        }
    });
});


function deleteNotificationAll() {
    var del = confirm("Точно хотите удалить все уведомления?");

    if (del) {
        $j.ajax({
            url: '/admin/notification/close/',
            type: "POST",
            data: {
                all: 1
            },
            dataType : "json",
            success: function (data) {
                updateNotificationList();
            }
        });
    }

}

var userID;

function updateNotificationList() {
    if (!userID) {
        userID = $j('.js-current-user-id').text();
    }

    $j.ajax({
        url: '/media/notification/notification-' + userID + '.json',
        type: "GET",
        cache: false,
        dataType : "json",
        success: function (data, textStatus) {
            if (data && data.notificationList) {
                var str = data.notificationList;
                var count = (str.split('js-notification-element').length - 1);

                if (count > 0) {
                    $j('.js-notification-list .js-notify-scroll-block').empty();
                    $j('.js-notification-list .js-notify-scroll-block').html('').html(data.notificationList);
                } else {
                    $j('.js-notification-count').removeClass('alert');
                    $j('.js-notification-list').removeClass('enable');
                    $j('body').removeClass('blured-notification');
                    $j('.js-notification-toggle').addClass('js-empty');
                    $j('.js-wrap-notification').hide();

                    $j('.js-notification-list .js-notify-scroll-block').empty();
                    $j('.js-notification-list .js-notify-scroll-block').html('')
                }
            }
            updateNotificationCount();
        },
        error: function () {
            updateNotificationCount();
        }
    });

    setTimeout(updateNotificationList, 60000);
}

function updateNotificationCount() {
    var count = $j('.js-notification-element').length;

    $j('.js-notification-count').html('').html(count);

    if (count > 0) {
        $j('.js-notification-toggle').removeClass('js-empty');
        $j('.js-notification-count').addClass('alert');
    } else {
        $j('.js-notification-toggle').addClass('js-empty');
        $j('.js-notification-count').removeClass('alert');
    }

    $j('.js-stat-element').each(function (i, elem) {
        var data_href = $j(elem).data('href');
        var count2 = Number($j('#'+data_href).parent().find('.js-notification-element').length);
        $j('[data-href-count='+data_href+']').text(count2);
    });
}