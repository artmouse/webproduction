<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:02
         compiled from /var/www/shop.local//templates/default//block/block_menu_brand.html */ ?>
<?php if ($this->_tpl_vars['allBrandsCount']): ?>
    <div class="nav-element">
        <div class="element-inner">
            <a href="<?php echo $this->_tpl_vars['brandAllUrl']; ?>
"><span><?php echo $this->_tpl_vars['translate_brands']; ?>
</span></a>
            <?php if ($this->_tpl_vars['brandsArray']): ?>
                <div class="sub">
                    <ul class="js-category-list">
                        <?php $_from = $this->_tpl_vars['brandsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['b']):
?>
                            <li>
                                <div class="level-1">
                                    <a href="<?php echo $this->_tpl_vars['b']['url']; ?>
"><?php echo $this->_tpl_vars['b']['name']; ?>
</a><?php if ($this->_tpl_vars['b']['productCount']): ?><span class="count">(<?php echo $this->_tpl_vars['b']['productCount']; ?>
)</span><?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; endif; unset($_from); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>