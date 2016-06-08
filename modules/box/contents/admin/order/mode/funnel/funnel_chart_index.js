function fade_workflow (e) {
    var id = $j(e).attr('data-id');
    var workflow = JSON.parse($j(e).val());
    var str = [];
    for(var key in workflow) {

        if (typeof workflow[key] == 'object') {
            if (('name' in workflow[key]) && ('count' in workflow[key]) && ('id' in workflow[key]) ) {
                // проверка чекбокса
                var check = $j('#check'+workflow[key].id);
                if (check.prop("checked")) {
                    str[str.length] = [workflow[key].name, workflow[key].count];
                }
            }
        }
    }

    // вытащить из обьекта название и количество

    $j('#funnel-'+id).highcharts({
        chart: {
            type: 'funnel',
            marginRight: 300
        },
        title: {
            text: $j(e).attr('data-name'),
            x: -150
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b> ({point.y:,.0f})',
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                    softConnector: true
                },
                neckWidth: '30%',
                neckHeight: '25%'
            }
        },
        legend: {
            enabled: false
        },
        series:[{ data: str }]
    });
}
