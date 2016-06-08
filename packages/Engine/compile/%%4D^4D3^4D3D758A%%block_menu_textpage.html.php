<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:02
         compiled from /var/www/shop.local//templates/default//block/block_menu_textpage.html */ ?>
<ul class="list textpage-block-menu">
    <?php $_from = $this->_tpl_vars['textpageArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e1']):
?>
        <li>
            <a href="<?php echo $this->_tpl_vars['e1']['url']; ?>
" <?php if ($this->_tpl_vars['e1']['selected']): ?>class="selected"<?php endif; ?>><?php if ($this->_tpl_vars['e1']['btnName']): ?><?php echo $this->_tpl_vars['e1']['btnName']; ?>
<?php else: ?><?php echo $this->_tpl_vars['e1']['name']; ?>
<?php endif; ?></a>
            <?php if ($this->_tpl_vars['e1']['childArray']): ?>
               <ul class="sub">
                    <?php $_from = $this->_tpl_vars['e1']['childArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e2']):
?>
                        <li>
                            <a href="<?php echo $this->_tpl_vars['e2']['url']; ?>
" <?php if ($this->_tpl_vars['e2']['selected']): ?>class="selected"<?php endif; ?>><?php if ($this->_tpl_vars['e2']['btnName']): ?><?php echo $this->_tpl_vars['e2']['btnName']; ?>
<?php else: ?><?php echo $this->_tpl_vars['e2']['name']; ?>
<?php endif; ?></a>
                        </li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; endif; unset($_from); ?>
</ul>