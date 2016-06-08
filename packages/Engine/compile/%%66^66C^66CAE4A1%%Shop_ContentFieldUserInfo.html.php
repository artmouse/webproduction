<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:08:46
         compiled from /var/www/shop.local/api/forms/Shop_ContentFieldUserInfo.html */ ?>
<?php if ($this->_tpl_vars['url']): ?>
    <a href="<?php echo $this->_tpl_vars['url']; ?>
" data-id="<?php echo $this->_tpl_vars['id']; ?>
" class="js-contact-preview"><?php echo $this->_tpl_vars['name']; ?>
</a>
<?php else: ?>
    <?php echo $this->_tpl_vars['name']; ?>

<?php endif; ?>