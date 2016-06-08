<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:08:26
         compiled from /var/www/shop.local/contents/shop/admin/workflow/workflow_filter_block.html */ ?>
<?php $_from = $this->_tpl_vars['workflowArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['w']):
?>
    <div class="element ulist">
        <div class="ulist-caption js-filter-block-toggle">
            <input type="checkbox" name="workflowid[]" value="<?php echo $this->_tpl_vars['w']['id']; ?>
" <?php if ($this->_tpl_vars['w']['selected']): ?> checked <?php endif; ?>>
            <span><?php echo $this->_tpl_vars['w']['name']; ?>
</span>
        </div>
        <div class="js-filter-block" style="display: none;">
            <?php $_from = $this->_tpl_vars['w']['statusArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s']):
?>
                <label <?php if ($this->_tpl_vars['s']['color']): ?> style="background-color: <?php echo $this->_tpl_vars['s']['color']; ?>
;" <?php endif; ?>>
                    <input type="checkbox" name="statusid[]" value="<?php echo $this->_tpl_vars['s']['id']; ?>
" <?php if ($this->_tpl_vars['s']['selected']): ?> checked <?php endif; ?>>
                    <?php echo $this->_tpl_vars['s']['name']; ?>

                </label>
            <?php endforeach; endif; unset($_from); ?>
        </div>
    </div>
<?php endforeach; endif; unset($_from); ?>

<script type="text/javascript">
$j(function() {
    $j('.js-filter-block-toggle').click(function(){
        $j(this).next('.js-filter-block').slideToggle();
    });
});
</script>