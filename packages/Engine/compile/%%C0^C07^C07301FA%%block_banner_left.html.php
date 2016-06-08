<?php /* Smarty version 2.6.27-optimized, created on 2015-11-22 14:28:39
         compiled from /var/www/shop.local/modules/collars/contents/block/block_banner_left.html */ ?>
<?php if ($this->_tpl_vars['bannerLeftArray']): ?>
    <?php $_from = $this->_tpl_vars['bannerLeftArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['b']):
?>
        <div class="cl-aside-block-banner">
            <a href="<?php echo $this->_tpl_vars['b']['url']; ?>
" class="item" <?php if ($this->_tpl_vars['b']['external']): ?>rel="nofollow" target="_blank"<?php endif; ?>>
                <img src="<?php echo $this->_tpl_vars['b']['image']; ?>
" alt="<?php echo $this->_tpl_vars['b']['name']; ?>
" title="<?php echo $this->_tpl_vars['b']['name']; ?>
"/>
            </a>
        </div>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
