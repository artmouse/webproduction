<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 17:06:29
         compiled from /var/www/shop.local//templates/default//block/block_banner_pageinterval.html */ ?>
<?php if ($this->_tpl_vars['pageIntervalBannerId']): ?>
    <div class="os-block-popup js-popup-pageinterval-block" >
        <div class="dark" onclick="popup_pageinterval_close();"></div>
        <div class="block-popup pageinterval-popup">
            <div class="head">
                <a href="javascript: void(0);" class="close" onclick="popup_pageinterval_close();"></a>
                <?php echo $this->_tpl_vars['pageIntervalName']; ?>

            </div>
            <img class="banner-image" src="<?php echo $this->_tpl_vars['urlBannerLoginImg']; ?>
" width="800" height="350" alt=""/>
            <div class="body"> <?php echo $this->_tpl_vars['commentPageIntervalBanner']; ?>
 </div>
            <div class="foot">
                <a class="os-submit green" href="<?php echo $this->_tpl_vars['urlBannerLogin']; ?>
"><?php echo $this->_tpl_vars['translate_registration']; ?>
</a>
            </div>
        </div>
        <input type="hidden" id="pageIntervalBannerId" value="<?php echo $this->_tpl_vars['pages']; ?>
">
    </div>
<?php endif; ?>