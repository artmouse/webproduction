<?php /* Smarty version 2.6.27-optimized, created on 2015-12-08 16:09:57
         compiled from /var/www/shop.local/modules/collars/contents/review.html */ ?>

<?php if ($this->_tpl_vars['productname'] && $this->_tpl_vars['brandname']): ?>
<h2>
    Review about the product <?php echo $this->_tpl_vars['productname']; ?>
 by <?php echo $this->_tpl_vars['brandname']; ?>

</h2>
<?php endif; ?>



<div class="os-block-faq review-blank">
    <div class="element">
        <?php echo $this->_tpl_vars['content']; ?>
<br>
        <div class="info"><?php echo $this->_tpl_vars['date']; ?>
 <?php echo $this->_tpl_vars['user']; ?>
</div>
    </div>
</div>
