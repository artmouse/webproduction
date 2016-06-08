<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 17:04:05
         compiled from /var/www/shop.local/api/forms/Shop_ContentTable_Stepper.html */ ?>
<?php if (count ( $this->_tpl_vars['pagesArray'] ) > 1): ?>
    <div class="ob-block-stepper">
        <?php if ($this->_tpl_vars['urlprev']): ?>
            <a href="<?php echo $this->_tpl_vars['urlprev']; ?>
" class="prev">&lsaquo; <?php echo $this->_tpl_vars['translate_back']; ?>
</a>
            <?php if ($this->_tpl_vars['hellip']): ?>&hellip;<?php endif; ?>
        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['pagesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" <?php if ($this->_tpl_vars['e']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['urlnext']): ?>
            <?php if ($this->_tpl_vars['hellip']): ?>&hellip;<?php endif; ?>
            <a href="<?php echo $this->_tpl_vars['urlnext']; ?>
" class="next"><?php echo $this->_tpl_vars['translate_next']; ?>
 &rsaquo;</a>
        <?php endif; ?>
    </div>
<?php endif; ?>