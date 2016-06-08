<?php /* Smarty version 2.6.27-optimized, created on 2015-11-16 17:07:51
         compiled from /var/www/shop.local/contents/shop/admin/admin_shop_tpl.html */ ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php if ($this->_tpl_vars['title']): ?><?php echo $this->_tpl_vars['title']; ?>
<?php if ($this->_tpl_vars['shop_title']): ?> &mdash; <?php endif; ?><?php endif; ?><?php echo $this->_tpl_vars['shop_title']; ?>
</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <link rel="icon" href="<?php echo $this->_tpl_vars['favicon']; ?>
" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo $this->_tpl_vars['favicon']; ?>
" type="image/x-icon" />

    <link href='//fonts.googleapis.com/css?family=Roboto:400,300,700,700italic,400italic,300italic&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>

    <?php echo $this->_tpl_vars['engine_includes']; ?>

</head>
<body>
    <?php echo $this->_tpl_vars['admin_shop_svg']; ?>

    <a href="/" class="nb-loader js-loader"></a>

    <div class="ob-wait js-wait">
        <span class="js-wait-text"><?php echo $this->_tpl_vars['translate_load']; ?>
...</span>
    </div>

    <div class="ob-success js-success" style="display: none;">
        <span class="text"></span>
    </div>

    <div class="ob-error js-error" style="display: none;">
        <span class="text"></span>
    </div>

    <div class="shop-block-popup js-cache-confirm" style="display: none;">
        <div class="dark"></div>
        <div class="popupblock">
            <a href="#" class="close js-cache-clear-no">
                <svg viewBox="0 0 16 16">
                    <use xlink:href="#icon-close"></use>
                </svg>
            </a>
            <div class="head"><?php echo $this->_tpl_vars['translate_cash_clear']; ?>
</div>
            <div class="window-content window-form">
                <h1><?php echo $this->_tpl_vars['translate_do_you_really_want_to_clear_the_cache']; ?>
?</h1>
                <label>
                    <input type="checkbox" class="js-cache-image" name="" />
                    <?php echo $this->_tpl_vars['translate_just_remove_all_thumbnail_image_versions']; ?>

                </label>
                <br /><br />
                <input type="button" value="<?php echo $this->_tpl_vars['translate_clear_cash']; ?>
" name="" class="ob-button button-green js-cache-clear-yes" />
                <input type="button" value="<?php echo $this->_tpl_vars['translate_cancel']; ?>
" name="" class="ob-button button-cancel js-cache-clear-no" />
            </div>
        </div>
    </div>

    <div class="shop-block-popup js-letteradd-popup" style="display: none;">
        <div class="dark"></div>
        <div class="popupblock">
            <a href="#" class="close" onclick="return box_email_popup_close();">
                <svg viewBox="0 0 16 16">
                    <use xlink:href="#icon-close"></use>
                </svg>
            </a>
            <div class="head"><?php echo $this->_tpl_vars['translate_write_letter']; ?>
</div>
            <div class="window-content window-form">
                <div class="element">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_whom']; ?>
</div>
                    <div class="el-value"><input type="text" id="js-mail-to" name="" value="" placeholder="<?php echo $this->_tpl_vars['translate_vvedite_e_mail']; ?>
" /></div>
                </div>
                <div class="element">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_subject']; ?>
</div>
                    <div class="el-value"><input type="text" id="js-mail-subject" name="" value="" placeholder="<?php echo $this->_tpl_vars['translate_ukazhite_temu']; ?>
" /></div>
                </div>
                <div class="element">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_dispatch_date']; ?>
</div>
                    <div class="el-value"><input class="js-datetime" type="text" id="js-mail-send-date" name="" value="" placeholder="<?php echo $this->_tpl_vars['translate_ukazhite_datu_otpravki']; ?>
" /></div>
                </div>
                <div class="element">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_ot_kogo']; ?>
</div>
                    <div class="el-value">
                        <input type="hidden" id="js-mail-from" value=""/>
                        <select class="chzn-select" onchange="$j('#js-mail-from').val($j(this).val());">
                            <?php $_from = $this->_tpl_vars['emailArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <option value="<?php echo $this->_tpl_vars['e']; ?>
"><?php echo $this->_tpl_vars['e']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="element">
                    <textarea name="" id="js-mail-content" placeholder="<?php echo $this->_tpl_vars['translate_message']; ?>
" cols="30" rows="15" style="height: 300px; max-height: 300px;"></textarea>
                </div>
                <div class="element">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_dobavit_fayl']; ?>
</div>
                    <div class="el-value"><input type="file" id="js-mail-files" multiple /></div>
                </div>
                <div class="element">
                    <label><input type="checkbox" id="letterhtml" value=""/><?php echo $this->_tpl_vars['translate_otpravit_krasivoe_html_pismo']; ?>
</label>
                </div>
                <div class="js-letteradd-attachment-container">

                </div>
                <input type="submit" id="js-mail-send" class="ob-button button-green" value="<?php echo $this->_tpl_vars['translate_send']; ?>
" />
                <input type="button" class="ob-button button-cancel" onclick="return box_email_popup_close();" value="<?php echo $this->_tpl_vars['translate_cancel']; ?>
" />
            </div>
        </div>
    </div>

    <div class="shop-block-popup js-smsadd-popup" style="display: none;">
        <div class="dark"></div>
        <div class="popupblock">
            <a href="#" class="close" onclick="return sms_popup_close();">
                <svg viewBox="0 0 16 16">
                    <use xlink:href="#icon-close"></use>
                </svg>
            </a>
            <div class="head"><?php echo $this->_tpl_vars['translate_napisat_sms']; ?>
</div>
            <div class="window-content window-form">
                <div class="element">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_phone']; ?>
</div>
                    <div class="el-value"><input type="text" id="js-sms-to" value="" placeholder="<?php echo $this->_tpl_vars['translate_vvedite_telefon']; ?>
" /></div>
                </div>
                <div class="clear"></div>
                <div class="element">
                    <textarea name="" id="js-sms-content" placeholder="<?php echo $this->_tpl_vars['translate_message']; ?>
" cols="30" rows="15" style="height: 50px; max-height: 300px;"></textarea>
                </div>
                <input type="submit" id="js-sms-send" class="ob-button button-green" value="<?php echo $this->_tpl_vars['translate_send']; ?>
" />
                <input type="button" class="ob-button button-cancel" onclick="return sms_popup_close();" value="<?php echo $this->_tpl_vars['translate_cancel']; ?>
" />
            </div>
        </div>
    </div>

    <div id="js-smart-workflow-popup" style="display: none;"></div>
    <div class="nb-wrap-menuvertical">
        <div class="nb-block-menuvertical">
            <div class="menu-element logo">
                <div class="menu-element-part static">
                    <a class="logo-image" href="/admin/">
                        <img src="/_images/admin/logo.svg" alt="">
                    </a>
                </div>

                <div class="menu-element-part collapse">
                    <a href="/admin/" class="logo-text" title="Мой <?php if ($this->_tpl_vars['branding']): ?><?php echo $this->_tpl_vars['branding']; ?>
<?php else: ?>OneBox<?php endif; ?>">
                        Мой
                        <?php if ($this->_tpl_vars['branding']): ?>
                            <?php echo $this->_tpl_vars['branding']; ?>

                        <?php else: ?>
                            OneBox
                        <?php endif; ?>
                    </a>
                </div>
                <div class="clear"></div>
            </div>

            <div class="scroll-wrap js-scroll-wrap">
                <br>
                <div class="menu-element">
                    <div class="menu-element-part collapse-full">
                        <div class="block-search">
                            <input class="js-search-helper" type="text" placeholder="Быстрый поиск">
                            <div class="icon">
                                <svg class="icon-svg icon-search" viewBox="0 0 16 16">
                                    <use xlink:href="#icon-search"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nb-asidenav-drop">
                    <?php $_from = $this->_tpl_vars['menuArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['url'] => $this->_tpl_vars['name']):
?>
                        <li class="js-search-line">
                            <div class="menu-element">
                                <div class="menu-element-part static">
                                    <a class="icon js-menu-toggle" href="<?php echo $this->_tpl_vars['url']; ?>
">
                                        <svg class="icon-svg icon-products" style="" viewBox="0 0 16 16">
                                            <use xlink:href="#icon-products"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-element-part collapse">
                                    <a class="menu-link js-menu-toggle" href="<?php echo $this->_tpl_vars['url']; ?>
"><?php echo $this->_tpl_vars['name']; ?>
</a>
                                </div>
                                <div class="clear"></div>

                            </div>
                        </li>
                    <?php endforeach; else: ?>
                                                <?php if ($this->_tpl_vars['acl']['products']): ?>
                            <li class="js-search-line">
                                <div class="menu-element">
                                    <div class="menu-element-part static">
                                        <a class="icon js-menu-toggle" href="/admin/shop/products/list-table/">
                                            <svg class="icon-svg icon-products" style="" viewBox="0 0 16 16">
                                                <use xlink:href="#icon-products"></use>
                                            </svg>
                                        </a>
                                    </div>

                                    <div class="menu-element-part collapse">
                                        <a class="menu-link js-menu-toggle" href="/admin/shop/products/list-table/"><?php echo $this->_tpl_vars['translate_many_products']; ?>
</a>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endif; unset($_from); ?>

                    <?php $_from = $this->_tpl_vars['menuTopArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['top'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['top']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['e']):
        $this->_foreach['top']['iteration']++;
?>
                        <li class="js-search-line">
                            <div class="menu-element">
                                <div class="menu-element-part static">
                                    <a class="icon js-menu-toggle" href="<?php echo $this->_tpl_vars['e']['url']; ?>
">
                                        <svg class="icon-svg <?php echo $this->_tpl_vars['e']['class']; ?>
" viewBox="0 0 16 16">
                                            <use xlink:href="#<?php echo $this->_tpl_vars['e']['class']; ?>
"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-element-part collapse">
                                    <a class="menu-link js-menu-toggle" href="<?php echo $this->_tpl_vars['e']['url']; ?>
" <?php if ($this->_tpl_vars['e']['childArray']): ?>data-name="module<?php echo ($this->_foreach['top']['iteration']-1); ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['e']['name']; ?>
 <?php if ($this->_tpl_vars['e']['childArray']): ?><i class="expand"></i><?php endif; ?></a>
                                </div>
                                <div class="clear"></div>

                                <?php if ($this->_tpl_vars['e']['childArray']): ?>
                                    <div class="menu-element-part collapse-full">
                                        <ul class="sub-nav">
                                            <?php $_from = $this->_tpl_vars['e']['childArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                                                <li>
                                                    <a href="<?php echo $this->_tpl_vars['c']['url']; ?>
"><?php echo $this->_tpl_vars['c']['name']; ?>
</a>
                                                </li>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; endif; unset($_from); ?>

                    <?php if ($this->_tpl_vars['menuReportArray']): ?>
                        <li class="js-search-line">
                            <div class="menu-element">
                                <div class="menu-element-part static">
                                    <a class="icon js-menu-toggle" href="javascript:void(0);">
                                        <svg class="icon-svg icon-issue" viewBox="0 0 16 16">
                                            <use xlink:href="#icon-issue"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-element-part collapse">
                                    <a class="menu-link js-menu-toggle" href="javascript:void(0);"><?php echo $this->_tpl_vars['translate_reports']; ?>
 <?php if ($this->_tpl_vars['menuReportArray']): ?><i class="expand"></i><?php endif; ?></a>
                                </div>
                                <div class="clear"></div>

                                <?php if ($this->_tpl_vars['menuReportArray']): ?>
                                    <div class="menu-element-part collapse-full">
                                        <ul class="sub-nav">
                                            <?php $_from = $this->_tpl_vars['menuReportArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foreach_report'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foreach_report']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['e']):
        $this->_foreach['foreach_report']['iteration']++;
?>
                                                <li class="js-search-line"><a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a></li>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endif; ?>

                    <li class="js-search-line">
                        <div class="menu-element">
                            <div class="menu-element-part static">
                                <a class="icon js-menu-toggle" href="javascript:void(0);">
                                    <svg class="icon-svg icon-settings" viewBox="0 0 20 20">
                                        <use xlink:href="#icon-settings"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="menu-element-part collapse">
                                <a class="menu-link js-menu-toggle" href="javascript:void(0);"><?php echo $this->_tpl_vars['translate_settings']; ?>
 <?php if (! $this->_tpl_vars['denyShop']): ?><i class="expand"></i><?php endif; ?></a>
                            </div>
                            <div class="clear"></div>

                            <?php if (! $this->_tpl_vars['denyShop']): ?>
                                <div class="menu-element-part collapse-full">
                                    <ul class="sub-nav">
                                        <?php $_from = $this->_tpl_vars['menuSettingArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foreach_setting'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foreach_setting']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['e']):
        $this->_foreach['foreach_setting']['iteration']++;
?>
                                            <li class="js-search-line">
                                                <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                                            </li>
                                        <?php endforeach; endif; unset($_from); ?>
                                        <?php if ($this->_tpl_vars['acl']['settings']): ?>
                                            <li class="js-search-line">
                                                <a href="#" class="js-clear-cache"><?php echo $this->_tpl_vars['translate_cash_clear']; ?>
</a>
                                            </li>
                                        <?php endif; ?>
                                        <li class="js-search-line">
                                            <a href="/doc/" target="_blank"><?php echo $this->_tpl_vars['translate_help']; ?>
</a>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>

                        </div>
                    </li>

                    <li class="js-search-line">
                        <div class="menu-element">
                            <div class="menu-element-part static">
                                <a class="icon js-menu-toggle" href="/doc/">
                                    <svg class="icon-svg icon-doc" viewBox="0 0 16 16">
                                        <use xlink:href="#icon-doc"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="menu-element-part collapse">
                                <a class="menu-link js-menu-toggle" href="/doc/"><?php echo $this->_tpl_vars['translate_help']; ?>
</a>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </li>

                    <li class="js-search-line">
                        <div class="menu-element">
                            <div class="menu-element-part static">
                                <a class="icon js-menu-toggle" href="javascript:void(0);">
                                    <svg class="icon-svg icon-exit" viewBox="0 0 16 16">
                                        <use xlink:href="#icon-exit"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="menu-element-part collapse">
                                <a class="menu-link js-menu-toggle" href="javascript:void(0);"><?php if ($this->_tpl_vars['user']['login']): ?><?php echo $this->_tpl_vars['user']['login']; ?>
<?php else: ?>admin<?php endif; ?> <i class="expand"></i></a>
                            </div>
                            <div class="clear"></div>

                            <div class="menu-element-part collapse-full">
                                <ul class="sub-nav">
                                    <li class="js-search-line"><a href="/"><?php echo $this->_tpl_vars['translate_shop']; ?>
</a></li>
                                    <li class="js-search-line"><a href="/client/orders/"><?php echo $this->_tpl_vars['translate_cabinet']; ?>
 <?php echo $this->_tpl_vars['translate_client']; ?>
</a></li>
                                    <li class="js-search-line"><a href="/client/change/password/"><?php echo $this->_tpl_vars['translate_change']; ?>
 <?php echo $this->_tpl_vars['translate_password']; ?>
</a></li>
                                    <li class="js-search-line"><a href="/admin/shop/ticket/support/"><?php echo $this->_tpl_vars['translate_technical_support']; ?>
</a></li>
                                    <li class="js-search-line"><a href="/logout/"><?php echo $this->_tpl_vars['translate_logout']; ?>
</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="nb-admin-body">
        <div class="nb-message-container"></div>

        <div class="nb-admin-content">
            <?php echo $this->_tpl_vars['content']; ?>

        </div>

    </div>

    <div style="display: none;" class="js-usertextcomplete-mentions"><?php echo $this->_tpl_vars['mentionsJSON']; ?>
</div>
</body>
</html>