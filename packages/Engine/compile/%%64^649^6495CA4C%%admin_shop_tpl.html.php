<?php /* Smarty version 2.6.27-optimized, created on 2015-12-02 18:05:35
         compiled from /var/www/shop.local/modules/box/contents//admin/admin_shop_tpl.html */ ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php if ($this->_tpl_vars['title']): ?><?php echo $this->_tpl_vars['title']; ?>
<?php if ($this->_tpl_vars['shop_title']): ?> &mdash; <?php endif; ?><?php endif; ?><?php echo $this->_tpl_vars['shop_title']; ?>
</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <link rel="icon" href="/modules/box/_images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/modules/box/_images/favicon.ico" type="image/x-icon" />

    <link href='//fonts.googleapis.com/css?family=Roboto:400,300,700,700italic,400italic,300italic&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <?php echo $this->_tpl_vars['engine_includes']; ?>

</head>
<body>

<?php if ($this->_tpl_vars['welcometext']): ?>
    <div class="nb-popup-welcome js-popup-welcome">
        <div class="close" onclick="welcomeHide();">
            <span class="nb-icon-close">
                 <svg>
                     <use xlink:href="#icon-close"></use>
                 </svg>
            </span>
        </div>

        <div class="logo js-welcome-logo">
            <img src="/_images/admin/logo.svg" alt="OneBOX" onclick="welcomeHide();" />
        </div>

        <div class="phrases js-welcome-phrases">
            <?php echo $this->_tpl_vars['welcometext']; ?>

        </div>

        <script src="/modules/box/_js/jquery.lettering.js"></script>
        <script>
            $j(function() {
                $j('body').addClass('no-scroll');

                $j(".js-welcome-phrases > h2").lettering('words').children("span").lettering().children("span").lettering();
                setTimeout(function(){
                    $j('.js-welcome-logo').addClass('visible');
                }, 12000);
            });

            function welcomeHide() {
                $j('body').removeClass('no-scroll');
                $j('.js-popup-welcome').fadeToggle();
            }
        </script>
    </div>
<?php endif; ?>

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
        <div class="head"><?php echo $this->_tpl_vars['translate_clear_cash']; ?>
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
                <div class="el-comment-cell">
                    <textarea name="" id="js-mail-content" placeholder="<?php echo $this->_tpl_vars['translate_message']; ?>
" cols="30" rows="15" style="height: 300px;"></textarea>
                </div>
                <?php if ($this->_tpl_vars['commentTemplateArray']): ?>
                    <div class="el-template-cell">
                        <div class="list" style="max-height: 270px;">
                            <?php $_from = $this->_tpl_vars['commentTemplateArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comment']):
?>
                                <a href="javascript:void(0);" class="ob-link-dashed" data-text="<?php echo $this->_tpl_vars['comment']['text']; ?>
" onclick="$j('#js-mail-content').val($j('#js-mail-content').val()+$j(this).data('text'));"><?php echo $this->_tpl_vars['comment']['name']; ?>
</a><br>
                            <?php endforeach; endif; unset($_from); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="element">
                <div class="el-caption"><?php echo $this->_tpl_vars['translate_dobavit_fayl']; ?>
</div>
                <div class="el-value"><input type="file" id="js-mail-files" multiple /></div>
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
                <div class="el-caption"><?php echo $this->_tpl_vars['translate_user_phone']; ?>
</div>
                <div class="el-value"><input type="text" id="js-sms-to" value="" placeholder="<?php echo $this->_tpl_vars['translate_vvedite_telefon']; ?>
" /></div>
            </div>
            <div class="clear"></div>
            <div class="element" style="display: inline-flex;">
                <textarea name="" id="js-sms-content" placeholder="<?php echo $this->_tpl_vars['translate_message']; ?>
" cols="30" rows="15" style="height: 50px; max-height: 300px;"></textarea>
                <?php if ($this->_tpl_vars['commentTemplateArray']): ?>
                    <div class="template-cell js-template-cell">
                        <div class="list">
                            <?php $_from = $this->_tpl_vars['commentTemplateArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comment']):
?>
                                <a href="javascript:void(0);" class="ob-link-dashed" data-text="<?php echo $this->_tpl_vars['comment']['text']; ?>
"
                                   onclick="$j('#js-sms-content').val($j('#js-sms-content').val()+$j(this).data('text')).trigger('autosize.resize');"><?php echo $this->_tpl_vars['comment']['name']; ?>
</a>
                                <br>
                            <?php endforeach; endif; unset($_from); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <input type="submit" id="js-sms-send" class="ob-button button-green" value="<?php echo $this->_tpl_vars['translate_send']; ?>
" />
            <input type="button" class="ob-button button-cancel" onclick="return sms_popup_close();" value="<?php echo $this->_tpl_vars['translate_cancel']; ?>
" />
        </div>
    </div>
</div>

<div id="js-smart-workflow-popup" style="display: none;"></div>

<?php echo $this->_tpl_vars['content_menu']; ?>


<div class="nb-admin-body">
    <div class="shop-message-container"></div>

    <div class="nb-admin-content">
        <?php echo $this->_tpl_vars['content']; ?>

    </div>
</div>

<div class="nb-wrap-search js-wrap-search" style="display: none;" >
    <div class="close js-search-close">
        <span class="nb-icon-close">
             <svg>
                 <use xlink:href="#icon-close"></use>
             </svg>
        </span>
    </div>
    <input id="js-search-custom-input" class="search-input js-search-field" type="text" name="" value="" placeholder="<?php echo $this->_tpl_vars['translate_search_capital']; ?>
..."/>
    <div class="loading js-search-loading" style="display: none;"></div>
    <div class="search-thead-wrap">
        <div class="search-thead">
            <div class="row js-search-theadrow"></div>
        </div>
    </div>
    <div class="search-result js-search-result">
        <div class="row" id="js-search-custom-input-result-div"></div>
    </div>
</div>

<div style="display: none;" class="js-usertextcomplete-mentions"><?php echo $this->_tpl_vars['mentionsJSON']; ?>
</div>
<input type="hidden" value="<?php echo $this->_tpl_vars['dynamic_workflow_type_in_menu']; ?>
" id="js-dynamic-workflow-type-in-menu">
<?php if ($this->_tpl_vars['allowCallWindow']): ?>
    <script type="text/javascript">
        var callWindowTimeout = <?php echo $this->_tpl_vars['callWindowTimeout']; ?>
;
        var callWindowUserID = <?php echo $this->_tpl_vars['callWindowUserID']; ?>
;

        setTimeout(box_voip_call, 1000);
    </script>
<?php endif; ?>
</body>
</html>