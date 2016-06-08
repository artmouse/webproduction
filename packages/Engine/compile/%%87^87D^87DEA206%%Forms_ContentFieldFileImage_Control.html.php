<?php /* Smarty version 2.6.27-optimized, created on 2015-11-18 16:46:04
         compiled from /var/www/shop.local/packages/Forms/Forms_ContentFieldFileImage_Control.html */ ?>
<?php if ($this->_tpl_vars['value']): ?>
    <img src="<?php echo $this->_tpl_vars['value']; ?>
" width="100" alt="" /><br />
    <br />
<?php endif; ?>

<?php echo $this->_tpl_vars['translate_download_file']; ?>
 <input type="file" name="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['disabled']): ?> disabled <?php endif; ?> />
<br />

<?php if ($this->_tpl_vars['value']): ?>
    <label>
        <input type="checkbox" name="<?php echo $this->_tpl_vars['key']; ?>
-delete" <?php if ($this->_tpl_vars['disabled']): ?> disabled <?php endif; ?> />
        <?php echo $this->_tpl_vars['translate_delete_file']; ?>

    </label>
    <br />
<?php endif; ?>