<?php /* Smarty version 2.6.27-optimized, created on 2015-11-18 16:45:42
         compiled from /var/www/shop.local//templates/default/client/shop_admin_change_password.html */ ?>
<?php if ($this->_tpl_vars['message'] == 'ok'): ?>
    <div class="shop-message-success">
        <?php echo $this->_tpl_vars['translate_save_success']; ?>
.
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'oldpass'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_error']; ?>
 <br />
        Старый пароль не может быть пустым
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'newpassempty'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_error']; ?>
 <br />
        Новый пароль не может быть пустым
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'oldpass'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_error']; ?>
 <br />
        Старый пароль не может быть пустым
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'passnoteq'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_error']; ?>
 <br />
        Пароль в поле "Повторите новый пароль" не равен новому паролю
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'smallpass'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_error']; ?>
 <br />
        Новый пароль слишком короткий (нужен не менее 6 символов)
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'oldpassnotcorrect'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_error']; ?>
 <br />
        Старый пароль не верный
    </div>
<?php endif; ?>
<h2>Изменить пароль</h2>
<br />
<form action="" method="post">
    <div class="ob-data-element" style="width: 600px">
        <div class="data-add">
            <div class="el-caption">Введите старый пароль:</div>
            <div class="el-value">
                <input type="password" name="oldpass" value="">
            </div>
        </div>
        <br />
        <div class="data-add">
            <div class="el-caption">Введите новый пароль:</div>
            <div class="el-value">
                <input type="password" name="newpass" value="">
            </div>
        </div>
        <br />
        <div class="data-add">
            <div class="el-caption">Повторите новый пароль:</div>
            <div class="el-value">
                <input type="password" name="repeatpass" value="">
            </div>
        </div>
        <br />
        <div style="text-align: right">
            <input type="hidden" name="ok" value="1">
            <input type="submit" value="Сохранить" class="ob-button button-green">
        </div>
    </div>
    

</form>