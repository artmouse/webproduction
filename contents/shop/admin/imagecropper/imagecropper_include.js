var widthDiv;
var heightDiv;
var widthImage;
var heightImage;

$j(function () {
    if ($j('#file_upload_crop').length) {
        $j('#file_upload_crop').uploadify({
            swf           : '/media/uploadify/uploadify.swf',
            uploader      : '/imagecropper/upload/ajax/',
            buttonText    : 'Загрузить',
            multi         : false,
            'onUploadSuccess' : function(file, data, response) {
                if (data != 'Не коректный файл.' && data != 'Изображение слишком велико.' && data != 'Изображение слишком мало.') {
                    data = $j.parseJSON(data);
                    $j('.js-cropper').html(
                        '<img src="'+data.src+'" alt="" />'
                    );

                    widthDiv = data.widthdiv;
                    heightDiv = data.heightdiv;
                    widthImage = data.width;
                    heightImage = data.height;

                    $j('#imagecropper-name').val(data.filename);
                    $j('#big-image-main').val(data.filename);
                    $j('#imagecropper-ext').val(data.ext);
                    $j('#imagecropper-x1').val(0);
                    $j('#imagecropper-y1').val(0);
                    $j('#imagecropper-x2').val(widthDiv);
                    $j('#imagecropper-y2').val(heightDiv);
                    $j('#imagecropper-koef').val(data.koef);

                    if ($j('.js-imagecropper-enable').length) {
                        var aspectRatio = data.cropWidth+':'+data.cropHeight;
                    } else {
                        var aspectRatio = false;
                    }
                } else {
                    $j('.js-cropper').append('<div>'+data+'</div>');
                }
                popupOpen('.js-croper-popup');

                $j('.js-cropper > img').cropper({
                    aspectRatio: 1 / 1,
                    autoCropArea: 3,
                    guides: true,
                    highlight: false,
                    dragCrop: false,
                    movable: false,
                    resizable: false,
                    crop: function(data) {
                        $j('#imagecropper-x1').val(data.x);
                        $j('#imagecropper-y1').val(data.y);
                        $j('#imagecropper-x2').val(data.width);
                        $j('#imagecropper-y2').val(data.height);
                    }
                });

                $j('.js-cropper-zoomin').click(function(){
                    $j('.js-cropper > img').cropper('zoom', 0.1);
                    return false;
                });

                $j('.js-cropper-zoomout').click(function(){
                    $j('.js-cropper > img').cropper('zoom', -0.1);
                    return false;
                });
            }
        });
    }
});

function preview(img, selection) {
    var scaleX = widthDiv / (selection.width || 1);
    var scaleY = heightDiv / (selection.height || 1);

    $j('#imagecropper-cropimage + div > img').css({
        width: Math.round(scaleX * widthImage) + 'px',
        height: Math.round(scaleY * heightImage) + 'px',
        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
}