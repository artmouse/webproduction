<?php /* Smarty version 2.6.27-optimized, created on 2015-12-20 19:36:46
         compiled from /var/www/shop.local/modules/collars/contents/shop_products_quick_order.html */ ?>
<div class="cl-block-popup js-popup-quickorder" style="display: none;">
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
                <div class="block-form">
                    <div class="form-element">
                        <div class="descript"><?php echo $this->_tpl_vars['translate_your_name']; ?>
 <span class="important">*</span>:</div>
                        <input class="js-required" id="qoname" type="text" name="qoname" value="<?php echo $this->_tpl_vars['control_qoname']; ?>
" />
                    </div>

                    <div class="form-element">
                        <div class="descript"><?php echo $this->_tpl_vars['translate_phone']; ?>
 <span class="important">*</span>:</div>
                        <input class="js-required js-phone-formatter" id="qophone" type="text" name="qophone" value="<?php echo $this->_tpl_vars['control_qophone']; ?>
" />
                    </div>

                    <div class="form-element">
                        <div class="descript">
                            E-mail <?php if ($this->_tpl_vars['requiredEmail']): ?><span class="important">*</span><?php endif; ?>:
                        </div>
                        <input type="text" data-error ="<?php echo $this->_tpl_vars['translate_mail_error']; ?>
" name="qoemail" value="<?php echo $this->_tpl_vars['control_qoemail']; ?>
" class="js-check-email <?php if ($this->_tpl_vars['requiredEmail']): ?>js-required<?php endif; ?>" />
                    </div>
                </div>
            </div>
            <div class="foot">
                <input type="hidden" name="productid" value="<?php echo $this->_tpl_vars['productID']; ?>
" />
                <textarea id="option" name="productoption" style="display: none;"></textarea>
                <input type="hidden" name="ajs" class="ajs" value="1" />
                <input type="submit" name="qosubmit" value="<?php echo $this->_tpl_vars['translate_ordering']; ?>
" class="cl-button green js-form-validation" />
            </div>
        </form>
    </div>
</div>
