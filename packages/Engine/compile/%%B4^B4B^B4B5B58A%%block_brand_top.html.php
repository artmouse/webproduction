<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:03
         compiled from /var/www/shop.local//templates/default//block/block_brand_top.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/var/www/shop.local//templates/default//block/block_brand_top.html', 1, false),)), $this); ?>
<?php if (count($this->_tpl_vars['brandArray']) > 4): ?>
    <div class="os-brand-carousel">
        <a href="#" class="prev">&nbsp;</a>
        <a href="#" class="next">&nbsp;</a>
        <div class="line">
            <ul>
                <?php $_from = $this->_tpl_vars['brandArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                    <li><a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" alt="<?php echo $this->_tpl_vars['e']['name']; ?>
" /></a></li>
                <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        $j(function() {
            //brand carousel init
            $j('.os-brand-carousel .line').jCarouselLite({
                visible: 13,
                auto: false,
                timeout: 5000,
                speed: 500,
                pause: false,
                btnPrev: '.os-brand-carousel .prev',
                btnNext: '.os-brand-carousel .next'
            });

            // фикс для маленького кол-ва слайдов
            $j('.os-brand-carousel .next').click();
        });
    </script>
<?php endif; ?>