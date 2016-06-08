<?php /* Smarty version 2.6.27-optimized, created on 2015-12-02 18:05:21
         compiled from /var/www/shop.local/modules/box/contents//shop_tpl.html */ ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this->_tpl_vars['title']; ?>
</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="<?php echo $this->_tpl_vars['shopname']; ?>
" />
    <meta name="viewport" content="width=device-width" />
        <?php if ($this->_tpl_vars['shopName']): ?><meta name="dcterms.rightsHolder" content="<?php echo $this->_tpl_vars['shopName']; ?>
" /><?php endif; ?>

    <link rel="icon" href="<?php echo $this->_tpl_vars['favicon']; ?>
" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo $this->_tpl_vars['favicon']; ?>
" type="image/x-icon" />

    <?php echo $this->_tpl_vars['engine_includes']; ?>

    <script type="text/javascript" src="/_js/jquery.parallax.js"></script>
    <script type="text/javascript" src="/contents/shop/admin/old-browser.js"></script>
</head>
<body>
    <?php echo $this->_tpl_vars['content']; ?>

</body>
</html>