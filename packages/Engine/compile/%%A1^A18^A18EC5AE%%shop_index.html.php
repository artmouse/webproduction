<?php /* Smarty version 2.6.27-optimized, created on 2015-11-16 18:05:32
         compiled from /var/www/shop.local//templates/default//shop_index.html */ ?>
<?php echo $this->_tpl_vars['block_banner_top_index']; ?>


<?php if ($this->_tpl_vars['seotextinindexpage']): ?>
    <?php echo $this->_tpl_vars['seotextinindexpage']; ?>

<?php endif; ?>

<?php $_from = $this->_tpl_vars['carouselArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
    <?php if ($this->_tpl_vars['e']['html'] !== ""): ?>
        <div class="os-block-caption">
            <h3><?php echo $this->_tpl_vars['e']['name']; ?>
</h3>
        </div>
        <?php echo $this->_tpl_vars['e']['html']; ?>

    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['tabsArray']): ?>
    <div class="os-block-tabs" id="id-tabs">
        <?php $_from = $this->_tpl_vars['tabsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <a href="#" data-rel=".tab-<?php echo $this->_tpl_vars['e']['id']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
        <?php endforeach; endif; unset($_from); ?>
        <div class="clear"></div>
    </div>

    <?php $_from = $this->_tpl_vars['tabsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
        <div class="tab-<?php echo $this->_tpl_vars['e']['id']; ?>
 shop-tabI" style="display: none;"><?php echo $this->_tpl_vars['e']['html']; ?>
</div>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['setArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
">
            <?php echo $this->_tpl_vars['e']['name']; ?>

            <img src="<?php echo $this->_tpl_vars['e']['image']; ?>
">
        </a>
<?php endforeach; endif; unset($_from); ?>

<?php echo $this->_tpl_vars['block_brand_top']; ?>


<?php echo $this->_tpl_vars['block_category_top']; ?>