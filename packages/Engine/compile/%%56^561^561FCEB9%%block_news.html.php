<?php /* Smarty version 2.6.27-optimized, created on 2015-11-13 16:34:31
         compiled from /var/www/shop.local//templates/default//block/block_news.html */ ?>
<?php if ($this->_tpl_vars['newsArray']): ?>
    <div class="os-block-caption"><?php echo $this->_tpl_vars['translate_site_news']; ?>
</div>
    <div class="os-block-news">
        <?php $_from = $this->_tpl_vars['newsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <div class="element">
                <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                <div class="date"><?php echo $this->_tpl_vars['e']['date']; ?>
</div>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>