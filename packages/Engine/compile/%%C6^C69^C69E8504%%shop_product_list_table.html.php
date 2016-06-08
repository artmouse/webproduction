<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 12:59:35
         compiled from /var/www/shop.local/modules/collars/contents/shop_product_list_table.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/shop.local/modules/collars/contents/shop_product_list_table.html', 8, false),)), $this); ?>
<?php if ($this->_tpl_vars['productsArray']): ?>
<div class="cl-product-list">
    <ul class="small-block-grid-1 smaller-block-grid-2 medium-block-grid-3 sub-large-block-grid-4 large-block-grid-4">
        <?php $_from = $this->_tpl_vars['productsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
        <li>
            <div class="cl-product-thumb">
                <div class="block-image">
                    <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></a>
                </div>

                <div class="hidden-descript">

                    <div class="name"><a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" title="<?php echo $this->_tpl_vars['e']['name']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a></div>

                    <div class="block-price">
                        <?php if ($this->_tpl_vars['e']['price'] == 0): ?>
                        <div class="os-price-specify"><?php echo $this->_tpl_vars['translate_specify_a_price']; ?>
</div>
                        <?php else: ?>
                        <?php if (! $this->_tpl_vars['e']['avail']): ?>
                            <div class="os-price-unavailable <?php if ($this->_tpl_vars['e']['priceold'] && $this->_tpl_vars['e']['priceold'] > $this->_tpl_vars['e']['price']): ?>new-price<?php endif; ?>">
                                from <?php echo $this->_tpl_vars['e']['price']; ?>
 <?php echo $this->_tpl_vars['e']['currency']; ?>

                            </div>
                        <?php else: ?>
                            <div class="os-price-available <?php if ($this->_tpl_vars['e']['priceold'] && $this->_tpl_vars['e']['priceold'] > $this->_tpl_vars['e']['price']): ?>new-price<?php endif; ?>">
                                from <?php echo $this->_tpl_vars['e']['price']; ?>
 <?php echo $this->_tpl_vars['e']['currency']; ?>

                            </div>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['e']['priceold'] && $this->_tpl_vars['e']['priceold'] > $this->_tpl_vars['e']['price']): ?>
                        <div class="os-price-old">
                            <?php echo $this->_tpl_vars['e']['priceold']; ?>
 <?php echo $this->_tpl_vars['e']['currency']; ?>

                        </div>
                        <?php endif; ?>
                        <div class="js_personal_discount_check" data-productid="<?php echo $this->_tpl_vars['e']['id']; ?>
"></div>
                        <?php endif; ?>
                    </div>
                    <div class="block-button">
                        <?php if ($this->_tpl_vars['e']['canbuy'] || $this->_tpl_vars['e']['canMakePreorder']): ?>
                        <div class="button js-shop-buy" data-productid="<?php echo $this->_tpl_vars['e']['id']; ?>
">
                            <a href="#" class="js-shop-buy-action cl-button buy-button"><?php echo $this->_tpl_vars['translate_buy']; ?>
</a>
                        </div>
                        <?php endif; ?>
                        <a href="javascript:void(0);" class="cl-favorite-button js-shop-favorite"  data-productid="<?php echo $this->_tpl_vars['e']['id']; ?>
"></a>
                    </div>
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
