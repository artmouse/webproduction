$j(function () {
    $j('.id-link').bind("click", function(event) {
        id = this.id;
        linkwindow_init('w2', 'id-linked-amount-'+id, id);
    });
});