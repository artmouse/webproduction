<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:10
         compiled from /var/www/shop.local//templates/default//shop_product_list_thumbs.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/shop.local//templates/default//shop_product_list_thumbs.html', 8, false),)), $this); ?>
<?php if ($this->_tpl_vars['productsArray']): ?>
    <div class="os-productthumb-list">
        <?php $_from = $this->_tpl_vars['productsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <div class="os-productthumb-element js-productthumb-element">
                <div class="wrapper js-wrapper">
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
                    <div class="name">
                        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" title="<?php echo $this->_tpl_vars['e']['name']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                    </div>
                    <div class="option"><?php if ($this->_tpl_vars['e']['code']): ?><?php echo $this->_tpl_vars['translate_code_small']; ?>
: <?php echo $this->_tpl_vars['e']['code']; ?>
<?php endif; ?></div>
                    <div class="option js-shop-compare" data-productid="<?php echo $this->_tpl_vars['e']['id']; ?>
">
                        <a href="javascript:void(0);" class="os-link-dashed js-shop-compare-action"><?php echo $this->_tpl_vars['translate_shop_compare_action']; ?>
</a>
                        <a href="/compare/" class="os-link-dashed js-shop-compared" style="display: none;"><?php echo $this->_tpl_vars['translate_compared']; ?>
</a>
                        <br /><a href="javascript:void(0);" data-productid="<?php echo $this->_tpl_vars['e']['id']; ?>
" class="os-link-dashed js-shop-favorite" ></a>
                    </div>
                    <div class="clear"></div>
                    <div class="block-price">
                        <?php if ($this->_tpl_vars['e']['price'] == 0): ?>
                            <div class="os-price-specify"><?php echo $this->_tpl_vars['translate_specify_a_price']; ?>
</div>
                        <?php else: ?>
                            <?php if (! $this->_tpl_vars['e']['avail']): ?>
                                <div class="os-price-unavailable"><?php echo $this->_tpl_vars['e']['price']; ?>
 <?php echo $this->_tpl_vars['e']['currency']; ?>
</div>
                            <?php else: ?>
                                <div class="os-price-available"><?php echo $this->_tpl_vars['e']['price']; ?>
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

                    <?php if ($this->_tpl_vars['e']['rating'] > 0): ?>
                        <div class="os-block-rating">
                            <div class="inner" style="width: <?php echo $this->_tpl_vars['e']['rating']*20; ?>
%;"></div>
                        </div>
                    <?php endif; ?>
                    <div class="clear"></div>

                    <div class="avail js-avail">
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

                    <div class="block-buttons">
                        <div class="row">
                            <?php if ($this->_tpl_vars['e']['canbuy'] || $this->_tpl_vars['e']['canMakePreorder']): ?>
                                <div class="button js-shop-buy" data-productid="<?php echo $this->_tpl_vars['e']['id']; ?>
">
                                    <a href="#" class="js-shop-buy-action os-submit green"><?php echo $this->_tpl_vars['translate_buy']; ?>
</a>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->_tpl_vars['isAdmin']): ?>
                                <?php if (! ( $this->_tpl_vars['e']['canbuy'] || $this->_tpl_vars['e']['canMakePreorder'] )): ?>
                                    <div class="button-expand">&nbsp;</div>
                                <?php endif; ?>
                                <div class="button edit">
                                    <a href="<?php echo $this->_tpl_vars['e']['urlEdit']; ?>
" class="os-submit red"></a>
                                </div>
                            <?php else: ?>
                                <?php if ($this->_tpl_vars['e']['canbuy'] || $this->_tpl_vars['e']['canMakePreorder']): ?>
                                    <div class="button">
                                        <a href="javascript: void(0);" onclick="basket_order_quick('<?php echo $this->_tpl_vars['e']['id']; ?>
', '<?php echo $this->_tpl_vars['e']['nameQuick']; ?>
');" class="os-submit quick"><?php echo $this->_tpl_vars['translate_buy_quick']; ?>
</a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (( $this->_tpl_vars['e']['discount'] && $this->_tpl_vars['e']['avail'] && ! $this->_tpl_vars['e']['canMakePreorder'] ) || ( $this->_tpl_vars['e']['discount'] && $this->_tpl_vars['e']['canMakePreorder'] && ! $this->_tpl_vars['e']['avail'] )): ?><div class="discount">-<?php echo $this->_tpl_vars['e']['discount']; ?>
%</div><?php endif; ?>

                    <div class="expanded js-expanded">
                        <?php if ($this->_tpl_vars['e']['descriptionshort']): ?>
                            <div class="description">
                                <span><?php echo $this->_tpl_vars['e']['descriptionshort']; ?>
</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; endif; unset($_from); ?>

        <div class="os-productthumb-empty js-product-list-ajax-add"></div>
        <div class="os-productthumb-empty"></div>
        <div class="os-productthumb-empty"></div>
        <div class="os-productthumb-empty"></div>
        <div class="os-productthumb-empty"></div>
    </div>
<?php else: ?>
    <div class="os-message-noproducts">
        <?php echo $this->_tpl_vars['translate_noproducts_message']; ?>
.
    </div>
<?php endif; ?>