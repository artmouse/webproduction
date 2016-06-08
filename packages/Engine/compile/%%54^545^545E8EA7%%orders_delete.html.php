<?php /* Smarty version 2.6.27-optimized, created on 2015-12-20 18:33:39
         compiled from /var/www/shop.local/modules/order/contents/admin//orders/orders_delete.html */ ?>
<?php if ($this->_tpl_vars['message'] != 'ok'): ?>
    <?php echo $this->_tpl_vars['block_menu']; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'ok'): ?>
    <div class="shop-message-success">
        <?php echo $this->_tpl_vars['translate_order_delete_success']; ?>
.<br />
        <?php if ($this->_tpl_vars['orderReferer']): ?>
            <?php echo $this->_tpl_vars['translate_redirection']; ?>

            <script>
                setTimeout(function(){
                    document.location = '<?php echo $this->_tpl_vars['orderReferer']; ?>
';
                }, 3000);
            </script>
        <?php else: ?>
            <a href="/admin/shop/orders/"><?php echo $this->_tpl_vars['translate_order_list']; ?>
</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'error'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_order_delete_error']; ?>
.
        <?php echo $this->_tpl_vars['translate_order_saled_probably']; ?>
.
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] != 'ok'): ?>
    <div class="ob-block-element">
        <form action="" method="post">
            <?php if ($this->_tpl_vars['isProject']): ?>
                <?php echo $this->_tpl_vars['translate_project_confirm']; ?>

            <?php elseif ($this->_tpl_vars['isIssue']): ?>
                <?php echo $this->_tpl_vars['translate_issue_confirm']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['translate_order_confirm']; ?>

            <?php endif; ?>

            <strong>#<?php echo $this->_tpl_vars['orderid']; ?>
</strong>?
            <br />
            <br />
            <input type="submit" name="ok" value="<?php echo $this->_tpl_vars['translate_yes']; ?>
" class="ob-button button-red" />
            <input class="ob-button" type="button" value="<?php echo $this->_tpl_vars['translate_no']; ?>
" onclick="document.location='../';" />
        </form>
    </div>
<?php endif; ?>