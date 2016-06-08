<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 12:59:13
         compiled from /var/www/shop.local/modules/collars/contents/block/block_basket.html */ ?>
<a class="basket" id="id-shop-basket" href="<?php echo $this->_tpl_vars['main']; ?>
/basket/"><span id="id-basket-count"><?php echo $this->_tpl_vars['cnt']; ?>
</span></a>

<div class="cl-block-popup js-basket-popup" style="display: none;">
    <div class="dark" onclick="popupClose('.js-basket-popup');"></div>
    <div class="block-popup popup-basket">
        <div class="head">
            <a href="javascript: void(0);" class="close" onclick="popupClose('.js-basket-popup');">&nbsp;</a>
            <?php if ($this->_tpl_vars['basketArray']): ?>
                <?php echo $this->_tpl_vars['translate_added_to_basket']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['translate_basket_is_empty']; ?>

            <?php endif; ?>
        </div>

        <?php if ($this->_tpl_vars['basketArray']): ?>
        <div class="cl-block-cart">
            <?php $_from = $this->_tpl_vars['basketArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['setid'] => $this->_tpl_vars['set']):
?>
                <?php if ($this->_tpl_vars['setid'] > 0): ?>
                    <div class="block-row">
                        <?php echo $this->_tpl_vars['translate_nabor']; ?>

                    </div>
                <?php endif; ?>

                <?php $_from = $this->_tpl_vars['set']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                    <div class="block-row">
                        <div class="cell-element image">
                            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" alt="" /></a>
                        </div>

                        <div class="cell-element name">
                            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                            <?php if ($this->_tpl_vars['e']['option']): ?>
                            <div class="os-options-list">
                                <div class="body">
                                    <?php $_from = $this->_tpl_vars['e']['option']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['o']):
?>
                                    <?php echo $this->_tpl_vars['o']['name']; ?>
: <?php echo $this->_tpl_vars['o']['value']; ?>
<br>
                                    <?php endforeach; endif; unset($_from); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="cell-element no-small-breakpoint">&nbsp;</div>

                        <div class="cell-element nowrap">
                            <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                <?php if ($this->_tpl_vars['e']['price'] == '0.00'): ?>
                                    <?php echo $this->_tpl_vars['translate_specify_price']; ?>
.
                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['e']['price']; ?>
 <?php echo $this->_tpl_vars['e']['currency']; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="cell-element ta-center">
                            <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                <strong><?php echo $this->_tpl_vars['e']['count']; ?>
 <?php echo $this->_tpl_vars['e']['unit']; ?>
</strong>
                            <?php endif; ?>
                        </div>

                        <div class="cell-element nowrap">
                            <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                <?php if ($this->_tpl_vars['e']['sum'] == '0.00'): ?>
                                    <?php echo $this->_tpl_vars['translate_specify_price']; ?>
.
                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['e']['sum']; ?>
 <?php echo $this->_tpl_vars['e']['currency']; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php endforeach; endif; unset($_from); ?>
                <?php if ($this->_tpl_vars['setid'] > 0): ?>
                    <div class="block-row">
                        <div class="cell-element image">&nbsp;</div>
                        <div class="cell-element ta-center">
                            <?php echo $this->_tpl_vars['translate_tsena_nabora']; ?>

                        </div>
                        <div class="cell-element ta-center">
                            <?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['one']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>

                        </div>
                        <div class="cell-element ta-center">
                            <div class="count"><?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['count']; ?>
</div>
                        </div>
                        <div class="cell-element ta-center">
                            <?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['total']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>

                        </div>
                        <div class="cell-element no-small-breakpoint">&nbsp;</div>
                        <div class="clear"></div>
                    </div>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>

            <div class="total-row">
                <div class="item">
                                    </div>
                <div class="item">
                    <table class="sum-table fl-r">
                        <?php if ($this->_tpl_vars['deliveryName']): ?>
                            <tr>
                                <td><strong><?php echo $this->_tpl_vars['translate_delivery']; ?>
: <?php echo $this->_tpl_vars['deliveryName']; ?>
</strong></td>
                                <td><strong><?php echo $this->_tpl_vars['deliveryPrice']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</strong></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td><strong><?php echo $this->_tpl_vars['translate_in_total']; ?>
:</strong></td>
                            <td><strong><?php echo $this->_tpl_vars['allSum']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</strong></td>
                        </tr>
                    </table>
                    <div class="clear"></div>

                    <div class="block-button ta-right">
                        <a class="cl-button continue" href="javascript: void(0);" onclick="popupClose('.js-basket-popup');">Continue shopping</a>
                        <form class="ta-right" action="/basket/makeorder/" method="post" style="display: inline-block">
                            <a class="cl-button green small" href="/basket/"><?php echo $this->_tpl_vars['translate_place_an_order']; ?>
</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php else: ?>
            <div class="message-error">
                <?php echo $this->_tpl_vars['translate_basket_is_empty']; ?>
<br />
                <a href="/"><?php echo $this->_tpl_vars['translate_empty_basket']; ?>
</a>.
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="js-basket-button-inbasket" style="display: none;">
    <a href="#" class="js-shop-buy-action cl-button buy-button"><?php echo $this->_tpl_vars['translate_in_basket']; ?>
</a>
</div>