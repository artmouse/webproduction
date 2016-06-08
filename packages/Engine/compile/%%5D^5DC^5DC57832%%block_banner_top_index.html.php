<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:10
         compiled from /var/www/shop.local//templates/default//block/block_banner_top_index.html */ ?>
<?php if ($this->_tpl_vars['bannerArray']): ?>
    <div class="os-block-slick-slider js-block-slick-slider">
        <?php $_from = $this->_tpl_vars['bannerArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['b']):
?>
            <div>
                <a href="<?php echo $this->_tpl_vars['b']['url']; ?>
" <?php if ($this->_tpl_vars['b']['external']): ?>rel="nofollow" target="_blank"<?php endif; ?>>
                    <img src="<?php echo $this->_tpl_vars['b']['image']; ?>
" alt="">
                    <?php if ($this->_tpl_vars['b']['comment']): ?>
                        <span class="comment"><?php echo $this->_tpl_vars['b']['comment']; ?>
</span>
                    <?php endif; ?>
                </a>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>