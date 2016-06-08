<?php /* Smarty version 2.6.27-optimized, created on 2015-12-08 12:38:17
         compiled from /var/www/shop.local/packages/Forms/Forms_ContentFieldTextarea_Control.html */ ?>
<textarea name="<?php echo $this->_tpl_vars['key']; ?>
" style="width: 99%; height: <?php if (! $this->_tpl_vars['height']): ?>100px;<?php else: ?><?php echo $this->_tpl_vars['height']; ?>
;<?php endif; ?>" <?php if ($this->_tpl_vars['disabled']): ?> disabled <?php endif; ?>><?php echo $this->_tpl_vars['value']; ?>
</textarea>