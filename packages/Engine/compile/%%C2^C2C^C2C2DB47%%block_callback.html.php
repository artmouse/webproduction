<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:09
         compiled from /var/www/shop.local//templates/default//block/block_callback.html */ ?>
<div class="os-block-popup call-block js-popup-callblock" style="display: none;">
    <div class="dark" onclick="popupClose('.js-popup-callblock');"></div>
    <div class="block-popup">
        <div class="head">
            <a href="javascript: void(0);" class="close" onclick="popupClose('.js-popup-callblock');">&nbsp;</a>
            <?php echo $this->_tpl_vars['translate_keep_your_contacts']; ?>
 <?php echo $this->_tpl_vars['translate_we_will_call']; ?>

        </div>
        
        <?php if ($this->_tpl_vars['callmessage'] == 'ok'): ?>
            <script type="text/javascript">
            $j(function() {
                $j('.js-popup-callblock').toggle();
                return false;
            });
            setTimeout(function() {
                document.location = '.';
            }, 3000);
            </script>
            <div class="message-success">
                <?php echo $this->_tpl_vars['translate_send_message_success']; ?>
!<br />
                <?php echo $this->_tpl_vars['translate_contact_manager_at_time']; ?>
.
            </div>
        <?php else: ?>
            <?php if ($this->_tpl_vars['callerrorsArray']): ?>
                <div class="message-error">
                    <?php $_from = $this->_tpl_vars['callerrorsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <?php if ($this->_tpl_vars['e'] == 'name'): ?>
                            <?php echo $this->_tpl_vars['translate_enter_name']; ?>
.<br />
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['e'] == 'phone'): ?>
                            <?php echo $this->_tpl_vars['translate_phone_error']; ?>
.<br />
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['e'] == 'answer'): ?>
                            <?php echo $this->_tpl_vars['translate_enter_question']; ?>
.
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
                            <td><input class="js-required" type="text" name="cbname" value="<?php echo $this->_tpl_vars['control_cbname']; ?>
" /></td>
                        </tr>
                        <tr>
                            <td class="vtop"><?php echo $this->_tpl_vars['translate_phone']; ?>
<span class="important">*</span>:</td>
                            <td><input class="js-required js-phone-formatter" type="text" name="cbphone" value="<?php echo $this->_tpl_vars['control_cbphone']; ?>
" /></td>
                        </tr>
                    </table>
                </div>
                <div class="foot">
                    <input type="hidden" name="ajs" class="ajs" value="1" />
                    <input class="js-form-validation os-submit" type="submit" name="call" value="<?php echo $this->_tpl_vars['translate_send']; ?>
" />
                </div>
            </form>
        <?php endif; ?>
        
    </div>
</div>

<?php if ($this->_tpl_vars['callmessage'] == 'error'): ?>
    <script type="text/javascript">
        $j(function() {
            $j('.js-popup-callblock').toggle();
            return false;
        });
    </script>
<?php endif; ?>