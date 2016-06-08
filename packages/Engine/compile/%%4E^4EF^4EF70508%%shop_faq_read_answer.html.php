<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 16:20:17
         compiled from /var/www/shop.local//templates/default//shop_faq_read_answer.html */ ?>
<div class="os-block-caption"><h3><?php echo $this->_tpl_vars['translate_most_discussed']; ?>
</h3></div>
<div class="os-block-faq">
    <div class="element">
        <?php echo $this->_tpl_vars['f']['question']; ?>

        <div class="name"><?php echo $this->_tpl_vars['f']['name']; ?>
</div>
    </div>
    <div class="element answer">
        <?php if ($this->_tpl_vars['f']['answer']): ?>
            <strong><?php echo $this->_tpl_vars['translate_answer']; ?>
:</strong> <?php echo $this->_tpl_vars['f']['answer']; ?>
 <br/>
            <div class="date"><?php echo $this->_tpl_vars['f']['cdate']; ?>
</div>
        <?php else: ?>
            <strong><?php echo $this->_tpl_vars['translate_answer']; ?>
</strong>
            <div class="date"><?php echo $this->_tpl_vars['translate_the_answer_is_expected']; ?>
</div>
        <?php endif; ?>
    </div>
</div>