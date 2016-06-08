<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 12:59:13
         compiled from /var/www/shop.local/modules/collars/contents/shop_product_carousel.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/var/www/shop.local/modules/collars/contents/shop_product_carousel.html', 1, false),array('modifier', 'escape', '/var/www/shop.local/modules/collars/contents/shop_product_carousel.html', 13, false),)), $this); ?>
<?php if (count($this->_tpl_vars['productsArray']) > 2): ?>
    <div class="cl-product-list">
        <ul class="small-block-grid-1 smaller-block-grid-3 medium-block-grid-4 sub-large-block-grid-4 large-block-grid-6">
            <?php $_from = $this->_tpl_vars['productsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
                <li>
                    <div class="cl-product-thumb">
                        <div class="block-image">
                                                        <a href="<?php echo $this->_tpl_vars['p']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['p']['image']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['p']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['p']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></a>
                        </div>
                        <div class="hidden-descript">
                            <div class="name">
                                <a href="<?php echo $this->_tpl_vars['p']['url']; ?>
" title="<?php echo $this->_tpl_vars['p']['name']; ?>
"><?php echo $this->_tpl_vars['p']['name']; ?>
</a>
                            </div>
                            <div class="block-price">
                                <?php if ($this->_tpl_vars['p']['price'] == 0): ?>
                                    <div class="os-price-specify"><?php echo $this->_tpl_vars['translate_specify_a_price']; ?>
</div>
                                <?php else: ?>
                                    <?php if (! $this->_tpl_vars['p']['avail']): ?>
                                        <div class="os-price-unavailable">from <?php echo $this->_tpl_vars['p']['price']; ?>
 <?php echo $this->_tpl_vars['p']['currency']; ?>
</div>
                                    <?php else: ?>
                                        <div class="os-price-available">from <?php echo $this->_tpl_vars['p']['price']; ?>
 <?php echo $this->_tpl_vars['p']['currency']; ?>
</div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="block-button">
                                <div class="js-shop-buy" data-productid="<?php echo $this->_tpl_vars['p']['id']; ?>
">
                                    <a href="#" class="cl-button buy-button js-shop-buy-action"><?php echo $this->_tpl_vars['translate_buy']; ?>
</a>
                                </div>
                                <a class="cl-favorite-button js-shop-favorite" href="javascript:void(0);" data-productid="<?php echo $this->_tpl_vars['p']['id']; ?>
"></a>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
<?php endif; ?>
