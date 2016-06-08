<?php /* Smarty version 2.6.27-optimized, created on 2015-11-26 14:07:00
         compiled from /var/www/shop.local//templates/default//shop_basket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/shop.local//templates/default//shop_basket.html', 39, false),array('modifier', 'number_format', '/var/www/shop.local//templates/default//shop_basket.html', 67, false),)), $this); ?>
<div class="os-crumbs">
    <a href="/"><?php echo $this->_tpl_vars['translate_main']; ?>
</a>
    <?php echo $this->_tpl_vars['translate_my_basket']; ?>

</div>

<h1 class="title"><?php echo $this->_tpl_vars['translate_my_basket']; ?>
</h1>


<form method="post" id="id-basket" enctype="multipart/form-data">
    <?php if (! $this->_tpl_vars['basketArray']): ?>
        <div class="os-message-error">
            <div class="caption"><?php echo $this->_tpl_vars['translate_basket_is_empty']; ?>
</div>
            <a href="/"><?php echo $this->_tpl_vars['translate_empty_basket']; ?>
</a>.
        </div>
    <?php else: ?>
        <div class="os-basket-page">
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
    foreach ($_from as $this->_tpl_vars['b']):
?>
                        <tr>
                            <td class="ta-center">
                                <a href="<?php echo $this->_tpl_vars['projecturl']; ?>
<?php echo $this->_tpl_vars['b']['pUrl']; ?>
" target="_blank">
                                    <img src="<?php echo $this->_tpl_vars['b']['image']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['b']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['b']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                                </a>
                            </td>
                            <td>
                                <div class="name"><a href="<?php echo $this->_tpl_vars['projecturl']; ?>
<?php echo $this->_tpl_vars['b']['pUrl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['b']['name']; ?>
</a></div>
                                <?php echo $this->_tpl_vars['b']['description']; ?>

                                <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                    <?php if ($this->_tpl_vars['b']['optionArray']): ?>
                                        <div class="os-options-list">
                                            <div class="body">
                                                <?php $_from = $this->_tpl_vars['b']['optionArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                                    <select name="option-<?php echo $this->_tpl_vars['b']['id']; ?>
-<?php echo $this->_tpl_vars['e']['id']; ?>
">
                                                        <option  value=""><?php echo $this->_tpl_vars['translate_specify']; ?>
 <?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                                                        <?php $_from = $this->_tpl_vars['e']['valueArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                                                            <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['v'] == $this->_tpl_vars['e']['selectedValue']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['v']; ?>
</option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                <?php endforeach; endif; unset($_from); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                   <?php if ($this->_tpl_vars['b']['price'] == '0.00'): ?>
                                       <div class="os-price-specify"><?php echo $this->_tpl_vars['translate_specify_price']; ?>
.</div>
                                   <?php else: ?>
                                       <div class="os-price-available"><?php echo ((is_array($_tmp=$this->_tpl_vars['b']['price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['b']['currency']; ?>
</div>
                                   <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                    <div class="count">
                                        <a href="<?php echo $this->_tpl_vars['b']['urldelete']; ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['translate_delete'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="delete">&nbsp;</a>
                                        <?php if (! $this->_tpl_vars['b']['coupon']): ?>
                                            <input type="hidden" name="selproducts[]" value="<?php echo $this->_tpl_vars['b']['id']; ?>
" />
                                            <input onkeydown="$j('#b<?php echo $this->_tpl_vars['b']['id']; ?>
').attr('checked', 'checked');" type="text" name="pcount_<?php echo $this->_tpl_vars['b']['id']; ?>
" value="<?php echo $this->_tpl_vars['b']['count']; ?>
" />
                                        <?php endif; ?>

                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                   <?php if ($this->_tpl_vars['b']['sum'] == '0.00'): ?>
                                       <div class="os-price-specify"><?php echo $this->_tpl_vars['translate_specify_price']; ?>
.</div>
                                   <?php else: ?>
                                       <div class="os-price-available"><?php echo ((is_array($_tmp=$this->_tpl_vars['b']['sum'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['b']['currency']; ?>
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
                                <div class="os-price-specify"><?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['one']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</div>
                            </td>
                            <td>
                                <div class="count">
                                    <a href="<?php echo $this->_tpl_vars['b']['urldelete']; ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['translate_delete'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="delete">&nbsp;</a>
                                    <input type="hidden" name="setproducts[]" value="<?php echo $this->_tpl_vars['setid']; ?>
" />
                                    <input type="text" name="setcount_<?php echo $this->_tpl_vars['setid']; ?>
" value="<?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['count']; ?>
" />
                                </div>
                            </td>
                            <td class="ta-center">
                                <div class="os-price-specify"><?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['total']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>

                <tr class="delivery">
                    <td colspan="2">&nbsp;</td>
                    <td colspan="1"><?php echo $this->_tpl_vars['translate_promocode']; ?>
:</td>
                    <td colspan="2" class="ta-right">
                        <input  type="text" name="coupon" value="<?php if ($this->_tpl_vars['couponCode']): ?><?php echo $this->_tpl_vars['couponCode']; ?>
 <?php else: ?><?php echo $this->_tpl_vars['control_coupon']; ?>
 <?php endif; ?>" class="promo js-coupon-formatter" <?php if ($this->_tpl_vars['couponCode']): ?>disabled<?php endif; ?>/>
                        <span class="<?php if ($this->_tpl_vars['couponCode']): ?>coupongood<?php else: ?>coupon<?php endif; ?>">
                            <?php if ($this->_tpl_vars['couponUse']): ?>
                                <?php echo $this->_tpl_vars['translate_coupon_already_use']; ?>
.
                            <?php elseif ($this->_tpl_vars['couponCodeFalse']): ?>
                                <?php echo $this->_tpl_vars['translate_invalid_code']; ?>
.
                            <?php elseif ($this->_tpl_vars['couponCode']): ?>
                                <?php echo $this->_tpl_vars['translate_code_true']; ?>
.
                            <?php else: ?>
                                &nbsp;
                            <?php endif; ?>
                        </span>
                    </td>
                </tr>

                <?php if ($this->_tpl_vars['discountName']): ?>
                    <tr class="delivery">
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">
                            <?php echo $this->_tpl_vars['translate_discount']; ?>
:
                            <?php echo $this->_tpl_vars['discountName']; ?>

                        </td>
                        <td>
                            <div class="os-price-available">-<?php echo ((is_array($_tmp=$this->_tpl_vars['discountSum'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</div>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['deliveryName']): ?>
                    <tr class="delivery">
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">
                            <?php echo $this->_tpl_vars['translate_delivery']; ?>
:
                            <?php echo $this->_tpl_vars['deliveryName']; ?>

                        </td>
                        <td>
                            <div class="os-price-available"><?php echo ((is_array($_tmp=$this->_tpl_vars['deliveryPrice'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</div>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr class="total">
                    <td colspan="2">&nbsp;</td>
                    <td colspan="2">
                        <?php echo $this->_tpl_vars['translate_in_total']; ?>
:
                    </td>
                    <td>
                        <div class="os-price-available"><?php echo ((is_array($_tmp=$this->_tpl_vars['allSum'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</div>
                    </td>
                </tr>
            </table>

            <?php if ($this->_tpl_vars['authorizedFail']): ?>
                <br />
                <div class="os-message-error">
                    <?php echo $this->_tpl_vars['translate_need_sign_in']; ?>
 <a href="/registration/"><?php echo $this->_tpl_vars['translate_sing_up']; ?>
</a>
                </div>
                <br />
            <?php endif; ?>
            <div class="buttons">
                <input type="hidden" name="pchcount" value="<?php echo $this->_tpl_vars['translate_calculate']; ?>
" />
                <a class="fl-l" href="javascript:void(0);" onclick="if(confirm('<?php echo $this->_tpl_vars['translate_baket_clear_confirm']; ?>
')) document.location='<?php echo $this->_tpl_vars['urlclear']; ?>
';"><?php echo $this->_tpl_vars['translate_clear']; ?>
</a>

                <input class="js-refresh" type="submit" name="refresh" value="<?php echo $this->_tpl_vars['translate_calculate']; ?>
" style="display: none;" />
                <a href="javascript:void(0);" onclick="$j('.js-refresh').click();"><?php echo $this->_tpl_vars['translate_calculate']; ?>
</a>

                <?php if ($this->_tpl_vars['basketArray']): ?>
                    <input class="os-submit green" type="submit" name="makeOrder" value="<?php echo $this->_tpl_vars['translate_basket_nextstep']; ?>
 &rsaquo;" />
                <?php endif; ?>
                <div class="clear"></div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['userlevel'] > 1): ?>
        <div class="os-form-find">
            <table>
                <tr>
                    <td class="name"><?php echo $this->_tpl_vars['translate_search_and_add']; ?>
:</td>
                    <td><input type="text" name="addproduct" value="" id="id-addproduct" placeholder="<?php echo $this->_tpl_vars['translate_enter_search_text']; ?>
..." /></td>
                    <td><input type="text" name="addproductcount" value="1" class="count" /></td>
                    <td><input type="submit" name="add" value="<?php echo $this->_tpl_vars['translate_add']; ?>
" class="os-submit" /></td>
                </tr>
            </table>
        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['recommendedArray']): ?>
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
"><img src="<?php echo $this->_tpl_vars['r']['image']; ?>
" alt="<?php echo $this->_tpl_vars['r']['name']; ?>
" title="<?php echo $this->_tpl_vars['r']['name']; ?>
"></a>
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
    <?php endif; ?>

    <?php if (! $this->_tpl_vars['basketArray']): ?>
        <?php $_from = $this->_tpl_vars['carouselArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <div class="os-block-caption"><h3><?php echo $this->_tpl_vars['e']['name']; ?>
</h3></div>
            <?php echo $this->_tpl_vars['e']['html']; ?>

        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['tabsArray']): ?>
            <div class="os-block-tabs" id="id-tabs">
                <?php $_from = $this->_tpl_vars['tabsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                    <a href="#" data-rel=".tab-<?php echo $this->_tpl_vars['e']['id']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                <?php endforeach; endif; unset($_from); ?>
                <div class="clear"></div>
            </div>
        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['tabsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <div class="tab-<?php echo $this->_tpl_vars['e']['id']; ?>
 shop-tabI" style="display: none;"><?php echo $this->_tpl_vars['e']['html']; ?>
</div>
        <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
</form>