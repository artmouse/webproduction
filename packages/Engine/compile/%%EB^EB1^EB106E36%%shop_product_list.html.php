<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 17:12:51
         compiled from /var/www/shop.local//templates/default//shop_product_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/shop.local//templates/default//shop_product_list.html', 111, false),)), $this); ?>
<input type="hidden" value="<?php echo $this->_tpl_vars['show']; ?>
" id="js-product-list-show">
<div class="os-product-layer <?php if (! $this->_tpl_vars['showFilters']): ?>nofilter<?php endif; ?>">
    <div class="inner-layer">
        <?php if ($this->_tpl_vars['categoryid']): ?>
            <div class="js-product-list-group-id" data-id="<?php echo $this->_tpl_vars['categoryid']; ?>
" data-key="category" style="display:none"></div>
        <?php elseif ($this->_tpl_vars['brandid']): ?>
            <div class="js-product-list-group-id" data-id="<?php echo $this->_tpl_vars['brandid']; ?>
" data-key="brand" style="display:none"></div>
        <?php endif; ?>
        <div class="js-product-list">
            <?php if ($this->_tpl_vars['pathArray']): ?>
                <div class="os-crumbs">
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
            <?php endif; ?>

            <?php echo $this->_tpl_vars['block_subscribe_category']; ?>


            <?php echo $this->_tpl_vars['container']; ?>


            <?php if ($this->_tpl_vars['showPages'] && count ( $this->_tpl_vars['pagesArray'] ) > 1): ?>
                <div class="os-submit red os-show-more js-show-more">
                    <div class="load"></div>
                    <span class="js-stepper-next-count"><?php echo $this->_tpl_vars['translate_pokazat_eshche']; ?>
 <?php echo $this->_tpl_vars['nextCount']; ?>
 <?php echo $this->_tpl_vars['translate_tovarov']; ?>
</span>
                </div>

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

        <?php if ($this->_tpl_vars['contentID'] != 'index' && $this->_tpl_vars['contentID'] != 'shop-basket'): ?>
            <?php $_from = $this->_tpl_vars['carouselArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                <div class="os-block-caption"><h3><?php echo $this->_tpl_vars['e']['name']; ?>
</h3></div>
                <?php echo $this->_tpl_vars['e']['html']; ?>

            <?php endforeach; endif; unset($_from); ?>
        <?php endif; ?>
    </div>
</div>

<?php if ($this->_tpl_vars['showFilters']): ?>
    <aside class="filter-layer js-wrap-filter">
        <div class="inner js-block-filter">
            <?php if ($this->_tpl_vars['isbrand']): ?>
                <div class="os-brand-info">
                    <?php if ($this->_tpl_vars['branddescription'] || $this->_tpl_vars['brandsiteurl']): ?>
                        <div class="description">
                            <?php if ($this->_tpl_vars['brandsiteurl']): ?>
                            <?php echo $this->_tpl_vars['translate_official_site_of_brand']; ?>
:
                            <a href="<?php echo $this->_tpl_vars['brandsiteurl']; ?>
" rel="nofollow"><?php echo $this->_tpl_vars['brandsiteurl']; ?>
</a>
                            <br />
                            <?php endif; ?>
                            <?php echo $this->_tpl_vars['branddescription']; ?>

                        </div>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['brandimage']): ?>
                        <div class="logo">
                            <img src="<?php echo $this->_tpl_vars['brandimage']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['brandname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php echo $this->_tpl_vars['block_productfilter']; ?>


            <?php echo $this->_tpl_vars['block_banner_left']; ?>


            <?php if ($this->_tpl_vars['integration_google_adsence_left']): ?>
                <div class="os-block-adsense-left">
                    <!--adsense left place-->
                    <?php echo $this->_tpl_vars['integration_google_adsence_left']; ?>

                </div>
            <?php endif; ?>

            <div class="clear"></div>
        </div>
    </aside>
<?php endif; ?>
<div class="clear"></div>