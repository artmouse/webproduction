<?php /* Smarty version 2.6.27-optimized, created on 2015-11-13 16:34:35
         compiled from /var/www/shop.local/contents/engine_include.html */ ?>
<?php if ($this->_tpl_vars['title']): ?>
    <title><?php echo $this->_tpl_vars['title']; ?>
</title>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['metaArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
    <meta name="<?php echo $this->_tpl_vars['k']; ?>
" content="<?php echo $this->_tpl_vars['v']; ?>
" />
<?php endforeach; endif; unset($_from); ?>

<?php $_from = $this->_tpl_vars['cssfiles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['css']):
?>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css']; ?>
" />
<?php endforeach; endif; unset($_from); ?>

<link href="<?php echo $this->_tpl_vars['cssMin']; ?>
" rel="stylesheet" type="text/css">

<?php $_from = $this->_tpl_vars['jsfiles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['js']):
?>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['js']; ?>
"></script>
<?php endforeach; endif; unset($_from); ?>

<script type="text/javascript" src="<?php echo $this->_tpl_vars['jsMin']; ?>
"></script>

<?php $_from = $this->_tpl_vars['linkArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
    <link rel="<?php echo $this->_tpl_vars['e']['rel']; ?>
" href="<?php echo $this->_tpl_vars['e']['href']; ?>
" <?php if ($this->_tpl_vars['e']['title']): ?>title="<?php echo $this->_tpl_vars['e']['title']; ?>
"<?php endif; ?> <?php if ($this->_tpl_vars['e']['type']): ?>type="<?php echo $this->_tpl_vars['e']['type']; ?>
"<?php endif; ?> />
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['jsEngineInfo']): ?>
    <script type="text/javascript">
        <?php $_from = $this->_tpl_vars['jsEngineInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['str']):
?>
            console.log("<?php echo $this->_tpl_vars['str']; ?>
");
        <?php endforeach; endif; unset($_from); ?>
    </script>
<?php endif; ?>