<?php /* Smarty version 2.6.27-optimized, created on 2015-11-22 15:58:50
         compiled from /var/www/shop.local//templates/default//shop_brand.html */ ?>
<?php echo $this->_tpl_vars['block_banner_top']; ?>


<h1 class="title"><?php echo $this->_tpl_vars['brandname']; ?>
 <?php echo $this->_tpl_vars['pathAdditionalH1']; ?>
</h1>

<div class="os-category-description">
    <?php if ($this->_tpl_vars['image']): ?>

        <img src="<?php echo $this->_tpl_vars['image']; ?>
" alt="<?php echo $this->_tpl_vars['categoryName']; ?>
" title="<?php echo $this->_tpl_vars['categoryName']; ?>
" />

    <?php endif; ?>

    <div class="os-editor-content js-ckEditor-container">
        <?php echo $this->_tpl_vars['description']; ?>

    </div>

    <div class="clear"></div>

</div>

<?php echo $this->_tpl_vars['items']; ?>


<?php if ($this->_tpl_vars['seoh1']): ?><h2><?php echo $this->_tpl_vars['seoh1']; ?>
</h2><?php endif; ?>

<?php echo $this->_tpl_vars['seocontent']; ?>
