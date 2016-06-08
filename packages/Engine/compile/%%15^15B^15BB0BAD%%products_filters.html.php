<?php /* Smarty version 2.6.27-optimized, created on 2015-11-26 18:24:19
         compiled from /var/www/shop.local/contents/shop/admin/products/products_filters.html */ ?>
<?php echo $this->_tpl_vars['menu']; ?>


<?php if ($this->_tpl_vars['message'] == 'ok'): ?>
    <div class="shop-message-success">
        <?php echo $this->_tpl_vars['translate_update_data_success']; ?>
.
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'error'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_data_error']; ?>
.<br />
        <?php $_from = $this->_tpl_vars['errorsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <?php echo $this->_tpl_vars['e']; ?>

        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>

<form  action="" method="post">
    <table>
        <?php $_from = $this->_tpl_vars['valuesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['e']):
?>
            <tr>
                <td width="300">
                    <select name="filterid[]" class="chzn-select">
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
                <td>
                    <input class="js-product-autocomplete-input" type="text"  name="filtervalue[]" value="<?php echo $this->_tpl_vars['e']['value']; ?>
"/>
                </td>
                <td>
                    <label><input type="checkbox" name="filteruse<?php echo $this->_tpl_vars['index']; ?>
" value="1" <?php if ($this->_tpl_vars['e']['use']): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['translate_available_in_filters']; ?>
</label><br />
                    <label><input type="checkbox" name="filteractual<?php echo $this->_tpl_vars['index']; ?>
" value="1" <?php if ($this->_tpl_vars['e']['actual']): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['translate_characteristics_Table']; ?>
</label><br />
                </td>
                <td>
                    <label><input type="checkbox" name="filteroption<?php echo $this->_tpl_vars['index']; ?>
" data-id="#markup<?php echo $this->_tpl_vars['index']; ?>
" class="js_option" value="1" <?php if ($this->_tpl_vars['e']['option']): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['translate_order_option']; ?>
</label>
                </td>
                <td>
                    <span <?php if (! $this->_tpl_vars['e']['option']): ?>style="display: none;"<?php endif; ?> id="markup<?php echo $this->_tpl_vars['index']; ?>
">
                        <label>
                            <?php echo $this->_tpl_vars['translate_markup']; ?>
 (<?php echo $this->_tpl_vars['translate_the_amount_of']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
)
                            <input type="text" name="filtermarkup[]" value="<?php echo $this->_tpl_vars['e']['markup']; ?>
" />
                        </label>
                    </span>
                    &nbsp;
                </td>
            </tr>
        <?php endforeach; endif; unset($_from); ?>
    </table>
    <br />
    <a href="<?php echo $this->_tpl_vars['addFilteUrl']; ?>
" target="_blank" class="ob-button"><?php echo $this->_tpl_vars['translate_products_filters_add']; ?>
</a>

    <div class="ob-button-fixed">
        <input type="button" onclick="document.location='/admin/shop/products/'" name="ok" value="&lsaquo; <?php echo $this->_tpl_vars['translate_product_list_run']; ?>
" class="ob-button" />
        <input type="submit" name="ok" value="<?php echo $this->_tpl_vars['translate_save']; ?>
" class="ob-button button-green" />
        <a href="/product/<?php echo $this->_tpl_vars['productid']; ?>
/" target="_blank"><?php echo $this->_tpl_vars['translate_review']; ?>
</a>
    </div>
    <div class="ob-button-fixed-place"></div>
</form>