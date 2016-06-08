<?php /* Smarty version 2.6.27-optimized, created on 2015-11-18 16:16:52
         compiled from /var/www/shop.local//templates/default//block/block_currency.html */ ?>
<?php if ($this->_tpl_vars['currencyArray']): ?>
<div class="os-block-caption"><?php echo $this->_tpl_vars['translate_exchange_rate']; ?>
</div>
<div class="os-block-subscribe">

    <?php $_from = $this->_tpl_vars['currencyArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
    <div class="success">
        1 <?php echo $this->_tpl_vars['e']['name']; ?>
 - <?php echo $this->_tpl_vars['e']['rate']; ?>
 <?php echo $this->_tpl_vars['translate_uah']; ?>
.
    </div>
    <?php endforeach; endif; unset($_from); ?>

</div>
<?php endif; ?>