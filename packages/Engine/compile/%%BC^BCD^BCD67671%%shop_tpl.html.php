<?php /* Smarty version 2.6.27-optimized, created on 2015-11-13 16:34:35
         compiled from /var/www/shop.local/modules/shop-land/contents/shop_tpl.html */ ?>
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

    <link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,700&amp;subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>

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

    <!--[if IE 8]><script src="/_js/html5shiv.js"></script><![endif]-->
</head>
<body <?php if ($this->_tpl_vars['background']): ?>style="background-image: url('<?php echo $this->_tpl_vars['background']; ?>
');"<?php endif; ?>>
    <div class="os-content-wrapper">
        <div class="wrapper-cell">
            <?php if ($this->_tpl_vars['seocontent']): ?>
                <div class="os-seo">
                    <?php echo $this->_tpl_vars['seocontent']; ?>

                </div>
            <?php endif; ?>

            <div class="os-mainer">
                <div class="os-mainwrapper">
                    <?php echo $this->_tpl_vars['content']; ?>


                    <?php if ($this->_tpl_vars['contentID'] == 'index'): ?>
                        <?php echo $this->_tpl_vars['block_brand_alphabet']; ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="os-header-wrapper">
        <div class="wrapper-cell">
            <?php echo $this->_tpl_vars['block_position_global_top']; ?>


            <div class="os-block-preheader">
                <div class="os-mainer">
                    <ul class="list auth-block-menu">
                        <li>
                            <a href="" onclick="return false;"><span class="os-link-dashed"><?php echo $this->_tpl_vars['translate_client_account']; ?>
</span></a>
                            <ul class="sub right">
                                <?php if ($this->_tpl_vars['userlogin']): ?>
                                    <?php if ($this->_tpl_vars['admin']): ?>
                                        <li><a href="<?php echo $this->_tpl_vars['main']; ?>
/admin/"><?php echo $this->_tpl_vars['translate_admin']; ?>
</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo $this->_tpl_vars['main']; ?>
/client/orders/"><?php echo $this->_tpl_vars['translate_my_orders']; ?>
</a></li>
                                    <?php if ($this->_tpl_vars['balance']): ?>
                                        <li><a href="<?php echo $this->_tpl_vars['main']; ?>
/client/cash/"><?php echo $this->_tpl_vars['translate_balance']; ?>
</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo $this->_tpl_vars['main']; ?>
/client/profile/"><?php echo $this->_tpl_vars['translate_profile']; ?>
</a></li>
                                    <li><a href="<?php echo $this->_tpl_vars['main']; ?>
/client/products/viewed/"><?php echo $this->_tpl_vars['translate_products_viewed']; ?>
</a></li>
                                    <?php if ($this->_tpl_vars['countCompare']): ?>
                                        <li><a href="/compare/"><?php echo $this->_tpl_vars['translate_products_compare']; ?>
</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo $this->_tpl_vars['main']; ?>
/client/products/ordered/"><?php echo $this->_tpl_vars['translate_products_ordered']; ?>
</a></li>
                                    <?php if ($this->_tpl_vars['favoriteUrl']): ?>
                                        <li><a href="<?php echo $this->_tpl_vars['main']; ?>
<?php echo $this->_tpl_vars['favoriteUrl']; ?>
"><?php echo $this->_tpl_vars['translate_wish']; ?>
</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo $this->_tpl_vars['main']; ?>
/logout/"><?php echo $this->_tpl_vars['translate_logout']; ?>
</a></li>
                                <?php else: ?>
                                    <li><a href="javascript: void(0);" onclick="popupOpen('.js-popup-auth-block');"><?php echo $this->_tpl_vars['translate_enter']; ?>
</a></li>

                                    <?php if ($this->_tpl_vars['loginzaURL']): ?>
                                        <script src="//loginza.ru/js/widget.js" type="text/javascript"></script>
                                        <li><a href="<?php echo $this->_tpl_vars['loginzaURL']; ?>
" class="loginza"><?php echo $this->_tpl_vars['translate_login_via_social_network']; ?>
</a></li>
                                    <?php endif; ?>

                                    <li><a href="<?php echo $this->_tpl_vars['main']; ?>
/registration/"><?php echo $this->_tpl_vars['translate_registration']; ?>
</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>

                    <?php echo $this->_tpl_vars['block_menu_textpage']; ?>

                </div>
            </div>

            <div class="js-header-wrap">
                <header class="js-header">
                    <div class="os-mainer">
                        <div class="os-mainwrapper">
                            <div class="os-block-center-header">
                                <div class="inner-center-header">
                                    <?php echo $this->_tpl_vars['block_search']; ?>


                                    <div class="os-block-contactsheader" itemscope itemtype="http://schema.org/Organization">
                                        <span itemprop="name" style="display: none;"><?php echo $this->_tpl_vars['shopName']; ?>
</span>
                                        <?php if ($this->_tpl_vars['worktime']): ?>
                                            <div class="element worktime">
                                                <div class="caption"><?php echo $this->_tpl_vars['translate_working_hours']; ?>
:</div>
                                                <?php echo $this->_tpl_vars['worktime']; ?>

                                            </div>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['showHeaderPhone']): ?>
                                            <div class="element">
                                                <?php if ($this->_tpl_vars['phone1']): ?>
                                                    <div class="phone" itemprop="telephone"><?php echo $this->_tpl_vars['phone1']; ?>
</div>
                                                <?php endif; ?>
                                                <?php if ($this->_tpl_vars['phone3']): ?>
                                                    <div class="phone" itemprop="telephone"><?php echo $this->_tpl_vars['phone3']; ?>
</div>
                                                <?php endif; ?>
                                                <?php if ($this->_tpl_vars['phone2']): ?>
                                                    <div class="phone" itemprop="telephone"><?php echo $this->_tpl_vars['phone2']; ?>
</div>
                                                <?php endif; ?>
                                                <?php if ($this->_tpl_vars['phone4']): ?>
                                                    <div class="phone" itemprop="telephone"><?php echo $this->_tpl_vars['phone4']; ?>
</div>
                                                <?php endif; ?>

                                                <div class="phone-link">
                                                    <?php if ($this->_tpl_vars['callback']): ?>
                                                        <a class="os-link-dashed" href="javascript: void(0);" onclick="popupOpen('.js-popup-callblock');"><?php echo $this->_tpl_vars['translate_call_back']; ?>
</a>
                                                    <?php endif; ?>   
                                                </div>
                                            </div>
                                            <div class="clear-l"></div>
                                        <?php endif; ?>

                                        <?php if ($this->_tpl_vars['icq'] && $this->_tpl_vars['showHeaderIcq']): ?>
                                            <div class="element">
                                                <span class="icq"><?php echo $this->_tpl_vars['icq']; ?>
</span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($this->_tpl_vars['skype'] && $this->_tpl_vars['showHeaderSkype']): ?>
                                            <div class="element">
                                                <span class="skype"><?php echo $this->_tpl_vars['skype']; ?>
</span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['showHeaderEmail']): ?>
                                            <div class="element">
                                                <?php if ($this->_tpl_vars['email']): ?>
                                                    <a class="email os-link-dashed" href="javascript: void(0);"
                                                       onclick="popupOpen('.js-popup-mail-block');" itemprop="email"><?php echo $this->_tpl_vars['email']; ?>
</a>
                                                <?php else: ?>
                                                    <?php if ($this->_tpl_vars['feedback']): ?>
                                                        <a class="os-link-dashed" href="javascript: void(0);"
                                                       onclick="popupOpen('.js-popup-mail-block');"><?php echo $this->_tpl_vars['translate_write_letter']; ?>
</a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($this->_tpl_vars['address'] && $this->_tpl_vars['showHeaderAddress']): ?>
                                            <div class="element">
                                                <span class="adress" itemprop="address"><?php echo $this->_tpl_vars['address']; ?>
</span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="os-basket-wrap js-basket">
                                                            </div>

                            <div class="os-block-logoheader">
                                <?php if ($this->_tpl_vars['contentID'] == 'index'): ?>
                                    <span>
                                        <img src="<?php echo $this->_tpl_vars['logo']; ?>
" alt="<?php echo $this->_tpl_vars['shopName']; ?>
" title="<?php echo $this->_tpl_vars['shopName']; ?>
"/>
                                    </span>
                                <?php else: ?>
                                    <a href="/" title="<?php echo $this->_tpl_vars['shopName']; ?>
">
                                        <img src="<?php echo $this->_tpl_vars['logo']; ?>
" alt="<?php echo $this->_tpl_vars['shopName']; ?>
" title="<?php echo $this->_tpl_vars['shopName']; ?>
"/>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </header>
            </div>
            <div class="clear"></div>

            <div class="os-mainer">
                <div class="os-mainwrapper">
                    <nav class="os-category-nav js-category-nav">
                        <div class="nav-inner">
                            <?php echo $this->_tpl_vars['block_menu_category']; ?>


                            <?php if ($this->_tpl_vars['showMenuBrands']): ?>
                                <?php echo $this->_tpl_vars['block_menu_brand']; ?>

                            <?php endif; ?>
                        </div>
                    </nav>
                </div>
            </div>
            <?php if ($this->_tpl_vars['contentID'] == index): ?>
                <?php echo $this->_tpl_vars['block_banner_wide']; ?>

            <?php endif; ?>
        </div>
    </div>

    <div class="os-footer-wrapper">
        <div class="wrapper-cell">
            <footer>
                <div class="os-mainer">
                    <div class="contacts">
                        <div class="footer-caption"><?php echo $this->_tpl_vars['translate_contact_information']; ?>
</div>
                        <?php if ($this->_tpl_vars['worktime']): ?>
                            <div class="element worktime">
                                <?php echo $this->_tpl_vars['translate_working_hours']; ?>
: <?php echo $this->_tpl_vars['worktime']; ?>

                            </div>
                        <?php endif; ?>

                        <div class="element">
                            <?php if ($this->_tpl_vars['phone1']): ?>
                                <div class="phone"><?php echo $this->_tpl_vars['phone1']; ?>
</div>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['phone3']): ?>
                                <div class="phone"><?php echo $this->_tpl_vars['phone3']; ?>
</div>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['phone2']): ?>
                                <div class="phone"><?php echo $this->_tpl_vars['phone2']; ?>
</div>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['phone4']): ?>
                                <div class="phone"><?php echo $this->_tpl_vars['phone4']; ?>
</div>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['callback']): ?>
                                <a class="os-link-dashed" href="javascript: void(0);" onclick="popupOpen('.js-popup-callblock');"><?php echo $this->_tpl_vars['translate_call_back']; ?>
</a>
                            <?php endif; ?>
                        </div>

                        <?php if ($this->_tpl_vars['icq']): ?>
                            <div class="element">
                                <span class="icq"><?php echo $this->_tpl_vars['icq']; ?>
</span>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['skype']): ?>
                            <div class="element">
                                <span class="skype"><?php echo $this->_tpl_vars['skype']; ?>
</span>
                            </div>
                        <?php endif; ?>

                        <div class="element full">
                            <?php if ($this->_tpl_vars['email']): ?>
                                <a class="email os-link-dashed" href="mailto:<?php echo $this->_tpl_vars['email']; ?>
"><?php echo $this->_tpl_vars['email']; ?>
</a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['feedback']): ?>
                                <a class="os-link-dashed" href="javascript: void(0);" onclick="popupOpen('.js-popup-mail-block');"><?php echo $this->_tpl_vars['translate_write_letter']; ?>
</a>
                            <?php endif; ?>    
                        </div>

                        <?php if ($this->_tpl_vars['address']): ?>
                            <div class="element full">
                                <span class="adress"><?php echo $this->_tpl_vars['address']; ?>
</span>
                            </div>
                        <?php endif; ?>
                    </div>


                    <div class="footer-menu">
                        <?php if ($this->_tpl_vars['block_footer_textpage']): ?>
                            <div class="footer-caption"><?php echo $this->_tpl_vars['translate_useful']; ?>
</div>

                            <?php echo $this->_tpl_vars['block_footer_textpage']; ?>


                            <br />
                        <?php endif; ?>

                        <div class="js-async">
                            <?php echo $this->_tpl_vars['integration_yandex_counter']; ?>

                            <?php echo $this->_tpl_vars['integration_ga']; ?>

                        </div>
                        <script>
                            var $asyncBlock = $j('.js-async')
                            var asyncInfo = $asyncBlock.html();
                            $asyncBlock.html('');

                            $j(window).bind('load', function() {
                                $asyncBlock.html(asyncInfo);
                            });
                        </script>
                        <?php echo $this->_tpl_vars['integration_liveinternet']; ?>

                        <?php echo $this->_tpl_vars['integration_cloudim']; ?>

                    </div>

                    <div class="footer-menu">
                        <div class="footer-caption"><?php echo $this->_tpl_vars['translate_catalog']; ?>
</div>
                        <?php echo $this->_tpl_vars['block_footer_category']; ?>

                    </div>

                    <div class="account">
                        <div class="footer-caption"><?php echo $this->_tpl_vars['translate_client_account']; ?>
</div>
                        <?php if ($this->_tpl_vars['userlogin']): ?>
                            <?php if ($this->_tpl_vars['admin']): ?>
                                <a href="<?php echo $this->_tpl_vars['main']; ?>
/admin/"><?php echo $this->_tpl_vars['translate_admin']; ?>
</a> <br />
                            <?php endif; ?>
                            <a href="<?php echo $this->_tpl_vars['main']; ?>
/client/orders/"><?php echo $this->_tpl_vars['translate_my_orders']; ?>
</a><br />
                            <?php if ($this->_tpl_vars['balance']): ?>
                                <a href="<?php echo $this->_tpl_vars['main']; ?>
/client/cash/"><?php echo $this->_tpl_vars['translate_balance']; ?>
</a><br />
                            <?php endif; ?>
                            <a href="<?php echo $this->_tpl_vars['main']; ?>
/client/profile/"><?php echo $this->_tpl_vars['translate_profile']; ?>
</a><br />
                            <a href="<?php echo $this->_tpl_vars['main']; ?>
/client/products/viewed/"><?php echo $this->_tpl_vars['translate_products_viewed']; ?>
</a><br />
                            <?php if ($this->_tpl_vars['countCompare']): ?>
                                <a href="/compare/"><?php echo $this->_tpl_vars['translate_products_compare']; ?>
</a><br />
                            <?php endif; ?>
                            <a href="<?php echo $this->_tpl_vars['main']; ?>
/client/products/ordered/"><?php echo $this->_tpl_vars['translate_products_ordered']; ?>
</a><br />
                            <a href="<?php echo $this->_tpl_vars['main']; ?>
/logout/"><?php echo $this->_tpl_vars['translate_logout']; ?>
</a><br />
                        <?php else: ?>
                            <a class="os-link-dashed" href="javascript: void(0);" onclick="popupOpen('.js-popup-auth-block');"><?php echo $this->_tpl_vars['translate_enter']; ?>
</a><br />

                            <?php if ($this->_tpl_vars['loginzaURL']): ?>
                                <script src="//loginza.ru/js/widget.js" type="text/javascript"></script>
                                <a href="<?php echo $this->_tpl_vars['loginzaURL']; ?>
" class="loginza"><?php echo $this->_tpl_vars['translate_login_via_social_network']; ?>
</a><br />
                            <?php endif; ?>

                            <a href="<?php echo $this->_tpl_vars['main']; ?>
/registration/"><?php echo $this->_tpl_vars['translate_registration']; ?>
</a><br />
                        <?php endif; ?>
                    </div>
                    <div class="clear"></div>

                    <div class="footer-line">
                        <div class="copy">
                            <?php echo $this->_tpl_vars['copyright']; ?>

                        </div>
                        <div class="wps">
                            <a href="http://webproduction.ua/" rel="nofollow"><?php echo $this->_tpl_vars['translate_creating_online_shops']; ?>
</a>
                            <?php echo $this->_tpl_vars['translate_on_platform']; ?>

                            OneClick &reg;
                        </div>

                        <div class="clear"></div>
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

    <div class="os-block-popup js-popup-auth-block" style="display: none;">
        <div class="dark" onclick="popupClose('.js-popup-auth-block');"></div>
        <div class="block-popup">
            <div class="head">
                <a href="javascript: void(0);" class="close" onclick="popupClose('.js-popup-auth-block');">&nbsp;</a>
                <?php echo $this->_tpl_vars['translate_authorization']; ?>

            </div>
            <form method="post">
                <div class="body">
                    <table>
                        <tr>
                            <td><?php echo $this->_tpl_vars['translate_login_email']; ?>
</td>
                            <td><input name="auth_login" id="id-auth-login" type="text" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->_tpl_vars['translate_password_small']; ?>
</td>
                            <td><input name="auth_password" id="id-auth-password" type="password" /></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><a href="/remindpassword/"><?php echo $this->_tpl_vars['translate_forgot_password']; ?>
?</a></td>
                        </tr>
                    </table>
                </div>
                <div class="foot">
                    <?php if ($this->_tpl_vars['loginzaURL']): ?>
                        <a href="<?php echo $this->_tpl_vars['loginzaURL']; ?>
" class="loginza" title="<?php echo $this->_tpl_vars['translate_login_via_social_network']; ?>
">&nbsp;</a>
                    <?php endif; ?>
                    <input type="submit" value="<?php echo $this->_tpl_vars['translate_sign_in']; ?>
" class="os-submit <?php if ($this->_tpl_vars['loginzaURL']): ?>fl-r<?php endif; ?>" />
                    <div class="clear"></div>
                </div>
            </form>
        </div>
    </div> 
    <?php if ($this->_tpl_vars['welcomeBannerId']): ?>
        <div class="os-block-popup js-popup-welcome-block" style="display: none" >
            <div class="dark" onclick="popup_welcome_close(<?php echo $this->_tpl_vars['welcomeBannerId']; ?>
);"></div>
            <div class="block-popup welcome-popup">
                <div class="head">
                    <a href="javascript: void(0);" class="close" onclick="popup_welcome_close(<?php echo $this->_tpl_vars['welcomeBannerId']; ?>
);"></a>
                    <?php echo $this->_tpl_vars['welcomeName']; ?>

                </div>
                <img class="banner-image" src="<?php echo $this->_tpl_vars['urlBannerWelcome']; ?>
" width="800" height="350" alt=""/>
                <div class="foot">
                                        <form method="post">
                        <div class="os-block-subscribe" style="width: 300px; margin: 0 auto;">
                            <input type="text" name="distribution_email" class="ui-autocomplete-input" value="<?php echo $this->_tpl_vars['control_distribution_email']; ?>
" placeholder="Email">
                            <input type="submit" class="os-submit grey" name="distribution_ok" value="<?php echo $this->_tpl_vars['translate_subscribe']; ?>
">
                        </div>
                    </form>
                    <?php if ($this->_tpl_vars['subscribe_message'] == 'ok'): ?>
                        <br />
                        <br />
                        <div class="os-message-success">
                            <?php echo $this->_tpl_vars['translate_you_have_successfully_subscribed']; ?>
.
                        </div>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['subscribe_message'] == 'error'): ?>
                        <br />
                        <br />
                        <div class="os-message-error">
                            <?php echo $this->_tpl_vars['translate_you_did_not_enter_email_address']; ?>
.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <input type="hidden" id="welcomeBannerId" value="<?php echo $this->_tpl_vars['welcomeBannerId']; ?>
">

        </div>
    <?php endif; ?>

    <?php echo $this->_tpl_vars['block_callback']; ?>

    <?php echo $this->_tpl_vars['block_feedback']; ?>


    <?php echo $this->_tpl_vars['quickOrder']; ?>


    <div style="display: none;" class="js-phone-mask"><?php echo $this->_tpl_vars['phone_mask']; ?>
</div>

    <div class="os-gototop js-gototop"></div>
</body>
</html>