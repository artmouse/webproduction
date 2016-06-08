function chznResultTree(item) {
    var datalevel = $j(item.element).data('level');
    return '<span style="display: block; padding-left: '+ datalevel*10 +'px;">'+ item.text +'</span>';
}

// selectwindow functions
function selectwindow_init(windowID, inputName, valueName, options) {
    var $inputName = $j('#'+inputName);
    var $valueName = $j('#'+valueName);
    var $window = $j('#'+windowID);

    // если окно уже есть - пропускаем
    if ($window.length) {
        return;
    }

    // дописываем в options идентификатор окна
    options.windowID = windowID;

    // загружаем окно
    $j.ajax({
        url: '/admin/selectwindow/',
        method: 'post',
        data: options,
        success: function(html) {
            // вставляем окно в конец body
            $j('body').append(html);

            // инициализируем все что нужно для работы окна:
            if ($j('select.chzn-select').length) {
                $j('select.chzn-select').select2();
            }

            if ($j('select.chzn-select-tree').length) {
                $j('select.chzn-select-tree').select2({
                    formatResult: chznResultTree
                });
            }

            // кнопка закрыть
            $j('#'+windowID+'-close').click(function (event) {
                popupClose('#'+windowID);
                setTimeout(function(){
                    $j('#'+windowID).remove();
                }, 1000);
                event.preventDefault();
            });

            // закрыть esc
            $j(document).keyup(function(e) {
                if (e.keyCode == 27) {
                    popupClose('#'+windowID);
                    setTimeout(function(){
                        $j('#'+windowID).remove();
                    }, 1000);
                }
            });

            if (options.productsearch) {
                // product search autocomplete
                var $productSearchInput = $j('#'+windowID+'-product-search');
                $productSearchInput.focus();
                $productSearchInput.keydown(function (event) {
                    if (event.keyCode == 13) {
                        $j('#'+windowID+'-product-search-button').click();
                    }
                });

                var $round = $j('.js-round-select-window').val();
                $j('#'+windowID+'-product-search-button').click(function (event) {
                    shop_product_search($productSearchInput.val(), $j('#'+windowID+'-product-search-categoryid').val(), function (json) {
                        var html = '';
                        $j(json).each(function (i, e) {
                            var $price = e.price;
                            var availClass;
                            if (e.avail != '0') {
                                availClass = 'available';
                            } else {
                                availClass = 'unavailable';
                            }

                            var availText = e.availtext;
                            if (!availText) {
                                if (e.avail != '0') {
                                    availText = "Есть в наличии";
                                } else {
                                    availText = "Нет в наличии";
                                }
                            }

                            if ($round) {
                               $price = Math.round($price);
                            }
                            if (e.image != false ) {
                                html += '<a href="#" class="result-element js-product" rel="'+e.id+'"> <img src = '+ e.image+'></img><span class="id">#'+e.id+'</span> <span class="category">'+e.categoryname+'&nbsp;</span> <span class="price">'+$price+' '+e.currencyname+'</span> <span class="availtext '+availClass+'">'+availText+'</span> <span class="name">'+e.name+'&nbsp;</span><span class="clear"></span></a>';
                            } else {
                                html += '<a href="#" class="result-element js-product" rel="'+e.id+'"><span class="id">#'+e.id+'</span><span class="price">'+$price+' '+e.currencyname+'</span><span class="availtext '+availClass+'">'+availText+'</span> <span class="name">'+e.name+'&nbsp;</span><span class="clear"></span></a>';
                            }
                        });
                        $j('#'+windowID+'-product-search-result').html(html);
                    });
                });

                // product search result
                $j(document).on('click', '#'+windowID+'-product-search-result a', function (event) {
                    var e = this;
                    if (e.rel) {
                        if ($j('#js-product-tag').length) {
                            $j('#js-product-tag').tagit("createTag", '#'+ e.rel+' '+$j(e).find('.name').text());
                        }
                        $inputName.val($j(e.innerHTML).text());
                        $valueName.val(e.rel);

                        // simulate change
                        $valueName.change();

                        $j('#'+windowID).remove();
                    }
                    event.preventDefault();
                });

                $j('#'+windowID+'-product-search-button').trigger('click');
            }

            if (options.usersearch) {
                // user search autocomplete
                var $userSearchInput = $j('#'+windowID+'-user-search');
                $userSearchInput.keydown(function (event) {
                    if (event.keyCode == 13) {
                        $j('#'+windowID+'-user-search-button').click();
                    }
                });

                // переключение табов "все", "клиенты", "пользователи"
                jQueryTabs.TabMenu($j('#'+windowID+'-user-search-result .selectwindow-users-link'), false);

                $j('#'+windowID+'-user-search-button').click(function (event) {
                    shop_user_search($j($userSearchInput).val(), function (json) {
                        var html = '';
                        $j(json.all).each(function (i, e) {
                            html += '<a href="#" class="result-element" rel="'+e.id+'">'+e.name+'</a>';
                        });
                        $j('#'+windowID+'-user-search-result .selectwindow-users-tab-all').html(html);

                        var html = '';
                        $j(json.clients).each(function (i, e) {
                            html += '<a href="#" class="result-element" rel="'+e.id+'">'+e.name+'</a>';
                        });
                        $j('#'+windowID+'-user-search-result .selectwindow-users-tab-clients').html(html);

                        var html = '';
                        $j(json.users).each(function (i, e) {
                            html += '<a href="#" class="result-element" rel="'+e.id+'">'+e.name+'</a>';
                        });
                        $j('#'+windowID+'-user-search-result .selectwindow-users-tab-users').html(html);
                    }, options.usersearchcompanyonly);
                });

                // user search result
                $j('#'+windowID+'-user-search-result').click(function (event) {
                    var e = event.target;
                    if (e.rel) {

                        $inputName.val(e.innerHTML);
                        $valueName.val(e.rel);

                        $valueName.change();

                        $j('#'+windowID).remove();
                    }
                    event.preventDefault();
                });

                $j('#'+windowID+'-user-search-button').trigger('click');
            }

            if (options.productadd) {
                $j('#'+windowID+'-product-add-button').click(function (event) {
                    var productName = '';
                    $j('.'+windowID+'-product-add-name').each(function (index, namePart) {
                        if (index > 0) {
                            productName += ' / ';
                        }
                        productName += $j(namePart).val();
                    });

                    var hidden = $j('#'+windowID+'-product-add-hidden').prop('checked') ? 1 : 0;

                    shop_product_add({
                        name: productName.trim(),
                        categoryid: $j('#'+windowID+'-product-add-categoryid').val(),
                        price: $j('#'+windowID+'-product-add-price').val(),
                        currencyid: $j('#'+windowID+'-product-add-currencyid').val(),
                        brandid: $j('#'+windowID+'-product-add-brandid').val(),
                        source: $j('#'+windowID+'-product-add-source').val(),
                        term: $j('#'+windowID+'-product-add-term').val(),
                        pricebase: $j('#'+windowID+'-product-add-pricebase').val(),
                        unit: $j('#'+windowID+'-product-add-unit').val(),
                        hidden: hidden
                    }, function (json) {
                        if ($j('#js-product-tag').length) {
                            $j('#js-product-tag').tagit("createTag", '#'+json.id+' '+json.name);
                        }
                        $inputName.val(json.name);
                        $valueName.val(json.id);
                        // simulate change
                        $valueName.change();

                        $j('#'+windowID).remove();
                    });
                });
            }

            if (options.useradd) {
                // user add
                var $userAddInput = $j('#'+windowID+'-user-add-name');
                $userAddInput.keydown(function (event) {
                    if (event.keyCode == 13) {
                        $j('#'+windowID+'-user-add-button').click();
                    }
                });

                $j('#'+windowID+'-user-add-button').click(function (event) {
                    shop_user_add({
                        typesex:    $j('#'+windowID+'-user-add-typesex').val(),
                        name:       $j('#'+windowID+'-user-add-name').val(),
                        namelast:   $j('#'+windowID+'-user-add-name-last').val(),
                        namemiddle: $j('#'+windowID+'-user-add-name-middle').val(),
                        company:    $j('#'+windowID+'-user-add-company').val(),
                        post:       $j('#'+windowID+'-user-add-post').val(),
                        skype:      $j('#'+windowID+'-user-add-skype').val(),
                        whatsapp:   $j('#'+windowID+'-user-add-whatsapp').val(),
                        phone:      $j('#'+windowID+'-user-add-phone').val(),
                        email:      $j('#'+windowID+'-user-add-email').val(),
                        sourceid:   $j('#'+windowID+'-user-add-source').val(),
                        address:    $j('#'+windowID+'-user-add-address').val()
                    }, function (json) {
                        if ($j('#js-client-email').length) {
                            $j('#js-client-email').val(json.email);
                        }
                        if ($j('#js-client-skype').length) {
                            $j('#js-client-skype').val(json.skype);
                        }
                        if ($j('#js-client-whatsapp').length) {
                            $j('#js-client-whatsapp').val(json.whatsapp);
                        }
                        if ($j('#js-client-phone').length) {
                            $j('#js-client-phone').val(json.phone);
                        }
                        $inputName.val(htmlspecialchars_decode(json.name+' '+ json.namelast+' '+ json.namemiddle+' '+ json.company));
                        $valueName.val(json.id);

                        $valueName.change();

                        $j('#'+windowID).remove();
                    });
                });
            }
            // табы в окне
            if (options.selectedTab) {
                jQueryTabs.TabMenu('#' + windowID + '-tabs a', options.selectedTab);
            } else {
                jQueryTabs.TabMenu('#' + windowID + '-tabs a');
            }
            $j('.selectwindow-input-search').focus();
        },
        error: function() {
            alert('Error loading selectwindow');
        }
    });
}