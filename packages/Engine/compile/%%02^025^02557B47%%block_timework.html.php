<?php /* Smarty version 2.6.27-optimized, created on 2015-11-30 18:31:09
         compiled from /var/www/shop.local//templates/default//block/block_timework.html */ ?>
<?php if ($this->_tpl_vars['currentTimeworkArray']): ?>
    <div>
        <?php $_from = $this->_tpl_vars['currentTimeworkArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <?php echo $this->_tpl_vars['e']; ?>
<br/>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>