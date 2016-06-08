<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 16:21:03
         compiled from /var/www/shop.local/modules/collars/contents/shop_basket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/shop.local/modules/collars/contents/shop_basket.html', 38, false),array('modifier', 'number_format', '/var/www/shop.local/modules/collars/contents/shop_basket.html', 65, false),)), $this); ?>
<h1><?php echo $this->_tpl_vars['translate_my_basket']; ?>
</h1>

<div class="cl-crumbs">
    <div>
        <a href="/"><?php echo $this->_tpl_vars['translate_main']; ?>
</a>
    </div>
    <div>
        <a href="#"><?php echo $this->_tpl_vars['translate_my_basket']; ?>
</a>
    </div>
</div>



<form method="post" id="id-basket" enctype="multipart/form-data">
    <?php if (! $this->_tpl_vars['basketArray']): ?>
        <div class="os-message-error">
            <div class="caption"><?php echo $this->_tpl_vars['translate_basket_is_empty']; ?>
</div>
            <a href="/"><?php echo $this->_tpl_vars['translate_empty_basket']; ?>
</a>.
        </div>
    <?php else: ?>

        <div class="cl-block-cart">

            <?php $_from = $this->_tpl_vars['basketArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['setid'] => $this->_tpl_vars['set']):
?>
                <?php if ($this->_tpl_vars['setid'] > 0): ?>
                    <div class="block-row ta-center">
                        <br />
                        <br />
                        <strong style="font-size: 16px"><?php echo $this->_tpl_vars['translate_nabor']; ?>
</strong>
                        <br />
                        <br />
                    </div>
                <?php endif; ?>
                <?php $_from = $this->_tpl_vars['set']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['b']):
?>
                    <div class="block-row">
                        <div class="cell-element image">
                            <a href="<?php echo $this->_tpl_vars['projecturl']; ?>
<?php echo $this->_tpl_vars['b']['pUrl']; ?>
" target="_blank">
                                <img src="<?php echo $this->_tpl_vars['b']['image']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['b']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['b']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                            </a>
                        </div>

                        <div class="cell-element name">
                            <a class="product-name" href="<?php echo $this->_tpl_vars['projecturl']; ?>
<?php echo $this->_tpl_vars['b']['pUrl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['b']['name']; ?>
</a>
                            <span class="small-font">by</span>
                            <a href="<?php echo $this->_tpl_vars['b']['brand_url']; ?>
" class="brand"><?php echo $this->_tpl_vars['b']['brand_name']; ?>
</a>
                            <a class="cl-favorite-button js-shop-favorite" data-productid="<?php echo $this->_tpl_vars['b']['id']; ?>
" href="javascript:void(0);"></a>
                            <?php if ($this->_tpl_vars['b']['option']): ?>
                            <div class="os-options-list">
                                <div class="body">
                                    <?php $_from = $this->_tpl_vars['b']['option']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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

                        <div class="cell-element">
                            <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                <?php if ($this->_tpl_vars['b']['price'] == '0.00'): ?>
                                    <?php echo $this->_tpl_vars['translate_specify_price']; ?>
.
                                <?php else: ?>
                                    <?php echo ((is_array($_tmp=$this->_tpl_vars['b']['price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['b']['currency']; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="cell-element ta-center">
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
                        </div>

                        <div class="cell-element">
                            <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                <?php if ($this->_tpl_vars['b']['sum'] == '0.00'): ?>
                                    <?php echo $this->_tpl_vars['translate_specify_price']; ?>
.
                                <?php else: ?>
                                    <?php echo ((is_array($_tmp=$this->_tpl_vars['b']['sum'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['b']['currency']; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php endforeach; endif; unset($_from); ?>

                <?php if ($this->_tpl_vars['setid'] > 0): ?>
                    <div class="block-row">
                        <div class="cell-element image">&nbsp;</div>

                        <div class="cell-element name ta-center">
                            <?php echo $this->_tpl_vars['translate_tsena_nabora']; ?>

                        </div>

                        <div class="cell-element no-small-breakpoint">&nbsp;</div>

                        <div class="cell-element ta-center">
                            <?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['one']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>

                        </div>

                        <div class="cell-element ta-center">
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
                        </div>

                        <div class="cell-element">
                            <?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['total']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>

                        </div>
                        <div class="clear"></div>
                    </div>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>

            <div class="total-row">
                <div class="item">

                </div>
                <div class="item">
                    <table class="sum-table fl-r">
                        <?php if ($this->_tpl_vars['discountName']): ?>
                            <tr>
                                <td>
                                    <?php echo $this->_tpl_vars['translate_discount']; ?>
:
                                    <?php echo $this->_tpl_vars['discountName']; ?>

                                </td>
                                <td>
                                    -<?php echo ((is_array($_tmp=$this->_tpl_vars['discountSum'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['currency']; ?>

                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['deliveryName']): ?>
                            <tr class="delivery">
                                <td>
                                    <?php echo $this->_tpl_vars['translate_delivery']; ?>
:
                                    <?php echo $this->_tpl_vars['deliveryName']; ?>

                                </td>
                                <td>
                                    <?php echo ((is_array($_tmp=$this->_tpl_vars['deliveryPrice'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['currency']; ?>

                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr class="total">
                            <td>
                                <?php echo $this->_tpl_vars['translate_in_total']; ?>
:
                            </td>
                            <td>
                                <?php echo ((is_array($_tmp=$this->_tpl_vars['allSum'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['currency']; ?>

                            </td>
                        </tr>
                    </table>
                    <div class="clear"></div>
                    <div class="block-button ta-right">
                        <input type="hidden" name="pchcount" value="<?php echo $this->_tpl_vars['translate_calculate']; ?>
" />
                        <a href="javascript:void(0);" onclick="if(confirm('<?php echo $this->_tpl_vars['translate_baket_clear_confirm']; ?>
')) document.location='<?php echo $this->_tpl_vars['urlclear']; ?>
';"><?php echo $this->_tpl_vars['translate_clear']; ?>
</a>
                        <br />
                        <br />

                        <input class="js-refresh" type="submit" name="refresh" value="<?php echo $this->_tpl_vars['translate_calculate']; ?>
" style="display: none;" />
                        <a class="cl-button continue" href="/" onclick="$j('.js-refresh').click();">Continue shopping</a>

                        <?php if ($this->_tpl_vars['basketArray']): ?>
                        <input class="cl-button green small" type="submit" name="makeOrder" value="<?php echo $this->_tpl_vars['translate_basket_nextstep']; ?>
" />
                        <?php endif; ?>
                    </div>

                </div>
            </div>

            <?php if ($this->_tpl_vars['authorizedFail']): ?>
                <br />
                <div class="os-message-error">
                    <?php echo $this->_tpl_vars['translate_need_sign_in']; ?>
 <a href="/registration/"><?php echo $this->_tpl_vars['translate_sing_up']; ?>
</a>
                </div>
                <br />
            <?php endif; ?>
        </div>

    <?php endif; ?>


    <?php if ($this->_tpl_vars['recommendedArray']): ?>
        <div class="cl-additional-product">
            <h2 class="title"><?php echo $this->_tpl_vars['translate_our_recomendation']; ?>
</h2>

            <div class="cl-product-list">
                <ul class="small-block-grid-1 smaller-block-grid-3 medium-block-grid-4 sub-large-block-grid-4 large-block-grid-6">
                    <?php $_from = $this->_tpl_vars['recommendedArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['r']):
?>
                        <li>
                            <div class="cl-product-thumb">
                                <div class="block-image">
                                    <a href="<?php echo $this->_tpl_vars['r']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['r']['image']; ?>
" alt="<?php echo $this->_tpl_vars['r']['name']; ?>
" title="<?php echo $this->_tpl_vars['r']['name']; ?>
"></a>
                                </div>
                                <div class="hidden-descript">
                                    <div class="name">
                                        <a href="<?php echo $this->_tpl_vars['r']['url']; ?>
" title=""><?php echo $this->_tpl_vars['r']['name']; ?>
</a>
                                    </div>
                                    <div class="block-button">
                                        <a class="cl-button green small" href="<?php echo $this->_tpl_vars['r']['url']; ?>
"><?php echo $this->_tpl_vars['r']['price']; ?>
 <?php echo $this->_tpl_vars['r']['currency']; ?>
</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            </div>
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
    <?php endif; ?>
</form>