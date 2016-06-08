<?php /* Smarty version 2.6.27-optimized, created on 2015-11-20 17:46:29
         compiled from /var/www/shop.local//templates/default//shop_category.html */ ?>
<?php echo $this->_tpl_vars['block_banner_top']; ?>


<?php if ($this->_tpl_vars['seoh1']): ?>
    <h1 class="title"><?php echo $this->_tpl_vars['seoh1']; ?>
 <?php echo $this->_tpl_vars['pathAdditionalH1']; ?>
</h1>
<?php elseif ($this->_tpl_vars['categoryName']): ?>
    <h1 class="title"><?php echo $this->_tpl_vars['categoryName']; ?>
 <?php echo $this->_tpl_vars['pathAdditionalH1']; ?>
</h1>
<?php endif; ?>

<?php if ($this->_tpl_vars['description']): ?>
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
<?php endif; ?>

<?php echo $this->_tpl_vars['items']; ?>


<?php if ($this->_tpl_vars['tagArray']): ?>
    <?php echo $this->_tpl_vars['translate_also']; ?>
:
    <?php $_from = $this->_tpl_vars['tagArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
    <?php endforeach; endif; unset($_from); ?>
    <br />
    <br />
<?php endif; ?>

<?php echo $this->_tpl_vars['seocontent']; ?>