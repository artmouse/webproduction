<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 18:00:39
         compiled from /var/www/shop.local/modules/order/contents/admin//orders/orders_control.html */ ?>
<?php echo $this->_tpl_vars['block_menu']; ?>


<?php if ($this->_tpl_vars['message'] == 'access'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_dostup_zapreshchen']; ?>
.
    </div> 
    <script>setTimeout("location='/admin/shop/orders/'",3000);</script>
<?php else: ?>
    <?php if ($this->_tpl_vars['message'] == 'ok' || $this->_tpl_vars['arg_message'] == 'ok'): ?>
        <div class="shop-message-success">
            <?php echo $this->_tpl_vars['translate_order_update_success']; ?>
.
        </div>
    <?php endif; ?>

    <?php if (! $this->_tpl_vars['canEdit']): ?>
        <div class="shop-message-info">
            <?php echo $this->_tpl_vars['translate_order_cant_edit_mess']; ?>
.
        </div>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="ob-grid-default">
            <div class="main-layer">
                <div class="block-zone">
                    <?php echo $this->_tpl_vars['block_info']; ?>

                    <?php echo $this->_tpl_vars['block_product_list']; ?>

                    <?php echo $this->_tpl_vars['block_workflow']; ?>

                    <?php echo $this->_tpl_vars['block_processorform']; ?>

                    <?php echo $this->_tpl_vars['block_comment']; ?>

                </div>
            </div>
            <div class="aside-layer">
                <div class="block-zone">
                    <div class="ob-block-element wrapped">
                        <div class="block-caption"><?php echo $this->_tpl_vars['translate_aktivnie_zakazi']; ?>
</div>
                        <?php $_from = $this->_tpl_vars['activeOrderArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
                            <a class="shop-activity-preview" href="<?php echo $this->_tpl_vars['p']['url']; ?>
" style="background-color: <?php echo $this->_tpl_vars['p']['color']; ?>
">
                                <span class="activity-head">
                                    <span class="ob-icon-order type-icon"></span>
                                    <span class="subject">#<?php echo $this->_tpl_vars['p']['id']; ?>
</span>
                                    <span class="name"><?php echo $this->_tpl_vars['p']['clientName']; ?>
</span>
                                </span>
                            </a>
                        <?php endforeach; endif; unset($_from); ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <?php if ($this->_tpl_vars['canEdit']): ?>
            <div class="ob-button-fixed">
                <input type="hidden" name="ok" value="1" />
                <input type="submit" value="<?php echo $this->_tpl_vars['translate_save']; ?>
" class="ob-button button-green js-clear-localstorage" onclick="shopWaitShow('<?php echo $this->_tpl_vars['translate_vipolnyaetsya_sohranenie_zakaza']; ?>
.');" />

                <input type="hidden" name="menu_statusid" value="" id="js-issue-input-statusid" />
                <?php $_from = $this->_tpl_vars['statusNextArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                    <input type="submit" value="<?php echo $this->_tpl_vars['e']['name']; ?>
" class="ob-button" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
"
                       onclick="$j('#js-issue-input-statusid').val($j(this).data('id')); shopWaitShow('<?php echo $this->_tpl_vars['translate_vipolnyaetsya_sohranenie_zadachi']; ?>
.');"
                    <?php if ($this->_tpl_vars['e']['colour']): ?>style="background-color: <?php echo $this->_tpl_vars['e']['colour']; ?>
; color: #000000 !important;"<?php endif; ?> />
                <?php endforeach; endif; unset($_from); ?>

                <input class="ob-button" type="button" name="name" onclick="$j('#js-text-order-popup').fadeToggle();" value="<?php echo $this->_tpl_vars['translate_tekst_zakaza']; ?>
" style="float: right; margin-right: 20px;" />
                <a class="ob-button" href="./printing/" style="float: right;"><?php echo $this->_tpl_vars['translate_print']; ?>
</a>
                <div class="clear"></div>
            </div>
            <div class="ob-button-fixed-place"></div>
        <?php endif; ?>

        <div class="shop-block-popup" id="js-text-order-popup" style="display: none;">
            <div class="dark"></div>
            <div class="popupblock">
                <a href="#" class="close" onclick="$j('#js-text-order-popup').fadeToggle();">
                    <svg viewBox="0 0 16 16">
                        <use xlink:href="#icon-close"></use>
                    </svg>
                </a>
                <div class="head"><?php echo $this->_tpl_vars['translate_tekst_zakaza']; ?>
</div>
                <div class="window-content">
                    <div class="fake-textarea" contenteditable>
                        <table style="width: 100%; border-spacing: 2px; table-layout: fixed">
                            <tr>
                                <td colspan="4">
                                    <?php echo $this->_tpl_vars['translate_ord']; ?>
: <?php echo $this->_tpl_vars['orderName']; ?>

                                </td>
                            </tr>
                            <?php $_from = $this->_tpl_vars['productsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
                                <tr>
                                    <td class="va-top"><?php if ($this->_tpl_vars['p']['suppliercode']): ?><?php echo $this->_tpl_vars['p']['suppliercode']; ?>
<?php else: ?><?php echo $this->_tpl_vars['p']['productid']; ?>
<?php endif; ?></td>
                                    <td class="va-top"><?php echo $this->_tpl_vars['p']['name']; ?>
</td>
                                    <td class="va-top"><?php echo $this->_tpl_vars['p']['count']; ?>
 <?php echo $this->_tpl_vars['translate_sht']; ?>
</td>
                                    <td class="va-top"><?php echo $this->_tpl_vars['p']['price']*$this->_tpl_vars['p']['count']; ?>
 <?php echo $this->_tpl_vars['p']['currencySym']; ?>
</td>
                                </tr>
                            <?php endforeach; endif; unset($_from); ?>
                            <?php if ($this->_tpl_vars['deliveryPrice'] > 0): ?>
                                <tr>
                                    <td colspan="4" class="va-top"><?php echo $this->_tpl_vars['translate_delivery']; ?>
 <?php if ($this->_tpl_vars['deliveryPrice']): ?><?php echo $this->_tpl_vars['deliveryPrice']; ?>
<?php endif; ?> <?php echo $this->_tpl_vars['currency']; ?>
 <?php if ($this->_tpl_vars['payDelivery']): ?>(<?php echo $this->_tpl_vars['translate_ne_uchitivaetsya']; ?>
)<?php endif; ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['discountSum'] > 0): ?>
                                <tr>
                                    <td colspan="4" class="va-top"><?php echo $this->_tpl_vars['translate_discount']; ?>
 <?php echo $this->_tpl_vars['discountSum']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="4" class="va-top"><?php echo $this->_tpl_vars['translate_in_total']; ?>
: <?php echo $this->_tpl_vars['totalSum']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php endif; ?>