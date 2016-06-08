<?php /* Smarty version 2.6.27-optimized, created on 2015-11-18 16:46:04
         compiled from /var/www/shop.local/packages/Forms/Forms_ContentField_Control.html */ ?>
<input  type="text"
        name="<?php echo $this->_tpl_vars['key']; ?>
"
        value="<?php echo $this->_tpl_vars['control_value']; ?>
"
        <?php if ($this->_tpl_vars['cssclass']): ?> class="<?php echo $this->_tpl_vars['cssclass']; ?>
" <?php endif; ?>
        style="width: 80%; <?php if (! $this->_tpl_vars['valid']): ?> border: 1px solid red; <?php endif; ?>"
        <?php if ($this->_tpl_vars['disabled']): ?> disabled <?php endif; ?>
        />