$j(function() {
    initIssueControlForm();

    cookieToInstruction();

    $j('.js-block-instruction-toggle').click(function(){
        $j('.js-block-instruction').slideToggle(300);

        setTimeout("cookieFromInstruction();", 1000);
    });
});