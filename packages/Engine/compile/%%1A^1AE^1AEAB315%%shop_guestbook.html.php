<?php /* Smarty version 2.6.27-optimized, created on 2015-11-23 15:07:23
         compiled from /var/www/shop.local/modules/collars/contents/shop_guestbook.html */ ?>
<br />
<br />
<?php if ($this->_tpl_vars['message'] == 'ok'): ?>
    <div class="os-message-success">
        <?php echo $this->_tpl_vars['translate_message_success']; ?>
.<br />
        <?php echo $this->_tpl_vars['translate_be_published']; ?>
.
    </div>
<?php endif; ?>

<?php if (! $this->_tpl_vars['guestBookArray']): ?>
    <div class="os-message-notice">
        <?php echo $this->_tpl_vars['translate_message_notice']; ?>

    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'error'): ?>
    <?php $_from = $this->_tpl_vars['errorsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
        <div class="os-message-error">
            <?php if ($this->_tpl_vars['e'] == 'response'): ?>
                <?php echo $this->_tpl_vars['translate_message_error']; ?>
.<br />
                <?php echo $this->_tpl_vars['translate_your_feedback']; ?>
<br />
            <?php elseif ($this->_tpl_vars['e'] == 'contact'): ?>
                <?php echo $this->_tpl_vars['translate_message_error']; ?>
.<br />
                <?php echo $this->_tpl_vars['translate_enter_name_or_login']; ?>
<br />
            <?php elseif ($this->_tpl_vars['e'] == 'name'): ?>
                <?php echo $this->_tpl_vars['translate_message_error']; ?>
.<br />
                <?php echo $this->_tpl_vars['translate_enter_name']; ?>
<br />
            <?php endif; ?>
        </div>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['guestBookArray']): ?>
    <div class="ta-center">
        <a href="javascript: void(0);" class="cl-button grey" onclick="popupOpen('.js-popup-review')"><?php echo $this->_tpl_vars['translate_leave_reply']; ?>
</a>
    </div>
    <br />

    <div class="os-block-faq">
        <?php $_from = $this->_tpl_vars['guestBookArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['g']):
?>
            <div class="element">
                <div class="identifier"></div>
                <?php echo $this->_tpl_vars['g']['response']; ?>

                <?php if ($this->_tpl_vars['g']['answer']): ?>
                    <div class="adminanswer">
                        <br />
                        <strong><?php echo $this->_tpl_vars['translate_answer_administration']; ?>
:</strong>
                        <br />
                        <?php echo $this->_tpl_vars['g']['answer']; ?>

                    </div>
                <?php endif; ?>
                <div class="date">
                    <?php echo $this->_tpl_vars['g']['cdate']; ?>

                    <?php if ($this->_tpl_vars['g']['name']): ?>
                        <?php echo $this->_tpl_vars['translate_from_small']; ?>
 <?php echo $this->_tpl_vars['g']['name']; ?>

                    <?php elseif ($this->_tpl_vars['g']['login']): ?>
                        <?php echo $this->_tpl_vars['translate_from_small']; ?>
 <?php echo $this->_tpl_vars['g']['login']; ?>

                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>
<br />
<div class="ta-center">
    <a href="javascript: void(0);" class="cl-button grey" onclick="popupOpen('.js-popup-review')"><?php echo $this->_tpl_vars['translate_leave_reply']; ?>
</a>
</div>
<br />
<br />
<br />

<?php if ($this->_tpl_vars['isUserAuthorized']): ?>
    <div id="form-order-id" class="cl-block-popup js-popup-review" style="display: none;">
        <div class="dark" onclick="popupClose('.js-popup-review');"></div>
        <div class="block-popup">
            <div class="head">
                <a href="javascript: void(0);" class="close" onclick="popupClose('.js-popup-review');">&nbsp;</a>
                <?php echo $this->_tpl_vars['translate_leave_reply']; ?>

            </div>
            <form method="post">
                <div class="body">
                    <div class="block-form">
                        <div class="form-element">
                            <div class="descript"><?php echo $this->_tpl_vars['translate_review_big']; ?>
<span class="important">*</span>:</div>
                            <textarea class="js-required" type="text" name="response"><?php echo $this->_tpl_vars['control_response']; ?>
</textarea>
                        </div>
                        <div class="form-element">
                            <div class="descript"><?php echo $this->_tpl_vars['translate_order_number']; ?>
:</div>
                            <input type="text" name="orderNumber" value="<?php echo $this->_tpl_vars['control_orderNumber']; ?>
"/>
                        </div>
                    </div>
                </div>
                <div class="foot ta-center">
                    <input type="hidden" name="ajs" class="ajs" value="1" />
                    <input class="js-form-validation cl-button" type="submit" name="guestbook" value="<?php echo $this->_tpl_vars['translate_send_message']; ?>
" />
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
    <?php if ($this->_tpl_vars['isUnregisteredUsers']): ?>
        <div id="form-order-id" class="cl-block-popup js-popup-review" style="display: none;">
            <div class="dark" onclick="popupClose('.js-popup-review');"></div>
            <div class="block-popup">
                <div class="head">
                    <a href="javascript: void(0);" class="close" onclick="popupClose('.js-popup-review');">&nbsp;</a>
                    <?php echo $this->_tpl_vars['translate_leave_reply']; ?>

                </div>
                <form method="post">
                    <div class="body">
                        <div class="block-form">
                            <div class="form-element">
                                <div class="descript"><?php echo $this->_tpl_vars['translate_name_small']; ?>
<span class="important">*</span>:</div>
                                <input type="text" name="name" value="<?php echo $this->_tpl_vars['control_name']; ?>
" />
                            </div>
                            <div class="form-element">
                                <div class="descript"><?php echo $this->_tpl_vars['translate_phone']; ?>
<span class="important">*</span>:</div>
                                <input type="text" name="phone" value="<?php echo $this->_tpl_vars['control_phone']; ?>
" />
                            </div>
                            <div class="form-element">
                                <div class="descript">Email<span class="important">*</span>:</div>
                                <input type="text" name="email" value="<?php echo $this->_tpl_vars['control_email']; ?>
" />
                            </div>
                            <div class="form-element">
                                <div class="descript"><?php echo $this->_tpl_vars['translate_review_big']; ?>
<span class="important">*</span>:</div>
                                <textarea type="text" name="response"><?php echo $this->_tpl_vars['control_response']; ?>
</textarea>
                            </div>
                            <div class="form-element">
                                <div class="descript"><?php echo $this->_tpl_vars['translate_order_number']; ?>
:</div>
                                <input type="text" name="orderNumber" value="<?php echo $this->_tpl_vars['control_orderNumber']; ?>
"/>
                            </div>
                        </div>
                    </div>
                    <div class="foot ta-center">
                        <input type="hidden" name="ajs" class="ajs" value="1" />
                        <input type="submit" name="guestbook" value="<?php echo $this->_tpl_vars['translate_send_message']; ?>
" class="cl-button green" />
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="os-message-info">
            <?php echo $this->_tpl_vars['translate_message_info']; ?>
.
        </div>
    <?php endif; ?>
<?php endif; ?>