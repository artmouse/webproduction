<?php /* Smarty version 2.6.27-optimized, created on 2015-11-16 17:03:30
         compiled from /var/www/shop.local//templates/default/error/error403.html */ ?>
<div class="os-crumbs">
    <a href="/"><?php echo $this->_tpl_vars['translate_main']; ?>
</a>
    <?php echo $this->_tpl_vars['translate_error']; ?>
 403
</div>

<div class="os-block-popup">
    <div class="dark"></div>
    <div class="block-popup">
        <div class="head">
            <a class="close" href="/"></a>
            <?php echo $this->_tpl_vars['translate_error_need_authorization']; ?>
.
        </div>
        <form method="post">
            <div class="body">
                <table>
                    <tr>
                        <td><?php echo $this->_tpl_vars['translate_login_small']; ?>
:</td>
                        <td><input type="text" name="auth_login" value="<?php echo $this->_tpl_vars['control_auth_login']; ?>
" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->_tpl_vars['translate_password_small']; ?>
:</td>
                        <td><input type="password" name="auth_password" value="<?php echo $this->_tpl_vars['control_auth_password']; ?>
" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="/remindpassword/"><?php echo $this->_tpl_vars['translate_forgot_password']; ?>
?</a></td>
                    </tr>
                </table>
            </div>
            <div class="foot">
                <input type="submit" name="logok" value="<?php echo $this->_tpl_vars['translate_sign_in']; ?>
" class="os-submit" />
            </div>
        </form>
    </div>
</div>