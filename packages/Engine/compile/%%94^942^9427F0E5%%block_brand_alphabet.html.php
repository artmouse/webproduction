<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:01:10
         compiled from /var/www/shop.local//templates/default//block/block_brand_alphabet.html */ ?>
<br />
<div class="ob-brands-list">
    <?php $_from = $this->_tpl_vars['brandsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['brands']):
?>
    <?php if ($this->_tpl_vars['brands']): ?>
    <div class="element">
        <div class="letter"><?php if ($this->_tpl_vars['k'] == 'others'): ?><span title="<?php echo $this->_tpl_vars['translate_other_brands']; ?>
">#</span><?php else: ?><?php echo $this->_tpl_vars['k']; ?>
<?php endif; ?></div>
        <?php $_from = $this->_tpl_vars['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a> <?php if ($this->_tpl_vars['e']['productCount']): ?>(<?php echo $this->_tpl_vars['e']['productCount']; ?>
)<?php endif; ?><br />
        <?php endforeach; endif; unset($_from); ?>
    </div>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
    <div class="empty"></div>
</div>