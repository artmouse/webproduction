<?php /* Smarty version 2.6.27-optimized, created on 2015-11-22 14:28:41
         compiled from /var/www/shop.local/modules/collars/contents/shop_product_list.html */ ?>
<input type="hidden" value="<?php echo $this->_tpl_vars['show']; ?>
" id="js-product-list-show">

<?php if ($this->_tpl_vars['showFilters']): ?>
    <div class="cl-filter-layer js-wrap-filter">
        <div class="inner js-block-filter">
            <?php echo $this->_tpl_vars['block_productfilter']; ?>


            <?php echo $this->_tpl_vars['block_banner_left']; ?>

            <div class="clear"></div>
        </div>
    </div>
<?php endif; ?>

<div class="cl-content-layer <?php if (! $this->_tpl_vars['showFilters']): ?>nofilter<?php endif; ?>">
    <?php if ($this->_tpl_vars['categoryid']): ?>
        <div class="js-product-list-group-id" data-id="<?php echo $this->_tpl_vars['categoryid']; ?>
" data-key="category" style="display:none"></div>
    <?php elseif ($this->_tpl_vars['brandid']): ?>
        <div class="js-product-list-group-id" data-id="<?php echo $this->_tpl_vars['brandid']; ?>
" data-key="brand" style="display:none"></div>
    <?php endif; ?>

    <div class="js-product-list">
        <?php if ($this->_tpl_vars['pathArray']): ?>
            <div class="cl-crumbs">
                <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                    <a href="/" itemprop="url">
                        <span itemprop="title"><?php echo $this->_tpl_vars['storeTitle']; ?>
</span>
                    </a>
                </div>

                <?php $_from = $this->_tpl_vars['pathArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['e']):
        $this->_foreach['foo']['iteration']++;
?>
                    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" data-rel=".tab-ordered" itemprop="url">
                            <span itemprop="title"><?php echo $this->_tpl_vars['e']['name']; ?>
</span>
                        </a>
                    </div>
                <?php endforeach; endif; unset($_from); ?>

                <?php $_from = $this->_tpl_vars['pathAdditionalArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['e']):
        $this->_foreach['foo']['iteration']++;
?>
                    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" data-rel=".tab-ordered" itemprop="url">
                            <span itemprop="title"><?php echo $this->_tpl_vars['e']['name']; ?>
</span>
                        </a>
                    </div>
                <?php endforeach; endif; unset($_from); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['showSort']): ?>
            <script>
                function filterChange(e) {
                    if($j(e).val() != '<?php echo $this->_tpl_vars['sort']; ?>
') {
                        $j('[data-id=id-sort-form]').submit();
                    }
                }
            </script>

            <form action="<?php echo $this->_tpl_vars['formUrl']; ?>
" method="post" data-id="id-sort-form">
                <div class="os-block-productsort">
                    <?php echo $this->_tpl_vars['translate_sort']; ?>
:
                    <select name="sort" onchange="filterChange(this);">
                        <option value="rating" <?php if ($this->_tpl_vars['sort'] == 'rating'): ?>selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_sort_rating']; ?>
</option>
                        <option value="ordered" <?php if ($this->_tpl_vars['sort'] == 'ordered'): ?>selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_sort_ordered']; ?>
</option>
                        <option value="name" <?php if ($this->_tpl_vars['sort'] == 'name'): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_sort_name']; ?>
</option>
                        <option value="price-asc" <?php if ($this->_tpl_vars['sort'] == 'price-asc'): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_sort_price_asc']; ?>
</option>
                        <option value="price-desc" <?php if ($this->_tpl_vars['sort'] == 'price-desc'): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_sort_price_desc']; ?>
</option>
                        <option value="avail" <?php if ($this->_tpl_vars['sort'] == 'avail'): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_sort_avail']; ?>
</option>
                        <?php if ($this->_tpl_vars['need_relevance_sort']): ?>
                        <option value="relevance" <?php if ($this->_tpl_vars['sort'] == 'relevance'): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_sort_relevance']; ?>
</option>
                        <?php endif; ?>
                    </select>
                </div>
            </form>
            <div class="clear"></div>
        <?php endif; ?>

        <?php echo $this->_tpl_vars['block_subscribe_category']; ?>


        <?php echo $this->_tpl_vars['container']; ?>


        <?php if ($this->_tpl_vars['showPages'] && count ( $this->_tpl_vars['pagesArray'] ) > 1): ?>
            
            <div class="os-stepper js-stepper">
                <?php if ($this->_tpl_vars['urlprev']): ?>
                    <a class="prev" href="<?php echo $this->_tpl_vars['urlprev']; ?>
" data-rel="prev" id="back">&larr;<?php echo $this->_tpl_vars['translate_back']; ?>
</a>
                <?php endif; ?>

                <?php $_from = $this->_tpl_vars['pagesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                    <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" <?php if (! $this->_tpl_vars['e']['visible']): ?>style="display:none"<?php endif; ?> <?php if ($this->_tpl_vars['e']['selected']): ?>class="selected"<?php endif; ?> data-type="page"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                <?php endforeach; endif; unset($_from); ?>

                <?php if ($this->_tpl_vars['urlnext']): ?>
                    <a class="next" href="<?php echo $this->_tpl_vars['urlnext']; ?>
" data-rel="next" id="next"><?php echo $this->_tpl_vars['translate_next']; ?>
&rarr;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    </div>
<div class="clear"></div>