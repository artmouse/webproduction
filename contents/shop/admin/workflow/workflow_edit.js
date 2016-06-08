var stateMachineConnector;

$j(function () {
    jsPlumb.ready(function() {
        // делаем все элементы таскающимися
        jsPlumb.draggable(jsPlumb.getSelector(".onebox-workflow-element"), {
            grid: [ 20, 20 ],
            containment: "parent",
            stop: function() {
                // при остановке считаем позицию
                var id = $j(this).data('id');
                $j('#js-position-'+id+'-x').val($j(this).position().left);
                $j('#js-position-'+id+'-y').val($j(this).position().top);
            }
        });

        jsPlumb.importDefaults({
            DragOptions : { cursor: "pointer", zIndex: 2000 },
            HoverClass: "connector-hover"
        });

        // стили соединительных стрелок
        stateMachineConnector = {
            connector: "StateMachine",
            paintStyle: {
                lineWidth: 2,
                strokeStyle: "#888888"
            },
            hoverPaintStyle:{strokeStyle:"#ff0000"},
            endpoint:"Blank",
            anchor:"Continuous",
            overlays:[ ["PlainArrow", {location: 1, width: 5, length: 5} ]]
        };

        // стиль и структура точки связи
        var endpoint = {
            isSource: true,
            isTarget: true,
            reattach: true,
            connectorStyle: {
                lineWidth: 3,
                strokeStyle: "green"
            },
            endpoint: ['Rectangle', {
                width: 20,
                height: 20,
                cssClass: 'onebox-workflow-element-endpoint'
            }],
            beforeDrop:function(params) {
                var from = params.sourceId.replace('js-wfe-', '');
                var to = params.targetId.replace('js-wfe-', '');

                if ($j('.js-connection-'+from+'-'+to).val() == 1) {
                    return false;
                }

                // ставим галочку
                $j('.js-connection-'+from+'-'+to).val(1);

                // соединяемся
                jsPlumb.connect({
                    source: "js-wfe-"+from,
                    target: "js-wfe-"+to
                }, stateMachineConnector);
            }
        };

        // на все инпуты вешаем обработку jsPlumb-прорисовки
        $j('.js-state').click(function (e) {
            redrawConnectors();
        });

        // на все блоки делаем подсказки
        $j('.onebox-workflow-layout .onebox-workflow-element').tooltip();

        // на все блоки ставим endPoint'ы
        $j('.onebox-workflow-layout .onebox-workflow-element').each(function (i, e) {
            // делаем блок resizable
            $j(e).resizable({
                maxHeight: 300,
                maxWidth: 300,
                minHeight: 20,
                minWidth: 100,
                grid: [ 20, 20 ],
                stop: function () {
                    // при остановке считаем размеры
                    var id = $j(this).data('id');
                    $j('#js-position-'+id+'-width').val($j(this).width());
                    $j('#js-position-'+id+'-height').val($j(this).height());
                },
                resize: function () {
                    // подвигаем endpoint
                    jsPlumb.getEndpoints(this)[0].paint();
                }
            });

            var x = jsPlumb.addEndpoint($j(e), { anchor: [1, 1, 1, 1] }, endpoint);

            // устанавливаем IDшник endPoint'y
            $j(x.canvas).data('id', $j(e).data('id'));
        });

        // подсветка точек при старте
        $j('.onebox-workflow-element-endpoint').on('dragstart', function (event, ui) {
            // получаем элемент с которого начался drag
            var currentElementID = $j(event.target).data('id');

            // подсвечиваем элементы, в которых может завершиться drag
            $j('.onebox-workflow-layout .onebox-workflow-element').each(function (i, e) {
                var canvas = $j(jsPlumb.getEndpoints(e)[0].canvas);
                if ($j('.js-connection-'+currentElementID+'-'+$j(e).data('id')).val() == 0) {
                    // (если галочки нет - то туда можно конектиться)
                    // подсвечиваем endPoint допустимого объекта
                    canvas.addClass('onebox-workflow-element-endpoint-allow');
                } else {
                    // (если галочка есть - то туда нельзя конектиться)
                    // подсвечиваем endPoint не_допустимого объекта
                    canvas.addClass('onebox-workflow-element-endpoint-deny');
                }
            });
        });

        // убирание подсветки точек
        $j('.onebox-workflow-element-endpoint').on('dragstop', function (event, ui) {
            $j('.onebox-workflow-element-endpoint-allow').removeClass('onebox-workflow-element-endpoint-allow');
            $j('.onebox-workflow-element-endpoint-deny').removeClass('onebox-workflow-element-endpoint-deny');
        });

        // при клике на соединение подсвечиваем чекбокс
        jsPlumb.bind("click", function(connection) {
            var from = connection.sourceId.replace('js-wfe-', '');
            var to = connection.targetId.replace('js-wfe-', '');
        });

        // при contextmenu клике убираем соединение
        jsPlumb.bind("contextmenu", function(connection) {
            jsPlumb.detach(connection);

            var from = connection.sourceId.replace('js-wfe-', '');
            var to = connection.targetId.replace('js-wfe-', '');

            $j('.js-connection-'+from+'-'+to).val(0);
        });

        // вызываем первый раз простановку связей
        redrawConnectors();
    });
});

$j(function() {
    $j('#js-product-tag').each(function (i, e) {
        var $ul = $j(e);
        $ul.tagit({
            singleField: true,
            singleFieldNode: $j($ul.data('input')),
            allowSpaces: true,
            autocomplete: {
                delay: 0,
                minLength: 2,
                source: function( request, response ) {
                    $j.ajax({
                        url: "/admin/products/json/autocomtlite/ajax/",
                        dataType: "json",
                        data:{
                            name: request.term,
                            add: 'no'
                        },
                        success: function( data ) {
                            if (data==null) response(null);
                            response( $j.map( data, function( item ) {
                                var result = name = '';

                                result = '#'+item.id+' '+item.name;
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

});

function redrawConnectors() {
    // удаляем все связи
    jsPlumb.detachEveryConnection();

    // ставим все связи заново
    $j('.js-state').each(function (i, e) {
        // получаем связи
        var from = $j(e).data('from');
        var to = $j(e).data('to');
        if (from != to) {
            // создаем новую связь
            if ($j(e).val() == 1) {
                jsPlumb.connect({
                    source: "js-wfe-"+from,
                    target: "js-wfe-"+to
                }, stateMachineConnector);
            }
        }
    });
}

$j(function() {
    //workflow sages sort
    $j('.js-wfstage-sort').sortable({
        update: function() {
            var sort = 0;
            $j('.js-wfstage-sort .js-sort-value').each(function(){
                sort = sort + 1
                $j(this).val(sort);
            });
        }
    });
});

$j(function() {
    //colorpicjer init
    $j('.js-color').each(function(){
        var input = $j(this);
        var currentColor = input.val();
        input.css({
            'background-color' : currentColor
        });

        input.ColorPicker({
            color: currentColor,
            onShow: function (colpkr) {
                $j(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $j(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                input.css({
                    'background-color' : '#' + hex
                });
                input.val('#' + hex);
            }
        });
    });
});