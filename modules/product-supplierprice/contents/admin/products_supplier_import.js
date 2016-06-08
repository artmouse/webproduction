$j(function() {
    $j('.js-productnew').click(function () {
        $j('.js-code-input').each(function(index, e){
            if (!$j(e).val()) {
                $j(e).val('+');
            }
        });
    });

    $j('.js-code-error').on('click', function (event) {
        var code = $j(this).data('code');
        $j('input[name="productid-'+code+'"]').show();
        $j('input[name="productid-'+code+'"]').focus();
        event.preventDefault();
    });

    $j('.js-select-column').live('change', function() {
        var option, optionData, numberInput,
            rowNumber, value, firstValue = true;

        option = $j(this).find('option:selected');

        // Сбросить все остальные, нужно для склейки
        $j(this).find('option').removeClass('js-first');

        //optionText = option.text();
        optionData = option.data('type');
        if (!optionData) {
            return;
        }

        // проверить первое ли  значение этого типа
        $j('[data-type='+optionData+']').each(function(index, e){
            if ($j(e).hasClass('js-first')) {
                firstValue = false;
            }
        });

        numberInput = $j('[name='+optionData+']');
        rowNumber = $j(this).data('row');
        // контроль склейка
        if (option.hasClass('js-glue')
            && numberInput.val() && !firstValue) {
            value = numberInput.val();
            value = value + ',' + rowNumber;
        } else {
            option.addClass('js-first');
            value = rowNumber;
        }

        numberInput.val(value);
    });

    $j('.js-code-input').on('focus', function () {
        var code = $j(this).data('code');
        var productIncorrect = $j('input[name="productincorrect-'+code+'"]');
        productIncorrect.val(productIncorrect.data('name'));
        if (!$j(this).hasClass('ui-autocomplete-input')) {
            $j(this).autocomplete({
                delay: 500,
                minLength: 5,
                source: function (request, response) {
                    $j.ajax({
                        url: "/search/jsonautocomplete/",
                        dataType: "json",
                        data: {
                            name: request.term,
                            type: 'product'
                        },
                        success: function (data) {
                            if (data == null)
                            response(null);
                            response($j.map(data, function (item) {
                                var result = name = '';
                                result = item.id;
                                name = item.name;

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
    });
    // prew
    $j('.js-price-file').on('change', function(){
         
        var files, fileType, fileEncoding;

        files = this.files;
        
        var data = new FormData();
        $j.each(files, function (key, value) {
            data.append('file', value);
        });
        fileType = $j('[name="type"]').filter(':checked').val();
        fileEncoding = $j('[name="encoding"]').filter(':checked').val();
        data.append('fileType', fileType);
        data.append('fileEncoding', fileEncoding);
        
        
    $j.ajax({
        url: '/admin/shop/supplier/import/prew',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'html',
        processData: false,
        contentType: false,
        success: function(data){
            var prewContainer = $j('.js-prev-container');
            prewContainer.html(data);
        }
    });

    });

    // xls or xslx
    $j('.js-change-list label').change(function(){
        if ($j(this).find('input').val() == 'xls' || $j(this).find('input').val() == 'xlsx') {
            $j('.js-lists').show();
        } else {
            $j('.js-lists').hide();
        }
    });
});

function loadImportConfig(){
    var supplierId = $j('#supplierId').val();
    $j.ajax({
        url: "/supplier/import/config/",
        dataType: 'json',
        data: {
            supplierid:supplierId
        },
        success: function (data) {
            if (data) {
                // сбросить checkbox
                $j("input:checkbox:enabled").attr('checked', false);
                $j("input:text").val('');
                
                // currency
                console.log(data.minretail_cur_id);
                console.log(data.recommretail_cur_id);

                $j(".js-suppliercurrency").select2('val', data.suppliercurrencyid);
                $j(".js-currencyminretail").select2('val', data.minretail_cur_id);
                $j(".js-currencyrecommretail").select2('val', data.recommretail_cur_id);
                
                // fileType
                $j("."+"js-"+data.filetype).attr("checked", "checked");
                // encoding
                $j("."+"js-"+data.fileencoding).attr("checked", "checked");
                // code
                $j('.js-columncode').val(data.columncode);
                // name
                $j('.js-columnname').val(data.columnname);
                // columnarticul
                $j('.js-columnarticul').val(data.columnarticul);
                // columnprice
                $j('.js-columnprice').val(data.columnprice);
                // columnminretail
                $j('.js-columnminretail').val(data.columnminretail);
                // columnrecommretail
                $j('.js-columnrecommretail').val(data.columnrecommretail);
                // columnavail
                $j('.js-columnavail').val(data.columnavail);
                //processedLists
                $j('.js-processedLists').val(data.processed_lists);
                // columncomment
                $j('.js-columncomment').val(data.columncomment);
                // columndiscount
                $j('.js-columndiscount').val(data.columndiscount);
                // limitto
                $j('.js-limitto').val(data.limitto);
                // limitfrom
                $j('.js-limitfrom').val(data.limitfrom);

                //issearchnameprecision
                $j('.js-nameprecision').val(data.issearchnameprecision);

                if (parseInt(data.issearchcode)) {
                    $j(".js-issearchcode").attr("checked", "checked");
                }

                if (parseInt(data.issearchcodethis)) {
                    $j(".js-issearchcodethis").attr("checked", "checked");
                }
                if (parseInt(data.issearchcodemd5)) {
                    $j(".js-issearchcodemd5").attr("checked", "checked");
                }
                if (parseInt(data.issearchname)) {
                    $j(".js-issearchname").attr("checked", "checked");
                }
                if (parseInt(data.issearcharticul)) {
                    $j(".js-issearcharticul").attr("checked", "checked");
                }
                if (parseInt(data.createnewproduct)) {
                    $j(".js-createnewproduct").attr("checked", "checked");
                }
                if (parseInt(data.importcron)) {
                    $j(".js-importcron").attr("checked", "checked");
                }
                if (parseInt(data.onlyretail)) {
                    $j(".js-onlyretail").attr("checked", "checked");
                }
                if (parseInt(data.removeminretail)) {
                    $j(".js-removeminretail").attr("checked", "checked");
                }
                if (parseInt(data.removerecommretail)) {
                    $j(".js-removerecommretail").attr("checked", "checked");
                }
                if (parseInt(data.notimportemptyprice)) {
                    $j(".js-notimportemptyprice").attr("checked", "checked");
                }
                if (parseInt(data.notimportemptyavail)) {
                    $j(".js-notimportemptyavail").attr("checked", "checked");
                }
            }
        }
    });
}