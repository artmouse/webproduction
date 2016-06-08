<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:10
         compiled from /var/www/shop.local//templates/default//block/block_banner_wide.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/var/www/shop.local//templates/default//block/block_banner_wide.html', 14, false),)), $this); ?>
<?php if ($this->_tpl_vars['bannerArray']): ?>
    <div class="os-wrap-slider-full">
        <div class="os-block-slider-full  js-block-slick-slider-full">
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
        <?php if (count($this->_tpl_vars['bannerArray']) > 1): ?>
            <div class="prev-arrow"></div>
            <div class="next-arrow"></div>
        <?php endif; ?>
    </div>

    <script>
        $j(window).on('load resize', function(){
            var $fulpageSlider = $j('.js-block-slick-slider-full');
            var contentWidth = $j(window).width();
            $fulpageSlider.width(contentWidth);

            $fulpageSlider.slick({
                prevArrow: $j('.os-wrap-slider-full .prev-arrow'),
                nextArrow: $j('.os-wrap-slider-full .next-arrow'),
                adaptiveHeight: true
            });
        });
    </script>
<?php endif; ?>