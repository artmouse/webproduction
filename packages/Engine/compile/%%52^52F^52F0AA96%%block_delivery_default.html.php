<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 17:21:41
         compiled from /var/www/shop.local//templates/default//block/block_delivery_default.html */ ?>
<?php if ($this->_tpl_vars['contentAdmin']): ?>
    <?php if ($this->_tpl_vars['needcountry']): ?>
        <div class="form-element">
            <div class="element-caption"><?php echo $this->_tpl_vars['translate_country']; ?>
</div>
            <input type="text" name="country" value="<?php echo $this->_tpl_vars['control_country']; ?>
" />
        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['needcity']): ?>
        <div class="form-element">
            <div class="element-caption"><?php echo $this->_tpl_vars['translate_city']; ?>
</div>
            <input type="text" name="city" value="<?php echo $this->_tpl_vars['control_city']; ?>
" />
        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['needaddress']): ?>
        <div class="form-element">
            <div class="element-caption"><?php echo $this->_tpl_vars['translate_delivery_address']; ?>
</div>
            <input type="text" name="address" value="<?php echo $this->_tpl_vars['control_address']; ?>
" />
        </div>
    <?php endif; ?>
<?php else: ?>
    <table>
        <?php if ($this->_tpl_vars['needcountry']): ?>
            <tr id="needcountry">
                <td class="vtop" style="width: 120px;"><?php echo $this->_tpl_vars['translate_country']; ?>
 <span class="important">*</span>:</td>
                <td><input class="js-required" type="text" id="usercountry" name="country" value="<?php echo $this->_tpl_vars['control_country']; ?>
" /></td>
            </tr>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['needcity']): ?>
            <tr id="needcity">
                <td class="vtop" style="width: 120px;"><?php echo $this->_tpl_vars['translate_city']; ?>
 <span class="important">*</span>:</td>
                <td>
                    <div style="display: none;">
                        <select id="js-delivery-city-select" name="city_select" class="chzn-select" style="width: 90%;"></select>
                    </div>
                    <input class="js-required" id="usercity" type="text" name="city" value="<?php echo $this->_tpl_vars['control_city']; ?>
" />
                </td>
            </tr>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['needaddress']): ?>
            <tr id="needaddress">
                <td class="vtop" style="width: 120px;"><?php echo $this->_tpl_vars['translate_delivery_address']; ?>
 <span class="important">*</span>:</td>
                <td>
                    <div style="display: none;">
                        <select id="js-delivery-office-select" name="delivery_office_select" class="chzn-select" style="width: 90%;"></select>
                    </div>
                    <input class="js-required" type="text" id="useraddress" name="address" value="<?php echo $this->_tpl_vars['control_address']; ?>
" />
                    <input class="js-required" type="text" id="useraddress" name="address" value="<?php echo $this->_tpl_vars['control_address']; ?>
" />
                </td>
            </tr>
        <?php endif; ?>
    </table>
<?php endif; ?>