<?php /* Smarty version 2.6.27-optimized, created on 2015-11-18 16:16:53
         compiled from /var/www/shop.local//templates/default//block/block_subscribe.html */ ?>
<?php if ($this->_tpl_vars['subscribe_status'] !== 'ok'): ?>
    <form method="post">
        <div class="os-block-caption"><?php echo $this->_tpl_vars['translate_subscription']; ?>
</div>
        <div class="os-block-subscribe">
            <?php if (! $this->_tpl_vars['useremail']): ?>
                <input type="text" name="distribution_email" class="ui-autocomplete-input" value="<?php echo $this->_tpl_vars['control_distribution_email']; ?>
" placeholder="Email">
            <?php endif; ?>
            <input type="submit" class="os-submit grey" name="distribution_ok" value="<?php echo $this->_tpl_vars['translate_subscribe']; ?>
">
        </div>
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['subscribe_message']): ?>
    <div class="os-block-popup js-popup-subscribe">
        <div class="dark" onclick="popupClose('.js-popup-subscribe');"></div>
        <div class="block-popup">
            <div class="head">
                <a href="#" class="close" onclick="popupClose('.js-popup-subscribe');">&nbsp;</a>
                <?php echo $this->_tpl_vars['translate_subscription']; ?>

            </div>
            
            <?php if ($this->_tpl_vars['subscribe_message'] == 'ok'): ?>
                <div class="message-success">
                    <?php echo $this->_tpl_vars['translate_you_have_successfully_subscribed']; ?>
.
                </div>
            <?php endif; ?>


            <?php if ($this->_tpl_vars['subscribe_message'] == 'error'): ?>
                <div class="message-error">
                    <?php echo $this->_tpl_vars['translate_you_did_not_enter_email_address']; ?>
.
                </div>
            <?php endif; ?>

            <script type="text/javascript">
                setTimeout(function() {
                     popupClose('.js-popup-subscribe');
                }, 3000);
            </script>
        </div>
    </div>
<?php endif; ?>