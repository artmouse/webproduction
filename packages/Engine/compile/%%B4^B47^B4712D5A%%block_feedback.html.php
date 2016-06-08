<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:09
         compiled from /var/www/shop.local//templates/default//block/block_feedback.html */ ?>
<div class="os-block-popup js-popup-mail-block" style="display: none;">
    <div class="dark" onclick="popupClose('.js-popup-mail-block');"></div>
    <div class="block-popup">
        <div class="head">
            <a href="javascript: void(0);" class="close" onclick="popupClose('.js-popup-mail-block');">&nbsp;</a>
            <?php echo $this->_tpl_vars['translate_send_letter']; ?>

        </div>
        <?php if ($this->_tpl_vars['feedbackmessage'] == 'ok'): ?>
            <script type="text/javascript">
            $j(function() {
                $j('.js-popup-mail-block').toggle();
                return false;
            });

            setTimeout(function() {
                document.location = '.';
            }, 3000);
            </script>

            <div class="message-success">
                <?php echo $this->_tpl_vars['translate_message_success_small']; ?>
.
            </div>
        <?php else: ?>
            <?php if ($this->_tpl_vars['feedbackArray']): ?>
                <div class="message-error">
                    <?php $_from = $this->_tpl_vars['feedbackArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
                        <?php if ($this->_tpl_vars['f'] == 'name'): ?>
                            <?php echo $this->_tpl_vars['translate_enter_name']; ?>
.<br />
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['f'] == 'email'): ?>
                            <?php echo $this->_tpl_vars['translate_mail_error']; ?>
.<br />
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['f'] == 'phone'): ?>
                            <?php echo $this->_tpl_vars['translate_phone_error']; ?>
.<br />
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['f'] == 'message'): ?>
                            <?php echo $this->_tpl_vars['translate_text_error']; ?>
.<br />
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="body">
                    <table>
                        <tr>
                            <td class="vtop"><?php echo $this->_tpl_vars['translate_name_small']; ?>
<span class="important">*</span>:</td>
                            <td><input class="js-required" type="text" name="fbname" id="id-fbname" value="<?php echo $this->_tpl_vars['control_fbname']; ?>
" /></td>
                        </tr>
                        <tr>
                            <td class="vtop"><?php echo $this->_tpl_vars['translate_phone']; ?>
<span class="important">*</span>:</td>
                            <td><input class="js-required js-phone-formatter" type="text" name="fbphone" id="id-fbphone" value="<?php echo $this->_tpl_vars['Control_fbphone']; ?>
" /></td>
                        </tr>
                        <tr>
                            <td class="vtop">E-mail<span class="important">*</span>:</td>
                            <td><input class="js-required" type="text" name="fbemail" id="id-fbemail" value="<?php echo $this->_tpl_vars['control_fbemail']; ?>
" /></td>
                        </tr>
                        <tr>
                            <td class="vtop"><?php echo $this->_tpl_vars['translate_message']; ?>
<span class="important">*</span>:</td>
                            <td><textarea class="js-required" name="fbmessage" cols="30" rows="10"><?php echo $this->_tpl_vars['control_fbmessage']; ?>
</textarea></td>
                        </tr>
                    </table>
                </div>
                <div class="foot">
                    <input type="hidden" name="ajs" class="ajs" value="1" />
                    <input class="js-form-validation os-submit" type="submit" name="feedback" value="<?php echo $this->_tpl_vars['translate_send']; ?>
" />
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php if ($this->_tpl_vars['feedbackmessage'] == 'error'): ?>
    <script type="text/javascript">
        $j(function() {
            $j('.js-popup-mail-block').toggle();
            return false;
        });
    </script>
<?php endif; ?>