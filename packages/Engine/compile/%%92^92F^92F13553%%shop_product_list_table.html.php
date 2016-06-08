<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 17:03:55
         compiled from /var/www/shop.local//templates/default//shop_product_list_table.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/shop.local//templates/default//shop_product_list_table.html', 7, false),)), $this); ?>
<?php if ($this->_tpl_vars['productsArray']): ?>
    <div class="os-productline-list">
        <?php $_from = $this->_tpl_vars['productsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <div class="os-productline-element js-os-productline-element">
                <div class="image">
                    <?php if ($this->_tpl_vars['e']['iconImage']): ?>
                        <img src="<?php echo $this->_tpl_vars['e']['iconImage']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['e']['iconName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['e']['iconName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="icon-image" />
                    <?php endif; ?>
                    <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></a>
                </div>
                <div class="block-buy">
                    <div class="block-price">
                        <?php if ($this->_tpl_vars['e']['price'] == 0): ?>
                            <div class="os-price-specify"><?php echo $this->_tpl_vars['translate_specify_a_price']; ?>
</div>
                        <?php else: ?>
                            <?php if ($this->_tpl_vars['e']['priceold'] && $this->_tpl_vars['e']['priceold'] > $this->_tpl_vars['e']['price']): ?>
                                <div class="os-price-old"><?php echo $this->_tpl_vars['e']['priceold']; ?>
 <?php echo $this->_tpl_vars['e']['currency']; ?>
</div>
                            <?php endif; ?>
                            <?php if (! $this->_tpl_vars['e']['avail']): ?>
                                <div class="os-price-unavailable"><?php echo $this->_tpl_vars['e']['price']; ?>
 <?php echo $this->_tpl_vars['e']['currency']; ?>
</div>
                            <?php else: ?>
                                <div class="os-price-available"><?php echo $this->_tpl_vars['e']['price']; ?>
 <?php echo $this->_tpl_vars['e']['currency']; ?>
</div>
                            <?php endif; ?>

                            <div class="js_personal_discount_check" data-productid="<?php echo $this->_tpl_vars['e']['id']; ?>
"></div>

                        <?php endif; ?>
                        <div class="js-shop-compare" data-productid="<?php echo $this->_tpl_vars['e']['id']; ?>
">
                            <a href="javascript:void(0);" class="os-link-dashed js-shop-compare-action"><?php echo $this->_tpl_vars['translate_shop_compare_action']; ?>
</a>
                            <a href="/compare/" class="os-link-dashed js-shop-compared" style="display: none;"><?php echo $this->_tpl_vars['translate_compared']; ?>
</a>
                            <br /><a href="javascript:void(0);" data-productid="<?php echo $this->_tpl_vars['e']['id']; ?>
" class="os-link-dashed js-shop-favorite" ></a>
                        </div>
                    </div>
                    <?php if (( $this->_tpl_vars['e']['discount'] && $this->_tpl_vars['e']['avail'] && ! $this->_tpl_vars['e']['canMakePreorder'] ) || ( $this->_tpl_vars['e']['discount'] && $this->_tpl_vars['e']['canMakePreorder'] && ! $this->_tpl_vars['e']['avail'] )): ?><div class="discount">-<?php echo $this->_tpl_vars['e']['discount']; ?>
%</div><?php endif; ?>
                    <?php if ($this->_tpl_vars['e']['canbuy'] || $this->_tpl_vars['e']['canMakePreorder']): ?>
                        <a class="os-submit small light" href="javascript: void(0);" onclick="basket_order_quick('<?php echo $this->_tpl_vars['e']['id']; ?>
', '<?php echo $this->_tpl_vars['e']['nameQuick']; ?>
');"><?php echo $this->_tpl_vars['translate_buy_quick']; ?>
</a>
                        <div class="js-shop-buy" data-productid="<?php echo $this->_tpl_vars['e']['id']; ?>
">
                            <a href="#" class="js-shop-buy-action os-submit green"><?php echo $this->_tpl_vars['translate_buy']; ?>
</a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="info">
                    <div class="name">
                        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" title="<?php echo $this->_tpl_vars['e']['name']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                    </div>
                    <?php if ($this->_tpl_vars['e']['code']): ?><div class="code"><?php echo $this->_tpl_vars['translate_item_code']; ?>
: <?php echo $this->_tpl_vars['e']['code']; ?>
</div><?php endif; ?>
                    <div class="avail">
                        <?php if ($this->_tpl_vars['e']['avail']): ?>
                            <?php if ($this->_tpl_vars['e']['availtext']): ?>
                                <div class="os-available"><?php echo $this->_tpl_vars['e']['availtext']; ?>
</div>
                            <?php else: ?>
                                <div class="os-available"><?php echo $this->_tpl_vars['translate_in_stock']; ?>
</div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($this->_tpl_vars['e']['availtext']): ?>
                                <div class="os-unavailable"><?php echo $this->_tpl_vars['e']['availtext']; ?>
</div>
                            <?php else: ?>
                                <div class="os-unavailable"><?php echo $this->_tpl_vars['translate_out_of_stock']; ?>
</div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <?php if ($this->_tpl_vars['e']['rating'] > 0): ?>
                        <div class="os-block-rating">
                            <div class="inner" style="width: <?php echo $this->_tpl_vars['rating']*20; ?>
%;"></div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="clear"></div>
            </div>
        <?php endforeach; endif; unset($_from); ?>
        <div class="js-product-list-ajax-add" style="display: none"></div>
    </div>
<?php else: ?>
    <div class="os-message-noproducts">
        <?php echo $this->_tpl_vars['translate_noproducts_message']; ?>
.
    </div>
<?php endif; ?>