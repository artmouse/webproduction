/********************* LOADING *********************/

// автоматический loading div
$j(function () {
    $j(".os-loading").bind("ajaxSend", function(event, xhr, settings) {
        // для фоновых процессов лоадинг не показываем
        if (settings.background == undefined) {
            $j(this).fadeIn();
        }
    }).bind("ajaxComplete", function(event, xhr, settings) {
        // для фоновых процессов лоадинг не показываем
        if (settings.background == undefined) {
            $j(this).fadeOut('slow');
        }
    });
});