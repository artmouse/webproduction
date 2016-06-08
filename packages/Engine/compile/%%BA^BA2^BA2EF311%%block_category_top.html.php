<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:09
         compiled from /var/www/shop.local//templates/default//block/block_category_top.html */ ?>
<?php if ($this->_tpl_vars['subcategoriesArray']): ?>
    <div class="os-category-list">
        <?php $_from = $this->_tpl_vars['subcategoriesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <div class="os-category-element">
                <div class="head">
                    <h2>
                        <?php echo $this->_tpl_vars['e']['name']; ?>

                        <?php if (! $this->_tpl_vars['e']['childsArray']): ?>
                            <?php if ($this->_tpl_vars['e']['productCount']): ?>
                                (<?php echo $this->_tpl_vars['e']['productCount']; ?>
)
                            <?php endif; ?>
                        <?php endif; ?>
                    </h2>
                </div>
                <div class="body">
                    <div class="image">
                        <?php if ($this->_tpl_vars['e']['image']): ?>
                            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" alt="<?php echo $this->_tpl_vars['e']['name']; ?>
" title="<?php echo $this->_tpl_vars['e']['name']; ?>
" /></a>
                        <?php else: ?>
                            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><img src="/media/shop/stub.jpg" alt="<?php echo $this->_tpl_vars['e']['name']; ?>
" title="<?php echo $this->_tpl_vars['e']['name']; ?>
" /></a>
                        <?php endif; ?>
                    </div>

                    <div class="list">
                        <?php $_from = $this->_tpl_vars['e']['childsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s']):
?>
                                <a href="<?php echo $this->_tpl_vars['s']['url']; ?>
" ><?php echo $this->_tpl_vars['s']['name']; ?>
</a><?php if ($this->_tpl_vars['s']['productCount']): ?><span class="count">(<?php echo $this->_tpl_vars['s']['productCount']; ?>
)</span><?php endif; ?><br />
                        <?php endforeach; endif; unset($_from); ?>

                        <?php if ($this->_tpl_vars['e']['shortdesc']): ?>
                            <?php echo $this->_tpl_vars['e']['shortdesc']; ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; endif; unset($_from); ?>
        <div class="os-category-empty"></div>
        <div class="os-category-empty"></div>
        <div class="os-category-empty"></div>
        <div class="os-category-empty"></div>
        <div class="os-category-empty"></div>
    </div>
<?php endif; ?>