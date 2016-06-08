<?php /* Smarty version 2.6.27-optimized, created on 2015-11-30 18:20:34
         compiled from /var/www/shop.local/modules/kazakhfilm-adaptive/contents/block/block_callback.html */ ?>
<div class="kzh-modal-wrapp callusModal">
    <div class="modal-black-mask">&nbsp;</div>
    <div class="kzh-modal" style="margin-left: -305px;">
        <div class="kzh-modal-content">
            <?php if ($this->_tpl_vars['callmessage'] == 'ok'): ?>
                <script type="text/javascript">
                    $j(function() {
                        $j('.tpl-contacts-call-us-back>div').click();
                    });
                </script>
                <div class="shop-message-success">
                    <?php echo $this->_tpl_vars['translate_send_message_success']; ?>
!<br />
                    <?php echo $this->_tpl_vars['translate_contact_manager_at_time']; ?>
.
                </div>

                <!-- Google Code for &#1054;&#1073;&#1088;&#1072;&#1090;&#1085;&#1099;&#1081; &#1079;&#1074;&#1086;&#1085;&#1086;&#1082; &#1054;&#1090;&#1077;&#1083;&#1103; Conversion Page -->
                <script type="text/javascript">
                    /* <![CDATA[ */
                    var google_conversion_id = 1010099357;
                    var google_conversion_language = "en";
                    var google_conversion_format = "3";
                    var google_conversion_color = "ffffff";
                    var google_conversion_label = "xxPTCJuD7QgQncnT4QM";
                    var google_conversion_value = 5.000000;
                    var google_remarketing_only = false;
                    /* ]]> */
                </script>
                <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
                </script>
                <noscript>
                    <div style="display:inline;">
                        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1010099357/?value=5.000000&amp;label=xxPTCJuD7QgQncnT4QM&amp;guid=ON&amp;script=0"/>
                    </div>
                </noscript>
            <?php else: ?>
                <?php if ($this->_tpl_vars['callerrorsArray']): ?>
                    <script type="text/javascript">
                        $j(function() {
                            $j('.tpl-contacts-call-us-back>div').click();
                        });
                    </script>
                    <div class="shop-message-error">
                        <?php $_from = $this->_tpl_vars['callerrorsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                            <?php if ($this->_tpl_vars['c'] == 'name'): ?>
                                <?php echo $this->_tpl_vars['translate_enter_name']; ?>
.<br />
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['c'] == 'phone'): ?>
                                <?php echo $this->_tpl_vars['translate_phone_error']; ?>
.<br />
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                    </div>
                <?php endif; ?>
                <div class="call-back-text">
                    Пожалуйста, укажите Ваш номер телефона, и мы перезвоним Вам где бы Вы не<br />находились.
                </div>
                <div class="kzh-callus-form">
                    <form method="post">
                        <input type="text" name="cbphone" value="<?php echo $this->_tpl_vars['control_cbphone']; ?>
" placeholder="+_ (___)___-__-__" class="js-phone-formatter"/><br />
                        <input type="text" name="cbname" value="<?php echo $this->_tpl_vars['control_cbname']; ?>
" placeholder="Ваше имя"/>
                        <div class="kzh-modal-submit">
                            <input type="hidden" name="ajs" class="ajs" value="1" />
                            <input type="submit" value="Отправить запрос" name="call" class="kzh-btn-default" />
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>