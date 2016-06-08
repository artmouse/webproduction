<?php /* Smarty version 2.6.27-optimized, created on 2015-11-27 15:33:31
         compiled from /var/www/shop.local/modules/collars/contents/products_add.html */ ?>
<div class="nb-top-nav-place js-top-nav-buffer"></div>
<div class="nb-top-nav js-top-nav">
    <div class="nb-block-tabs">
        <div class="tab-element"><a href="/admin/shop/products/">&lsaquo; <?php echo $this->_tpl_vars['translate_many_products']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/products/add/" class="selected"><?php echo $this->_tpl_vars['translate_product_add']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/products/copy/"><?php echo $this->_tpl_vars['translate_products_copy']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/products/exchange-xls/"><?php echo $this->_tpl_vars['translate_import_and_export_excel']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/category/manage/"><?php echo $this->_tpl_vars['translate_category']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/brands/"><?php echo $this->_tpl_vars['translate_brands']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/products/filters/"><?php echo $this->_tpl_vars['translate_products_filters']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/products/productslist/"><?php echo $this->_tpl_vars['translate_products_list']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/comments/"><?php echo $this->_tpl_vars['translate_many_comments']; ?>
</a></div>
        <div class="clear"></div>
    </div>
</div>

<?php if ($this->_tpl_vars['message'] == 'ok'): ?>
<div class="shop-message-success">
    <?php echo $this->_tpl_vars['translate_product_create_success']; ?>
.<br />
    <a href="<?php echo $this->_tpl_vars['urlEdit']; ?>
"><?php echo $this->_tpl_vars['translate_product_run_edit']; ?>
</a>
    <a class="ob-button js-preview" target="_blank" href="<?php echo $this->_tpl_vars['productURL']; ?>
"><?php echo $this->_tpl_vars['translate_see_product_on_the_website']; ?>
</a>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'error'): ?>
<div class="shop-message-error">
    <?php echo $this->_tpl_vars['translate_product_create_error']; ?>
.
    <?php echo $this->_tpl_vars['translate_product_create_error_for']; ?>
.
</div>
<?php endif; ?>

<form action="<?php echo $this->_tpl_vars['actionForm']; ?>
" method="post" enctype="multipart/form-data">
    <div class="shop-productright-layer">
        <div class="inner">
            <div class="shop-block-toggle">
                <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_product_general']; ?>
</a>
                <div class="block">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="50%">
                                <div class="caption"><?php echo $this->_tpl_vars['translate_single_category']; ?>
</div>
                                <span class="important-field">
                                    <select class="chzn-select-tree" id="js-category" style="width: 98%;" name="category">
                                        <option value="0">---</option>
                                        <?php $_from = $this->_tpl_vars['categoryArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_category']): ?> selected <?php endif; ?> data-level="<?php echo $this->_tpl_vars['e']['level']; ?>
">
                                        <?php echo $this->_tpl_vars['e']['name']; ?>

                                        (#<?php echo $this->_tpl_vars['e']['id']; ?>
)
                                        <?php if ($this->_tpl_vars['e']['hidden']): ?>
                                        - <?php echo $this->_tpl_vars['translate_hidden1_small']; ?>

                                        <?php endif; ?>
                                        </option>
                                        <?php endforeach; endif; unset($_from); ?>
                                    </select>
                                </span>
                            </td>
                            <td>
                                <div class="caption"><?php echo $this->_tpl_vars['translate_title_short']; ?>
</div>
                                <div class="js-formula">
                                    <span class="important-field"><input type="text" name="name[]" value="<?php echo $this->_tpl_vars['control_name']; ?>
" style="width: 100%;" class="help-hint-product-name" /></span>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="145">
                                <div class="caption"><?php echo $this->_tpl_vars['translate_unit']; ?>
</div>
                                <input type="text" name="unit" value="<?php echo $this->_tpl_vars['control_unit']; ?>
" style="width: 135px;" />
                            </td>
                            <td width="125">
                                <div class="caption"><acronym title="<?php echo $this->_tpl_vars['translate_zakupochnaya_tsena_ili_sebestoimost_produkta']; ?>
"><?php echo $this->_tpl_vars['translate_base_price']; ?>
</acronym></div>
                                <input type="text" name="pricebase" value="<?php echo $this->_tpl_vars['control_pricebase']; ?>
" style="width: 115px;" />
                            </td>
                            <td width="170">
                                <div class="caption"><?php echo $this->_tpl_vars['translate_price']; ?>
</div>

                                <input type="text" name="price" value="<?php echo $this->_tpl_vars['control_price']; ?>
" style="width: 76px;" />

                                <select class="chzn-select"  name="currency" style="width: 80px;">
                                    <?php $_from = $this->_tpl_vars['currencyArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                    <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_currency']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                            </td>
                            <td>
                                <div class="caption">&nbsp;</div>
                                <label>
                                    <input type="checkbox" name="tax" value="1" <?php if ($this->_tpl_vars['control_tax']): ?> checked <?php endif; ?> />
                                    <?php echo $this->_tpl_vars['translate_vklyuchaya_nds']; ?>

                                </label>
                            </td>
                        </tr>
                    </table>
                    <br />

                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="270">
                                <div class="caption"><?php echo $this->_tpl_vars['translate_source_product_type']; ?>
</div>
                                <select class="chzn-select" name="source" style="width: 260px;">
                                    <option value=""><?php echo $this->_tpl_vars['translate_storage_or_supplier']; ?>
</option>
                                    <option value="service" <?php if ($this->_tpl_vars['control_source'] == 'service'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['translate_service_unlimited_replicability']; ?>
</option>
                                    <option value="servicebusy" <?php if ($this->_tpl_vars['control_source'] == 'servicebusy'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['translate_service_with_net_employment']; ?>
</option>
                                </select>
                            </td>
                            <td width="170">
                                <div class="caption"><?php echo $this->_tpl_vars['translate_term_product']; ?>
</div>
                                <select class="chzn-select"  name="term" style="width: 160px;">
                                    <option value="unlimited"<?php if ($this->_tpl_vars['control_term'] == 'unlimited'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['translate_unlimited']; ?>
</option>
                                    <option value="day" <?php if ($this->_tpl_vars['control_term'] == 'day'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['translate_day']; ?>
</option>
                                    <option value="month" <?php if ($this->_tpl_vars['control_term'] == 'month'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['translate_month']; ?>
</option>
                                    <option value="year" <?php if ($this->_tpl_vars['control_term'] == 'year'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['translate_year']; ?>
</option>
                                </select>
                            </td>
                            <td width="140">
                                <div class="caption"><acronym title="13 <?php echo $this->_tpl_vars['translate_symbols']; ?>
, EAN, GS1"><?php echo $this->_tpl_vars['translate_item_barcode']; ?>
</acronym></div>
                                <input type="text" name="barcode" value="<?php echo $this->_tpl_vars['control_barcode']; ?>
" style="width: 130px;" />
                            </td>
                            <td>
                                <div class="caption"><?php echo $this->_tpl_vars['translate_brand']; ?>
</div>
                                <select name="brand" class="chzn-select" style="width: 100%;">
                                    <option value="0">---</option>
                                    <?php $_from = $this->_tpl_vars['brandsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                    <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_brand']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <?php echo $this->_tpl_vars['translate_in_stock_info']; ?>

                    <div class="products-form-row">
                        <div class="column four">
                            <input class="help-hint-availability" type="text" name="availtext" value="<?php echo $this->_tpl_vars['control_availtext']; ?>
" style="width: 260px" />
                            <label>
                                <input class="help-hint-no-available" type="checkbox" name="avail" value="1" <?php if ($this->_tpl_vars['control_avail']): ?> checked <?php endif; ?> />
                                <?php echo $this->_tpl_vars['translate_item_in_stock']; ?>

                            </label>
                        </div>
                    </div>
                    <?php echo $this->_tpl_vars['translate_code_small']; ?>
 1C
                    <div class="products-form-row">
                        <div class="column four">
                            <input type="text" name="code1c" value="<?php echo $this->_tpl_vars['control_code1c']; ?>
" style="width: 260px"/>
                            <label>
                                <input type="checkbox" name="syncable" value="1" <?php if ($this->_tpl_vars['control_syncable']): ?> checked <?php endif; ?> />
                                <?php echo $this->_tpl_vars['translate_synchronized']; ?>
 (1C, <?php echo $this->_tpl_vars['translate_etc']; ?>
)
                            </label>
                        </div>
                    </div>

                    <div class="caption"><?php echo $this->_tpl_vars['translate_description']; ?>
</div>
                    <textarea name="description" style="width: 99%; height: 100px;" id="id"><?php echo $this->_tpl_vars['control_description']; ?>
</textarea>
                    <script type="text/javascript" src="/packages/CKEditor/ckeditor/ckeditor.js"></script>
                    <script type="text/javascript">
                        CKEDITOR.replace('id', {
                            filebrowserBrowseUrl : '/packages/CKFinder/ckfinder/ckfinder.html',
                            filebrowserImageBrowseUrl : '/packages/CKFinder/ckfinder/ckfinder.html?Type=Images',
                            filebrowserFlashBrowseUrl : '/packages/CKFinder/ckfinder/ckfinder.html?Type=Flash',
                            filebrowserUploadUrl : '/packages/CKFinder/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                            filebrowserImageUploadUrl : '/packages/CKFinder/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                            filebrowserFlashUploadUrl : '/packages/CKFinder/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                        });
                    </script>
                    <br />
                    <br />
                    <div class="caption"><?php echo $this->_tpl_vars['translate_product_deacription']; ?>
 <?php echo $this->_tpl_vars['translate_product_deacription_term']; ?>
</div>
                    <textarea name="descriptionshort" style="width: 99%; height: 60px;" id="id-descriptionshort"><?php echo $this->_tpl_vars['control_descriptionshort']; ?>
</textarea>
                    <br />
                    <br />

                    <div class="clear"></div>
                    <br />

                    <label>
                        <input type="checkbox" name="hidden" value="1" class="help-hint-product-hide" <?php if ($this->_tpl_vars['control_hidden']): ?> checked <?php endif; ?> />
                        <?php echo $this->_tpl_vars['translate_product_hidden']; ?>

                    </label>

                    <label>
                        <input class="help-hint-deleted" type="checkbox" name="deleted" value="1" <?php if ($this->_tpl_vars['control_deleted']): ?> checked <?php endif; ?> />
                        <?php echo $this->_tpl_vars['translate_product_deleted']; ?>

                    </label>

                    <label>
                        <input type="checkbox" name="sale" value="1" />
                        Sale
                    </label>
                </div>
            </div>

            <div class="shop-block-toggle">
                <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_features']; ?>
</a>
                <div class="block">
                    <textarea name="characteristics" style="width: 99%; height: 80px;" ><?php echo $this->_tpl_vars['control_characteristics']; ?>
</textarea>
                </div>
            </div>

            <div class="shop-block-toggle">
                <a href="#" class="toggle">Рекламация</a>
                <div class="block">
                    <textarea name="advertise" style="width: 99%; height: 80px;" ></textarea>
                </div>
            </div>



            <div class="shop-block-toggle">
                <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_presence_and_storage']; ?>
:</a>
                <div class="block">
                    <label>
                        <input class="help-hint-no-available" type="checkbox" name="suppliered" value="1" <?php if ($this->_tpl_vars['control_suppliered']): ?> checked <?php endif; ?> />
                        <?php echo $this->_tpl_vars['translate_product_in_stock_at_the_supplier']; ?>

                    </label>
                    <br />
                    <br />

                    <?php echo $this->_tpl_vars['translate_lifetime']; ?>
 <?php echo $this->_tpl_vars['translate_with']; ?>

                    <input type="text" name="datelifefrom" value="<?php echo $this->_tpl_vars['control_datelifefrom']; ?>
" class="js-date" style="width: 110px" />
                    <?php echo $this->_tpl_vars['translate_for']; ?>

                    <input type="text" name="datelifeto" value="<?php echo $this->_tpl_vars['control_datelifeto']; ?>
" class="js-date" style="width: 110px" />
                </div>
            </div>

            <div class="shop-block-toggle">
                <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_actions_and_presents']; ?>
:</a>
                <div class="block">
                    <?php echo $this->_tpl_vars['translate_discount']; ?>
<br />
                    <input type="text" name="discount" value="<?php echo $this->_tpl_vars['control_discount']; ?>
" style="width: 80px" /> %
                    <br />
                    <br />

                    <label>
                        <input type="checkbox" name="preorderDiscount" value="1"<?php if ($this->_tpl_vars['control_preorderDiscount']): ?>checked value="1"<?php endif; ?>  />
                        <?php echo $this->_tpl_vars['translate_discount_preorder']; ?>

                    </label>
                    <br />
                    <br />
                    <?php echo $this->_tpl_vars['translate_action']; ?>
<br />
                    <input type="text" name="share" value="<?php echo $this->_tpl_vars['control_share']; ?>
" style="width: 184px;"/>
                    <br />
                    <br />
                    <?php echo $this->_tpl_vars['translate_crossed_out_price']; ?>

                    <input class="help-hint-old-price" type="text" name="priceold" value="<?php echo $this->_tpl_vars['control_priceold']; ?>
" style="width: 60px;" />
                    <div class="description">
                        <?php echo $this->_tpl_vars['translate_crossed_out_price_description']; ?>

                    </div>
                </div>
            </div>

            <div class="shop-block-toggle">
                <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_order_options']; ?>
:</a>
                <div class="block">
                    <?php echo $this->_tpl_vars['translate_divisibility']; ?>
 <?php echo $this->_tpl_vars['translate_divisibility_description']; ?>

                    <input type="text" name="divisibility" value="<?php echo $this->_tpl_vars['control_divisibility']; ?>
" style="width: 50px;" />
                    <br />
                    <br />

                    <label>
                        <input type="checkbox" name="denycomments" value="1" class="help-hint-products-comments-off" <?php if ($this->_tpl_vars['control_denycomments']): ?> checked <?php endif; ?> />
                        <?php echo $this->_tpl_vars['translate_denycomments']; ?>

                    </label>
                    <br />
                    <br />
                    <label>
                        <input  type="checkbox" name="notdiscount" value="1" <?php if ($this->_tpl_vars['control_notdiscount']): ?> checked <?php endif; ?> />
                        <?php echo $this->_tpl_vars['without_discount']; ?>

                    </label>
                    <br />
                    <br />
                    <?php echo $this->_tpl_vars['max_size_percent_discount']; ?>

                    <br />
                    <input  type="text" name="maxdiscount" value="<?php echo $this->_tpl_vars['control_maxdiscount']; ?>
"  style="width: 50px;" /> %
                    <br />
                    <br />

                    <?php echo $this->_tpl_vars['translate_price_levels']; ?>
:<br /><br />
                    <div class="products-form-row">
                        <div class="column five">
                            <?php echo $this->_tpl_vars['translate_price']; ?>
 1<br />
                            <input type="text" name="price1" value="<?php echo $this->_tpl_vars['control_price1']; ?>
" />
                        </div>
                        <div class="column five">
                            <?php echo $this->_tpl_vars['translate_price']; ?>
 2<br />
                            <input type="text" name="price2" value="<?php echo $this->_tpl_vars['control_price2']; ?>
" />
                        </div>
                        <div class="column five">
                            <?php echo $this->_tpl_vars['translate_price']; ?>
 3<br />
                            <input type="text" name="price3" value="<?php echo $this->_tpl_vars['control_price3']; ?>
" />
                        </div>
                        <div class="column five">
                            <?php echo $this->_tpl_vars['translate_price']; ?>
 4<br />
                            <input type="text" name="price4" value="<?php echo $this->_tpl_vars['control_price4']; ?>
" />
                        </div>
                        <div class="column five">
                            <?php echo $this->_tpl_vars['translate_price']; ?>
 5<br />
                            <input type="text" name="price5" value="<?php echo $this->_tpl_vars['control_price5']; ?>
" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="shop-block-toggle">
                <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_all_features']; ?>
</a>
                <div class="block">
                    <?php echo $this->_tpl_vars['translate_model']; ?>
<br />
                    <input type="text" name="model" value="<?php echo $this->_tpl_vars['control_model']; ?>
" style="width: 280px"/>
                    <br />
                    <br />
                    <?php echo $this->_tpl_vars['translate_articul']; ?>
<br />
                    <input type="text" name="articul" value="<?php echo $this->_tpl_vars['control_articul']; ?>
" style="width: 280px"/>
                    <br />
                    <br />
                    <?php echo $this->_tpl_vars['translate_modelniy_ryad_seriya_kollektsiya_']; ?>
<br />
                    <input type="text" name="seriesname" value="<?php echo $this->_tpl_vars['control_seriesname']; ?>
" style="width: 280px"/>
                    <br />
                    <br />
                    <?php if ($this->_tpl_vars['collectionArray']): ?>
                    <?php echo $this->_tpl_vars['translate_single_collection']; ?>
<br />
                    <select name="collection" class="chzn-select">
                        <option value="0">---</option>
                        <?php $_from = $this->_tpl_vars['collectionArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_collection']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                    <br />
                    <br />
                    <?php endif; ?>
                    <?php echo $this->_tpl_vars['translate_number_in_box']; ?>
<br />
                    <input type="text" name="unitbox" value="<?php echo $this->_tpl_vars['control_unitbox']; ?>
" style="width: 280px"/>
                    <br />
                    <br />

                    <div class="products-form-row">
                        <div class="column four">
                            <?php echo $this->_tpl_vars['translate_width']; ?>
<br />
                            <input type="text" name="width" value="<?php echo $this->_tpl_vars['control_width']; ?>
" />
                        </div>
                        <div class="column four">
                            <?php echo $this->_tpl_vars['translate_length']; ?>
<br />
                            <input type="text" name="length" value="<?php echo $this->_tpl_vars['control_length']; ?>
" />
                        </div>
                        <div class="column four">
                            <?php echo $this->_tpl_vars['translate_height']; ?>
<br />
                            <input type="text" name="height" value="<?php echo $this->_tpl_vars['control_height']; ?>
" />
                        </div>
                        <div class="column four">
                            <?php echo $this->_tpl_vars['translate_weight']; ?>
<br />
                            <input type="text" name="weight" value="<?php echo $this->_tpl_vars['control_weight']; ?>
" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="shop-block-toggle">
                <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_downloadable_goods']; ?>
</a>
                <div class="block">
                    <?php echo $this->_tpl_vars['translate_download_the_ZIP_format']; ?>

                    <br />

                    <input type="file" name="downloadfile"/>
                </div>
            </div>

            <div class="shop-block-toggle">
                <a href="#" class="toggle">SEO</a>
                <div class="block">
                    SEO <?php echo $this->_tpl_vars['translate_heading']; ?>
 (title)
                    <input type="text" name="seotitle" value="<?php echo $this->_tpl_vars['control_seotitle']; ?>
" style="width: 100%;" />
                    <br />
                    <br />

                    <div class="caption">SEO <?php echo $this->_tpl_vars['translate_description_small']; ?>
 (description)</div>
                    <textarea name="seodescription" style="width: 100%; height: 80px;"><?php echo $this->_tpl_vars['control_seodescription']; ?>
</textarea>
                    <br />
                    <br />

                    <div class="caption">SEO <?php echo $this->_tpl_vars['translate_seo_content']; ?>
 (content)</div>
                    <textarea name="seocontent" style="width: 100%; height: 80px;" class="rte-zone"><?php echo $this->_tpl_vars['control_seocontent']; ?>
</textarea>
                    <br />
                    <br />

                    <div class="caption">SEO <?php echo $this->_tpl_vars['translate_seo_kaewords']; ?>
 (kaewords)</div>
                    <textarea name="seokeywords" style="width: 100%; height: 80px;"><?php echo $this->_tpl_vars['control_seokeywords']; ?>
</textarea>
                    <br />
                    <br />

                                    </div>
            </div>

            <div class="shop-block-toggle">
                <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_sync_and_producer']; ?>
:</a>
                <div class="block">
                    <?php echo $this->_tpl_vars['translate_code_small']; ?>
 (ID)
                    <input type="text" name="code" value="<?php echo $this->_tpl_vars['control_code']; ?>
" style="width: 200px;" />
                    <div class="description">
                        <?php echo $this->_tpl_vars['translate_optional']; ?>

                    </div>
                    <br />
                    <br />
                </div>
            </div>

            <div class="shop-block-toggle">
                <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_warranty_dilivery_payment']; ?>
:</a>
                <div class="description" style="padding-left: 12px">
                    <?php echo $this->_tpl_vars['translate_wdp_description']; ?>
.
                </div>
                <div class="block">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="33%">
                                <div class="caption"><?php echo $this->_tpl_vars['translate_warranty']; ?>
</div>
                                <textarea name="warranty" style="width: 93%; height: 80px;"><?php echo $this->_tpl_vars['control_warranty']; ?>
</textarea>
                            </td>
                            <td>
                                <div class="caption"><?php echo $this->_tpl_vars['translate_delivery_terms']; ?>
</div>
                                <textarea name="delivery" style="width: 93%; height: 80px;"><?php echo $this->_tpl_vars['control_delivery']; ?>
</textarea>
                            </td>
                            <td width="33%">
                                <div class="caption"><?php echo $this->_tpl_vars['translate_payment_terms']; ?>
</div>
                                <textarea name="payment" style="width: 93%; height: 80px;"><?php echo $this->_tpl_vars['control_payment']; ?>
</textarea>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="shop-block-toggle">
                <a href="#" class="toggle">Стоимость доставки</a>
                <div class="description" style="padding-left: 12px">
                  Стоимость доставки будет посчитана в системной валюте
                </div>
                <div class="block">
                    <input type="text" name="delivery_price" value=""/>
                </div>
            </div>

            <?php if ($this->_tpl_vars['customFieldArray']): ?>
            <div class="shop-block-toggle">
                <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_dopolnitelnie_polya']; ?>
:</a>
                <div class="description" style="padding-left: 12px">
                </div>
                <div class="block">
                    <?php $_from = $this->_tpl_vars['customFieldArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['e']):
?>
                    <?php if ($this->_tpl_vars['e']['type'] == 'text'): ?>
                    <?php echo $this->_tpl_vars['e']['name']; ?>
:
                    <br />
                    <textarea name="custom_<?php echo $this->_tpl_vars['e']['field']; ?>
"><?php echo $this->_tpl_vars['e']['value']; ?>
</textarea>
                    <br />
                    <br />
                    <?php elseif ($this->_tpl_vars['e']['type'] == 'string'): ?>
                    <?php echo $this->_tpl_vars['e']['name']; ?>
:
                    <br />
                    <input type="text" name="custom_<?php echo $this->_tpl_vars['e']['field']; ?>
" value="<?php echo $this->_tpl_vars['e']['value']; ?>
" style="width: 100%;" />
                    <br />
                    <br />
                    <?php elseif ($this->_tpl_vars['e']['type'] == 'int'): ?>
                    <?php echo $this->_tpl_vars['e']['name']; ?>
:
                    <br />
                    <input type="text" name="custom_<?php echo $this->_tpl_vars['e']['field']; ?>
" value="<?php echo $this->_tpl_vars['e']['value']; ?>
" class="js-int" />
                    <br />
                    <br />
                    <?php elseif ($this->_tpl_vars['e']['type'] == 'float'): ?>
                    <?php echo $this->_tpl_vars['e']['name']; ?>
:
                    <br />
                    <input type="text" name="custom_<?php echo $this->_tpl_vars['e']['field']; ?>
" value="<?php echo $this->_tpl_vars['e']['value']; ?>
" class="js-float"/>
                    <br />
                    <br />
                    <?php elseif ($this->_tpl_vars['e']['type'] == 'bool'): ?>
                    <label>
                        <?php echo $this->_tpl_vars['e']['name']; ?>
:
                        <input type="checkbox" name="custom_<?php echo $this->_tpl_vars['e']['field']; ?>
" value="1" <?php if ($this->_tpl_vars['e']['value']): ?> checked <?php endif; ?> />
                    </label>
                    <br />
                    <br />
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="shop-productleft-layer">
        <div class="shop-block-toggle">
            <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_main_image_small']; ?>
:</a>
            <div class="block">
                <strong><?php echo $this->_tpl_vars['translate_main_image']; ?>
</strong>
                <div class="shop-block-photos">
                    <div class="main">
                        <div class="item">
                                                        <?php echo $this->_tpl_vars['cropper']; ?>

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="shop-block-toggle">
            <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_item_icon']; ?>
:</a>
            <div class="block">
                <div class="shop-block-photos">
                    <div class="main">
                        <div class="item">
                            <select name="icon" class="chzn-select" style="min-width: 150px;">
                                <option value="0">---</option>
                                <?php $_from = $this->_tpl_vars['iconsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <option value="<?php echo $this->_tpl_vars['e']['image']; ?>
" <?php if ($this->_tpl_vars['e']['image'] == $this->_tpl_vars['control_icon']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>

    <div class="ob-button-fixed">
        <input type="button" onclick="document.location='/admin/shop/products/'" name="ok" value="&lsaquo; <?php echo $this->_tpl_vars['translate_product_list']; ?>
" class="ob-button right help-hint-back-to-products" />
        <input type="submit" name="ok" value="<?php echo $this->_tpl_vars['translate_create_new_product']; ?>
" class="ob-button button-green" />
        <input type="submit" name="ok_continue" value="<?php echo $this->_tpl_vars['translate_create_new_product_and_continue']; ?>
" class="ob-button" />
    </div>
    <div class="ob-button-fixed-place"></div>

    <script type="text/javascript">
        $j(function() {
            $j(".rte-zone").htmlarea({
                css: '/_css/jquery.htmlarea.editor.css'
            });
        });
    </script>
</form>