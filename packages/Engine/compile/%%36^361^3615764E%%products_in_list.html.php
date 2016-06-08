<?php /* Smarty version 2.6.27-optimized, created on 2015-11-25 17:06:55
         compiled from /var/www/shop.local/contents/shop/admin/products/products_in_list.html */ ?>
<div class="nb-top-nav-place js-top-nav-buffer"></div>
<div class="nb-top-nav js-top-nav">
    <div class="nb-block-tabs">
        <div class="tab-element"><a href="/admin/shop/products/">&lsaquo; <?php echo $this->_tpl_vars['translate_many_products']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/products/productslist/" class="selected"><?php echo $this->_tpl_vars['translate_products_in_list']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/products/list/"><?php echo $this->_tpl_vars['translate_products_control']; ?>
</a></div>
        <div class="clear"></div>
    </div>
</div>

<?php if ($this->_tpl_vars['listArray']): ?>
    <div class="filter-hidden"></div>
    <div class="shop-filter-panel open">
        <div class="inner-pannel">
            <h1><?php echo $this->_tpl_vars['translate_products_in_list']; ?>
</h1>
            <div class="ob-block-tree">
                <ul>
                    <?php $_from = $this->_tpl_vars['listArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['l']):
?>
                        <li><a href="?l=<?php echo $this->_tpl_vars['l']['id']; ?>
"><?php echo $this->_tpl_vars['l']['name']; ?>
<?php if ($this->_tpl_vars['l']['linkkey']): ?> (<?php echo $this->_tpl_vars['l']['linkkey']; ?>
)<?php endif; ?></a></li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="shop-result-list">
        <div class="inner-list filter-reserve">
            <?php if ($this->_tpl_vars['message'] == 'ok'): ?>
                <div class="shop-message-success">
                    <?php echo $this->_tpl_vars['translate_products_upgrade_success']; ?>
.
                </div>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['message'] == 'error'): ?>
                <div class="shop-message-error">
                    <?php echo $this->_tpl_vars['translate_products_upgrade_error']; ?>
.
                </div>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['name']): ?>
                <h2><?php echo $this->_tpl_vars['name']; ?>
</h2><?php if (! $this->_tpl_vars['logicclass']): ?> (<?php echo $this->_tpl_vars['translate_list_is_automatically_generated']; ?>
)<?php endif; ?>
            <?php endif; ?>

            <?php echo $this->_tpl_vars['table']; ?>


            <?php if (! $this->_tpl_vars['table']): ?>
                <div class="shop-message-info"><?php echo $this->_tpl_vars['translate_list_select']; ?>
.</div>
            <?php endif; ?>

            <?php if (count ( $this->_tpl_vars['pagesArray'] ) > 1): ?>
                <div class="ob-block-stepper">
                    <?php if ($this->_tpl_vars['urlprev']): ?>
                        <a href="<?php echo $this->_tpl_vars['urlprev']; ?>
" class="prev">&lsaquo; <?php echo $this->_tpl_vars['translate_back']; ?>
</a>
                        <?php if ($this->_tpl_vars['hellip']): ?>&hellip;<?php endif; ?>
                    <?php endif; ?>

                    <?php $_from = $this->_tpl_vars['pagesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" <?php if ($this->_tpl_vars['e']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                    <?php endforeach; endif; unset($_from); ?>

                    <?php if ($this->_tpl_vars['urlnext']): ?>
                        <?php if ($this->_tpl_vars['hellip']): ?>&hellip;<?php endif; ?>
                        <a href="<?php echo $this->_tpl_vars['urlnext']; ?>
" class="next"><?php echo $this->_tpl_vars['translate_next']; ?>
 &rsaquo;</a>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['allowAll']): ?>
                        <a href="?p=all"><?php echo $this->_tpl_vars['translate_allow_all']; ?>
 (<?php echo $this->_tpl_vars['productsCount']; ?>
)</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="clear"></div>

    <div class="nb-right-sidebar" style="display: block;">
        <div class="toggle"></div>
        <form class="inner" action="" method="post">
            <div class="element double">
                <?php echo $this->_tpl_vars['translate_priceplace_product_add']; ?>

                <?php if ($this->_tpl_vars['useCode1c']): ?>
                    <?php echo $this->_tpl_vars['translate_priceplace_product_declare_code1c']; ?>

                <?php else: ?>
                    <?php echo $this->_tpl_vars['translate_priceplace_product_declare_code']; ?>

                <?php endif; ?>
                <textarea name="codes"></textarea>
            </div>

            <div class="element double" id="id-form-delete" style="display: none;">
                <label>
                    <input type="checkbox" name="delete" value="" id="id-checkboxes" />
                    <?php echo $this->_tpl_vars['translate_products_list_delete_confirm']; ?>

                </label>
            </div>

            <div class="element">
                <input class="ob-button" type="submit" name="ok" value="<?php echo $this->_tpl_vars['translate_save']; ?>
" />
            </div>
            <div class="element"></div>
        </form>
    </div>
<?php else: ?>
    <div class="shop-message-info">
        <?php echo $this->_tpl_vars['translate_no_product_list']; ?>
. &nbsp;&nbsp;<a href="/admin/shop/products/list/add/" class="ob-button"><?php echo $this->_tpl_vars['translate_create_product_list']; ?>
</a>
    </div>
<?php endif; ?>