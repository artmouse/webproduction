<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:08:46
         compiled from /var/www/shop.local/api/forms/Shop_ContentTableRow.html */ ?>
<tr <?php if ($this->_tpl_vars['class']): ?>class="<?php echo $this->_tpl_vars['class']; ?>
"<?php endif; ?>>
    <?php $_from = $this->_tpl_vars['cellsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fieldkey'] => $this->_tpl_vars['c']):
?>
        <td <?php if ($this->_tpl_vars['productId']): ?>data-id="<?php echo $this->_tpl_vars['productId']; ?>
"<?php endif; ?> data-ds="<?php echo $this->_tpl_vars['datasource']; ?>
" data-pkv="<?php echo $this->_tpl_vars['c']['pkValue']; ?>
" data-fk="<?php echo $this->_tpl_vars['fieldkey']; ?>
" class="<?php if ($this->_tpl_vars['c']['quickedit']): ?>quickedit<?php endif; ?> <?php if ($this->_tpl_vars['classPreview']): ?><?php echo $this->_tpl_vars['classPreview']; ?>
<?php endif; ?>">
            <?php if ($this->_tpl_vars['fieldkey'] == 'statusid'): ?>
                <div class="ob-wf-stage nowrap" <?php if ($this->_tpl_vars['c']['colour']): ?>style="background-color: <?php echo $this->_tpl_vars['c']['colour']; ?>
;"<?php endif; ?>><?php echo $this->_tpl_vars['c']['cells']; ?>
</div>
            <?php else: ?>
                <?php echo $this->_tpl_vars['c']['cells']; ?>

            <?php endif; ?>
        </td>
    <?php endforeach; endif; unset($_from); ?>
</tr>