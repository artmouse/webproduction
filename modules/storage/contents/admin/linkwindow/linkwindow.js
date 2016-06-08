function linkwindow_init(windowID, inputName, objectID) {
    var $inputName = $j('#'+inputName);

    // если окно уже есть - пропускаем
    if ($j('#'+windowID).length) {
        return;
    }

    // загружаем окно
    $j.ajax({
        url: '/admin/shop/storage/linkwindow/',
        type: 'post',
        data: {
            objectid: objectID,
            windowID: windowID
        },
        success: function(html) {
            // вставляем окно в конец body
            $j('body').append(html);

            linkwindow_process(windowID, $inputName, objectID);
        },
        fail: function() {
            alert('Error loading selectwindow');
        }
    });
}

function linkwindow_update(windowID, $inputName, objectID) {
    $j.ajax({
        url: '/admin/shop/storage/linkwindow/',
        type: 'post',
        data: {
            objectid: objectID,
            windowID: windowID
        },
        success: function(html) {
            // обновляем окно
            $j('#'+windowID).remove();
            $j('body').append(html);

            linkwindow_process(windowID, $inputName, objectID);
        },
        fail: function() {
            alert('Error loading selectwindow');
        }
    });
}

var message_added = '<div class="shop-message-success">Товар привязан.</div>';
var message_deleted = '<div class="shop-message-success">Привязка удалена.</div>';

function linkwindow_process(windowID, $inputName, objectID) {
    // инициализируем все что нужно для работы окна:

    // кнопка закрытия окна
    $j('#'+windowID+'-close').click(function (event) {
        $j('#'+windowID).remove();

        event.preventDefault();
    });

    try {
        // кнопка добавить привязку
        $j('#'+windowID+'-link-add-button').click(function (event) {
            shop_storage_link_add(
            $j('#'+windowID+'-link-form').serialize() + '&objectid=' +objectID,
            function (json) {
                linkwindow_update(windowID, $inputName, objectID);
                $j('#' + windowID + '-message').append(message_added);

                // обновляем количество привязанного товара
                $inputName.html(json.amount);
            });
        });
    } catch (e) {

    }

    try {
        // ссылки удалить привязку
        $j('.'+windowID+'-link-delete').each(function (e) {
            $j(this).click(function (event) {
                var $id = $j(this).prev('input').val();

                shop_storage_link_delete({
                    linkid: $id
                },
                function (json) {
                    linkwindow_update(windowID, $inputName, objectID);
                    $j('#' + windowID + '-message').append(message_deleted);

                    // обновляем количество привязанного товара
                    $inputName.html(json.amount);
                });
            });
        });
    } catch (e) {

    }
}