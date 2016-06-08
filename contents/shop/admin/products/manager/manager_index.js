function get_XPath(elt)
{var path = '';
    for (; elt && elt.nodeType==1; elt=elt.parentNode)
    {var idx=jQuery(elt.parentNode).children(elt.tagName).index(elt)+1;
        idx>1 ? (idx='['+idx+']') : (idx='');
        path='/'+elt.tagName.toLowerCase()+idx+path;
    }
    return path;
}

jQuery(document).ready(function() {
    jQuery('*').click(function(event) {
        event.stopPropagation();
        console.log(get_XPath(this));
    });
});