<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:02
         compiled from /var/www/shop.local//templates/default//block/block_banner_bottom.html */ ?>
<?php if ($this->_tpl_vars['bannerBottomArray']): ?>
    <div class="shop-bottom-banner-carousel block-banners">
        <a href="#" class="prev">&nbsp;</a>
        <a href="#" class="next">&nbsp;</a>
        <div class="line-s">
            <div class="line-b banner-carousel">
                <ul>
                    <?php $_from = $this->_tpl_vars['bannerBottomArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['b']):
?>
                        <li>
                            <a href="<?php echo $this->_tpl_vars['b']['url']; ?>
" class="item" <?php if ($this->_tpl_vars['b']['external']): ?>rel="nofollow" target="_blank"<?php endif; ?>>
                                <img src="<?php echo $this->_tpl_vars['b']['image']; ?>
" width="300" height="250" alt="<?php echo $this->_tpl_vars['b']['name']; ?>
" title="<?php echo $this->_tpl_vars['b']['name']; ?>
" />
                            </a>
                        </li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>