<?php /* Smarty version 2.6.27-optimized, created on 2015-11-22 16:03:31
         compiled from /var/www/shop.local/modules/collars/contents/error/error401.html */ ?>
<div class="cl-crumbs">
    <div><a href="/"><?php echo $this->_tpl_vars['translate_main']; ?>
</a></div>
    <div><a href="#"><?php echo $this->_tpl_vars['translate_error']; ?>
 401</a></div>
</div>

<div class="cl-block-popup">
    <div class="dark"></div>
    <div class="block-popup">
        <div class="head">
            <a class="close" href="/"></a>
            <?php echo $this->_tpl_vars['translate_error_need_authorization']; ?>
.
        </div>
        <form method="post">
            <div class="body">
                <div class="block-form">
                    <div class="form-element">
                        <div class="descript"><?php echo $this->_tpl_vars['translate_login_small']; ?>
:</div>
                        <input type="text" name="auth_login" value="<?php echo $this->_tpl_vars['control_auth_login']; ?>
" />
                    </div>
                    <div class="form-element">
                        <div class="descript"><?php echo $this->_tpl_vars['translate_password_small']; ?>
:</div>
                        <input type="password" name="auth_password" value="<?php echo $this->_tpl_vars['control_auth_password']; ?>
" />
                    </div>
                    <div class="form-element">
                        <a href="/remindpassword/"><?php echo $this->_tpl_vars['translate_forgot_password']; ?>
?</a>
                    </div>
                </div>
            </div>
            <div class="foot ta-center">
                <input type="submit" name="ok" value="<?php echo $this->_tpl_vars['translate_sign_in']; ?>
" class="cl-button green" />
            </div>
        </form>
    </div>
</div>