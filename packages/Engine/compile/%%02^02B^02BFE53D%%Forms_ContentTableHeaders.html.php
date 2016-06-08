<?php /* Smarty version 2.6.27-optimized, created on 2015-12-08 12:54:07
         compiled from /var/www/shop.local/packages/Forms/Forms_ContentTableHeaders.html */ ?>
<?php if ($this->_tpl_vars['headersArray']): ?>
    <thead>
        <tr>
            <?php $_from = $this->_tpl_vars['headersArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                <td>
                    <?php if ($this->_tpl_vars['e']['url']): ?>
                        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                    <?php else: ?>
                        <?php echo $this->_tpl_vars['e']['name']; ?>

                    <?php endif; ?>
                </td>
            <?php endforeach; endif; unset($_from); ?>
        </tr>
    </thead>
<?php endif; ?>