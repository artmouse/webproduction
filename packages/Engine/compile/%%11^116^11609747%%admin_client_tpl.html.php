<?php /* Smarty version 2.6.27-optimized, created on 2015-12-08 14:20:50
         compiled from /var/www/shop.local/modules/collars/contents/client/admin_client_tpl.html */ ?>
<div class="cl-block-tabs">
    <div class="tabs">
        <?php if ($this->_tpl_vars['admin']): ?>
            <a href="/admin/"><?php echo $this->_tpl_vars['translate_administration']; ?>
</a>
        <?php endif; ?>

        <a href="/client/profile/" <?php if ($this->_tpl_vars['page'] == 'shop-client-profile'): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['translate_profile_small']; ?>
</a>
        <a href="/client/orders/" <?php if ($this->_tpl_vars['page'] == 'shop-client-orders' || $this->_tpl_vars['page'] == 'shop-client-orders-view'): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['translate_my_orders']; ?>
</a>
        <a href="/client/products/viewed/" <?php if ($this->_tpl_vars['page'] == 'shop-client-products-viewed'): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['translate_products_viewed_small']; ?>
</a>
        <a href="/client/products/ordered/" <?php if ($this->_tpl_vars['page'] == 'shop-client-products-ordered'): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['translate_products_ordered_small']; ?>
</a>

        <?php if ($this->_tpl_vars['countCompare']): ?><a href="/compare/"><?php echo $this->_tpl_vars['translate_products_compare']; ?>
</a><?php endif; ?>

        <?php $_from = $this->_tpl_vars['moduleTabArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" <?php if ($this->_tpl_vars['selected'] == $this->_tpl_vars['e']['moduleName']): ?> class="selected" <?php endif; ?> ><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
        <?php endforeach; endif; unset($_from); ?>

        <a href="/logout/"><?php echo $this->_tpl_vars['translate_logout']; ?>
</a>
    </div>
</div>

<?php echo $this->_tpl_vars['content']; ?>