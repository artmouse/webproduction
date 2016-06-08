<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 18:38:25
         compiled from /var/www/shop.local/modules/collars/contents/block/block_delivery_default.html */ ?>
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
        <?php endif; ?>

    <?php if ($this->_tpl_vars['needaddress']): ?>

    
    <tr>
        <td class="vtop" style="width: 120px;"> Street <span class="important">*</span>:</td>
        <td>
            <input class="js-required" type="text" id="street" name="street" value="" />
        </td>
    </tr>

    <tr>
        <td class="vtop" style="width: 120px;"> Town (City) <span class="important">*</span>:</td>
        <td>
            <input class="js-required" type="text" id="town" name="city" value="" />
        </td>
    </tr>

    <tr>
        <td class="vtop" style="width: 120px;"> Postal Code <span class="important">*</span>:</td>
        <td>
            <input class="js-required" type="text" id="postal" name="postal" value="" />
        </td>
    </tr>


    <tr>
        <td class="vtop" style="width: 120px;"> Country <span class="important">*</span>:</td>
        <td>
            <input class="js-required" type="text" id="country" name="country" value="" />
        </td>
    </tr>

    <?php endif; ?>
</table>
<?php endif; ?>