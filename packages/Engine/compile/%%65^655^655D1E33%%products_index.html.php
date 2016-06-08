<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 11:42:48
         compiled from /var/www/shop.local/contents/shop/admin/products/products_index.html */ ?>
<div class="nb-top-nav-place js-top-nav-buffer"></div>
<div class="nb-top-nav js-top-nav">
    <div class="nb-block-tabs">
        <?php if ($this->_tpl_vars['block_folders']): ?>
            <div class="tab-element">
                <a href="/admin/shop/products/list-table/" class="selected"> <?php echo $this->_tpl_vars['translate_many_products']; ?>
</a>
            </div>
        <?php else: ?>
            <div class="tab-element">
                <a href="/admin/shop/products/list-table/<?php echo $this->_tpl_vars['query']; ?>
"> <?php echo $this->_tpl_vars['translate_many_products']; ?>
</a>
            </div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['block_table']): ?>
            <div class="tab-element">
                <a href="/admin/shop/products/" class="selected" > <?php echo $this->_tpl_vars['translate_many_products_inlist']; ?>
</a>
            </div>
        <?php else: ?>
            <div class="tab-element">
                <a href="/admin/shop/products/<?php echo $this->_tpl_vars['query']; ?>
"> <?php echo $this->_tpl_vars['translate_many_products_inlist']; ?>
</a>
            </div>
        <?php endif; ?>
        <div class="tab-element"><a href="/admin/shop/products/add/"><?php echo $this->_tpl_vars['translate_new_product']; ?>
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
        <div class="tab-element"><a href="/admin/product/merge/"><?php echo $this->_tpl_vars['translate_skleyka_tovarov']; ?>
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
    <?php echo $this->_tpl_vars['translate_products_added_to_order']; ?>
.<br />
    <a href="<?php echo $this->_tpl_vars['urlredirect']; ?>
"><?php echo $this->_tpl_vars['translate_go_to_order']; ?>
...</a>
</div>
<?php endif; ?>
<div hidden="" id="js-open-category-id" category-id="<?php if ($this->_tpl_vars['openCategoryId']): ?><?php echo $this->_tpl_vars['openCategoryId']; ?>
<?php else: ?>0<?php endif; ?>"></div>

<div class="filter-toggle <?php if ($this->_tpl_vars['filterpanelCookie']): ?>open<?php endif; ?>"></div>
<div class="shop-filter-panel <?php if ($this->_tpl_vars['filterpanelCookie']): ?>open<?php endif; ?>">
    <div class="inner-pannel">
        <form action="" method="get">
            <?php if ($this->_tpl_vars['block_folders']): ?>
                <div class="element">
                    <div class="nb-block-tabs js-slide-tabs js-folder-type">
                        <div class="tab-element"><a class="selected" href="#">Больше</a></div>
                        <div class="tab-element"><a href="#" class="line">Компактно</a></div>
                        <span class="hover"></span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="element">
                <input type="hidden" name="filter1_key" value="id" />
                <input type="hidden" name="filter1_type" value="equals" />
                <input type="text" name="filter1_value" value="<?php echo $this->_tpl_vars['control_filter1_value']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_code_small']; ?>
" />
            </div>
            <div class="element">
                <input type="hidden" name="filter22_key" value="articul" />
                <input type="hidden" name="filter22_type" value="equals" />
                <input type="text" name="filter22_value" value="<?php echo $this->_tpl_vars['control_filter22_value']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_articul']; ?>
" />
            </div>
            <div class="element">
                <input type="hidden" name="filter44_key" value="code1c" />
                <input type="hidden" name="filter44_type" value="equals" />
                <input type="text" name="filter44_value" value="<?php echo $this->_tpl_vars['control_filter44_value']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_code1c_small']; ?>
" />
            </div>
            <div class="element">
                <input type="hidden" name="filter2_key" value="barcode"/>
                <input type="hidden" name="filter2_type" value="equals" />
                <input type="text" name="filter2_value" value="<?php echo $this->_tpl_vars['control_filter2_value']; ?>
" id="barcode" placeholder="<?php echo $this->_tpl_vars['translate_item_barcode']; ?>
" />
            </div>
            <div class="element">
                <input type="hidden" name="filter21_key" value="model"/>
                <input type="hidden" name="filter21_type" value="equals" />
                <input type="text" name="filter21_value" value="<?php echo $this->_tpl_vars['control_filter21_value']; ?>
" id="model" placeholder="<?php echo $this->_tpl_vars['translate_model']; ?>
" />
            </div>
            <div class="element">
                <input type="hidden" name="filter3_key" value="name" />
                <input type="hidden" name="filter3_type" value="search" />
                <input type="text" name="filter3_value" value="<?php echo $this->_tpl_vars['control_filter3_value']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_title_short']; ?>
" />
            </div>
            <div class="element">
                <input type="hidden" name="filter5_key" value="tags" />
                <input type="hidden" name="filter5_type" value="search" />
                <input type="text" name="filter5_value" value="<?php echo $this->_tpl_vars['control_filter5_value']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_tags']; ?>
" />
            </div>

            <?php $_from = $this->_tpl_vars['productFilterArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
                <div class="element">
                    <input type="text" name="custom_filter_<?php echo $this->_tpl_vars['p']['id']; ?>
" value="<?php echo $this->_tpl_vars['p']['value']; ?>
" placeholder="<?php echo $this->_tpl_vars['p']['name']; ?>
">
                </div>
            <?php endforeach; endif; unset($_from); ?>

            <div class="element ulist">
                <label>
                    <?php echo $this->_tpl_vars['translate_show_deleted_products']; ?>

                    <input type="checkbox" class="js-show-products" <?php if ($this->_tpl_vars['control_filter_show_deleted']): ?>checked<?php endif; ?> name="filter_show_deleted" value="<?php echo $this->_tpl_vars['control_filter_show_deleted']; ?>
" />
                </label>
            </div>
            <div class="element ulist">
                <label>
                    <?php echo $this->_tpl_vars['translate_show_hidden_products']; ?>

                    <input type="checkbox" class="js-show-products" <?php if ($this->_tpl_vars['control_filter_show_hidden']): ?>checked<?php endif; ?> name="filter_show_hidden" value="<?php echo $this->_tpl_vars['control_filter_show_hidden']; ?>
" />
                </label>
            </div>
            <div class="element ulist">
                <label>
                    <?php echo $this->_tpl_vars['translate_show_not_synchronize']; ?>

                    <input type="checkbox" class="js-show-products" <?php if ($this->_tpl_vars['control_filter_show_not_sync']): ?>checked<?php endif; ?> name="filter_show_not_sync" value="<?php echo $this->_tpl_vars['control_filter_show_not_sync']; ?>
" />
                </label>
            </div> 
            <div class="element ulist">
                <label>
                    <?php echo $this->_tpl_vars['translate_product_in_stock']; ?>

                    <input type="checkbox" class="js-show-products" <?php if ($this->_tpl_vars['control_filter_show_avail']): ?>checked<?php endif; ?> name="filter_show_avail" value="<?php echo $this->_tpl_vars['control_filter_show_avail']; ?>
" />
                </label>
            </div> 
            <div class="element ulist">
                <label>
                    <?php echo $this->_tpl_vars['translate_not_available']; ?>

                    <input type="checkbox" class="js-show-products" <?php if ($this->_tpl_vars['control_filter_show_not_avail']): ?>checked<?php endif; ?> name="filter_show_not_avail" value="<?php echo $this->_tpl_vars['control_filter_show_not_avail']; ?>
" />
                </label>
            </div> 
                        
            <?php if (count ( $this->_tpl_vars['brandArray'] ) > 0): ?>
                <div class="element">
                    <div class="caption-field"><?php echo $this->_tpl_vars['translate_brand']; ?>
</div>
                    <input type="hidden" name="filter4_key" value="brandid" />
                    <input type="hidden" name="filter4_type" value="equals" />
                    <select name="filter4_value" class="chzn-select">
                        <option value=""><?php echo $this->_tpl_vars['translate_all']; ?>
</option>
                        <?php $_from = $this->_tpl_vars['brandArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['control_filter4_value'] == $this->_tpl_vars['e']['id']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['supplierArray']): ?>
                <div class="element">
                    <div class="caption-field"><?php echo $this->_tpl_vars['translate_supplier']; ?>
</div>
                    <select name="supplierid" class="chzn-select">
                        <option value=""><?php echo $this->_tpl_vars['translate_all']; ?>
</option>
                        <?php $_from = $this->_tpl_vars['supplierArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['control_supplierid'] == $this->_tpl_vars['e']['id']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            <?php endif; ?>

                        <input type="hidden" name="categoryid" value="<?php echo $this->_tpl_vars['arg_categoryid']; ?>
" />

            <input class="ob-button button-orange" type="submit" value="<?php echo $this->_tpl_vars['translate_filter']; ?>
" />
            <div class="clear"></div>
            <br />

            <h1><?php echo $this->_tpl_vars['translate_many_products']; ?>
</h1>
            <div class="element">
                <input type="text" name="" placeholder="<?php echo $this->_tpl_vars['translate_enter_category_name']; ?>
" id="id_search" />
            </div>

            <div class="ob-block-tree js-block-tree">
                <?php if ($this->_tpl_vars['newCategoryArray'][0]): ?>
                    <ul>
                        <li>
                            <div class="item js-droppable" js-data-id="0"><a href="."><?php echo $this->_tpl_vars['translate_category_list']; ?>
</a></div>
                        </li>
                        <li>
                            <div class="item js-droppable" js-data-id="0"><a href="./?categoryid=0"><?php echo $this->_tpl_vars['translate_no_category']; ?>
</a></div>
                        </li>
                        <?php $_from = $this->_tpl_vars['newCategoryArray'][0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <li>
                                <div class="item js-droppable" js-data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
"><a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" <?php if ($this->_tpl_vars['e']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</a></div>
                                <?php if ($this->_tpl_vars['newCategoryArray'][$this->_tpl_vars['e']['id']]): ?>
                                    <span class="expand"></span>
                                    <ul style="display: none;">
                                        <?php $_from = $this->_tpl_vars['newCategoryArray'][$this->_tpl_vars['e']['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e2']):
?>
                                            <li>
                                                <div class="item js-droppable" js-data-id="<?php echo $this->_tpl_vars['e2']['id']; ?>
"><a href="<?php echo $this->_tpl_vars['e2']['url']; ?>
" <?php if ($this->_tpl_vars['e2']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['e2']['name']; ?>
</a>
                                                </div>
                                                <?php if ($this->_tpl_vars['newCategoryArray'][$this->_tpl_vars['e2']['id']]): ?>
                                                    <span class="expand"></span>
                                                    <ul style="display: none;">
                                                        <?php $_from = $this->_tpl_vars['newCategoryArray'][$this->_tpl_vars['e2']['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e3']):
?>
                                                            <li>
                                                                <div class="item js-droppable" js-data-id="<?php echo $this->_tpl_vars['e3']['id']; ?>
"><a href="<?php echo $this->_tpl_vars['e3']['url']; ?>
" <?php if ($this->_tpl_vars['e3']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['e3']['name']; ?>
</a>
                                                                </div>
                                                                <?php if ($this->_tpl_vars['newCategoryArray'][$this->_tpl_vars['e3']['id']]): ?>
                                                                    <span class="expand"></span>
                                                                    <ul style="display: none;">
                                                                        <?php $_from = $this->_tpl_vars['newCategoryArray'][$this->_tpl_vars['e3']['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e4']):
?>
                                                                            <li>
                                                                                <div class="item js-droppable" js-data-id="<?php echo $this->_tpl_vars['e4']['id']; ?>
"><a href="<?php echo $this->_tpl_vars['e4']['url']; ?>
" <?php if ($this->_tpl_vars['e4']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['e4']['name']; ?>
</a>
                                                                                </div>
                                                                                <?php if ($this->_tpl_vars['newCategoryArray'][$this->_tpl_vars['e4']['id']]): ?>
                                                                                    <span class="expand"></span>
                                                                                    <ul style="display: none;">
                                                                                        <?php $_from = $this->_tpl_vars['newCategoryArray'][$this->_tpl_vars['e4']['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e5']):
?>
                                                                                            <li>
                                                                                                <div class="item js-droppable" js-data-id="<?php echo $this->_tpl_vars['e5']['id']; ?>
"><a href="<?php echo $this->_tpl_vars['e5']['url']; ?>
" <?php if ($this->_tpl_vars['e5']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['e5']['name']; ?>
</a>
                                                                                                </div>
                                                                                            </li>
                                                                                        <?php endforeach; endif; unset($_from); ?>
                                                                                    </ul>
                                                                                <?php endif; ?>
                                                                            </li>
                                                                        <?php endforeach; endif; unset($_from); ?>
                                                                    </ul>
                                                                <?php endif; ?>
                                                            </li>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; endif; unset($_from); ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; endif; unset($_from); ?>
                    </ul>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="shop-result-list">
    <div class="inner-list <?php if ($this->_tpl_vars['filterpanelCookie']): ?>filter-reserve<?php endif; ?>">
        <?php if ($this->_tpl_vars['block_table']): ?>
            <?php echo $this->_tpl_vars['block_table']; ?>

            <?php if ($this->_tpl_vars['productFilterCount']): ?>
                <div class="ob-block-details">
                    <div class="single-wrap">
                        <div class="ob-data-element">
                            <div class="data-view">
                                <div class="el-caption static" style=""><?php echo $this->_tpl_vars['translate_kolichestvo_produktov']; ?>
:</div>
                                <div class="el-value">
                                    <?php echo $this->_tpl_vars['productFilterCount']; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php echo $this->_tpl_vars['block_folders']; ?>

        <?php endif; ?>
    </div>
</div>
<div class="clear"></div>

<div class="nb-right-sidebar disable">
    <div class="toggle"></div>

    <?php if ($this->_tpl_vars['allowEdit']): ?>
        <form class="inner" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" id="id-category" name="moveids" />
            <div class="element double">
                <?php echo $this->_tpl_vars['translate_move_into_category']; ?>
:
                <select class="chzn-select-tree" name="movecategory">
                    <option value="0">---</option>
                    <?php $_from = $this->_tpl_vars['categoryArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_movecategory']): ?> selected <?php endif; ?> data-level="<?php echo $this->_tpl_vars['e']['level']; ?>
">
                            <?php echo $this->_tpl_vars['e']['name']; ?>

                            (<?php echo $this->_tpl_vars['e']['productcount']; ?>
)
                            <?php if ($this->_tpl_vars['e']['hidden']): ?>
                                - <?php echo $this->_tpl_vars['translate_hidden1_small']; ?>

                            <?php endif; ?>
                        </option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </div>

            <?php if (count ( $this->_tpl_vars['brandArray'] ) > 0): ?>
                <div class="element double">
                    <?php echo $this->_tpl_vars['translate_move_into_the_brand']; ?>
:
                    <select class="chzn-select" name="movebrand">
                        <option value="0">---</option>
                        <?php $_from = $this->_tpl_vars['brandArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['control_movebrand'] == $this->_tpl_vars['e']['id']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="element">
                <?php echo $this->_tpl_vars['translate_sync_not_sync']; ?>

                <select class="chzn-select" name="changesync">
                    <option value="notTouch">---</option>
                    <option value="0"><?php echo $this->_tpl_vars['translate_synchronized']; ?>
</option>
                    <option value="1"><?php echo $this->_tpl_vars['translate_not_synchronize']; ?>
</option>
                </select>
            </div>

            <div class="element">
                <br />
                <?php echo $this->_tpl_vars['translate_open']; ?>
 / <?php echo $this->_tpl_vars['translate_hide']; ?>

                <select class="chzn-select" name="hide">
                    <option value="0">---</option>
                    <option value="unhide"><?php echo $this->_tpl_vars['translate_open']; ?>
</option>
                    <option value="hide"><?php echo $this->_tpl_vars['translate_hide']; ?>
</option>
                </select>
            </div>

            <div class="element">
                <?php echo $this->_tpl_vars['translate_delete']; ?>
 / <?php echo $this->_tpl_vars['translate_restore']; ?>

                <select class="chzn-select" name="delete">
                    <option value="0">---</option>
                    <option value="delete"><?php echo $this->_tpl_vars['translate_delete']; ?>
</option>
                    <option value="undelete"><?php echo $this->_tpl_vars['translate_restore']; ?>
</option>
                </select>
            </div>

            <div class="element">
                <?php echo $this->_tpl_vars['translate_in_stock']; ?>
 / <?php echo $this->_tpl_vars['translate_out_of_stock']; ?>

                <select class="chzn-select" name="avail">
                    <option value="0">---</option>
                    <option value="setavail"><?php echo $this->_tpl_vars['translate_in_stock']; ?>
</option>
                    <option value="setunavail"><?php echo $this->_tpl_vars['translate_out_of_stock']; ?>
</option>
                </select>
            </div>

            <div class="element">
                <?php echo $this->_tpl_vars['translate_dobavit_tegi']; ?>

                <input type="text" name="changeaddtags" value="" />
            </div>

            <div class="element">
                <?php echo $this->_tpl_vars['translate_ubrat_tegi']; ?>

                <input type="text" name="changeremovetags" value="" />
            </div>

            <div class="element">
                <?php echo $this->_tpl_vars['translate_ustanovit_izobrazhenie']; ?>

                <input type="file" name="changeimage" value="">
            </div>

            <div class="element double">
                <?php echo $this->_tpl_vars['translate_ustanovit_opisanie']; ?>

                <textarea name="changedescription" rows="2"></textarea>
            </div>

            <div class="element">
                <input class="ob-button" type="submit" name="change" value="<?php echo $this->_tpl_vars['translate_user_change']; ?>
" />
            </div>
            <?php if ($this->_tpl_vars['isOrder']): ?>
                <div class="element">
                    <input class="ob-button" type="submit" name="createorder" value="<?php echo $this->_tpl_vars['translate_create_new_order']; ?>
" style="margin-bottom: 5px;" />
                    <label><input type="checkbox" name="gotoorder" /><?php echo $this->_tpl_vars['translate_go_to_order']; ?>
</label>
                </div>
    
                <div class="element">
                    <input type="text" name="orderid" value="" placeholder="id"  />
                </div>
                <div class="element">
                    <input class="ob-button" type="submit" name="addexistorder" value="<?php echo $this->_tpl_vars['translate_add_to_existing_order']; ?>
"  />
                </div>
                <div class="element"></div>
            <?php endif; ?>
        </form>
    <?php endif; ?>
    <div class="clear"></div>
</div>