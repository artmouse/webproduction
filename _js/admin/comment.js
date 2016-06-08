function initCommentBlock() {
    $j('.js-comments-type a').click(function(){
        var currentType = $j(this).data('type');
        if (currentType) {
            $j('.js-item-comment, .js-item-document, .js-item-change, .js-item-notify, .js-item-email, .js-item-sms, .js-item-call').each(function(){
                var $this = $j(this);
                setTimeout(function(){
                    if ($this.hasClass('js-item-' + currentType)) {
                        $this.slideDown(300);
                    } else {
                        $this.slideUp(300);
                    }
                }, 300);
            });
        } else {
            setTimeout(function(){
                $j('.js-item-comment, .js-item-document, .js-item-change, .js-item-notify, .js-item-email, .js-item-sms, .js-item-call').slideDown(300);
            }, 300);
        }
    });

    // скрываем таб, если нет контента
    if (!$j('.js-item-comment').length) {
        $j('.js-comments-type a[data-type="comment"]').parent().remove();
    }

    if (!$j('.js-item-change').length) {
        $j('.js-comments-type a[data-type="change"]').parent().remove();
    }

    if (!$j('.js-item-notify').length) {
        $j('.js-comments-type a[data-type="notify"]').parent().remove();
    }

    if (!$j('.js-item-email').length) {
        $j('.js-comments-type a[data-type="email"]').parent().remove();
    }

    if (!$j('.js-item-sms').length) {
        $j('.js-comments-type a[data-type="sms"]').parent().remove();
    }

    if (!$j('.js-item-call').length) {
        $j('.js-comments-type a[data-type="call"]').parent().remove();
    }

    if (!$j('.js-item-document').length) {
        $j('.js-comments-type a[data-type="document"]').parent().remove();
    }
    // скрываем табы, если меньше 3 табов
    if (($j('.js-comments-type a').length) < 3) {
        $j('.js-comments-type').hide();
    }

    // notification value toggle
    var confirmMessageShow = true;
    $j('.js-notify-value-toggle').change(function(){
        if (confirmMessageShow) {
            var clickConfirm = confirm('Вы уверены что хотите отправить комментарий клиенту? Отменить операцию будет невозможно.');
            if (clickConfirm) {
                $j(this).next('.js-notify-value').toggle();
                confirmMessageShow = false;
            } else {
                $j(this).find('input').removeAttr('checked');
            }
        } else {
            $j(this).next('.js-notify-value').toggle();
            confirmMessageShow = true;
        }
    });

    // разворачивание коммента
    $j('#js-postcomment').focus(function(){
        $j(this).addClass('open');
    });

    // добавление code
    $j('.js-add-codetag').click(function(){
        var tArea = $j(this).closest('.area-wrap').find('textarea');
        tArea.val(tArea.val() + '[code][/code]');
        tArea.focus().selectRange(tArea.val().length - 7);
        return false;
    });

    $j.fn.selectRange = function(start, end) {
        if(typeof end === 'undefined') {
            end = start;
        }
        return this.each(function() {
            if('selectionStart' in this) {
                this.selectionStart = start;
                this.selectionEnd = end;
            } else if(this.setSelectionRange) {
                this.setSelectionRange(start, end);
            } else if(this.createTextRange) {
                var range = this.createTextRange();
                range.collapse(true);
                range.moveEnd('character', end);
                range.moveStart('character', start);
                range.select();
            }
        });
    };

    // Редактирование, удаление комментариев
    if ( $j('.js-edit-message').length ){

        $j('.js-edit-message').click(function(){
            var popupButton =  $j('.js-edit-comment');
            var popupTitle =  $j('.js-popup-title');
            var popupTextarea =  $j('.js-edit-comment-text');

            // параметры для кнопки редактирования, удаления
            var id = $j(this).attr('data-id');
            var action = $j(this).attr('data-action');
            popupButton.attr('data-id',id);
            popupButton.attr('data-action',action);

            // готовим попап для удаления или редактирования
            if ( action == 'edit' ) {
                popupButton.val('Редактировать');
                popupTitle.text('Редактировать сообщение');
                popupTextarea.removeAttr('disabled');
            } else {
                popupButton.val('Удалить');
                popupTitle.text('Удалить сообщение');
                popupTextarea.attr('disabled','');
            }

            var text = $j('.js-comment-content-original[data-id="' + id + '"]').html(); // получаем текст сообщения

            popupTextarea.val(text);

            popupOpen('.js-edit-message-popup');
            popupTextarea.trigger('autosize.resize');
            return false;
        });
    }

    if ( $j('.js-edit-comment').length ){
        $j('.js-edit-comment').click( function(){

            $j.ajax({
                url: '/admin/shop/edit-comment/ajax/',
                type: 'post',
                data: {
                    id: $j(this).attr('data-id'),
                    action: $j(this).attr('data-action'),
                    text: $j('.js-edit-comment-text').val() // textarea, текст сообщения
                },
                dataType:'json',
                success: function(json){
                    if (json.status == 'success') {
                        $j('#js-text-' + json.id).html(json.content);
                        $j('#js-text-' + json.id + ' .js-toggle-image').click(function(){
                            var $img = $j(this).next().find('img');

                            if (!$img.attr('src')) {
                                var src = $img.attr('data-src');
                                $img.attr('src', src);
                                $j(this).next().css('dispalay', 'block');
                            } else {
                                $j(this).next().slideToggle();
                            }
                        });

                        $j('.js-comment-content-original[data-id="' + json.id + '"]').text(json.text);

                        if (json.text == 'Сообщение удалено') {
                            $j('a[data-id=' + json.id + ']').hide(); // скрываем кнопки для удаления редактирования
                        }
                    }

                    // отменяем проверку на изменения попапа
                    $j('.js-edit-message-popup').removeClass('js-changed');

                    // закрываем попап
                    popupClose('.js-edit-message-popup');
                }
            })
        })
    }

    if ($j('.js-quote-message').length) {
        // цитирование

        $j('.js-quote-message').click(function(event){
            event.preventDefault();
            event.stopPropagation();

            var id = $j(this).attr('data-id');

            // получаем текст сообщения
            var text = $j('#js-postcomment').val();
            if (text) {
                text = text + "\n";
            }

            // имя автора
            if ($j('.js-comment-author-' + id).length) {
                var authorName = $j('.js-comment-author-' + id).text();
                text = text + authorName + ' писал(а):';
                text = text + "\n";
            }

            // получаем текст цитаты
            var quote = $j('.js-comment-content-original[data-id="' + id + '"]').html();
            var quoteArray = quote.split("\n");
            for (var i = 0; i < quoteArray.length; i++) {
                text = text + quoteArray[i];
                text = text + "\n";
            }
            if (text.match('[quote]') && text.match('[/quote]')) {
                text = text.replace('[quote]', '');
                text = text.replace('[/quote]', '');
                text = "[quote]" +text + "[/quote]\n";
            } else {
                text = "[quote]" +text + "[/quote]\n";
            }
            
            $j('#js-postcomment').focus().val('').val(text).trigger('autosize.resize');
            $j('#js-postcomment').trigger('change');            
        });
    }

    $j('.js-comment-tabs a').click(function() {
        var currentHover = $j('.js-comment-tabs .hover').attr('style');
        $j('.js-comment-tabs .selected').addClass('js-selected');
        var type = $j(this).data('name');
        if (type == 'letter') {
            if (!confirm('Письмо отправится клиенту и это нельзя будет отменить.')) {
                setTimeout(function(){
                    $j('.js-comment-tabs a').removeClass('selected');
                    $j('.js-comment-tabs .js-selected').addClass('selected').removeClass('js-selected');
                    $j('.js-comment-tabs .hover').attr('style', currentHover);
                }, 200);
                return false;
            }
        } else if (type == 'sms') {
            if (!confirm('SMS отправится клиенту и это нельзя будет отменить.')) {
                setTimeout(function(){
                    $j('.js-comment-tabs a').removeClass('selected');
                    $j('.js-comment-tabs .js-selected').addClass('selected').removeClass('js-selected');
                    $j('.js-comment-tabs .hover').attr('style', currentHover);
                }, 200);
                return false;
            }
        } else if (type == 'forms') {
            $j('.ob-block-attach').hide();
            if (!confirm('Форма отправится клиенту и это нельзя будет отменить.')) {
                setTimeout(function(){
                    $j('.js-comment-tabs a').removeClass('selected');
                    $j('.js-comment-tabs .js-selected').addClass('selected').removeClass('js-selected');
                    $j('.js-comment-tabs .hover').attr('style', currentHover);
                }, 200);
                return false;
            }
        }

        if (type == 'issue') {
            $j('.js-template-cell').hide();
        } else {
            $j('.js-template-cell').show();
        }

        $j('.js-order-comment-letter-div, .js-order-comment-sms-div, .js-order-comment-forms-div, .js-order-comment-letter-div').hide();
        if ($j(this).data('name')) {
            $j('#js-comment-type').val($j(this).data('name'));
            $j('.js-order-comment-'+$j(this).data('name')+'-div').show();
        }
        $j('.js-comment-tabs .js-selected').removeClass('js-selected');
    });

    // загрузка файлов
    var uploader = new DropUploader('.js-droppable-zone', '.js-uploader');
}
