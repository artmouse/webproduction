<?php /* Smarty version 2.6.27-optimized, created on 2015-11-22 14:28:41
         compiled from /var/www/shop.local/modules/collars/contents/shop_index.html */ ?>
<?php $_from = $this->_tpl_vars['carouselArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
    <?php if ($this->_tpl_vars['e']['html'] !== ""): ?>
        <h2 class="ta-center"><?php echo $this->_tpl_vars['e']['name']; ?>
</h2>
        <?php echo $this->_tpl_vars['e']['html']; ?>

    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>



