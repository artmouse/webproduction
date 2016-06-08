$j(function () {
    // подстановка формулы при выборе категории
    $j('#js-category').change(product_category_select);

    // система скрытия/раскрытия блоков
    var element = $j('.shop-toggle-block');
    var ToggleMas = new Array(); // создаем масив который по деволту сожержит открытые состояния (false - блок открыт)
    for(var k=0; k < element.length; k++ ){
        ToggleMas[k] = 'false';
    }

    var cookie = $j.cookie('switcher'); // считываем куки
    // если куки пришли делаем след операции
    if(cookie) {
        var cookieMas =cookie.split(","); // создаем масив с пришедших куки (строка - масив)
        //  устанавливаем открытые - закрытые блоки согласно куки
        for(var i = 0; i < cookieMas.length; i++ ){
            ToggleMas[i] = cookieMas[i]; // заполняем дефолтный  масив даными куки
            if(cookieMas[i] == 'true'){
                $j(element[i]).find('.toggle').addClass('close');
                $j(element[i]).find('.block').hide();
            }else{
                $j(element[i]).find('.toggle').removeClass('close');
                $j(element[i]).find('.block').show();
            }
        }

    }

    // обработчик клик
    $j('.shop-toggle-block .toggle').click(function() {
        var toggleElement = $j('.shop-toggle-block ').has(this); // текеущий блок по котором нажали
        var index = toggleElement.index(); // индекс елемента
        $j(toggleElement).find('.block').animate({
        'height' : 'toggle'
        });

        if ($j(this).is('.close')) {
            $j(this).removeClass('close');
            ToggleMas[index] = 'false';

        } else {
            $j(this).addClass('close');
            ToggleMas[index] = 'true';

        }
        $j.cookie('switcher', ToggleMas); // запись в куки
        return false;
    });

    // file uploaded (ajax)
    var productID = $j('.js-productid').val();

    if ($j('#file_upload').length) {
        $j('#file_upload').uploadify({
            swf           : '/media/uploadify/uploadify.swf',
            uploader      : '/admin/shop/uplodify/',
            buttonText    : 'Загрузить',
            'onUploadSuccess' : function(file, data, response) {
                if (data != 'Не коректный фаил.' && data != 'Изображение слишком велико.') {
                    $j.ajax({
                        url: '/admin/shop/products/imageupload/',
                        type:'GET',
                        data: {
                            file: data,
                            id: productID
                        },
                        success: function(imageid) {
                            var inpupimages = '<input value="/media/shop/'+data+'" type="hidden" name="images[]"></input>';
                            $j('#image').append('<div class="item">'+inpupimages+'<img src="/media/shop/'+data+'" width="202" alt="" /><br /><label><input type="checkbox" name="deleteimage[]" value="'+imageid+'" /> Удалить</label></div>');
                        },
                        fail: function() {},
                        always: function() {}
                    });
                } else {
                    $j('#image').append('<div>'+data+'</div>');
                }
            }
        });
    }


    $j('.js-preview').click(function(e) {
        window.open($j(this).data('href'), '_blank');
    });

    // при вставке значения в характеристики - автоматически ставить
    // галочки рядом
    $j('.features input:text').focus(function(){
        $j(this).parent().parent().find('.js-feature-autoselect').attr('checked', 'checked');
    });
});

// подстановка формулы
function product_category_select(event) {
    var categoryID = $j(event.target).val();
    var $container = $j('.js-formula');

    // загружаем формулу
    $j.ajax({
        url: '/admin/shop/product/nameformula/',
        method: 'get',
        data: {
            categoryid: categoryID
            // name: name
        },
        success: function(html) {
            if (html) {
                // вставляем блок
                $container.html(html);
            }
        },
        error: function() {
            alert('Error loading product name formula!');
        }
    });

    // выбираем категорию из списка ниже
    $j('#id-category').val(categoryID);

    return false;
}

$j('.add-filter').click(function() {
    $('#hide-layout, #popup').fadeIn(300);  // плавно показываем окно/фон
})

function filter_add_popup(sel) {
    if($j(sel).val()=="-1"){

        $j('.js-add-filter-popup').show();

        // и центрируем по центру
        $j('.js-add-filter-popup').css({
            position: 'absolute',
            left: ($j(window).width() - $j('.js-add-filter-popup').width())/2,
            top: $j(document).scrollTop() +($j(window).height()-$j('.js-add-filter-popup').height())/2
        });
    }
//    console.log($j(sel).val());

}

