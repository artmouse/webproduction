<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:08:26
         compiled from /var/www/shop.local/contents/shop/admin/datasource_filter.html */ ?>
<div style="display: none;" class="shop-block-popup js-tableview-popup">
    <div class="dark"></div>
    <div class="popupblock">
        <a class="close" onclick="popupClose('.js-tableview-popup');" href="#">
            <svg viewBox="0 0 16 16">
                <use xlink:href="#icon-close"></use>
            </svg>
        </a>
        <div class="head"><?php echo $this->_tpl_vars['translate_caption_tool_table']; ?>
</div>
        <div class="window-content">
            <div class="shop-table-view">
                <form action="" method="post">
                    <?php $_from = $this->_tpl_vars['fieldsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <label class="element">
                            <input type="checkbox" name="columns[]" value="<?php echo $this->_tpl_vars['e']['key']; ?>
" <?php if ($this->_tpl_vars['e']['visible']): ?> checked <?php endif; ?> <?php if ($this->_tpl_vars['e']['primary']): ?> disabled <?php endif; ?> />
                            <?php echo $this->_tpl_vars['e']['name']; ?>

                        </label>
                    <?php endforeach; endif; unset($_from); ?>
                    <br />

                    <div class="view">
                        <table>
                            <tr>
                                <td><strong><?php echo $this->_tpl_vars['translate_show_records_per_page']; ?>
</strong>:</td>
                                <td><input type="text" name="rowscount" value="<?php echo $this->_tpl_vars['rowscount']; ?>
" style="width: 70px;"/> (max:100)</td>
                            </tr>
                            <tr>
                                <td><strong><?php echo $this->_tpl_vars['translate_sort_by_default']; ?>
:</strong></td>
                                <td>
                                    <select class="chzn-select inline" name="rowssort" style="width: 200px;">
                                        <option value="">Auto</option>
                                        <?php $_from = $this->_tpl_vars['fieldsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                            <?php if ($this->_tpl_vars['e']['sortable']): ?>
                                                <option value="<?php echo $this->_tpl_vars['e']['key']; ?>
" <?php if ($this->_tpl_vars['rowssort'] == $this->_tpl_vars['e']['key']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                                            <?php endif; ?>
                                        <?php endforeach; endif; unset($_from); ?>
                                    </select>

                                    <select class="chzn-select inline" name="rowssorttype">
                                        <option value="">Auto</option>
                                        <option value="asc" <?php if ($this->_tpl_vars['rowssorttype'] == 'asc'): ?> selected <?php endif; ?>>A-Z</option>
                                        <option value="desc" <?php if ($this->_tpl_vars['rowssorttype'] == 'desc'): ?> selected <?php endif; ?>>Z-A</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="ob-button-fixed">
                        <input type="submit" value="<?php echo $this->_tpl_vars['translate_save']; ?>
" name="columnsave" class="ob-button button-green" />
                        <input type="button" value="<?php echo $this->_tpl_vars['translate_cancel']; ?>
" class="ob-button" onclick="popupClose('.js-tableview-popup');" />
                    </div>
                    <div class="ob-button-fixed-place"></div>
                </form>
            </div>
        </div>
    </div>
</div>