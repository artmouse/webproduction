<?php /* Smarty version 2.6.27-optimized, created on 2015-11-30 18:20:34
         compiled from /var/www/shop.local/modules/kazakhfilm-adaptive/contents/block/block_feedback.html */ ?>
<?php if ($this->_tpl_vars['guestBookArray']): ?>
    <h2>Отзывы</h2>
    <br />
    <?php $_from = $this->_tpl_vars['guestBookArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['g']):
?>
        <div class="ks-review-element">
            <?php if ($this->_tpl_vars['g']['image']): ?>
                <div class="image">
                    <img src=<?php echo $this->_tpl_vars['g']['image']; ?>
 alt="">
                </div>
            <?php endif; ?>

            <div class="data <?php if (! $this->_tpl_vars['g']['image']): ?>no-image<?php endif; ?>">
                <div class="name"><u><?php echo $this->_tpl_vars['g']['name']; ?>
</u> <?php echo $this->_tpl_vars['g']['cdate']; ?>
</div>
                <?php echo $this->_tpl_vars['g']['response']; ?>

            </div>
            <div class="clear"></div>
        </div>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>