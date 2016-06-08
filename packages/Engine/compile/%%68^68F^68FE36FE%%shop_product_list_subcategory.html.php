<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 11:39:40
         compiled from /var/www/shop.local/modules/collars/contents/shop_product_list_subcategory.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/shop.local/modules/collars/contents/shop_product_list_subcategory.html', 9, false),)), $this); ?>
<?php if ($this->_tpl_vars['subcategoriesArray']): ?>
    <div class="os-category-list">
        <ul class="small-block-grid-1 smaller-block-grid-2 medium-block-grid-3 sub-large-block-grid-4 large-block-grid-4">
            <?php $_from = $this->_tpl_vars['subcategoriesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                <li>
                    <div class="os-category-element">
                        <div class="image">
                            <?php if ($this->_tpl_vars['e']['image']): ?>
                                <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></a>
                            <?php else: ?>
                                <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><img src="/media/shop/stub.jpg" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></a>
                            <?php endif; ?>
                        </div>
                        <div class="name">
                            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                        </div>
                    </div>
                </li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
<?php else: ?>
    <div class="os-message-noproducts">
        <?php echo $this->_tpl_vars['translate_noproducts_message']; ?>
.
    </div>
<?php endif; ?>