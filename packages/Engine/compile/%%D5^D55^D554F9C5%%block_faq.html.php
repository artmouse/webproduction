<?php /* Smarty version 2.6.27-optimized, created on 2015-11-13 16:34:32
         compiled from /var/www/shop.local//templates/default//block/block_faq.html */ ?>
<?php if ($this->_tpl_vars['faqArray']): ?>
    <div class="os-block-caption"><?php echo $this->_tpl_vars['translate_most_discussed']; ?>
</div>
    <div class="os-block-faq">
        <?php $_from = $this->_tpl_vars['faqArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <div class="element">
                <div class="identifier" style="background-color: <?php echo $this->_tpl_vars['e']['color']; ?>
;"></div>
                <a href="/faq/<?php echo $this->_tpl_vars['e']['id']; ?>
/" rel="nofollow"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                <div class="date"><?php echo $this->_tpl_vars['e']['date']; ?>
</div>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>