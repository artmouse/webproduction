<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:10
         compiled from /var/www/shop.local//templates/default//block/block_footer_textpage.html */ ?>
<?php $_from = $this->_tpl_vars['textpageArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
    <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
    <br />
<?php endforeach; endif; unset($_from); ?>