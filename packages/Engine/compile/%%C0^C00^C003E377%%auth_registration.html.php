<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 16:09:52
         compiled from /var/www/shop.local/modules/collars/contents/auth/auth_registration.html */ ?>
<div class="cl-crumbs">
    <div>
        <a href="/"><?php echo $this->_tpl_vars['translate_main']; ?>
</a>
    </div>
    <div>
        <a href="#"><?php echo $this->_tpl_vars['translate_user_registration']; ?>
</a>
    </div>
</div>

<?php if ($this->_tpl_vars['message'] == 'ok'): ?>
    <div class="os-message-success">
        <?php echo $this->_tpl_vars['registration_good_message']; ?>

    </div>
    <script>
        $j(function(){
            setTimeout("document.location.href='<?php echo $this->_tpl_vars['linkclientprofile']; ?>
'", 5);
        });
    </script>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'activate'): ?>
    <div class="os-message-success">
        <?php echo $this->_tpl_vars['translate_user_registrate_success']; ?>
. <?php echo $this->_tpl_vars['translate_account_activate']; ?>
.
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'error'): ?>
    <div class="os-message-error">
        <?php echo $this->_tpl_vars['translate_registration_error']; ?>
:
        <br />
        <?php $_from = $this->_tpl_vars['errorsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <?php if ($this->_tpl_vars['e'] == 'login'): ?>
                <?php echo $this->_tpl_vars['translate_order_error_login']; ?>
. <?php echo $this->_tpl_vars['translate_order_error_login_must_be']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'login-exists'): ?>
                <?php echo $this->_tpl_vars['translate_login_already_exists']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'easy-password'): ?>
                <?php echo $this->_tpl_vars['translate_profile_error_password_must_be']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'password'): ?>
                <?php echo $this->_tpl_vars['translate_profile_error_password']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'email'): ?>
                <?php echo $this->_tpl_vars['translate_profile_error_mail']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'email-exists'): ?>
                <?php echo $this->_tpl_vars['translate_profile_error_mail_exists']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'phone-exists'): ?>
                <?php echo $this->_tpl_vars['translate_already_registered_phone']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'parentid'): ?>
                <?php echo $this->_tpl_vars['translate_registration_error_parent']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'bdate'): ?>
                <?php echo $this->_tpl_vars['translate_profile_error_bdate']; ?>
.<br />
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] != 'ok' && $this->_tpl_vars['message'] != 'activate'): ?>
    <div class="cl-block-form block-width">
        <form method="post">
            <div class="form-element">
                <div class="descript"><?php echo $this->_tpl_vars['translate_password_small']; ?>
<span class="important">*</span>:</div>
                <input type="password" name="password" value="<?php echo $this->_tpl_vars['control_password']; ?>
" /><br />
                <span class="light">(<?php echo $this->_tpl_vars['translate_password_must_be']; ?>
)</span>
            </div>

            <div class="form-element">
                <div class="descript">E-mail<span class="important">*</span>:</div>
                <input type="text" name="email" value="<?php echo $this->_tpl_vars['control_email']; ?>
" /><br />
                <span class="light">(<?php echo $this->_tpl_vars['translate_at_example']; ?>
: example@example.ua)</span>

            </div>

            <div class="form-element">
                <label>
                    <input type="checkbox" checked name="zakon" value="1" />
                    <span class="light"><?php echo $this->_tpl_vars['used_user_info']; ?>
</span>
                </label>
            </div>

            <div class="form-element">
                <input type="submit" name="ok" value="<?php echo $this->_tpl_vars['translate_sing_up_small']; ?>
" class="cl-button green" />
                <input type="hidden" name="ajs" class="ajs" value="1" />
            </div>

        </form>
    </div>
<?php endif; ?>