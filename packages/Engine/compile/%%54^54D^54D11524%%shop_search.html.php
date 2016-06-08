<?php /* Smarty version 2.6.27-optimized, created on 2015-11-23 14:52:39
         compiled from /var/www/shop.local//templates/default//shop_search.html */ ?>
<?php if ($this->_tpl_vars['error']): ?>
    <div class="os-message-error">
        <?php echo $this->_tpl_vars['translate_search_error']; ?>
.
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['name']): ?>
    <h1 class="title"><?php echo $this->_tpl_vars['name']; ?>
 <?php echo $this->_tpl_vars['pathAdditionalH1']; ?>
</h1>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['resultArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['r']):
?>
    <strong>
        <?php if ($this->_tpl_vars['key'] == 'category' && $this->_tpl_vars['r']): ?>
            <?php echo $this->_tpl_vars['translate_category']; ?>

        <?php elseif ($this->_tpl_vars['key'] == 'brand' && $this->_tpl_vars['r']): ?>
            <?php echo $this->_tpl_vars['translate_brands']; ?>

        <?php elseif ($this->_tpl_vars['key'] == 'page' && $this->_tpl_vars['r']): ?>
        <?php endif; ?>
    </strong><br />

    <?php if ($this->_tpl_vars['key'] == 'product'): ?>
        <?php echo $this->_tpl_vars['r']; ?>

    <?php else: ?>
        <div class="os-block-news">
            <?php $_from = $this->_tpl_vars['r']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                <div class="element">
                    <?php if ($this->_tpl_vars['e']['image']): ?>
                        <div class="image"><img src="<?php echo $this->_tpl_vars['e']['image']; ?>
" alt="" /></div>
                    <?php endif; ?>
                    <div class="text <?php if (! $this->_tpl_vars['e']['image']): ?>no-image<?php endif; ?>">
                        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                        <?php echo $this->_tpl_vars['e']['description']; ?>

                    </div>
                    <div class="clear"></div>
                </div>
            <?php endforeach; endif; unset($_from); ?>
        </div>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>