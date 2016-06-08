<?php /* Smarty version 2.6.27-optimized, created on 2015-11-18 16:46:04
         compiled from /var/www/shop.local/packages/Forms/Forms_ContentFieldSelectList_Control.html */ ?>
<select name="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['disabled']): ?> disabled <?php endif; ?>>
    <?php $_from = $this->_tpl_vars['optionsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
        <option value="<?php echo $this->_tpl_vars['e']['value']; ?>
" <?php if ($this->_tpl_vars['e']['value'] == $this->_tpl_vars['value']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
    <?php endforeach; endif; unset($_from); ?>
</select>