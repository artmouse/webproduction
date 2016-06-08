<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:02
         compiled from /var/www/shop.local//templates/default//block/block_banner_left.html */ ?>
<?php if ($this->_tpl_vars['bannerLeftArray']): ?>
    <div class="os-columnbanner-carousel">
        <?php if (count ( $this->_tpl_vars['bannerRightArray'] ) > 1): ?>
            <div class="line">
                <ul>
                    <?php $_from = $this->_tpl_vars['bannerLeftArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['b']):
?>
                    <li>
                        <a href="<?php echo $this->_tpl_vars['b']['url']; ?>
" class="item" <?php if ($this->_tpl_vars['b']['external']): ?>rel="nofollow" target="_blank"<?php endif; ?>>
                        <img src="<?php echo $this->_tpl_vars['b']['image']; ?>
" width="220" height="250" alt="<?php echo $this->_tpl_vars['b']['name']; ?>
" title="<?php echo $this->_tpl_vars['b']['name']; ?>
"/>
                        </a>
                    </li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            </div>
        <?php else: ?>
            <?php $_from = $this->_tpl_vars['bannerLeftArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['b']):
?>
                <a href="<?php echo $this->_tpl_vars['b']['url']; ?>
" class="item" <?php if ($this->_tpl_vars['b']['external']): ?>rel="nofollow" target="_blank"<?php endif; ?>>
                <img src="<?php echo $this->_tpl_vars['b']['image']; ?>
" width="220" height="250" alt="<?php echo $this->_tpl_vars['b']['name']; ?>
" title="<?php echo $this->_tpl_vars['b']['name']; ?>
"/>
                </a>
            <?php endforeach; endif; unset($_from); ?>
        <?php endif; ?>

        <?php if (count ( $this->_tpl_vars['bannerLeftArray'] ) > 1): ?>
            <div class="control">
                <div class="prev">&lt;</div>
                <div class="next">&gt;</div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>