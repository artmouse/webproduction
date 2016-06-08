$j(window).on('load', function(){
    dropZoneMinHeight();
});


function dropZoneMinHeight(){
    // подстраиваем дропзону по высоте aside блока, сделано
    // функией, что б можно было рефрешить по ивенту, если надо
    $j('.js-form-block').css({
        "min-height": $j('.ob-grid-control .control').innerHeight() - $j('.js-caption-height').innerHeight()
    });
}

$j(function () {
    $j(document).on('click', '.js-block-delete', function (event) {
        $j(this).closest('.js-block-element').remove();
    });
});

$j(function () {
    // Добавляем иконку удаления
    $j('.js-block-zone .js-block-element').prepend($j('#js-button-delete').html());
});

$j(function() {
    // быстрый поиск
    $j('.js-block-helper').keyup(function() {
        jQueryFilter.categorySearch('.js-block-list .block-element', this);
    });
});

$j(function() {
    $j( ".js-block-list div" ).draggable({
        //appendTo: "body",
        helper: "clone"
    });




    var $index = Number($j('#js-index-count').val());
    $j($j(".js-droppable"), $j(".js-block-element")).droppable({
        helper: "clone",
        accept: ":not(.ui-sortable-helper)",
        drop: function( event, ui ){
            $index = $index + 1;
            var elem = ui.draggable;
            // правый блок с выводом формы
            $j.ajax({
                url: '/admin/workflow/actionblock/ajax/',
                data: {
                    contentId: elem.data('content'),
                    index: $index,
                    statusid: $j('#js-status-id').val()
                },
                dataType: 'json',
                success: function(data) {
                    $j('.js-form-block').append(data.html);
                    // Добавляем иконку удаления

                    $j('.js-form-block .js-block-element[data-index='+data.index+']').prepend($j('#js-button-delete').html());
                }
            });
        }
    }).sortable({
        items: ".js-block-element",
        handle: ".js-handele",
        axis: "y"
    });
});

$j(function () {
    $j('#js-form').submit(function () {
        var arr = [];
        $j('.temp-content').each(function (i, elem) {
            var index = 0;
            $j(elem).children('.js-block-element').each(function (i2, elem2) {
                index++;
                arr[index] = $j(elem2).data('index');
            });

        });
        $j('#js-block-value').val(JSON.stringify(arr));
    });
});

/*var myDropzone = new DropUploader('.js-droppable-zone', '.js-uploader');
myDropzone.on("drop", function(file) {
    alert('1');
});*/
