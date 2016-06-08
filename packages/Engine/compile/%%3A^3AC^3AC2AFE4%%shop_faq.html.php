<?php /* Smarty version 2.6.27-optimized, created on 2015-11-23 15:52:26
         compiled from /var/www/shop.local//templates/default//shop_faq.html */ ?>
<?php if ($this->_tpl_vars['message'] == 'ok'): ?>
    <div class="os-message-success">
        <?php echo $this->_tpl_vars['translate_message_success']; ?>
.<br />
        <?php echo $this->_tpl_vars['translate_be_notified']; ?>
.
    </div>
<?php endif; ?>

<?php if (! $this->_tpl_vars['faqArray']): ?>
    <div class="os-message-notice">
        <?php echo $this->_tpl_vars['translate_message_notice']; ?>

    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'error'): ?>
    <div class="os-message-error">
        <?php echo $this->_tpl_vars['translate_message_error']; ?>
.<br />
        <?php echo $this->_tpl_vars['translate_fill_a_field']; ?>
<br />
    </div>
<?php endif; ?>

<div class="os-block-faq">
    <?php $_from = $this->_tpl_vars['faqArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
        <div class="element">
            <div class="identifier" style="background-color: <?php echo $this->_tpl_vars['f']['color']; ?>
;"></div>
            <div class="question" id="question<?php echo $this->_tpl_vars['f']['id']; ?>
">
                <?php echo $this->_tpl_vars['f']['question']; ?>

                <div class="name"><?php echo $this->_tpl_vars['translate_from_small']; ?>
 <?php echo $this->_tpl_vars['f']['name']; ?>
</div>
                <a href="/faq/<?php echo $this->_tpl_vars['f']['id']; ?>
/?prev_page=<?php echo $this->_tpl_vars['f']['prevPage']; ?>
" class="more"><?php echo $this->_tpl_vars['translate_read_answer']; ?>
 &rarr;</a>
            </div>
        </div>
    <?php endforeach; endif; unset($_from); ?>
</div>

<?php if ($this->_tpl_vars['isUserAuthorized']): ?>
    <a href="javascript: void(0);" class="os-submit" onclick="popupOpen('.js-popup-faq-block');"><?php echo $this->_tpl_vars['translate_ask_the_administration']; ?>
</a>
    <div id="form-order-id" class="os-block-popup js-popup-faq-block" style="display: none;">
        <div class="dark" onclick="popupClose('.js-popup-faq-block');"></div>
        <div class="block-popup">
            <div class="head">
                <a href="javascript: void(0);" class="close" onclick="popupClose('.js-popup-faq-block');">&nbsp;</a>
                <?php echo $this->_tpl_vars['translate_ask_the_administration']; ?>

            </div>
            <form method="post">
                <div class="body">
                    <table>
                        <tr>
                            <td class="vtop"><?php echo $this->_tpl_vars['translate_question']; ?>
<span class="important">*</span>:</td>
                            <td><textarea class="js-required" type="text" name="question"></textarea></td>
                        </tr>
                    </table>
                </div>
                <div class="foot">
                    <input type="hidden" name="ajs" class="ajs" value="1" />
                    <input class="js-form-validation os-submit" type="submit" name="faq" value="<?php echo $this->_tpl_vars['translate_send_message']; ?>
" />
                </div>
            </form>
        </div>

    </div>
<?php else: ?>
     <div class="os-message-info">
        <?php echo $this->_tpl_vars['translate_must_register']; ?>
.
    </div>
<?php endif; ?>