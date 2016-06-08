<?php /* Smarty version 2.6.27-optimized, created on 2015-12-17 00:08:05
         compiled from /var/www/shop.local/modules/collars/contents/block/block_menu_category.html */ ?>
<ul class="cl-category-menu js-toggle-cat-menu">
    <?php $_from = $this->_tpl_vars['categoryArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['e1']):
?>
        <?php if ($this->_tpl_vars['key'] < 6): ?>
            <li>
                <a href="<?php echo $this->_tpl_vars['e1']['url']; ?>
"><span><?php echo $this->_tpl_vars['e1']['name']; ?>
</span></a>
                <?php if ($this->_tpl_vars['e1']['childsArray']): ?>
                    <ul class="dropdown-menu">
                        <?php $_from = $this->_tpl_vars['e1']['childsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['keye2'] => $this->_tpl_vars['e2']):
?>
                            <li class="element">
                                <a href="<?php echo $this->_tpl_vars['e2']['url']; ?>
"><?php echo $this->_tpl_vars['e2']['name']; ?>
</a>
                            </li>
                        <?php endforeach; endif; unset($_from); ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <li class="top-level-link">
        <a href="/contact">Contact</a>
    </li>
    <li class="top-level-link">
        <a  href="/sale/">Sale</a>
        <!--<div class="sales">Sale</div>-->
    </li>
</ul>