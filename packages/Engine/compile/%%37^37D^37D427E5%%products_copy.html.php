<?php /* Smarty version 2.6.27-optimized, created on 2015-11-27 14:43:52
         compiled from /var/www/shop.local/contents/shop/admin/products/copy/products_copy.html */ ?>
<div class="nb-top-nav-place js-top-nav-buffer"></div>
<div class="nb-top-nav js-top-nav">
    <div class="nb-block-tabs">
        <div class="tab-element"><a href="/admin/shop/products/">&lsaquo; <?php echo $this->_tpl_vars['translate_many_products']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/products/add/"><?php echo $this->_tpl_vars['translate_new_product']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/products/copy/" class="selected"><?php echo $this->_tpl_vars['translate_products_copy']; ?>
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

<?php if ($this->_tpl_vars['messageCopy'] == 'error'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_product_copy_error']; ?>
.
    </div>
<?php endif; ?>

<div class="shop-block">
    <form action="" method="post">
        <table>
            <tr>
                <td><?php echo $this->_tpl_vars['translate_enter_item_code']; ?>
 (<?php if ($this->_tpl_vars['useCode1c']): ?>1C<?php else: ?>ID<?php endif; ?>):</td>
                <td><input type="text" name="copyid" value="<?php echo $this->_tpl_vars['control_copyid']; ?>
" style="width: 60px;" /></td>
                <td><input type="submit" name="copy" value="<?php echo $this->_tpl_vars['translate_send']; ?>
" class="ob-button button-green" /></td>
            </tr>
        </table>
    </form>
</div>

<?php if ($this->_tpl_vars['productid'] || $this->_tpl_vars['message']): ?>
    <?php if ($this->_tpl_vars['message'] == 'ok'): ?>
    <div class="shop-message-success">
        <?php echo $this->_tpl_vars['translate_product_copy_success']; ?>
.<br />
        <a href="<?php echo $this->_tpl_vars['urlredirect']; ?>
"><?php echo $this->_tpl_vars['translate_product_run_edit']; ?>
</a>
    </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['message'] == 'error'): ?>
        <div class="shop-message-error">
            <?php echo $this->_tpl_vars['translate_copy_error']; ?>
.
            <?php $_from = $this->_tpl_vars['errorsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                <?php if ($this->_tpl_vars['e'] == 'name'): ?>
                    <?php echo $this->_tpl_vars['translate_product_error_title']; ?>
.<br />
                <?php endif; ?>
                <?php if ($this->_tpl_vars['e'] == 'url'): ?>
                    <?php echo $this->_tpl_vars['translate_product_error_url']; ?>
.<br />
                <?php endif; ?>
                <?php if ($this->_tpl_vars['e'] == 'image'): ?>
                    <?php echo $this->_tpl_vars['translate_product_error_image']; ?>
.<br />
                <?php endif; ?>
                <?php if ($this->_tpl_vars['e'] == 'brand'): ?>
                    <?php echo $this->_tpl_vars['translate_product_error_brand']; ?>
.<br />
                <?php endif; ?>
                <?php if ($this->_tpl_vars['e'] == 'category'): ?>
                    <?php echo $this->_tpl_vars['translate_product_error_category']; ?>
.<br />
                <?php endif; ?>
                <?php if ($this->_tpl_vars['e'] == 'collection'): ?>
                    <?php echo $this->_tpl_vars['translate_product_error_collection']; ?>
.<br />
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        </div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">

        <div class="shop-block-toggle">
            <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_product_general']; ?>
</a>
            <div class="block">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td>
                            <div class="caption"><?php echo $this->_tpl_vars['translate_title_short']; ?>
</div>
                            <span class="important-field"><input type="text" name="name" value="<?php echo $this->_tpl_vars['control_name']; ?>
" style="width: 95%;" /></span>
                        </td>
                        <td width="280">
                            <div class="caption"><?php echo $this->_tpl_vars['translate_price']; ?>
</div>

                            <input type="text" name="price" value="<?php echo $this->_tpl_vars['control_price']; ?>
" style="width: 60px;" />

                            <select name="currency">
                                <?php $_from = $this->_tpl_vars['currencyArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_currency']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>

                            <label>
                                <input type="checkbox" name="tax" value="1" <?php if ($this->_tpl_vars['control_tax']): ?> checked <?php endif; ?> />
                                <?php echo $this->_tpl_vars['translate_vklyuchaya_nds']; ?>

                            </label>
                        </td>
                    </tr>
                </table>
                <br />

                <div class="caption"><?php echo $this->_tpl_vars['translate_description']; ?>
</div>
                <textarea name="description" style="width: 99%; height: 100px;" class="rte-zone"><?php echo $this->_tpl_vars['control_description']; ?>
</textarea>
                <br />
                <br />

                <label>
                    <input type="checkbox" name="hidden" value="1" <?php if ($this->_tpl_vars['control_hidden']): ?> checked <?php endif; ?> />
                    <?php echo $this->_tpl_vars['translate_product_hidden']; ?>

                </label>

                <label>
                    <input type="checkbox" name="deleted" value="1" <?php if ($this->_tpl_vars['control_deleted']): ?> checked <?php endif; ?> />
                    <?php echo $this->_tpl_vars['translate_product_deleted']; ?>

                </label>
                <br />
                <br />

                <div class="caption"><?php echo $this->_tpl_vars['translate_product_deacription']; ?>
 <?php echo $this->_tpl_vars['translate_product_deacription_term']; ?>
</div>
                <textarea name="descriptionshort" style="width: 99%; height: 40px;" class="rte-zone"><?php echo $this->_tpl_vars['control_descriptionshort']; ?>
</textarea>
                <br />
                <br />

                <div class="caption"><?php echo $this->_tpl_vars['translate_features']; ?>
 </div>
                <textarea name="characteristics" style="width: 99%; height: 80px;" ><?php echo $this->_tpl_vars['control_characteristics']; ?>
</textarea>
                <br />
                <br />
                <?php if ($this->_tpl_vars['valuesArray'] && $this->_tpl_vars['filtersArray']): ?>
                    <table class="features">
                        <?php $_from = $this->_tpl_vars['valuesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['e']):
?>
                        <tr>
                            <td>
                                <select name="filter<?php echo $this->_tpl_vars['index']; ?>
id" class="chzn-select" style="width: 200px;">
                                    <option value="0">---</option>
                                    <?php $_from = $this->_tpl_vars['filtersArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
                                    <option value="<?php echo $this->_tpl_vars['f']['id']; ?>
" <?php if ($this->_tpl_vars['f']['id'] == $this->_tpl_vars['e']['id']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['f']['name']; ?>
 <?php if ($this->_tpl_vars['f']['hidden']): ?>(<?php echo $this->_tpl_vars['translate_hidden_small']; ?>
)<?php endif; ?></option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                            </td>
                            <td><input type="text" name="filter<?php echo $this->_tpl_vars['index']; ?>
value" value="<?php echo $this->_tpl_vars['e']['value']; ?>
" class="js-feature" /></td>
                            <td><label><input type="checkbox" class="js-feature-autoselect" name="filter<?php echo $this->_tpl_vars['index']; ?>
use" <?php if ($this->_tpl_vars['e']['use']): ?>checked<?php endif; ?> value="1" /><?php echo $this->_tpl_vars['translate_available_in_filters']; ?>
</label></td>
                            <td><label><input type="checkbox" class="js-feature-autoselect" name="filter<?php echo $this->_tpl_vars['index']; ?>
actual" <?php if ($this->_tpl_vars['e']['actual']): ?>checked<?php endif; ?>  value="1" /><?php echo $this->_tpl_vars['translate_characteristics_Table']; ?>
</label></td>
                            <td><label><input type="checkbox" name="filter<?php echo $this->_tpl_vars['index']; ?>
option" <?php if ($this->_tpl_vars['e']['option']): ?>checked<?php endif; ?>  value="1" /><?php echo $this->_tpl_vars['translate_order_option']; ?>
</label></td>
                            <td>
                                <label>
                                    <input type="text" name="filter<?php echo $this->_tpl_vars['index']; ?>
markup" value="<?php if ($this->_tpl_vars['e']['markup'] > 0): ?><?php echo $this->_tpl_vars['e']['markup']; ?>
<?php endif; ?>" placeholder="<?php echo $this->_tpl_vars['translate_markup_placeholder']; ?>
"/>
                                    <?php echo $this->_tpl_vars['translate_markup']; ?>
 (<?php echo $this->_tpl_vars['translate_the_amount_of']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
)
                                </label>
                            </td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?>
                    </table>
                <?php endif; ?>

            </div>
        </div>

        <div class="shop-block-toggle">
            <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_all_features']; ?>
</a>
            <div class="block">
                <?php echo $this->_tpl_vars['translate_item_barcode']; ?>
 (13 <?php echo $this->_tpl_vars['translate_symbols']; ?>
, EAN, GS1)
                <input type="text" name="barcode" value="<?php echo $this->_tpl_vars['control_barcode']; ?>
" style="width: 180px;" />
                <br />
                <br />

                <?php echo $this->_tpl_vars['translate_single_category']; ?>

                <span class="important-field">
                    <select name="category" class="chzn-select-tree">
                        <option value="0">---</option>
                        <?php $_from = $this->_tpl_vars['categoryArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_category']): ?> selected <?php endif; ?> data-level="<?php echo $this->_tpl_vars['e']['level']; ?>
">
                        <?php echo $this->_tpl_vars['e']['name']; ?>

                        (<?php echo $this->_tpl_vars['e']['id']; ?>
)
                        <?php if ($this->_tpl_vars['e']['hidden']): ?>
                            - <?php echo $this->_tpl_vars['translate_hidden1_small']; ?>

                        <?php endif; ?>
                        </option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </span>
                <br />
                <br />

                <?php echo $this->_tpl_vars['translate_brand']; ?>

                <select name="brand" class="chzn-select" style="min-width: 150px;">
                    <option value="0">---</option>
                    <?php $_from = $this->_tpl_vars['brandsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                    <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_brand']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
                <br />
                <br />

                <?php echo $this->_tpl_vars['translate_model']; ?>

                <input type="text" name="model" value="<?php echo $this->_tpl_vars['control_model']; ?>
" />
                <br />
                <br />

                <?php echo $this->_tpl_vars['translate_modelniy_ryad_seriya_kollektsiya_']; ?>

                <input type="text" name="seriesname" value="<?php echo $this->_tpl_vars['control_seriesname']; ?>
" />
                <br />
                <br />

                <?php if ($this->_tpl_vars['collectionArray']): ?>
                <?php echo $this->_tpl_vars['translate_single_collection']; ?>

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

                <input type="text" name="unitbox" value="<?php echo $this->_tpl_vars['control_unitbox']; ?>
" />
                <br />
                <br />

                <?php echo $this->_tpl_vars['translate_width']; ?>

                <input type="text" name="width" value="<?php echo $this->_tpl_vars['control_width']; ?>
" style="width: 100px;" />
                <?php echo $this->_tpl_vars['translate_length']; ?>

                <input type="text" name="length" value="<?php echo $this->_tpl_vars['control_length']; ?>
" style="width: 100px;" />
                <?php echo $this->_tpl_vars['translate_height']; ?>

                <input type="text" name="height" value="<?php echo $this->_tpl_vars['control_height']; ?>
" style="width: 100px;" />
                <?php echo $this->_tpl_vars['translate_weight']; ?>

                <input type="text" name="weight" value="<?php echo $this->_tpl_vars['control_weight']; ?>
" style="width: 100px;" />
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

                <?php echo $this->_tpl_vars['translate_unit']; ?>

                <input type="text" name="unit" value="<?php echo $this->_tpl_vars['control_unit']; ?>
" style="width: 70px;" />
                <?php echo $this->_tpl_vars['translate_pieces']; ?>
, <?php echo $this->_tpl_vars['translate_liter']; ?>
, <?php echo $this->_tpl_vars['translate_miter']; ?>
, ...
                <br />
                <br />

                <label>
                    <input type="checkbox" name="denycomments" value="1" <?php if ($this->_tpl_vars['control_denycomments']): ?> checked <?php endif; ?> />
                    <?php echo $this->_tpl_vars['translate_denycomments']; ?>

                </label>
            </div>
        </div>

        <div class="shop-block-toggle">
            <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_actions_and_presents']; ?>
:</a>
            <div class="block">
                <?php echo $this->_tpl_vars['translate_discount']; ?>

                <input type="text" name="discount" value="<?php echo $this->_tpl_vars['control_discount']; ?>
" style="width: 50px;" /> %
                <br />
                <br />

                <?php echo $this->_tpl_vars['translate_action']; ?>

                <input type="text" name="share" value="<?php echo $this->_tpl_vars['control_share']; ?>
" style="width: 300px;" />
                <br />
                <br />

                <?php echo $this->_tpl_vars['translate_crossed_out_price']; ?>

                <input type="text" name="priceold" value="<?php echo $this->_tpl_vars['control_priceold']; ?>
" style="width: 60px;" /> <?php echo $this->_tpl_vars['translate_crossed_out_price_description']; ?>

                <br />
                <br />
            </div>
        </div>

        <div class="shop-block-toggle">
            <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_presence_and_storage']; ?>
:</a>
            <div class="block">
                <label>
                    <input type="checkbox" name="avail" value="1" <?php if ($this->_tpl_vars['control_avail']): ?> checked <?php endif; ?> />
                    <?php echo $this->_tpl_vars['translate_item_in_stock']; ?>

                </label>

                <?php echo $this->_tpl_vars['translate_in_stock_info']; ?>

                <input type="text" name="availtext" value="<?php echo $this->_tpl_vars['control_availtext']; ?>
" style="width: 300px;" />
                <br /><br />

                <?php if ($this->_tpl_vars['allowStorage']): ?>
                <?php echo $this->_tpl_vars['translate_required_reserve']; ?>

                <input type="text" name="storagereserve" value="<?php echo $this->_tpl_vars['control_storagereserve']; ?>
" style="width: 100px;" />
                <?php endif; ?>
            </div>
        </div>

        <div class="shop-block-toggle">
            <a href="#" class="toggle">SEO</a>
            <div class="block">
                SEO <?php echo $this->_tpl_vars['translate_heading']; ?>
 (title)
                <input type="text" name="seotitle" value="<?php echo $this->_tpl_vars['control_seotitle']; ?>
" style="width: 300px;" />
                <br />
                <br />

                <div class="caption">SEO <?php echo $this->_tpl_vars['translate_description_small']; ?>
 (description)</div>
                <textarea name="seodescription" style="width: 99%; height: 80px;"><?php echo $this->_tpl_vars['control_seodescription']; ?>
</textarea>
                <br />
                <br />

                <div class="caption">SEO <?php echo $this->_tpl_vars['translate_seo_content']; ?>
 (content)</div>
                <textarea name="seocontent" style="width: 99%; height: 80px;"><?php echo $this->_tpl_vars['control_seocontent']; ?>
</textarea>
                <br />
                <br />

                <div class="caption">SEO <?php echo $this->_tpl_vars['translate_seo_kaewords']; ?>
 (keywords)</div>
                <textarea name="seokeywords" style="width: 99%; height: 80px;"><?php echo $this->_tpl_vars['control_seokeywords']; ?>
</textarea>
                <br />
                <br />

                SEO <?php echo $this->_tpl_vars['translate_seo_name']; ?>
 1
                <input type="text" name="name1" value="<?php echo $this->_tpl_vars['control_name1']; ?>
" style="width: 300px;" />
                <br />
                <br />

                SEO <?php echo $this->_tpl_vars['translate_seo_name']; ?>
 2
                <input type="text" name="name2" value="<?php echo $this->_tpl_vars['control_name2']; ?>
" style="width: 300px;" />
                <br />
                <br />

                URL-<?php echo $this->_tpl_vars['translate_prefix']; ?>

                <input type="text" name="url" value="<?php echo $this->_tpl_vars['control_url']; ?>
" style="width: 350px;" />
                <?php echo $this->_tpl_vars['translate_prefix_description']; ?>

            </div>
        </div>

        <div class="shop-block-toggle">
            <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_sync_and_producer']; ?>
:</a>
            <div class="block">
                <label>
                    <input type="checkbox" name="syncable" value="1" <?php if ($this->_tpl_vars['control_syncable']): ?> checked <?php endif; ?> />
                    <?php echo $this->_tpl_vars['translate_synchronized']; ?>
 (1C, <?php echo $this->_tpl_vars['translate_etc']; ?>
)
                </label>

                <?php echo $this->_tpl_vars['translate_code_small']; ?>
 1C
                <input type="text" name="code1c" value="<?php echo $this->_tpl_vars['control_code1c']; ?>
" style="width: 200px;" />
                <br />
                <br />


            </div>
        </div>

        <div class="shop-block-toggle">
            <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_warranty_dilivery_payment']; ?>
:</a>
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
                <?php echo $this->_tpl_vars['translate_wdp_description']; ?>

            </div>
        </div>


        <div class="shop-block-toggle">
            <a href="#" class="toggle"><?php echo $this->_tpl_vars['translate_item_images']; ?>
</a>
            <div class="block">
                <div class="shop-block-photos">
                    <div class="main">
                        <div class="caption"><?php echo $this->_tpl_vars['translate_main_image_small']; ?>
:</div>
                        <?php if ($this->_tpl_vars['imagemainsrc']): ?>
                        <div class="item">
                            <img src="<?php echo $this->_tpl_vars['imagemain']; ?>
" width="214" />
                            <input type="hidden" name="mainimageurl" value="<?php echo $this->_tpl_vars['imagemain']; ?>
" >
                            <label>
                                <input type="checkbox" name="deleteimagemain" value="1" />
                                <?php echo $this->_tpl_vars['translate_main_image_delete']; ?>

                            </label>
                        </div>
                        <?php endif; ?>

                        <div class="item">
                            <div class="caption"><?php echo $this->_tpl_vars['translate_main_image']; ?>
</div>
                            <input type="file" name="image" />
                        </div>
                    </div>
                    <div class="other">
                        <div class="caption"><?php echo $this->_tpl_vars['translate_more_image']; ?>
:</div>
                        <?php if ($this->_tpl_vars['imagesArray']): ?>
                            <?php $_from = $this->_tpl_vars['imagesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <div class="item">
                                    <img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" />
                                    <input type="hidden" name="smallImagesArray[]" value="<?php echo $this->_tpl_vars['e']['imagebig']; ?>
" >
                                </div>
                            <?php endforeach; endif; unset($_from); ?>
                        <?php endif; ?>
                        <div class="item">
                            <div class="caption"><?php echo $this->_tpl_vars['translate_load_more_image']; ?>
</strong> <?php echo $this->_tpl_vars['translate_load_more_image_description']; ?>
</div>
                            <input type="file" name="image1" /><br />
                            <input type="file" name="image2" /><br />
                            <input type="file" name="image3" /><br />
                            <input type="file" name="image4" /><br />
                            <input type="file" name="image5" /><br />
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="ob-button-fixed">
            <input type="button" onclick="document.location='/admin/shop/products/'" name="prev" value="&lsaquo; <?php echo $this->_tpl_vars['translate_product_list_run']; ?>
" class="ob-button" />
            <input type="submit" name="ok" value="<?php echo $this->_tpl_vars['translate_products_copy']; ?>
" class="ob-button button-green" />
        </div>
        <div class="ob-button-fixed-place"></div>
    </form>

    <style type="text/css">
        .chzn-container {
            vertical-align:middle;
        }
    </style>

    <script type="text/javascript">
    $j(function() {
        $j(".rte-zone").htmlarea({
            css: '/_css/jquery.htmlarea.editor.css'
        });
    });
    </script>
<?php endif; ?>