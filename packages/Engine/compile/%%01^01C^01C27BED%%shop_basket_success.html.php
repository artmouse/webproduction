<?php /* Smarty version 2.6.27-optimized, created on 2015-12-20 18:33:22
         compiled from /var/www/shop.local/modules/collars/contents/shop_basket_success.html */ ?>
<h1><?php echo $this->_tpl_vars['translate_checkout']; ?>
</h1>

<div class="cl-crumbs">
    <div><a href="/"><?php echo $this->_tpl_vars['translate_main']; ?>
</a></div>
    <div><a href="/basket/"><?php echo $this->_tpl_vars['translate_my_basket']; ?>
</a></div>
    <div>
        <a><?php echo $this->_tpl_vars['translate_checkout']; ?>
</a>
    </div>
</div>



<div class="os-message-success order-success">
    <?php echo $this->_tpl_vars['goodmessage']; ?>

</div>

<?php if ($this->_tpl_vars['productsArray']): ?>
    <div class="os-product-success-list">
        <ul class="small-block-grid-1 smaller-block-grid-2 medium-block-grid-3 large-block-grid-4">
            <?php $_from = $this->_tpl_vars['productsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
                <li>
                    <div class="os-category-element">
                        <div class="image">
                            <a  href="<?php echo $this->_tpl_vars['p']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['p']['image']; ?>
" /></a>
                        </div>
                        <div class="name"><a href="<?php echo $this->_tpl_vars['p']['url']; ?>
"><?php echo $this->_tpl_vars['p']['name']; ?>
</a></div>
                    </div>
                </li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
<?php endif; ?>
<br />
<br />
