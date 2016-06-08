document.observe('dom:loaded', function() {
    //alert('/EngineDebug/{|$key|}/');
    var body = $$('body')[0];
    body.insert({bottom: "<a target=_blank href=\"/EngineDebug/{|$key|}/\" class=\"EngineDebug-Panel\">EngineDebug</a>"});
});