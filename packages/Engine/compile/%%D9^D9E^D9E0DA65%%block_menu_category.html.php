<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:02
         compiled from /var/www/shop.local//templates/default//block/block_menu_category.html */ ?>
<?php $this->assign('divider', 9); ?>
<?php $this->assign('line', 0); ?>
<?php $_from = $this->_tpl_vars['categoryArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['e1']):
?>
    <div class="nav-element">
        <div class="element-inner">
            <a href="<?php echo $this->_tpl_vars['e1']['url']; ?>
"><span><?php echo $this->_tpl_vars['e1']['name']; ?>
</span></a>
            <?php if ($this->_tpl_vars['e1']['childsArray']): ?>
                <div class="sub">
                    <ul class="js-category-list">
                        <?php $_from = $this->_tpl_vars['e1']['childsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['keye2'] => $this->_tpl_vars['e2']):
?>
                            <li>
                                <div class="level-1">
                                    <a href="<?php echo $this->_tpl_vars['e2']['url']; ?>
"><?php echo $this->_tpl_vars['e2']['name']; ?>
</a><?php if (! $this->_tpl_vars['e2']['childsArray']): ?><?php if ($this->_tpl_vars['e2']['productCount']): ?><span class="count">(<?php echo $this->_tpl_vars['e2']['productCount']; ?>
)</span><?php endif; ?><?php endif; ?>
                                </div>
                                <?php if ($this->_tpl_vars['e2']['childsArray']): ?>
                                    <?php $_from = $this->_tpl_vars['e2']['childsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e3']):
?>
                                        <div class="level-2">
                                            <a href="<?php echo $this->_tpl_vars['e3']['url']; ?>
"><?php echo $this->_tpl_vars['e3']['name']; ?>
</a><?php if ($this->_tpl_vars['e3']['productCount']): ?><span class="count">(<?php echo $this->_tpl_vars['e3']['productCount']; ?>
)</span><?php endif; ?>
                                        </div>
                                    <?php endforeach; endif; unset($_from); ?>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; endif; unset($_from); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if (( $this->_tpl_vars['key']+1 ) == ( ( $this->_tpl_vars['line']+1 ) * $this->_tpl_vars['divider'] )): ?>
        <?php $this->assign('line', $this->_tpl_vars['line']+1); ?>
        </div>
        <div class="nav-inner">
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>