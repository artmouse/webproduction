<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 18:30:27
         compiled from /var/www/shop.local/modules/collars/contents/shop_tpl.html */ ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this->_tpl_vars['title']; ?>
</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="<?php echo $this->_tpl_vars['shopname']; ?>
" />
    <meta name="viewport" content="width=device-width" />
        <?php if ($this->_tpl_vars['shopName']): ?><meta name="dcterms.rightsHolder" content="<?php echo $this->_tpl_vars['shopName']; ?>
" /><?php endif; ?>

    <link rel="icon" href="<?php echo $this->_tpl_vars['favicon']; ?>
" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo $this->_tpl_vars['favicon']; ?>
" type="image/x-icon" />

    <?php echo $this->_tpl_vars['hreflang']; ?>


    <?php echo $this->_tpl_vars['integration_google_wmt']; ?>

    <?php echo $this->_tpl_vars['integration_yandex_wmt']; ?>

    <?php echo $this->_tpl_vars['loginzaVerification']; ?>


    <?php if ($this->_tpl_vars['cssUrl']): ?>
    <link href="<?php echo $this->_tpl_vars['cssUrl']; ?>
" rel="stylesheet" type="text/css">
    <?php endif; ?>
    <?php if ($this->_tpl_vars['jsUrl']): ?>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['jsUrl']; ?>
"> </script>
    <?php endif; ?>
    <?php echo $this->_tpl_vars['engine_includes']; ?>

    <?php echo $this->_tpl_vars['integration_facebook_pixel_head']; ?>

    <!--[if IE 8]><script src="/_js/html5shiv.js"></script><![endif]-->
</head>
<body <?php if ($this->_tpl_vars['background']): ?>style="background-image: url('<?php echo $this->_tpl_vars['background']; ?>
');"<?php endif; ?>>
<div class="cl-content-wrapper">
    <div class="wrapper-cell">


        <?php if ($this->_tpl_vars['seocontent']): ?>
            <div class="cl-seo <?php if ($this->_tpl_vars['contentID'] == index): ?>index-seo<?php endif; ?> js-append-seo">
                <?php echo $this->_tpl_vars['seocontent']; ?>

            </div>
        <?php endif; ?>


        <?php if ($this->_tpl_vars['contentID'] == index): ?>
            <?php echo $this->_tpl_vars['block_banner_wide']; ?>

        <?php endif; ?>

        <div class="cl-mainer">
            <?php echo $this->_tpl_vars['content']; ?>


            <div class="js-seo-wrapper"></div>
        </div>

    </div>
</div>

<div class="cl-header-wrapper">
    <div class="wrapper-cell">
        <?php echo $this->_tpl_vars['block_position_global_top']; ?>


        <header class="cl-header">
            <div class="cl-mainer">
                <div class="logo-image">
                    <?php if ($this->_tpl_vars['contentID'] == 'index'): ?>
                        <span class="inner-wrap">
                            <img src="<?php echo $this->_tpl_vars['logo']; ?>
" alt="<?php echo $this->_tpl_vars['shopName']; ?>
" title="<?php echo $this->_tpl_vars['shopName']; ?>
"/>
                        </span>
                    <?php else: ?>
                        <a class="inner-wrap" href="/" title="<?php echo $this->_tpl_vars['shopName']; ?>
">
                            <img src="<?php echo $this->_tpl_vars['logo']; ?>
" alt="<?php echo $this->_tpl_vars['shopName']; ?>
" title="<?php echo $this->_tpl_vars['shopName']; ?>
"/>
                        </a>
                    <?php endif; ?>
                </div>
                <!--<div class="logo">-->
                    <!--<a href="/">PetStuffMart</a>-->
                <!--</div>-->

                <a class="cl-nav-button js-toggle-nav-button" href="javascript:void(0);">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>

                <?php echo $this->_tpl_vars['block_search']; ?>


                <div class="basket-wrap js-basket">
                                    </div>

                <div class="block-auth">

                    <?php if ($this->_tpl_vars['userlogin']): ?>
                        <?php if ($this->_tpl_vars['admin']): ?>
                            <a class="no-small-breakpoint" href="<?php echo $this->_tpl_vars['main']; ?>
/admin/"><?php echo $this->_tpl_vars['translate_admin']; ?>
</a>
                        <?php endif; ?>
                        <a class="no-small-breakpoint" href="<?php echo $this->_tpl_vars['main']; ?>
/client/profile/"><?php echo $this->_tpl_vars['userlogin']; ?>
</a>
                    <?php else: ?>
                        <a class="enter-link" href="javascript: void(0);" onclick="popupOpen('.js-popup-auth-block');">Login</a>
                        <a class="registr-link" href="<?php echo $this->_tpl_vars['main']; ?>
/registration/">Sign In</a>
                    <?php endif; ?>
                </div>


                <div class="clear hidden"></div>

                <div class="inner-wrapper js-mobile-nav">
                    <?php echo $this->_tpl_vars['block_menu_category']; ?>


                </div>
                <div class="clear"></div>
            </div>

        </header>
    </div>
</div>

<div class="cl-footer-wrapper">
    <div class="wrapper-cell">
        <footer class="cl-footer">
            <div class="cl-mainer">
                <div class="block-column">
                    <div class="title">Shopping Help:</div>
                    <a href="/client/profile/">Your Account</a><br />
                    <?php $_from = $this->_tpl_vars['helpArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                    <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a><br />
                    <?php endforeach; endif; unset($_from); ?>

                </div>

                    <div class="block-column">
                        <div class="title"><?php echo $this->_tpl_vars['translate_useful']; ?>
</div>
                        <?php $_from = $this->_tpl_vars['companyArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a><br />
                        <?php endforeach; endif; unset($_from); ?>
                    </div>

                <div class="block-column contact">
                    <div class="title">Contacts</div>
                    <strong>PetStuffMart</strong><br />
                    <?php if ($this->_tpl_vars['address']): ?>
                        <?php echo $this->_tpl_vars['address']; ?>

                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['phone1']): ?>
                        <?php echo $this->_tpl_vars['phone1']; ?>
<br />
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['phone3']): ?>
                        <?php echo $this->_tpl_vars['phone3']; ?>
<br />
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['phone2']): ?>
                        <?php echo $this->_tpl_vars['phone2']; ?>
<br />
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['phone4']): ?>
                        <?php echo $this->_tpl_vars['phone4']; ?>
<br />
                    <?php endif; ?>

                    <strong>Manager</strong><br />
                    <a class="mail" href="mailto:<?php echo $this->_tpl_vars['email']; ?>
"><?php echo $this->_tpl_vars['email']; ?>
</a>

                    <div class="cl-social-links">
                        <a class="soc-link-1" href="#"></a>
                        <a class="soc-link-2" href="#"></a>
                        <a class="soc-link-3" href="#"></a>
                        <a class="soc-link-4" href="#"></a>
                        <a class="soc-link-5" href="#"></a>
                    </div>
                </div>

                
                <div class="clear"></div>

                <div class="dev"><?php echo $this->_tpl_vars['copyright']; ?>
</div>

            </div>
        </footer>
    </div>
</div>

<?php echo $this->_tpl_vars['block_position_global_bottom']; ?>


<div class="os-loading">
    <div class="dark"></div>
    <div class="loader"></div>
</div>

<div class="cl-block-popup js-popup-auth-block" style="display: none;">
    <div class="dark" onclick="popupClose('.js-popup-auth-block');"></div>
    <div class="block-popup">
        <div class="head">
            <a href="javascript: void(0);" class="close" onclick="popupClose('.js-popup-auth-block');">&nbsp;</a>
            <span class="login-title">Login</span>
        </div>
        <form method="post">
            <div class="body">
                <div class="block-form">
                    <div class="form-element">
                        <div class="descript">Username</div>
                        <input name="auth_login" id="id-auth-login" type="text" placeholder="Enter email" />
                    </div>

                    <div class="form-element">
                        <div class="descript">Password</div>
                        <input name="auth_password" id="id-auth-password" type="password" placeholder="Enter password" />
                    </div>

                    <div class="form-element">
                        <button class="cl-button small green login" type="submit">
                            <span></span> Login
                        </button>
                    </div>
                </div>
            </div>
            <div class="foot">
                <a class="cl-button small remove fl-l" href="#" onclick="popupClose('.js-popup-auth-block');">Cancel</a>
                <div class="fl-r ta-right">
                    Not a member? <a class="registr" href="<?php echo $this->_tpl_vars['main']; ?>
/registration/">Sign Up</a><br /><br />
                    Forgot <a class="remind" href="/remindpassword/">Password?</a>
                </div>
                <div class="clear"></div>
            </div>
        </form>
    </div>
</div>


<?php echo $this->_tpl_vars['quickOrder']; ?>


<div style="display: none;" class="js-phone-mask"><?php echo $this->_tpl_vars['phone_mask']; ?>
</div>

<a class="cl-to-top js-to-top" href="#"></a>
<?php echo $this->_tpl_vars['integration_gadwords']; ?>

</body>
</html>