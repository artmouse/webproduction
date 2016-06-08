<?php /* Smarty version 2.6.27-optimized, created on 2015-12-08 14:20:50
         compiled from /var/www/shop.local/modules/collars/contents/client/client_shop_profile.html */ ?>
<?php if ($this->_tpl_vars['message'] == 'ok'): ?>
    <div class="os-message-success">
        <?php echo $this->_tpl_vars['translate_update_profile_success']; ?>
.
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'error'): ?>
    <div class="os-message-error">
        <?php echo $this->_tpl_vars['translate_update_profile_error']; ?>
:
        <br />
        <?php $_from = $this->_tpl_vars['errorsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
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
        <?php if ($this->_tpl_vars['e'] == 'bdate'): ?>
        <?php echo $this->_tpl_vars['translate_profile_error_bdate']; ?>
.<br />
        <?php endif; ?>
        <?php if ($this->_tpl_vars['e'] == 'phone'): ?>
        <?php echo $this->_tpl_vars['translate_profile_error_phone']; ?>
.<br />
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="cl-block-form block-width">
        <div class="form-element">
            <div class="descript">E-mail:</div>
            <input type="text" name="email" value="<?php echo $this->_tpl_vars['control_email']; ?>
"  autocomplete="off" /><br />
            <span class="light">(<?php echo $this->_tpl_vars['translate_at_example']; ?>
: example@example.ua)</span>
        </div>
        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_password_small']; ?>
:</div>
            <input type="password" name="password" value="<?php echo $this->_tpl_vars['control_password']; ?>
" autocomplete="off"/><br />
            <span class="light">(<?php echo $this->_tpl_vars['translate_leave_empty']; ?>
)</span>
        </div>
        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_typesex']; ?>
:</div>
            <label>
                <input type="radio" name="typesex" value="man" <?php if ($this->_tpl_vars['control_typesex'] == 'man'): ?>checked<?php endif; ?>>
                <?php echo $this->_tpl_vars['translate_user_man']; ?>

            </label>
            &nbsp;
            <label>
                <input type="radio" name="typesex" value="woman" <?php if ($this->_tpl_vars['control_typesex'] == 'woman'): ?>checked<?php endif; ?>>
                <?php echo $this->_tpl_vars['translate_user_woman']; ?>

            </label>
        </div>
        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_name_small']; ?>
:</div>
            <input type="text" name="name" value="<?php echo $this->_tpl_vars['control_name']; ?>
" />
        </div>
        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_name_last']; ?>
:</div>
            <input type="text" name="namelast" value="<?php echo $this->_tpl_vars['control_namelast']; ?>
" />
        </div>
        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_name_middle']; ?>
:</div>
            <input type="text" name="namemiddle" value="<?php echo $this->_tpl_vars['control_namemiddle']; ?>
" />
        </div>
        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_phone']; ?>
:</div>
            <input type="text" name="phone" value="<?php echo $this->_tpl_vars['control_phone']; ?>
" class="js-phone-formatter" /><br />
            <span class="light">(<?php echo $this->_tpl_vars['translate_at_example']; ?>
 1-11-11 <?php echo $this->_tpl_vars['translate_or']; ?>
 +38(0XX)XX-XXX-XXX)</span>
        </div>
        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_address_small']; ?>
:</div>
            <input type="text" name="address" value="<?php echo $this->_tpl_vars['control_address']; ?>
" />
        </div>

        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_bdate']; ?>
:</div>
            <?php echo $this->_tpl_vars['translate_day']; ?>

            <input style="width: 52px;" type="text" name="bdate_day" value="<?php echo $this->_tpl_vars['control_bdate_day']; ?>
"  autocomplete="off"/>

            <?php echo $this->_tpl_vars['translate_month']; ?>

            <input style="width: 52px;" type="text" name="bdate_month" value="<?php echo $this->_tpl_vars['control_bdate_month']; ?>
"  autocomplete="off"/>

            <?php echo $this->_tpl_vars['translate_year']; ?>

            <input style="width: 80px;" type="text" name="bdate_year" value="<?php echo $this->_tpl_vars['control_bdate_year']; ?>
"  autocomplete="off"/>
        </div>
        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_convenient_time']; ?>
:</div>
            <input type="text" name="time" value="<?php echo $this->_tpl_vars['control_time']; ?>
" />
        </div>
        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_more_mail']; ?>
 e-mail:</div>
            <textarea name="emails" ><?php echo $this->_tpl_vars['control_emails']; ?>
</textarea><br />
            <span class="light">(<?php echo $this->_tpl_vars['translate_at_example']; ?>
: example@example.ua)</span>
        </div>
        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_more_phone']; ?>
:</div>
            <textarea name="phones" ><?php echo $this->_tpl_vars['control_phones']; ?>
</textarea>
        </div>
        <div class="form-element">
            <div class="descript"><?php echo $this->_tpl_vars['translate_urls']; ?>
:</div>
            <textarea name="urls" ><?php echo $this->_tpl_vars['control_urls']; ?>
</textarea>
        </div>
        <div class="form-element">
            <label>
                <input type="checkbox" checked name="zakon" value="1" onclick="this.checked ? $j('#demail').removeAttr('disabled') : $j('#demail').attr('disabled', 'disabled');" />
                <span class="light"><?php echo $this->_tpl_vars['used_user_info']; ?>
</span>
            </label>
        </div>
        <div class="form-element">
            <input type="submit" id="demail" name="ok" value="<?php echo $this->_tpl_vars['translate_save']; ?>
" class="cl-button green" />
        </div>
    </div>
</form>