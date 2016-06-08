<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:08:57
         compiled from /var/www/shop.local//templates/default//shop_products_quick_order.html */ ?>
<div class="os-block-popup js-popup-quickorder" style="display: none;">
    <div class="dark" onclick="popupClose('.js-popup-quickorder');"></div>
    <div class="block-popup">
        <div class="head">
            <a href="javascript: void(0);" class="close" onclick="popupClose('.js-popup-quickorder');">&nbsp;</a>
            <?php echo $this->_tpl_vars['translate_quick_order']; ?>
: <samp id="quickOrderProductName"><?php echo $this->_tpl_vars['productName']; ?>
</samp>?
        </div>

        <form method="post">
            <div class="body">
                <table>
                    <tr>
                        <td class="vtop"><?php echo $this->_tpl_vars['translate_your_name']; ?>
 <span class="important">*</span>:</td>
                        <td><input class="js-required" id="qoname" type="text" name="qoname" value="<?php echo $this->_tpl_vars['control_qoname']; ?>
" /></td>
                    </tr>
                    <tr>
                        <td class="vtop"><?php echo $this->_tpl_vars['translate_phone']; ?>
 <span class="important">*</span>:</td>
                        <td><input class="js-required js-phone-formatter" id="qophone" type="text" name="qophone" value="<?php echo $this->_tpl_vars['control_qophone']; ?>
" /></td>
                    </tr>
                    <tr>
                        <td>
                            E-mail
                            <?php if ($this->_tpl_vars['requiredEmail']): ?>
                                <span class="important">*</span>
                            <?php endif; ?>
                            :
                        </td>
                        <td>
                            <input type="text" data-error ="<?php echo $this->_tpl_vars['translate_mail_error']; ?>
" name="qoemail" value="<?php echo $this->_tpl_vars['control_qoemail']; ?>
" class="js-check-email <?php if ($this->_tpl_vars['requiredEmail']): ?>js-required<?php endif; ?>" />
                        </td>
                    </tr>
                </table>
            </div>
            <div class="foot">
                <input type="hidden" name="productid" value="<?php echo $this->_tpl_vars['productID']; ?>
" />
                <input type="hidden" name="ajs" class="ajs" value="1" />
                <input type="submit" name="qosubmit" value="<?php echo $this->_tpl_vars['translate_ordering']; ?>
" class="os-submit js-form-validation" />
            </div>
        </form>
    </div>
</div>