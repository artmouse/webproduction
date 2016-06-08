<?php /* Smarty version 2.6.27-optimized, created on 2015-12-02 18:33:07
         compiled from /var/www/shop.local/packages/Engine/compile/b6b5c54ce886293fd53bfd1c4b0580dc.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
    <title>Mail</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
</head>

<body style="padding: 0; margin: 0; min-width: 400px;">
<div style="padding: 30px;">
    <?php if ($this->_tpl_vars['logo'] && $this->_tpl_vars['host']): ?>
        <div align="center" style="text-align: center;">
            <a href="<?php echo $this->_tpl_vars['host']; ?>
">
                <img style="max-width: 100%; height: auto; display: block; margin: 0 auto;" src="<?php echo $this->_tpl_vars['host']; ?>
<?php echo $this->_tpl_vars['logo']; ?>
" alt="" />
            </a>
        </div>
    <?php endif; ?>

    <div style="background-color: rgba(36, 149, 255, 0.13); border: 1px solid #e0e0d5; margin: 18px 0 0 0; padding: 30px 18px 23px 18px; font-family: Arial; font-size: 14px; line-height: 20px;">
        [content]
    </div>

    <?php if ($this->_tpl_vars['company'] || $this->_tpl_vars['company_phone'] || $this->_tpl_vars['company_email']): ?>
        <div style="text-align: center; font-family: Arial; font-size: 14px; line-height: 20px; padding: 18px 0 0 0;">
            <?php if ($this->_tpl_vars['company_phone'] || $this->_tpl_vars['company_email']): ?>
                <strong>Контакты:</strong><br />
                <?php $_from = $this->_tpl_vars['company_phone']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['phoneForeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['phoneForeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['p']):
        $this->_foreach['phoneForeach']['iteration']++;
?>
                    <span style="white-space: nowrap;"><?php echo $this->_tpl_vars['p']; ?>
</span>
                    <?php if (! ($this->_foreach['phoneForeach']['iteration'] == $this->_foreach['phoneForeach']['total'])): ?>
                        ,
                    <?php else: ?>
                        <br>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>

                <?php if ($this->_tpl_vars['company_email']): ?>
                    <a href="mailto:<?php echo $this->_tpl_vars['company_email']; ?>
" style="color: #000000; font-family: Arial; font-size: 14px; text-decoration: none;"><?php echo $this->_tpl_vars['company_email']; ?>
</a><br /><br />
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['company']): ?>
                <span style="font-size: 10px;">Copyright &copy;2015  <?php echo $this->_tpl_vars['company']; ?>
. Все права защищены.</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>