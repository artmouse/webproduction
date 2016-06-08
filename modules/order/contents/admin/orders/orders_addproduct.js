document.observe('dom:loaded', function () {
    if ($('id-product')) {
        new JSPrototypeAutocomplete(
        'id-product',
        'id-product-autocomplete',
        '#id-product-autocomplete a',
        '/search/autocomplete/select/'
        );
    }
});