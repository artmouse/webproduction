$j(function() {
    company_autocomplete($j('#id-company'));
    post_autocomplete($j('#js-field-post'));

    if ($j('#id-recomended-name').length) {
        recommend_init();
    }

    // поиск дубликатов при вводе имени
    $j(".js-search-dublicates").keyup(function(){
        var namelast = $j("[name=namelast]").val();
        var name = $j("[name=name]").val();
        var result = false;
        var searchBlock = $j('.js-name-duplicate');
        if (searchBlock.length){
            searchBlock.empty();
            setTimeout(function() {
                if (namelast.length) {
                    searchDublicatesByNameAndNameLast(name, namelast);
                } else if (name.length) {
                    searchDublicatesByName(name);
                }
            }, 500);
        }
    });

    // поиск дубликатов при вводе email
    $j(".js-search-dublicates-email").keyup(function(){
        var email = $j("[name=emails]").val();

        var result = false;
        var searchBlock = $j('.js-email-duplicate');
        if (searchBlock.length){
            searchBlock.empty();

            if (email.length > 4){
                setTimeout(searchDublicatesByEmail(email), 500);
            }
        }
    });

    // поиск дубликатов при вводе phone
    $j(".js-search-dublicates-phones").keyup(function() {
        var phone = $j("[name=phones]").val();

        var result = false;
        var searchBlock = $j('.js-phones-duplicate');
        if (searchBlock.length) {
            searchBlock.empty();

            setTimeout(function () {
                if (phone.length >= 4) {
                    searchDublicatesByPhone(phone);
                    console.log(phone);
                }
            }, 500);
        }
    });

    // выбор компании tag it + autocomplete
    $j('#js-company-tag').each(function (i, e) {
        var $ul = $j(e);
        $ul.tagit({
            singleField: true,
            singleFieldNode: $j($ul.data('input')),
            placeholderText: 'Компания',
            allowSpaces: true,
            autocomplete: {
                delay: 500,
                minLength: 2,
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
                    })
                }
            }
        });
    });

    if ($j('#js-company-tag').length) {
        tagCompany();
    }

});

$j(function () {
    $j('.js-typesex').click(function () {
        var data = $j(this).val();

        if (data && data !=0) {
            $j('#js-typesex-input').val(data);
        } else {
            $j('#js-typesex-input').val($j('#js-type-sex').val());
        }
        $j('#js-typesex-input').change();
    });

});

function searchDublicatesByName(name ){
    $j.ajax({
        url: '/admin/shop/users/search/dublicates/name/',
        data: {
            name: name
        },
        dataType: 'json',
        success: function( data ) {
            //alert( "Прибыли данные name: " + data );
            echoDublicateResult(data);
        }
    });
}

function searchDublicatesByEmail(email){
    $j.ajax({
        url: '/admin/shop/users/search/dublicates/email/',
        data: {
            email: email
        },
        dataType: 'json',
        success: function( data ) {
            //alert( "Прибыли данные email: " + print_r(data) );
            echoDublicateResultEmail(data);
        }
    });
}

function searchDublicatesByPhone(phone){
    $j.ajax({
        url: '/admin/shop/users/search/dublicates/phone/',
        data: {
            phone: phone
        },
        dataType: 'json',
        success: function( data ) {

            echoDublicateResultPhone(data);
        }
    });
}

function searchDublicatesByNameAndNameLast(name, namelast) {
    $j.ajax({
        url: '/admin/shop/users/search/dublicates/namesurname/',
        data: {
            name: name,
            namelast: namelast
        },
        dataType: 'json',
        success: function( data ) {
            //
            echoDublicateResult(data);
        }
    });
}

function echoDublicateResult( data) {
    if (data!=null){
        var searchBlock = $j('.js-name-duplicate');
        searchBlock.empty();
        if (data.length) {
            searchBlock.append('<div class="elements-title">Возможные совпадения Имен</div>');
        }

        $j.map( data, function( item ) {

            var  url = name = '';

            name = item.name;
            url = item.url;

            var str = '<div class="element"><a class="ob-link-user ob-link-block" href="'+url+'" target="_blank">'+name+'</a></div>';

            searchBlock.append(str);

        });
    }

}

function echoDublicateResultEmail( data) {
    if (data!=null){
        var searchBlock = $j('.js-email-duplicate');
        searchBlock.empty();
        if (data.length) {
            searchBlock.append('<div class="elements-title">Возможные совпадения Email</div>');
        }

        $j.map( data, function( item ) {

            var  url = name = '';

            name = item.email;
            url = item.url;

            var str = '<div class="element"><a class="ob-link-email" href="'+url+'" target="_blank">'+name+'</a></div>';

            searchBlock.append(str);

        });
    }

}

function echoDublicateResultPhone( data) {
    if (data!=null){
        var searchBlock = $j('.js-phones-duplicate');
        searchBlock.empty();
        if (data.length) {
            searchBlock.append('<div class="elements-title">Возможные совпадения Телефона</div>');
        }

        $j.map( data, function( item ) {

            var  url = name = '';

            name = item.phone;
            url = item.url;

            var str = '<div class="element"><a class="ob-link-phone" href="'+url+'" target="_blank">'+name+'</a></div>';

            searchBlock.append(str);

        });
    }

}

// скрипт загрузки предосмотра аватарки
$j(function() {
    $j('.js-add-avatar').click(function(){
        $j(this).next().click();
        return false;
    });
    $j('#js-image-add').change(function(){
        imageFiles = document.getElementById('js-image-add').files
        // get the number of files
        numFiles = imageFiles.length;
        readFile();
        $j('#js-image-remove').show();
    });

    // set up variables
    var reader = new FileReader(),
        i=0,
        numFiles = 0,
        imageFiles;

    // use the FileReader to read image i
    function readFile() {
        reader.readAsDataURL(imageFiles[i])
    }

    // define function to be run when the File
    // reader has finished reading the file
    reader.onloadend = function(e) {
        $j('#js-add-avatar').attr('style', 'background-image: url('+ e.target.result +');');
    }
});

// autocomplete должности
function post_autocomplete($input) {
    $input.autocomplete({
        delay: 500,
        source: function(request, response) {
            $j.ajax({
                url: "/admin/shop/users/ajax/post/autocomplete/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data == null) response(null);
                    response($j.map(data, function(item) {
                        return {
                            label: item,
                            value: item
                        }
                    }));
                }
            });
        }
    });
}

function tagCompany () {
    if ($j('#js-typesex-input').val() != 'company'){
        $j('#js-company-tag').show();
        $j('#js-company-input').hide();
        var array = $j('#js-company-input').val().split(',');
        $j("#js-company-tag").tagit("removeAll");
        $j('#js-company-input').val('');

        $j(array).each(function (i, j) {
            if (j) {
                $j("#js-company-tag").tagit("createTag", j.trim());
            }
        });

    } else {
        $j('#js-company-tag').hide();
        $j('#js-company-input').show();
        $j('#js-company-input').val($j('#js-company-tag').tagit("assignedTags"));
    }
}
