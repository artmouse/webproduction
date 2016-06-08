<?php /* Smarty version 2.6.27-optimized, created on 2015-12-08 12:38:07
         compiled from /var/www/shop.local/contents/shop/admin/textpages/textpages_index.html */ ?>
<div class="nb-top-nav-place js-top-nav-buffer"></div>
<div class="nb-top-nav js-top-nav">
    <div class="nb-block-tabs">
        <div class="tab-element"><a href="/admin/shop/textpages/" class="selected"><?php echo $this->_tpl_vars['translate_textpages']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/textpages/add/"><?php echo $this->_tpl_vars['translate_new_textpage_add']; ?>
</a></div>
        <div class="clear"></div>
    </div>
</div>

<div class="filter-hidden"></div>
<div class="shop-filter-panel open">
    <div class="inner-pannel">
        <h1><?php echo $this->_tpl_vars['translate_textpages']; ?>
</h1>
        <?php if ($this->_tpl_vars['pagesArray'][0]): ?>
            <div class="ob-block-tree js-block-tree">
                <ul>
                    <?php $_from = $this->_tpl_vars['pagesArray'][0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e1']):
?>
                        <li>
                            <a href="<?php echo $this->_tpl_vars['e1']['url']; ?>
" <?php if ($this->_tpl_vars['e1']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['e1']['name']; ?>
</a>
                            <?php if ($this->_tpl_vars['pagesArray'][$this->_tpl_vars['e1']['id']]): ?>
                                <span class="expand"></span>
                                <ul style="display: none;">
                                    <?php $_from = $this->_tpl_vars['pagesArray'][$this->_tpl_vars['e1']['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e2']):
?>
                                        <li>
                                            <a href="<?php echo $this->_tpl_vars['e2']['url']; ?>
" <?php if ($this->_tpl_vars['e2']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['e2']['name']; ?>
</a>
                                        </li>
                                    <?php endforeach; endif; unset($_from); ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="shop-result-list">
    <div class="inner-list filter-reserve">
        <?php if ($this->_tpl_vars['form']): ?>
            <?php echo $this->_tpl_vars['form']; ?>

        <?php elseif ($this->_tpl_vars['pagesArray']): ?>
            <div class="shop-message-info"><?php echo $this->_tpl_vars['translate_textpages_select']; ?>
.</div>
        <?php else: ?>
            <a href="/admin/shop/textpages/add/"><?php echo $this->_tpl_vars['translate_new_textpage_add']; ?>
</a>
        <?php endif; ?>
    </div>
</div>
<div class="clear"></div>