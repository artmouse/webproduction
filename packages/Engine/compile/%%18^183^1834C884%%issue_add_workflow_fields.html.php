<?php /* Smarty version 2.6.27-optimized, created on 2015-11-09 14:02:06
         compiled from /var/www/shop.local/contents/shop/admin/issue/issue_add_workflow_fields.html */ ?>
<?php $_from = $this->_tpl_vars['customFieldArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['e']):
?>
    <?php if ($this->_tpl_vars['e']['type'] == 'text'): ?>
        <strong><?php echo $this->_tpl_vars['e']['name']; ?>
</strong><br />
        <textarea name="custom_<?php echo $this->_tpl_vars['key']; ?>
" style="width: 80%; height: 50px;"><?php echo $this->_tpl_vars['e']['value']; ?>
</textarea>
        <br />
        <br />
    <?php elseif ($this->_tpl_vars['e']['type'] == 'string'): ?>
        <strong><?php echo $this->_tpl_vars['e']['name']; ?>
</strong><br />
        <input type="text" name="custom_<?php echo $this->_tpl_vars['key']; ?>
" value="<?php echo $this->_tpl_vars['e']['value']; ?>
" style="width: 80%;" />
        <br />
        <br />
    <?php elseif ($this->_tpl_vars['e']['type'] == 'date'): ?>
        <strong><?php echo $this->_tpl_vars['e']['name']; ?>
</strong><br />
        <input type="text" name="custom_<?php echo $this->_tpl_vars['key']; ?>
" value="<?php echo $this->_tpl_vars['e']['value']; ?>
" class="js-date" />
        <br />
        <br />
    <?php elseif ($this->_tpl_vars['e']['type'] == 'int'): ?>
        <strong><?php echo $this->_tpl_vars['e']['name']; ?>
</strong><br />
        <input type="text" name="custom_<?php echo $this->_tpl_vars['key']; ?>
" value="<?php echo $this->_tpl_vars['e']['value']; ?>
" class="js-int" />
        <br />
        <br />
    <?php elseif ($this->_tpl_vars['e']['type'] == 'float'): ?>
        <strong><?php echo $this->_tpl_vars['e']['name']; ?>
</strong><br />
        <input type="text" name="custom_<?php echo $this->_tpl_vars['key']; ?>
" value="<?php echo $this->_tpl_vars['e']['value']; ?>
" class="js-float" />
        <br />
        <br />
    <?php elseif ($this->_tpl_vars['e']['type'] == 'bool'): ?>
        <label>
            <input type="checkbox" name="custom_<?php echo $this->_tpl_vars['key']; ?>
" value="1" <?php if ($this->_tpl_vars['e']['value']): ?> checked <?php endif; ?> />
            <?php echo $this->_tpl_vars['e']['name']; ?>

        </label>
        <br />
        <br />
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>