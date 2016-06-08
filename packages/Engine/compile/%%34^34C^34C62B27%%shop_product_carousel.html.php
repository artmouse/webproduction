<?php /* Smarty version 2.6.27-optimized, created on 2015-11-13 16:34:34
         compiled from /var/www/shop.local//templates/default//shop_product_carousel.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/var/www/shop.local//templates/default//shop_product_carousel.html', 1, false),array('modifier', 'escape', '/var/www/shop.local//templates/default//shop_product_carousel.html', 9, false),)), $this); ?>
<?php if (count($this->_tpl_vars['productsArray']) > 2): ?>
    <div class="os-product-carousel">
        <div class="inner">
            <div class="line" data-auto="<?php echo $this->_tpl_vars['autoplay']; ?>
">
                <ul>
                    <?php $_from = $this->_tpl_vars['productsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
                        <li>
                            <div class="image">
                                <a href="<?php echo $this->_tpl_vars['p']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['p']['image']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['p']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['p']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></a>
                            </div>
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
                                        <div class="os-price-unavailable"><?php echo $this->_tpl_vars['p']['price']; ?>
 <?php echo $this->_tpl_vars['p']['currency']; ?>
</div>
                                    <?php else: ?>
                                        <div class="os-price-available"><?php echo $this->_tpl_vars['p']['price']; ?>
 <?php echo $this->_tpl_vars['p']['currency']; ?>
</div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <div class="avail">
                                <?php if ($this->_tpl_vars['p']['avail']): ?>
                                    <?php if ($this->_tpl_vars['p']['availtext']): ?>
                                        <div class="os-available"><?php echo $this->_tpl_vars['p']['availtext']; ?>
</div>
                                    <?php else: ?>
                                        <div class="os-available"><?php echo $this->_tpl_vars['translate_in_stock']; ?>
</div>
                                    <?php endif; ?>
                                    <div class="button">
                                        <div class="js-shop-buy" data-productid="<?php echo $this->_tpl_vars['p']['id']; ?>
">
                                            <a href="#" class="os-submit green js-shop-buy-action"><?php echo $this->_tpl_vars['translate_buy']; ?>
</a>
                                        </div>
                                        <a class="os-submit small light" href="javascript: void(0);" onclick="basket_order_quick('<?php echo $this->_tpl_vars['p']['id']; ?>
', '<?php echo $this->_tpl_vars['p']['name']; ?>
');"><?php echo $this->_tpl_vars['translate_buy_quick']; ?>
</a>
                                    </div>
                                <?php else: ?>
                                    <?php if ($this->_tpl_vars['p']['availtext']): ?>
                                        <div class="os-unavailable"><?php echo $this->_tpl_vars['p']['availtext']; ?>
</div>
                                    <?php else: ?>
                                        <div class="os-unavailable"><?php echo $this->_tpl_vars['translate_out_of_stock']; ?>
</div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            </div>
        </div>
        <a href="#" class="next">&nbsp;</a>
    </div>
<?php endif; ?>