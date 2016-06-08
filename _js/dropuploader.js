// drag & drop загрузка файлов
function DropUploader(dropzoneSelector, clickableSelector, inputName) {
    if (!inputName) {
        inputName = 'fileid';
    }
    if (Dropzone.isBrowserSupported()) {

        $j(clickableSelector).click(function(event) {
            event.preventDefault();
        });

        if (!$j(clickableSelector).length) {
            clickableSelector = false;
        }

        if (!$j(dropzoneSelector).length) {
            return false;
        }

        var myDropzone = new Dropzone(dropzoneSelector, {
            url: '/admin/shop/file/upload/ajax/',
            method: 'post',
            uploadMultiple: true,
            clickable: clickableSelector,
            createImageThumbnails: false,
            previewsContainer: false
        });

        // загрузка файла
        myDropzone.on("processing", function(file) {
            $j(clickableSelector).after('<div class="js-uploader-loading">загрузка...</div>');
        });

        // пришел ответ от сервера
        myDropzone.on("success", function(file, response) {
            $j(clickableSelector).next('.js-uploader-loading').remove();

            try {
                // получаем ответ от сервера
                response = JSON.parse(response);
                if (response.result) {
                    for (var i = 0; i < response.result.length; i++) {
                        if (!$j('.js-uploaded-file-' + response.result[i].id).length) {

                            var element = '<div class="js-uploaded-file js-uploaded-file-' + response.result[i].id + '">';
                            element += '<input type="hidden" name="'+inputName+'[]" value="' + response.result[i].id + '" />';
                            element += response.result[i].name;
                            element += '</div>';
                            $j(clickableSelector).after(element);
                        }
                    }
                }

            } catch (_error) {
            }

            return;
        });

        // ошибка во время загрузки
        myDropzone.on("error", function(file, errorMessage) {
            $j(clickableSelector).next('.js-uploader-loading').remove();
            $j(clickableSelector).after('<div class="js-uploader-error">Ошибка загрузки файла. ' + errorMessage + '</div>');
        });
    }
}