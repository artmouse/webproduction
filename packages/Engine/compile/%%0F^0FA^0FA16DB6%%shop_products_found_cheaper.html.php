<?php /* Smarty version 2.6.27-optimized, created on 2015-12-08 11:55:08
         compiled from /var/www/shop.local//templates/default//shop_products_found_cheaper.html */ ?>
<div class="os-block-popup" id="id-found-cheaper-message-success" style="display: none;">
    <div class="dark" onclick="popupClose('#id-found-cheaper-message-success');"></div>
    <div class="block-popup">
        <div class="head">
            <a href="javascript: void(0);" class="close" onclick="popupClose('#id-found-cheaper-message-success');">&nbsp;</a>
            <?php echo $this->_tpl_vars['translate_found_cheaper']; ?>
 <?php echo $this->_tpl_vars['e']['name']; ?>
?
            <span><?php echo $this->_tpl_vars['translate_cheaper_message']; ?>
</span>
        </div>
        <div class="message-success">
            <?php echo $this->_tpl_vars['translate_message_success_small']; ?>
.
        </div>
    </div>
</div>

<div class="os-block-popup js-block-cheaper" style="display: none;">
    <div class="dark" onclick="popupClose('.js-block-cheaper');"></div>
    <?php if ($this->_tpl_vars['foundCheaperMessage'] !== 'ok'): ?>
        <div class="block-popup">
            <div class="head">
                <a href="javascript: void(0);" class="close" onclick="popupClose('.js-block-cheaper');">&nbsp;</a>
                <?php echo $this->_tpl_vars['translate_found_cheaper']; ?>
 <?php echo $this->_tpl_vars['e']['name']; ?>
?
                <span><?php echo $this->_tpl_vars['translate_cheaper_message']; ?>
</span>
            </div>
            <?php if ($this->_tpl_vars['foundCheaperErrorArray']): ?>
                <div class="message-error">
                    <?php $_from = $this->_tpl_vars['foundCheaperErrorArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
                        <?php if ($this->_tpl_vars['f'] == 'where'): ?>
                            <?php echo $this->_tpl_vars['translate_where_error']; ?>
.<br />
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['f'] == 'price'): ?>
                            <?php echo $this->_tpl_vars['translate_price_error']; ?>
.<br />
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <div class="body">
                    <table>
                        <tr>
                            <td class="vtop"><?php echo $this->_tpl_vars['translate_where']; ?>
<span class="important">*</span>:</td>
                            <td><input class="js-required" type="text" name="where" value="<?php echo $this->_tpl_vars['control_where']; ?>
" /></td>
                        </tr>
                        <tr>
                            <td class="vtop"><?php echo $this->_tpl_vars['translate_price']; ?>
<span class="important">*</span>:</td>
                            <td><input class="js-required" type="text" name="price" value="<?php echo $this->_tpl_vars['control_price']; ?>
" /></td>
                        </tr>
                        <tr>
                            <td class="vtop"><?php echo $this->_tpl_vars['translate_your_name']; ?>
<span class="important">*</span>:</td>
                            <td><input class="js-required" type="text" name="name" value="<?php echo $this->_tpl_vars['control_name']; ?>
" /></td>
                        </tr>
                        <tr>
                            <td class="vtop"><?php echo $this->_tpl_vars['translate_mail']; ?>
<span class="important">*</span>:</td>
                            <td><input class="js-required" type="text" name="email" value="<?php echo $this->_tpl_vars['control_email']; ?>
" /></td>
                        </tr>
                        <tr>
                            <td class="vtop"><?php echo $this->_tpl_vars['translate_city']; ?>
</td>
                            <td><input type="text" name="city" value="<?php echo $this->_tpl_vars['control_city']; ?>
" /></td>
                        </tr>
                        <tr>
                            <td class="vtop"><?php echo $this->_tpl_vars['translate_contact_phone']; ?>
<span class="important">*</span>:</td>
                            <td><input class="js-required js-phone-formatter" type="text" name="phone" value="<?php echo $this->_tpl_vars['control_phone']; ?>
" /></td>
                        </tr>
                    </table>
                </div>
                <div class="foot">
                    <input type="hidden" name="productid" value="<?php echo $this->_tpl_vars['productID']; ?>
"/>
                    <input type="hidden" name="ajs" class="ajs" value="1" />
                    <input class="js-form-validation os-submit" type="submit" name="foundcheaper" value="<?php echo $this->_tpl_vars['translate_send']; ?>
" />
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php if ($this->_tpl_vars['foundCheaperMessage'] == 'error'): ?>
    <script type="text/javascript">
        $j(function () {
            popupOpen('.js-block-cheaper');
        });
    </script>
<?php endif; ?>

<?php if ($this->_tpl_vars['foundCheaperMessage'] == 'ok'): ?>
    <script type="text/javascript">
        $j(function () {
            popupOpen('#id-found-cheaper-message-success');
        });
        
        setTimeout(function() {
            document.location = '.';
        }, 3000);
    </script>
<?php endif; ?>