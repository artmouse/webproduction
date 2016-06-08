<?php /* Smarty version 2.6.27-optimized, created on 2015-11-23 14:52:33
         compiled from /var/www/shop.local/modules/collars/contents/block/block_search.html */ ?>
<a href="javascript:void(0);" class="search-toggle-button js-toggle-search"></a>
<div class="search">
    <form action="/search/" method="get">
        <select id="js_search_category" name="categoryid" style="display: none;">
            <option value="-1" <?php if (! $this->_tpl_vars['categoryIdSelected'] || $this->_tpl_vars['categoryIdSelected'] == 0): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['translate_category_all']; ?>
</option>
            <?php $_from = $this->_tpl_vars['categoryArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
            <option value="<?php echo $this->_tpl_vars['c']['id']; ?>
" <?php if ($this->_tpl_vars['categoryIdSelected'] == $this->_tpl_vars['c']['id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['c']['name']; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
        </select>
        <input class="js-input-search" type="text" name="query" value="<?php echo $this->_tpl_vars['control_query']; ?>
"  />
        <input type="submit" value="" />
    </form>
</div>