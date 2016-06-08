$j(function() {
    // utm to cookie
    var utm_source = getUrlParameter('utm_source');
    var utm_medium = getUrlParameter('utm_medium');
    var utm_campaign = getUrlParameter('utm_campaign');
    var utm_content = getUrlParameter('utm_content');
    var utm_term = getUrlParameter('utm_term');
    var utm_referrer = document.referrer;

    var currentdate = new Date();
    var dd = currentdate.getDate();
    if (dd < 10) dd = '0' + dd;
    var mm = currentdate.getMonth() + 1;
    if (mm < 10) mm = '0' + mm;

    var utm_date = "" + currentdate.getFullYear() + "-"
        + mm  + "-"
        + dd + " "
        + currentdate.getHours() + ":"
        + currentdate.getMinutes() + ":"
        + currentdate.getSeconds();

    if ($j.cookie('utm_date') == undefined) {
        $j.cookie('utm_date', utm_date, { expires: 365, path: '/' });
    }

    if (utm_source != '') {
        $j.cookie('utm_source', utm_source, { expires: 365, path: '/' });
    }
    if (utm_medium != '') {
        $j.cookie('utm_medium', utm_medium, { expires: 365, path: '/' });
    }
    if (utm_campaign != '') {
        $j.cookie('utm_campaign', utm_campaign, { expires: 365, path: '/' });
    }
    if (utm_content != '') {
        $j.cookie('utm_content', utm_content, { expires: 365, path: '/' });
    }
    if (utm_term != '') {
        $j.cookie('utm_term', utm_term, { expires: 365, path: '/' });
    }
    if (!$j.cookie('utm_referrer') && utm_referrer != '') {
        $j.cookie('utm_referrer', utm_referrer, { expires: 365, path: '/' });
    }
});

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
    return '';
}