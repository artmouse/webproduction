<?php /* Smarty version 2.6.27-optimized, created on 2015-11-25 17:22:15
         compiled from /var/www/shop.local/modules/order/contents/admin//orders/orders_control_block_product_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '/var/www/shop.local/modules/order/contents/admin//orders/orders_control_block_product_list.html', 334, false),)), $this); ?>
<?php if ($this->_tpl_vars['message'] == 'error'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_box_message_error']; ?>
.<br />

        <?php $_from = $this->_tpl_vars['errorsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <?php if ($this->_tpl_vars['e'] == 'notlinked'): ?>
                <?php echo $this->_tpl_vars['translate_order_error_not_linked']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'issue-stop'): ?>
                <?php echo $this->_tpl_vars['translate_izmenenie_sostoyanie_zapreshcheno_poka_ne_vipolneni_vse_vnutrennie_zadachi']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'saled'): ?>
                <?php echo $this->_tpl_vars['translate_order_error_saled']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'user'): ?>
                <?php echo $this->_tpl_vars['translate_box_error_user']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'phone'): ?>
                <?php echo $this->_tpl_vars['translate_order_error_phone']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'email'): ?>
                <?php echo $this->_tpl_vars['translate_order_error_login']; ?>
.<br />
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['IdBusy']): ?>
            <?php echo $this->_tpl_vars['translate_ne_udalos_pomenyat_nomer_zakaza_takoy_nomer_uzhe_ispolzuetsya']; ?>
.<br />
        <?php endif; ?>

        <?php echo $this->_tpl_vars['errorText']; ?>

    </div>
<?php endif; ?>

<?php if (! $this->_tpl_vars['ajax']): ?>
<div class="ob-orderlist-toggle">
    <a href="<?php echo $this->_tpl_vars['urlBarcode']; ?>
" onclick="window.open('<?php echo $this->_tpl_vars['urlBarcode']; ?>
'); return false;"><?php echo $this->_tpl_vars['translate_shtrih_kodi']; ?>
</a>
    <a class="js-orderlist-editable" href="#"><?php echo $this->_tpl_vars['translate_redaktirovat_vse']; ?>
</a>
</div>
<div class="clear"></div>
<div class="shop-overflow-table" style="margin: 0 0 20px 0;">
<?php endif; ?>
    <table class="shop-table js-product-sort js-order-table" width="100%">
        <thead>
            <tr>
                <th data-sorter="false">&nbsp;</th>
                <th data-sorter="false">&nbsp</th>
                <th width="70"><?php echo $this->_tpl_vars['translate_code']; ?>
</th>
                <th><?php echo $this->_tpl_vars['translate_produkt']; ?>
</th>
                <th><?php echo $this->_tpl_vars['translate_price']; ?>
</th>
                <th><?php echo $this->_tpl_vars['translate_cost']; ?>
</th>
                <th data-sorter="false">&nbsp;</th>
                <th data-sorter="false">&nbsp;</th>
            </tr>
        </thead>

        <tbody class="js-oders-sort" data-orderid="<?php echo $this->_tpl_vars['orderid']; ?>
">
            <?php $this->assign('productsCount', 0); ?>
            <?php $_from = $this->_tpl_vars['productsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                <tr class="va_top" style="<?php if ($this->_tpl_vars['e']['reserveOK']): ?>background-color: #96cb8e;<?php endif; ?> <?php if ($this->_tpl_vars['e']['reserveOK'] || $this->_tpl_vars['e']['storageCount']): ?>background-color: #d4ffd8;<?php elseif ($this->_tpl_vars['e']['supplierOrders']): ?>background-color: #ffffd0;<?php endif; ?>" data-productid="<?php echo $this->_tpl_vars['e']['productid']; ?>
">
                    <td class="va_middle"><div class="move"></div></td>

                    <td width="50">
                        <?php if ($this->_tpl_vars['e']['url']): ?>
                            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" target="_blank">
                                <img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" width="50" alt="" />
                            </a>
                        <?php else: ?>
                            <img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" width="50" alt="" />
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="element-padding">
                            <?php if ($this->_tpl_vars['e']['url']): ?>
                                <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['productid']; ?>
</a>
                            <?php else: ?>
                                <?php echo $this->_tpl_vars['e']['productid']; ?>

                            <?php endif; ?>
                        </span>
                    </td>
                    <td width="90%">
                        <span style="display: none;"><?php echo $this->_tpl_vars['e']['name']; ?>
</span>
                        <div class="ob-data-group no-control light js-data-group">
                            <a class="ob-link-edit" href="#"></a>
                            <a class="ob-link-delete" href="#"></a>
                            <a class="ob-link-accept" href="#"></a>

                            <div class="element">
                                <?php if ($this->_tpl_vars['e']['productid'] != '0'): ?>
                                    <span class="element-padding">
                                        <a class="ob-link-dashed js-product-preview-click" href="javascript:void(0);" data-id="<?php echo $this->_tpl_vars['e']['productid']; ?>
"><?php echo $this->_tpl_vars['translate_timework_small']; ?>
</a>
                                    </span>
                                <?php endif; ?>
                                                            </div>

                            <div class="element">
                                <div class="el-value">
                                    <div class="data-view secondary">
                                        <?php echo $this->_tpl_vars['e']['categoryname']; ?>

                                    </div>
                                    <div class="data-edit">
                                        <input type="text" data-original="<?php echo $this->_tpl_vars['e']['categoryname']; ?>
" value="<?php echo $this->_tpl_vars['e']['categoryname']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_single_category']; ?>
" name="category<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                                    </div>
                                </div>
                            </div>

                            <div class="element">
                                <div class="el-value">
                                    <div class="data-view">
                                        <?php echo $this->_tpl_vars['e']['name']; ?>

                                    </div>
                                    <div class="data-edit">
                                        <input type="text" data-original="<?php echo $this->_tpl_vars['e']['name']; ?>
" value="<?php echo $this->_tpl_vars['e']['name']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_product_name']; ?>
" name="name<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                                    </div>
                                </div>
                            </div>

                            <?php if ($this->_tpl_vars['e']['source'] == 'servicebusy'): ?>
                                <div class="element">
                                    <div class="el-value">
                                        <div class="data-view">
                                            <?php echo $this->_tpl_vars['translate_from_small']; ?>
 <?php echo $this->_tpl_vars['e']['datefrom']; ?>
 <?php echo $this->_tpl_vars['translate_to']; ?>
 <?php echo $this->_tpl_vars['e']['dateto']; ?>

                                        </div>
                                        <div class="data-edit">
                                            <input type="text" name="datefrom<?php echo $this->_tpl_vars['e']['id']; ?>
" data-original="<?php echo $this->_tpl_vars['e']['datefrom']; ?>
" value="<?php echo $this->_tpl_vars['e']['datefrom']; ?>
" class="js-date" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> placeholder="<?php echo $this->_tpl_vars['translate_from_small']; ?>
" style="width: 100px;" /> -
                                            <input type="text" name="dateto<?php echo $this->_tpl_vars['e']['id']; ?>
" data-original="<?php echo $this->_tpl_vars['e']['dateto']; ?>
" value="<?php echo $this->_tpl_vars['e']['dateto']; ?>
" class="js-date" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> placeholder="<?php echo $this->_tpl_vars['translate_to']; ?>
" style="width: 100px;" />
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->_tpl_vars['e']['showSerial']): ?>
                                <div class="element">
                                    <div class="el-value">
                                        <div class="data-view">
                                            <?php echo $this->_tpl_vars['e']['serial']; ?>

                                        </div>
                                        <div class="data-edit">
                                            <input type="text" data-original="<?php echo $this->_tpl_vars['e']['serial']; ?>
" value="<?php echo $this->_tpl_vars['e']['serial']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_serial_number']; ?>
" name="serial<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="element">
                                <div class="el-value">
                                    <div class="data-view">
                                        <?php echo $this->_tpl_vars['e']['warranty']; ?>

                                    </div>
                                    <div class="data-edit">
                                        <input type="text" data-original="<?php echo $this->_tpl_vars['e']['warranty']; ?>
" value="<?php echo $this->_tpl_vars['e']['warranty']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_warranty']; ?>
" name="warranty<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                                    </div>
                                </div>
                            </div>

                            <div class="element">
                                <div class="el-value">
                                    <div class="data-view">
                                        <?php echo $this->_tpl_vars['e']['comment']; ?>

                                    </div>
                                    <div class="data-edit">
                                        <textarea name="comment<?php echo $this->_tpl_vars['e']['id']; ?>
" data-original="<?php echo $this->_tpl_vars['e']['comment']; ?>
" class="js-autosize" rows="1" <?php if (! $this->_tpl_vars['canEdit']): ?>disabled<?php endif; ?> placeholder="<?php echo $this->_tpl_vars['translate_remark']; ?>
"><?php echo $this->_tpl_vars['e']['comment']; ?>
</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="ob-data-group no-control light js-data-group">
                            <a class="ob-link-edit" href="#"></a>
                            <a class="ob-link-delete" href="#"></a>
                            <a class="ob-link-accept" href="#"></a>

                            <div class="element">
                                <div class="el-value">
                                    <div class="data-view nowrap align_right">
                                        <?php echo $this->_tpl_vars['e']['price']; ?>

                                        <?php $_from = $this->_tpl_vars['currencyArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                                            <?php if ($this->_tpl_vars['c']['id'] == $this->_tpl_vars['e']['currencyid']): ?><?php echo $this->_tpl_vars['c']['symbol']; ?>
<?php endif; ?>
                                        <?php endforeach; endif; unset($_from); ?>
                                        <?php echo $this->_tpl_vars['e']['taxname']; ?>

                                    </div>
                                    <div class="data-edit js-price-edit">
                                        <input class="js-price-edit-open" type="text" data-original="<?php echo $this->_tpl_vars['e']['price']; ?>
" value="<?php echo $this->_tpl_vars['e']['price']; ?>
" name="price<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                                        <?php if (! $this->_tpl_vars['isOutcoming']): ?>
                                            <div class="ob-price-sub" style="display: none;">
                                                <div class="close js-price-edit-close">x</div>
                                                <table>
                                                    <tr>
                                                        <td><?php echo $this->_tpl_vars['translate_price']; ?>
:</td>
                                                        <td><input type="text" name="" data-original="<?php echo $this->_tpl_vars['e']['pricebase']; ?>
" value="<?php echo $this->_tpl_vars['e']['pricebase']; ?>
" class="js-price-base"/></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $this->_tpl_vars['translate_markup']; ?>
:</td>
                                                        <td><input type="text" name="" data-original="<?php echo $this->_tpl_vars['e']['margin']; ?>
" value="<?php if ($this->_tpl_vars['e']['margin']): ?><?php echo $this->_tpl_vars['e']['margin']; ?>
<?php endif; ?>" class="js-price-margin"/></td>
                                                        <td>%</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        <?php endif; ?>
                                        <select data-original="<?php echo $this->_tpl_vars['e']['currencyid']; ?>
" name="currency<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?>disabled<?php endif; ?> class="chzn-select">
                                            <?php $_from = $this->_tpl_vars['currencyArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                                                <option value="<?php echo $this->_tpl_vars['c']['id']; ?>
" <?php if ($this->_tpl_vars['c']['id'] == $this->_tpl_vars['e']['currencyid']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['c']['symbol']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="element">
                                <div class="el-value">
                                    <div class="data-view nowrap align_right">
                                        <?php echo $this->_tpl_vars['e']['count']; ?>

                                        <?php echo $this->_tpl_vars['e']['unit']; ?>

                                    </div>
                                    <div class="data-edit">
                                        <input type="text" data-original="<?php echo $this->_tpl_vars['e']['count']; ?>
" value="<?php echo $this->_tpl_vars['e']['count']; ?>
" name="count<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td align="right">
                        <?php echo $this->_tpl_vars['e']['sum']; ?>
&nbsp;<?php echo $this->_tpl_vars['currency']; ?>

                    </td>

                    <td>
                        <?php if ($this->_tpl_vars['canEdit']): ?>
                            <a class="ob-link-delete ob-icon js-product-remove" href="#" title="<?php echo $this->_tpl_vars['translate_delete_small']; ?>
"></a>
                            <input type="checkbox" name="delete<?php echo $this->_tpl_vars['e']['id']; ?>
" value="1" style="display: none;" />
                        <?php else: ?>
                            &nbsp;
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($this->_tpl_vars['e']['linkOrderName']): ?>
                            <a href="<?php echo $this->_tpl_vars['e']['linkOrderURL']; ?>
"><?php echo $this->_tpl_vars['e']['linkOrderName']; ?>
</a><br>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['isOutcoming']): ?>
                            <?php if ($this->_tpl_vars['e']['storageCountArray']): ?>
                                <div class="js-storage-reserve-block">
                                    <?php if ($this->_tpl_vars['e']['storageLinked']): ?>
                                        <strong>
                                            <?php echo $this->_tpl_vars['translate_reserved']; ?>
 <?php echo $this->_tpl_vars['e']['storageLinkedAmount']; ?>
 <?php echo $this->_tpl_vars['e']['unit']; ?>

                                            (
                                            <?php $_from = $this->_tpl_vars['e']['storageLinked']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['storageLinked'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['storageLinked']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['link']):
        $this->_foreach['storageLinked']['iteration']++;
?>
                                                <?php echo $this->_tpl_vars['link']['storageName']; ?>
:<?php echo $this->_tpl_vars['link']['amount']; ?>

                                                <?php if (! ($this->_foreach['storageLinked']['iteration'] == $this->_foreach['storageLinked']['total'])): ?>
                                                    ;
                                                <?php endif; ?>
                                            <?php endforeach; endif; unset($_from); ?>
                                            )
                                        </strong>
                                        <a href="#" data-orderproductid="<?php echo $this->_tpl_vars['e']['id']; ?>
" class="js-storage-cancel-reserve" ><?php echo $this->_tpl_vars['translate_otmenit']; ?>
</a>
                                    <?php endif; ?>

                                    <?php if ($this->_tpl_vars['e']['storageLinkedAmount'] < $this->_tpl_vars['e']['count'] && $this->_tpl_vars['e']['storageCount']): ?>
                                        <a href="#" data-balanceid="<?php echo $this->_tpl_vars['e']['storageCountArray']['id']; ?>
" data-orderproductid="<?php echo $this->_tpl_vars['e']['id']; ?>
" class="js-storage-reserve" ><?php echo $this->_tpl_vars['translate_rezervirovat']; ?>
</a>
                                    <?php endif; ?>
                                </div>

                                <?php echo $this->_tpl_vars['translate_nalichie_na_skladah']; ?>
:
                                <select data-original="<?php echo $this->_tpl_vars['e']['storageid']; ?>
" name="storage<?php echo $this->_tpl_vars['e']['id']; ?>
" class="js-storage-name">
                                    <?php $_from = $this->_tpl_vars['e']['storageCountArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s']):
?>
                                        <option data-orderproductid="<?php echo $this->_tpl_vars['e']['id']; ?>
" value="<?php echo $this->_tpl_vars['s']['id']; ?>
" <?php if ($this->_tpl_vars['e']['storageid'] == $this->_tpl_vars['s']['id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['s']['name']; ?>
: <?php echo $this->_tpl_vars['s']['count']; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                            <?php endif; ?>

                            <?php if ($this->_tpl_vars['e']['supplierArray'] && ! $this->_tpl_vars['e']['linkOrderName']): ?>
                                <select data-original="<?php echo $this->_tpl_vars['e']['supplierid']; ?>
" class="js-select-supplier-color" name="supplier<?php echo $this->_tpl_vars['e']['id']; ?>
" style="width: 200px;">
                                    <option value="0" <?php if ($this->_tpl_vars['s']['id'] != $this->_tpl_vars['e']['supplierid']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['translate_net_postavshchika']; ?>
</option>
                                    <?php $_from = $this->_tpl_vars['e']['supplierArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s']):
?>
                                        <option value="<?php echo $this->_tpl_vars['s']['id']; ?>
" <?php if ($this->_tpl_vars['s']['workflow'] == 0 || $this->_tpl_vars['s']['contactId'] == 0): ?>disabled<?php endif; ?> <?php if ($this->_tpl_vars['s']['id'] == $this->_tpl_vars['e']['supplierid']): ?>selected class="js-select-supplier-current"<?php endif; ?> data-color="<?php echo $this->_tpl_vars['s']['color']; ?>
">
                                        <?php echo $this->_tpl_vars['s']['name']; ?>
 - <?php echo $this->_tpl_vars['s']['code']; ?>
 | <?php echo $this->_tpl_vars['s']['price']; ?>
 <?php echo $this->_tpl_vars['s']['currency']; ?>
 | <?php echo $this->_tpl_vars['s']['availtext']; ?>
 <?php if ($this->_tpl_vars['s']['workflow'] == 0): ?><?php echo $this->_tpl_vars['translate_bp_']; ?>
 <?php endif; ?><?php if ($this->_tpl_vars['s']['deliveryTime']): ?>| <?php echo $this->_tpl_vars['s']['deliveryTime']; ?>
 |<?php endif; ?><?php if ($this->_tpl_vars['s']['contactId'] == 0): ?> <?php echo $this->_tpl_vars['translate_kontakt_']; ?>
 <?php endif; ?>
                                        </option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                            <?php endif; ?>

                            <?php if ($this->_tpl_vars['e']['supplierOrders']): ?>
                                <?php echo $this->_tpl_vars['translate_zakaz_postavshchiku']; ?>
:
                                <?php $_from = $this->_tpl_vars['e']['supplierOrders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['supplierOrders']):
?>
                                    <a href="<?php echo $this->_tpl_vars['supplierOrders']['url']; ?>
" data-id="<?php echo $this->_tpl_vars['supplierOrders']['id']; ?>
" class="js-issue-preview">#<?php echo $this->_tpl_vars['supplierOrders']['id']; ?>
</a>
                                <?php endforeach; endif; unset($_from); ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($this->_tpl_vars['storageIncomingArray'] && $this->_tpl_vars['e']['source'] != 'service' && $this->_tpl_vars['e']['source'] != 'servicebusy'): ?>
                                <?php echo $this->_tpl_vars['translate_sklad_dlya_oprihodovaniya']; ?>

                                <select data-original="<?php echo $this->_tpl_vars['e']['storageIncoming']; ?>
" class="chzn-select" name="storageincoming<?php echo $this->_tpl_vars['e']['id']; ?>
" style="width: 200px;">
                                    <?php if ($this->_tpl_vars['e']['storageIncoming']): ?>
                                        <?php $_from = $this->_tpl_vars['storageIncomingArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s']):
?>
                                            <option value="<?php echo $this->_tpl_vars['s']['id']; ?>
" <?php if ($this->_tpl_vars['s']['id'] == $this->_tpl_vars['e']['storageIncoming']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['s']['name']; ?>
</option>
                                        <?php endforeach; endif; unset($_from); ?>
                                    <?php else: ?>
                                        <?php $_from = $this->_tpl_vars['storageIncomingArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s']):
?>
                                            <option value="<?php echo $this->_tpl_vars['s']['id']; ?>
" <?php if ($this->_tpl_vars['s']['default']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['s']['name']; ?>
</option>
                                        <?php endforeach; endif; unset($_from); ?>
                                    <?php endif; ?>
                                </select>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php $this->assign('productsCount', $this->_tpl_vars['productsCount']+$this->_tpl_vars['e']['count']); ?>
            <?php endforeach; endif; unset($_from); ?>
        </tbody>

        <tfoot class="order-foot">
            <?php if ($this->_tpl_vars['discountSum'] > 0 || $this->_tpl_vars['discountArray']): ?>
                <tr>
                    <td class="align_right" colspan="5">
                        <?php echo $this->_tpl_vars['translate_discount_amount']; ?>
:
                        <?php if ($this->_tpl_vars['discountArray']): ?>
                            <select name="discount" style="width: 150px;" <?php if (! $this->_tpl_vars['canEdit']): ?>disabled<?php endif; ?> class="chzn-select inline">
                                <option value="">---</option>
                                <?php $_from = $this->_tpl_vars['discountArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['d']):
?>
                                    <option value="<?php echo $this->_tpl_vars['d']['id']; ?>
" <?php if ($this->_tpl_vars['d']['id'] == $this->_tpl_vars['control_discount']): ?> selected <?php endif; ?>>
                                        <?php echo $this->_tpl_vars['d']['name']; ?>
 (<?php echo $this->_tpl_vars['d']['value']; ?>
<?php if ($this->_tpl_vars['d']['type'] == 'percent'): ?>%<?php elseif ($this->_tpl_vars['d']['type'] == 'value'): ?> <?php echo $this->_tpl_vars['d']['currency']; ?>
<?php endif; ?>)
                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        <?php endif; ?>
                    </td>
                    <td class="align_right"><strong class="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['discountSum'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
&nbsp;<?php echo $this->_tpl_vars['currency']; ?>
</strong></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['deliveryPrice'] > 0): ?>
                <tr>
                    <td class="align_right" colspan="5"><?php echo $this->_tpl_vars['translate_delivery']; ?>
<?php if ($this->_tpl_vars['payDelivery']): ?> (<?php echo $this->_tpl_vars['translate_ne_uchitivaetsya']; ?>
)<?php endif; ?>:</td>
                    <td class="align_right"><strong class="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['deliveryPrice'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
&nbsp;<?php echo $this->_tpl_vars['currency']; ?>
</strong></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['sum']): ?>
                <tr>
                    <td class="align_right" colspan="5">
                        <?php echo $this->_tpl_vars['translate_in_total']; ?>
 <strong><?php echo $this->_tpl_vars['productsCount']; ?>
</strong> <?php echo $this->_tpl_vars['translate_tovar_ov_']; ?>
:
                        <select name="ordercurrencyid" <?php if (! $this->_tpl_vars['canEdit']): ?>disabled<?php endif; ?> class="chzn-select inline">
                            <option value="">---</option>
                            <?php $_from = $this->_tpl_vars['orderCurrencyArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_ordercurrencyid']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
 (<?php echo $this->_tpl_vars['e']['rate']; ?>
)</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </td>
                    <td class="align_right"><strong class="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['sum'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
&nbsp;<?php echo $this->_tpl_vars['currency']; ?>
</strong></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['control_delivery']): ?>
                <?php if ($this->_tpl_vars['totalSum']): ?>
                    <tr>
                        <td class="align_right" colspan="5"><?php echo $this->_tpl_vars['translate_total_order_amount']; ?>
 (<?php echo $this->_tpl_vars['translate_with_delivery']; ?>
):</td>
                        <td class="align_right"><strong class="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['totalSum'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</strong></td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['taxSum'] > 0): ?>
                <tr>
                    <td class="align_right" colspan="5"><?php echo $this->_tpl_vars['translate_summa_bez_nds']; ?>
:</td>
                    <td class="align_right"><strong class="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['sumWithoutTax'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</strong></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td class="align_right" colspan="5"><?php echo $this->_tpl_vars['translate_order_tax']; ?>
:</td>
                    <td class="align_right"><strong class="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['taxSum'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</strong></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['finance'] && $this->_tpl_vars['productsArray']): ?>
                <tr>
                    <td class="align_right" colspan="5"><?php echo $this->_tpl_vars['translate_paid']; ?>
:</td>
                    <td class="align_right"><strong class="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['paymentSum'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
&nbsp;<?php echo $this->_tpl_vars['currency']; ?>
</strong></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td class="align_right" colspan="5"><?php echo $this->_tpl_vars['translate_balance']; ?>
:</td>
                    <td class="align_right"><strong class="nowrap" style="color: <?php if ($this->_tpl_vars['paymentBalance'] >= 0): ?>green<?php else: ?>red<?php endif; ?>"><?php echo ((is_array($_tmp=$this->_tpl_vars['paymentBalance'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
&nbsp;<?php echo $this->_tpl_vars['currency']; ?>
</strong></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
            <?php endif; ?>
        </tfoot>
    </table>
<?php if (! $this->_tpl_vars['ajax']): ?>
    <br />
    <?php if ($this->_tpl_vars['canEdit']): ?>
        <input class="js-product-autocomplete-input" type="text" data-orderid="<?php echo $this->_tpl_vars['orderid']; ?>
" id="id-value" name="productid" style="width: 400px; " />
        <a href="#" id="id-product" class="ob-button"><?php echo $this->_tpl_vars['translate_select_find_create_product']; ?>
...</a>
    <?php endif; ?>
</div>
<?php endif; ?>