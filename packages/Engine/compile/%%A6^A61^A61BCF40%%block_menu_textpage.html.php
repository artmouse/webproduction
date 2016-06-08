<?php /* Smarty version 2.6.27-optimized, created on 2015-11-30 18:20:34
         compiled from /var/www/shop.local/modules/kazakhfilm-adaptive/contents/block/block_menu_textpage.html */ ?>

<div class="nav-element">
    <a <?php if ($this->_tpl_vars['contentID'] == 'index'): ?>class="active"<?php endif; ?> href="/"><span>Главная</span></a>
</div>
<div class="nav-element">
    <a href="<?php echo $this->_tpl_vars['bookingUrl']; ?>
" <?php if ($this->_tpl_vars['contentID'] == 'booking'): ?>class="active"<?php endif; ?>><span>Номера и цены</span></a>
</div>
<div class="nav-element">
    <a href="http://astanacapital.com/i/hotelkz/index.html"><span>3D тур</span></a>
</div>
<div class="nav-element">
    <a href="<?php echo $this->_tpl_vars['guestbookUrl']; ?>
" <?php if ($this->_tpl_vars['contentID'] == 'shop-guestbook'): ?>class="active"<?php endif; ?>><span>Отзывы</span></a>
</div>
<div class="nav-element">
    <a href="/contacts/" <?php if ($this->_tpl_vars['contentID'] == 'shop-page'): ?>class="active"<?php endif; ?>><span>Контакты</span></a>
</div>