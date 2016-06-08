<?php /* Smarty version 2.6.27-optimized, created on 2015-12-02 18:05:21
         compiled from /var/www/shop.local/modules/box/contents//error403.html */ ?>
<div class="shop-block-popup">
    <div class="dark"></div>
    <div class="popupblock">
        <a href="javascript:void(0);" class="close" onclick="window.history.back();" title="Назад">
            <svg viewBox="0 0 16 16">
                <use xlink:href="#icon-close"></use>
            </svg>
        </a>
        <div class="head">
            <div class="logo">
                <?php if ($this->_tpl_vars['branding']): ?>
                    <img src="<?php echo $this->_tpl_vars['logo']; ?>
" alt="">
                <?php else: ?>
                    <img src="/_images/admin/logo.svg" alt="">
                <?php endif; ?>
            </div>
        </div>
        <div class="window-form">
            <form method="post">
                <div class="element">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_login_small']; ?>
</div>
                    <div class="el-value"><input type="text" name="auth_login" value="<?php echo $this->_tpl_vars['control_auth_login']; ?>
" /></div>
                </div>
                <div class="element">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_password_small']; ?>
</div>
                    <div class="el-value"><input type="password" name="auth_password" value="<?php echo $this->_tpl_vars['control_auth_password']; ?>
" /></div>
                </div>
                <input class="ob-button" type="submit" name="logok" value="<?php echo $this->_tpl_vars['translate_sign_in']; ?>
" />
            </form>
        </div>
        <div class="links">
            <a href="/doc/">Техническая документация OneBox</a>
        </div>
    </div>
</div>

<div class="parallax-bg-01"></div>
<div class="parallax-bg-02"></div>
<div class="parallax-bg-03"></div>
<div class="parallax-bg-04"></div>
<div class="parallax-bg-05"></div>
<div class="parallax-bg-06"></div>
<div class="parallax-bg-07"></div>

<script type="text/javascript">
    $j('.parallax-bg-01').parallax({xparallax: '40px'},{yparallax: '40px'});
    $j('.parallax-bg-02').parallax({xparallax: '80px'},{yparallax: '80px'});
    $j('.parallax-bg-03').parallax({xparallax: '160px'},{yparallax: '160px'});
    $j('.parallax-bg-04').parallax({xparallax: '80px'},{yparallax: '120px'});
    $j('.parallax-bg-05').parallax({xparallax: '160px'},{yparallax: '200px'});
    $j('.parallax-bg-06').parallax({xparallax: '80px'},{yparallax: '200px'});
    $j('.parallax-bg-07').parallax({xparallax: '160px'},{yparallax: '200px'});
    $j('input[type="text"]').focus();

    if ((pgwBrowser.os.group == 'Android') || (pgwBrowser.os.group == 'Windows Phone') || (pgwBrowser.os.group == 'iOS') || (pgwBrowser.os.group == 'BlackBerry')) {
        $j('.parallax-bg-01, .parallax-bg-02, .parallax-bg-03, .parallax-bg-04, .parallax-bg-05, .parallax-bg-06, .parallax-bg-07, .os-popup-block .dark').hide();
    }
</script>