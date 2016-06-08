<?php /* Smarty version 2.6.27-optimized, created on 2015-12-02 18:01:35
         compiled from /var/www/shop.local//templates/default//block/block_basket.html */ ?>
<div class="os-block-basket" id="id-shop-basket">
    <div class="head" onclick="document.location='<?php echo $this->_tpl_vars['main']; ?>
/basket/';">
        <span><?php echo $this->_tpl_vars['translate_in_yoar_basket']; ?>
</span>
        <span class="go"><?php echo $this->_tpl_vars['translate_go_basket']; ?>
</span>
    </div>
    <div class="body">
        <a href="#" class="os-link-dashed js-basketpopup-toggle"><?php echo $this->_tpl_vars['translate_goods']; ?>
 <span id="id-basket-count"><?php echo $this->_tpl_vars['cnt']; ?>
</span></a><br />
        <?php echo $this->_tpl_vars['translate_basket_block_amount']; ?>
 <span id="id-basket-sum"><?php echo $this->_tpl_vars['allSum']; ?>
</span> <?php echo $this->_tpl_vars['currency']; ?>

    </div>
</div>

<div class="os-block-popup js-basket-popup" style="display: none;">
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
            <div class="product-list">
                <table>
                    <thead>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="h-name"><?php echo $this->_tpl_vars['translate_product']; ?>
</td>
                            <td class="ta-center"><?php echo $this->_tpl_vars['translate_price']; ?>
</td>
                            <td class="ta-center"><?php echo $this->_tpl_vars['translate_number']; ?>
</td>
                            <td class="ta-center"><?php echo $this->_tpl_vars['translate_total']; ?>
</td>
                        </tr>
                    </thead>
                    <?php $_from = $this->_tpl_vars['basketArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['setid'] => $this->_tpl_vars['set']):
?>
                        <?php if ($this->_tpl_vars['setid'] > 0): ?>
                            <tr>
                                <td class="ta-center" colspan="5">
                                    <?php echo $this->_tpl_vars['translate_nabor']; ?>

                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php $_from = $this->_tpl_vars['set']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <tr>
                                <td class="ta-center">
                                    <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" alt="" /></a>
                                </td>
                                <td>
                                    <div class="name"><a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a></div>
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
                                </td>
                                <td>
                                    <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                        <?php if ($this->_tpl_vars['e']['price'] == '0.00'): ?>
                                            <div class="os-price-specify"><?php echo $this->_tpl_vars['translate_specify_price']; ?>
.</div>
                                        <?php else: ?>
                                            <div class="os-price-available"><?php echo $this->_tpl_vars['e']['price']; ?>
 <?php echo $this->_tpl_vars['e']['currency']; ?>
</div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="ta-center">
                                    <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                        <div class="count"><?php echo $this->_tpl_vars['e']['count']; ?>
 <?php echo $this->_tpl_vars['e']['unit']; ?>
</div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                        <?php if ($this->_tpl_vars['e']['sum'] == '0.00'): ?>
                                            <div class="os-price-specify"><?php echo $this->_tpl_vars['translate_specify_price']; ?>
.</div>
                                        <?php else: ?>
                                            <div class="os-price-available"><?php echo $this->_tpl_vars['e']['sum']; ?>
 <?php echo $this->_tpl_vars['e']['currency']; ?>
</div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; endif; unset($_from); ?>
                        <?php if ($this->_tpl_vars['setid'] > 0): ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td class="ta-center">
                                    <?php echo $this->_tpl_vars['translate_tsena_nabora']; ?>

                                </td>
                                <td class="ta-center">
                                    <?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['one']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>

                                </td>
                                <td class="ta-center">
                                    <div class="count"><?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['count']; ?>
</div>
                                </td>
                                <td class="ta-center">
                                    <?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['total']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>

                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                    <tfoot>
                        <?php if ($this->_tpl_vars['deliveryName']): ?>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td  colspan="2" class="ta-right"><div class="total"><?php echo $this->_tpl_vars['translate_delivery']; ?>
: <?php echo $this->_tpl_vars['deliveryName']; ?>
</div></td>
                                <td><div class="os-price-available"><?php echo $this->_tpl_vars['deliveryPrice']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</div></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                            <td class="ta-right"><div class="total"><?php echo $this->_tpl_vars['translate_in_total']; ?>
:</div></td>
                            <td><div class="os-price-available"><?php echo $this->_tpl_vars['allSum']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</div></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <a class="link os-link-dashed" href="javascript: void(0);" onclick="popupClose('.js-basket-popup');"> <?php echo $this->_tpl_vars['translate_continue_shopping']; ?>
</a>
                                <a class="link" href="/basket/"><?php echo $this->_tpl_vars['translate_go_basket']; ?>
</a>
                            </td>
                            <td class="ta-right" colspan="2">
                                <form class="ta-right" action="/basket/makeorder/" method="post">
                                    <a class="os-submit green" href="/basket/"><?php echo $this->_tpl_vars['translate_place_an_order']; ?>
</a>
                                </form>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <?php if ($this->_tpl_vars['recommendedArray']): ?>
                <div class="recomended-place">
                    <div class="os-recomended-caption"><?php echo $this->_tpl_vars['translate_our_recomendation']; ?>
</div>
                    <div class="os-recomended-list">
                        <?php $_from = $this->_tpl_vars['recommendedArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['r']):
?>
                            <div class="os-recomended-element">
                                <div class="recomended-wrap">
                                    <div class="block-image">
                                        <a href="<?php echo $this->_tpl_vars['r']['url']; ?>
">
                                            <img src="<?php echo $this->_tpl_vars['r']['image']; ?>
" alt="<?php echo $this->_tpl_vars['r']['name']; ?>
" title="<?php echo $this->_tpl_vars['r']['name']; ?>
">
                                        </a>
                                    </div>
                                    <div class="block-name">
                                        <a href="<?php echo $this->_tpl_vars['r']['url']; ?>
" title=""><?php echo $this->_tpl_vars['r']['name']; ?>
</a>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="block-button">
                                        <a href="<?php echo $this->_tpl_vars['r']['url']; ?>
" class="os-submit green"><?php echo $this->_tpl_vars['r']['price']; ?>
 <?php echo $this->_tpl_vars['r']['currency']; ?>
</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; endif; unset($_from); ?>
                    </div>
                </div>
            <?php endif; ?>
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
    <a href="#" class="js-shop-buy-action os-submit green"><?php echo $this->_tpl_vars['translate_in_basket']; ?>
</a>
</div>