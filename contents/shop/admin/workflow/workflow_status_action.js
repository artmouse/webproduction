$j(function () {
    var nextWorkflow = $j('#js-nextworkflowid').val();
    if (nextWorkflow) {
        loadStatuses(nextWorkflow);
    }
});

$j(function () {
    $j('#js-nextworkflowid').change(function () {
        loadStatuses($j('#js-nextworkflowid').val());
    });
});

function loadStatuses(nextWorkflow) {
    $j.ajax({
        url: '/workflow/status/list/ajax/',
        dataType: "json",
        data: {
            id: nextWorkflow
        },
        success: function (data) {
            if (data == 'error') {
                $j("#js-nextstatusid").empty();
                $j("#js-nextstatusid").append($j('<option>', {value:0, text: "Выберите бизнес-процесс"}));
                $j("#js-nextstatusid").select2('val', 0);
            } else {
                $j("#js-nextstatusid").empty();
                $j("#js-nextstatusid").append($j('<option>', {value:0, text: "Стартовый Этап"}));
                $j(data).each(function (e, item) {
                    $j("#js-nextstatusid").append($j('<option>', {value:item.id, text: item.name}));
                });
                $j("#js-nextstatusid").select2('val', $j('#js-nextstatusid-value').val());

            }
        }
    });
}