$j(function(){
    // fallback for older browsers (ie<=9 & windows Safari)
    if ((pgwBrowser.browser.group == 'Safari' && pgwBrowser.os.group == 'Windows') || (pgwBrowser.browser.group == 'Explorer' && pgwBrowser.browser.majorVersion <= 9)) {
        $j('body').html('');
        $j('body').append('<div class="nb-popup-oldbrowser"> <table> <tr class="header-row"> <td colspan="5" class="logo"><img class="" src="/_images/browsers/logo.png" alt=""></td> </tr> <tr> <td colspan="5" height="1px"><span class="bigger">Похоже у вас устаревший браузер.</span> <br><br> Для максимально комфортной работы с <strong>OneBox</strong> мы советуем вам скачать один из <strong>БЕСПЛАТНЫХ</strong> и более современных браузеров. </td> </tr> <tr> <td><img src="/_images/browsers/icon-chrome.png" alt=""> <br/> <br/> Google Chrome</td> <td><img src="/_images/browsers/icon-firefox.png" alt=""> <br/> <br/> Firefox</td> <td><img src="/_images/browsers/icon-opera.png" alt=""> <br/> <br/> Opera</td> <td><img src="/_images/browsers/icon-safari.png" alt=""> <br/> <br/> Safari<br>(macOS only)</td> <td><img src="/_images/browsers/icon-explorer.png" alt=""> <br/> <br/> Explorer 10+</td> </tr> </table> </div>');
    }
});