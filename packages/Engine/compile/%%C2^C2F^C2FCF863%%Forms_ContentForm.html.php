<?php /* Smarty version 2.6.27-optimized, created on 2015-11-18 16:46:04
         compiled from /var/www/shop.local/packages/Forms/Forms_ContentForm.html */ ?>
<?php if ($this->_tpl_vars['nodata']): ?>

    <div class="forms-message-error">
        <?php echo $this->_tpl_vars['translate_forms_message_error']; ?>

    </div>

<?php else: ?>

    <?php if ($this->_tpl_vars['datakeyexists']): ?>
        <h1><?php echo $this->_tpl_vars['translate_forms_record_edit']; ?>
 #<?php echo $this->_tpl_vars['datakey']; ?>
</h1>
    <?php else: ?>
        <h1><?php echo $this->_tpl_vars['translate_forms_record_add']; ?>
</h1>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['message'] == 'deleteok'): ?>
        <div class="forms-message-ok">
            <?php echo $this->_tpl_vars['translate_forms_message_delete_ok']; ?>

        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['message'] == 'deleteerror'): ?>
        <div class="forms-message-error">
            <?php echo $this->_tpl_vars['translate_forms_message_delete_error']; ?>

        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['message'] == 'updateok'): ?>
        <div class="forms-message-ok">
            <?php echo $this->_tpl_vars['translate_forms_message_update_ok']; ?>

        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['message'] == 'updateerror'): ?>
        <div class="forms-message-error">
            <?php echo $this->_tpl_vars['translate_forms_message_update_error']; ?>

        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['message'] == 'insertok'): ?>
        <div class="forms-message-ok">
            <?php echo $this->_tpl_vars['translate_forms_message_insert_ok']; ?>

        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['message'] == 'inserterror'): ?>
        <div class="forms-message-error">
            <?php echo $this->_tpl_vars['translate_forms_message_insert_error']; ?>

        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['message'] != 'deleteok'): ?>
        <form action="" method="post" enctype="multipart/form-data">
            <?php $_from = $this->_tpl_vars['controlsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                <?php if (! $this->_tpl_vars['e']['hidden']): ?>
                    <strong><?php echo $this->_tpl_vars['e']['name']; ?>
</strong><br />
                    <?php echo $this->_tpl_vars['e']['control']; ?>

                    <br />
                    <br />
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>

            <?php if ($this->_tpl_vars['datakey'] && $this->_tpl_vars['allowUpdate']): ?>
                <input type="submit" name="formsUpdate" value="<?php echo $this->_tpl_vars['translate_forms_record_update']; ?>
 #<?php echo $this->_tpl_vars['datakey']; ?>
" />
            <?php endif; ?>

            <?php if ($this->_tpl_vars['allowInsert']): ?>
                <input type="submit" name="formsInsert" value="<?php echo $this->_tpl_vars['translate_forms_record_insert']; ?>
" />
                            <?php endif; ?>

            <?php if ($this->_tpl_vars['datakey'] && $this->_tpl_vars['allowDelete']): ?>
                <input type="submit" name="formsDelete" value="<?php echo $this->_tpl_vars['translate_forms_record_delete']; ?>
 #<?php echo $this->_tpl_vars['datakey']; ?>
" onclick="return confirm('<?php echo $this->_tpl_vars['translate_forms_confirm_delete']; ?>
');" />
            <?php endif; ?>
        </form>
    <?php endif; ?>

<?php endif; ?>