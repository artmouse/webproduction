<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 12:52:06
         compiled from /var/www/shop.local/contents/shop/admin/products/products_nameformula.html */ ?>
<?php if ($this->_tpl_vars['formulaArray']): ?>
    <?php $_from = $this->_tpl_vars['formulaArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
        <strong><?php echo $this->_tpl_vars['e']['name']; ?>
</strong>
        <br />

        <?php if ($this->_tpl_vars['e']['valuesArray']): ?>
            <select name="<?php echo $this->_tpl_vars['name']; ?>
[]" class="<?php echo $this->_tpl_vars['name']; ?>
">
                <?php $_from = $this->_tpl_vars['e']['valuesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                    <option value="<?php echo $this->_tpl_vars['v']; ?>
"><?php echo $this->_tpl_vars['v']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>
        <?php else: ?>
            <input type="text" class="<?php echo $this->_tpl_vars['name']; ?>
" name="<?php echo $this->_tpl_vars['name']; ?>
[]" style="width: 90%;" <?php if ($this->_tpl_vars['val']): ?>value="<?php echo $this->_tpl_vars['val']; ?>
"<?php endif; ?>/>
        <?php endif; ?>
        <br />
    <?php endforeach; endif; unset($_from); ?>
<?php else: ?>
    <input type="text" class="<?php echo $this->_tpl_vars['name']; ?>
" name="<?php echo $this->_tpl_vars['name']; ?>
[]" style="width: 90%; "<?php if ($this->_tpl_vars['val']): ?> value="<?php echo $this->_tpl_vars['val']; ?>
"<?php endif; ?> />
    <br />
<?php endif; ?>