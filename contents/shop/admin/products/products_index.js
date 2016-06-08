//cookies for folder view
$j(function() {
    $j('.js-folder-type a').click(function(){
        if($j(this).hasClass('line')) {
            $j('.shop-productexplorer-list').addClass('line');
        } else {
            $j('.shop-productexplorer-list').removeClass('line');
        }
    });
});

function cookieFromFolderview(){
    var ch = [];
    if($j('.js-folder-type .selected').hasClass("line")){
        ch.push(true);
    }

    $j.cookie("folderviewCookie", ch.join(','));
    //alert(ch);
}

function cookieToFolderview(){
    if($j.cookie("folderviewCookie") == null){
        return;
    }
    var chMap = $j.cookie("folderviewCookie");

    if (chMap == 'true') {
        $j('.js-folder-type a').removeClass('selected');
        $j('.js-folder-type .line').addClass('selected');
        $j('.js-folder-type .line').click();
    }
}

$j(function() {
    cookieToFolderview();

    $j(".js-folder-type a").click(function(){
        setTimeout("cookieFromFolderview();", 500);
    });
});


$j(function() {
    // инициализируем событие нажатия клавиши
    $j('input#id_search').keyup(function() {
        $j('.js-block-tree ul').show();
        $j('.js-block-tree .expand').addClass('open');
        jQueryFilter.categorySearch('.js-block-tree li', this);
    });
});

$j(function () {
    $j('barcode').focus();
    $j('.js-checkbox').change(function () {
        var ids = '';

        $j('.js-checkbox').each(function (i, e) {
            if (e.checked) {
                ids += $j(e).val();
                ids += ',';
                $j(this).closest('.element').addClass('selected');
            } else {
                $j(this).closest('.element').removeClass('selected');
            }
        });

        $j('#id-category').val(ids);
    });

    // показывать, скрывать удаленные или скрытые товары
    if ( $j('.js-show-products').length ){
        $j('.js-show-products').click( function(){
            if ($j(this).is(':checked')) {
                $j(this).val(1);
            } else {
                $j(this).val(0);
            }
        });
    }
});

$j(function(){
    $j('.js-draggable').mouseup(function(){
        var dropOn = $j('.droppable-hover');// элемент на который бросаем
        var movable = $j(this); // элемент который перетаскиваем
        if (dropOn.length && movable.length){
            var isProduct = 0; // Для определения того что перетаскиваем (Категорию или продукт)
            if (movable.hasClass("js-draggable-product")){
                isProduct = 1;
            }
            $j(movable).hide('slow');
            var droponId = dropOn.attr('js-data-id');
            var mevedId = movable.attr('js-data-id');
            if ( isProduct == 1 || droponId != mevedId ){
                $j.ajax({
                    url: '/admin/shop/manage/products/ajax/',
                    data: {
                        dropOnId: droponId,
                        movedId: mevedId,
                        isProduct: isProduct
                    },
                    dataType: 'json',
                    success: function(json) {
                        movable.remove();
                        // если перетаскивали категорию
                        if ( isProduct == 0) {
                            rebuildCategoryTree();
                            // добавляем возможность кидать элементы на меню
                            setTimeout(function () {
                                $j('.js-block-tree .item').droppable({
                                    activeClass: "droppable",
                                    hoverClass: "droppable-hover"
                                });
                            }, 1000);
                        }
                    },
                    error: function(err, msg) {
                        console.log(msg);
                    }
                });
            }
        }
    });
});

function rebuildCategoryTree() {
    // id текущей категории
    var categoryid = $j("#js-open-category-id").attr('category-id');
    $j.ajax({
        url: '/admin/shop/rebuild/categorytree/',
        data :{
            categoryid: categoryid
        },
        dataType: 'json',
        success: function( json ) {
            $j(".js-block-tree").empty();
            $j(".js-block-tree").html(json.html);

            // menu expand
            $j('.js-block-tree .expand').click(function(){
                $j(this).toggleClass('open');
                $j(this).next().slideToggle(300);
            });

            // открытия дерева
            $j('.js-block-tree .selected').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open').closest('ul').show().prev().toggleClass('open');
        },
        error: function( data, error, errrDet ) {

        }
    });
}

$j(function () {
    $j('.js-checkbox').each(function (i, checkbox) {
        $j(checkbox).click(function() {
            recalculate_checkbox();
        });
    });
});

// пересчитываем checkboxы
function recalculate_checkbox() {
    var s = '';
    $j('.js-checkbox').each(function (i, checkbox) {
        if (checkbox.checked) {
            s += checkbox.value;
            s += ',';
        }
    });

    $j('#id-checkboxes').val(s);

    if (s != '') {
        $j('#id-form-delete').show();
    } else {
        $j('#id-form-delete').hide();
    }
}

// добавление новой категории
$j(function() {

    $j('.js-add-new-category').click(function() {

        var categoryName = prompt('Введите имя новой категории');

        if (categoryName != null) {

            var parentID = $j(this).attr('js-data-id');

            $j.ajax({
                url: '/admin/add/new/category/ajax/',
                data: {
                    name: categoryName,
                    parentID: parentID
                },
                dataType: 'json',
                success: function(result) {
                    if (result == 'ok') {
                        location.reload();
                    }
                }
            })
        }
        return false;
    })
});

$j(function() {
    // управление таблицей с клавиатуры
    var table = new HotKeyTable('.shop-productexplorer-list', '.js-product-preview', 'selected', function($table, $row) {
        $j('html, body').animate({
            scrollTop: ($row.position().top - 150)
        }, 100);
    });
});
