<?php /* Smarty version 2.6.27-optimized, created on 2015-11-22 14:28:40
         compiled from /var/www/shop.local/modules/collars/contents/block/block_banner_wide.html */ ?>
<?php if ($this->_tpl_vars['bannerArray']): ?>
    <div class="cl-fullwidth-slider js-fullwidth-slider">

        <?php $_from = $this->_tpl_vars['bannerArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['b']):
?>
            <div>
                <a href="<?php echo $this->_tpl_vars['b']['url']; ?>
" <?php if ($this->_tpl_vars['b']['external']): ?>rel="nofollow" target="_blank"<?php endif; ?>>
                    <img src="<?php echo $this->_tpl_vars['b']['image']; ?>
" alt="">
                </a>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>