<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 12:07:17
         compiled from /var/www/shop.local/contents/shop/admin/products/products_menu.html */ ?>
<div class="nb-top-nav-place js-top-nav-buffer"></div>
<div class="nb-top-nav js-top-nav">
    <div class="nb-block-tabs">
        <div class="tab-element"><a href="/admin/shop/products/list-table/">&lsaquo; <?php echo $this->_tpl_vars['translate_many_products']; ?>
</a></div>
        <?php if ($this->_tpl_vars['canEdit'] || $this->_tpl_vars['selected'] == 'edit'): ?>
            <div class="tab-element">
                <a href="../edit/" <?php if ($this->_tpl_vars['selected'] == 'edit'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_edit']; ?>
</a>
            </div>
        <?php endif; ?>
        <div class="clear"></div>
    </div>
</div>

<div class="ob-block-head js-block-head">
    <div class="background" <?php if ($this->_tpl_vars['bigImage']): ?>style="background-image: url('<?php echo $this->_tpl_vars['bigImage']; ?>
');"<?php endif; ?>>
        <?php if ($this->_tpl_vars['menuColor']): ?><span style="background-color: <?php echo $this->_tpl_vars['menuColor']; ?>
;"></span><?php endif; ?>
    </div>
    <div class="head-wrap">
        <?php if ($this->_tpl_vars['image']): ?>
            <div class="image"><a class="js-colorbox-head" <?php if ($this->_tpl_vars['bigImage']): ?>href="<?php echo $this->_tpl_vars['bigImage']; ?>
"<?php else: ?>href="<?php echo $this->_tpl_vars['image']; ?>
"<?php endif; ?>><img src="<?php echo $this->_tpl_vars['image']; ?>
" alt=""/></a></div>
        <?php endif; ?>

        <div class="info">
            <div class="caption">
                <?php if ($this->_tpl_vars['productId']): ?>
                    <div class="tag"><span>#<?php echo $this->_tpl_vars['productId']; ?>
</span></div>
                <?php endif; ?>
                <h1><?php echo $this->_tpl_vars['productName']; ?>
</h1>

                <div class="description"><?php echo $this->_tpl_vars['description']; ?>
</div>

                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="navigation js-ui-navigation">
        <?php if ($this->_tpl_vars['canEdit'] || $this->_tpl_vars['selected'] == 'edit'): ?>
            <a href="../edit/" <?php if ($this->_tpl_vars['selected'] == 'edit'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_edit']; ?>
</a>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['canViewSuppliers']): ?>
            <a href="../supplier/" <?php if ($this->_tpl_vars['selected'] == 'supplier'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_suppliers']; ?>
</a>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['canViewFilters']): ?>
            <a href="../filters/" <?php if ($this->_tpl_vars['selected'] == 'filters'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_products_filters_only']; ?>
</a>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['canViewViews']): ?>
            <a href="../view/" <?php if ($this->_tpl_vars['selected'] == 'view'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_views']; ?>
</a>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['canViewComments']): ?>
            <a href="../comments/" <?php if ($this->_tpl_vars['selected'] == 'comments'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_many_comments']; ?>
</a>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['canViewHistory']): ?>
            <a href="../history/" <?php if ($this->_tpl_vars['selected'] == 'history'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_history']; ?>
</a>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['canViewPriceplaces']): ?>
            <a href="../priceplaces/" <?php if ($this->_tpl_vars['selected'] == 'priceplaces'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_priceplace']; ?>
</a>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['canViewRelated']): ?>
            <a href="../related/" <?php if ($this->_tpl_vars['selected'] == 'related'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_related_products']; ?>
</a>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['canViewLists']): ?>
            <a href="../lists/" <?php if ($this->_tpl_vars['selected'] == 'lists'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_lists']; ?>
</a>
            <a href="../sets/" <?php if ($this->_tpl_vars['selected'] == 'action_set'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_aktsionnie_nabori']; ?>
</a>
        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['moduleTabArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" <?php if ($this->_tpl_vars['selected'] == $this->_tpl_vars['e']['moduleName']): ?> class="selected" <?php endif; ?> ><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['canDelete']): ?>
            <a href="../delete/"  <?php if ($this->_tpl_vars['selected'] == 'delete'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_delete']; ?>
</a>
        <?php endif; ?>
    </div>
</div>

<script>
    // инициализация просмотра картинок
    $j('.js-colorbox-head').colorbox({
        maxWidth: '95%',
        maxHeight: '95%',
        current: false,
        returnFocus: false
    });
</script>