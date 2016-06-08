$j(function() {
    $j('.disclose').click(function(e){
        // показываем дочерние блоки выбранной категории
        $j(this).closest('li').toggleClass('shop-admin-nestedSortable-collapsed').toggleClass('shop-admin-nestedSortable-expanded');
    });
    var $index = 0;

    $j('.js-category-sortable').nestedSortable({
        forcePlaceholderSize: true,
        handle: 'div',
        helper: 'clone',
        items: 'li',
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div',
        maxLevels: 10,
        isTree: true,
        expandOnHover: 700,
        startCollapsed: true,
        branchClass: 'shop-admin-nestedSortable-branch',
        collapsedClass: 'shop-admin-nestedSortable-collapsed',
        disableNestingClass: 'shop-admin-nestedSortable-no-nesting',
        errorClass: 'shop-admin-nestedSortable-error',
        expandedClass: 'shop-admin-nestedSortable-expanded',
        hoveringClass: 'shop-admin-nestedSortable-hovering',
        leafClass: 'shop-admin-nestedSortable-leaf',
        update: function (event, ui) {
            $j.ajax({
                type: 'POST',
                url: '/admin/shop/ajax/category/manager/',
                data: {
                    listArray: $j('.js-category-sortable').nestedSortable('serialize')
                },
                success: function(html) {
                    // nothing
                },
                error: function() {
                    alert('Error!');
                }
            });
        }
    });
});

function dump(arr,level) {
    var dumped_text = "";
    if(!level) level = 0;

    //The padding given at the beginning of the line.
    var level_padding = "";
    for(var j=0;j<level+1;j++) level_padding += "    ";

    if(typeof(arr) == 'object') { //Array/Hashes/Objects
        for(var item in arr) {
            var value = arr[item];

            if(typeof(value) == 'object') { //If it is an array,
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += dump(value,level+1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
            }
        }
    } else { //Strings/Chars/Numbers etc.
        dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
    }
    return dumped_text;
}


$j(function () {
    $j('.js-checkbox').change(function () {
        var ids = '';

        $j('.js-checkbox').each(function (i, e) {
            if (e.checked) {
                ids += $j(e).val();
                ids += ',';
            }
        });

        $j('#id-category').val(ids);

        load_releted_categories(ids);

    });
});

function load_releted_categories(ids) {
    if (ids != '') {
        $j.ajax({
            url: "/admin/shop/load/releted/categories/ajax/",
            dataType: "json",
            data:{
                ids: ids
            },

            success: function( data ) {
                var names = '';
                data.forEach(function(item) {
                    if ( names != '' ) {
                        names += ', ';
                        names += item.name;
                    } else {
                        names = item.name;
                    }

                })
                $j('#js-del-releted-category-names').val(names);
            }

        });
    }
}