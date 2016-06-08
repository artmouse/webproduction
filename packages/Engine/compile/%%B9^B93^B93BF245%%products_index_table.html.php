<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 12:07:12
         compiled from /var/www/shop.local/contents/shop/admin/products/products_index_table.html */ ?>
<?php if ($this->_tpl_vars['openCategoryId']): ?>
    <?php if ($this->_tpl_vars['productcount'] == 0): ?>
        <?php echo $this->_tpl_vars['translate_v_kategorii_net_tovarov']; ?>

    <?php else: ?>
        <?php echo $this->_tpl_vars['table']; ?>

    <?php endif; ?>
<?php else: ?>
    <?php echo $this->_tpl_vars['table']; ?>

<?php endif; ?>