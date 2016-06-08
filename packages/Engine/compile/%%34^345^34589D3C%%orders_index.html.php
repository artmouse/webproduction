<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:08:46
         compiled from /var/www/shop.local/modules/order/contents/admin//orders/orders_index.html */ ?>
<div class="nb-top-nav-place js-top-nav-buffer"></div>
<div class="nb-top-nav js-top-nav">
    <div class="nb-block-tabs">
        <div class="tab-element"><a href="/admin/shop/orders/" class="selected"><?php echo $this->_tpl_vars['translate_ords']; ?>
</a></div>
        <?php if ($this->_tpl_vars['acl']['orders_add']): ?>
            <div class="tab-element"><a href="/admin/shop/orders/add/"><?php echo $this->_tpl_vars['translate_order_add']; ?>
</a></div>
            <div class="tab-element"><a href="/admin/orders/exchange-xls/"><?php echo $this->_tpl_vars['translate_import_and_export_excel']; ?>
</a></div>
        <?php endif; ?>
        <div class="clear"></div>
    </div>
</div>

<?php echo $this->_tpl_vars['block_issue']; ?>