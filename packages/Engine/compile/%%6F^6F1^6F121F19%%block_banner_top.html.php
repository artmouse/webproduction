<?php /* Smarty version 2.6.27-optimized, created on 2015-11-30 18:20:33
         compiled from /var/www/shop.local/modules/kazakhfilm-adaptive/contents/block/block_banner_top.html */ ?>
<?php if ($this->_tpl_vars['bannerArray']): ?>
    <div class="kf-slider-block">
        <div class="line">
            <ul>
                <?php $_from = $this->_tpl_vars['bannerArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['b']):
?>
                    <li>
                        <a href="<?php echo $this->_tpl_vars['b']['url']; ?>
" <?php if ($this->_tpl_vars['b']['external']): ?>rel="nofollow" target="_blank"<?php endif; ?>>
                            <img src="<?php echo $this->_tpl_vars['b']['image']; ?>
" alt="" />
                            <span class="description">
                                <span class="description-content">
                                    <strong><?php echo $this->_tpl_vars['b']['name']; ?>
</strong>
                                    <?php echo $this->_tpl_vars['b']['comment']; ?>

                                </span>
                            </span>
                        </a>
                    </li>
                <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
        <script type="text/javascript">
            $j(function() {
                $j('.kf-slider-block .line>ul').bxSlider({
                    pager:false,
                    slideMargin: 0,
                    auto: true
                });
            });
        </script>
    </div>
<?php endif; ?>