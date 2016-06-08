<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 17:12:51
         compiled from /var/www/shop.local//templates/default//shop_tpl_column.html */ ?>
<section class="js-section">
    <div class="section-inner">
        <?php echo $this->_tpl_vars['block_timework']; ?>


        <?php echo $this->_tpl_vars['block_position_template_top']; ?>


        <?php echo $this->_tpl_vars['content']; ?>


        <?php echo $this->_tpl_vars['block_position_template_bottom']; ?>


        <?php echo $this->_tpl_vars['block_banner_bottom']; ?>


        <?php echo $this->_tpl_vars['block_position_template_column_top']; ?>

    </div>
</section>

<aside class="right-layer js-aside-right">
    <?php echo $this->_tpl_vars['block_banner_right']; ?>


    <?php if ($this->_tpl_vars['integration_google_adsence_right']): ?>
        <div class="os-block-adsense-right">
            <!--adsense right place-->
            <?php echo $this->_tpl_vars['integration_google_adsence_right']; ?>

        </div>
    <?php endif; ?>

    <?php echo $this->_tpl_vars['block_currency']; ?>


    <?php echo $this->_tpl_vars['block_compare']; ?>


    <?php echo $this->_tpl_vars['block_mymanager']; ?>


    <?php if ($this->_tpl_vars['productSelected']): ?>
        <?php if ($this->_tpl_vars['delivery'] || $this->_tpl_vars['warranty'] || $this->_tpl_vars['payment']): ?>
            <div class="os-block-caption"><h3><?php echo $this->_tpl_vars['translate_information']; ?>
</h3></div>
            <div class="os-block-productinfo">
                <?php if ($this->_tpl_vars['delivery']): ?>
                    <div class="element">
                        <h3><?php echo $this->_tpl_vars['translate_delivery']; ?>
</h3>
                        <?php echo $this->_tpl_vars['delivery']; ?>

                    </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['warranty']): ?>
                    <div class="element">
                        <h3><?php echo $this->_tpl_vars['translate_warranty']; ?>
</h3>
                        <?php echo $this->_tpl_vars['warranty']; ?>

                    </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['payment']): ?>
                    <div class="element">
                        <h3><?php echo $this->_tpl_vars['translate_payment']; ?>
</h3>
                        <?php echo $this->_tpl_vars['payment']; ?>

                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php echo $this->_tpl_vars['block_position_template_column_middle']; ?>


    <?php echo $this->_tpl_vars['block_news']; ?>


    <?php echo $this->_tpl_vars['block_subscribe']; ?>


    <?php echo $this->_tpl_vars['block_faq']; ?>


    <?php echo $this->_tpl_vars['block_guestbook']; ?>


    <?php echo $this->_tpl_vars['block_quiz']; ?>


    <?php echo $this->_tpl_vars['block_facebook']; ?>


    <?php echo $this->_tpl_vars['block_position_template_column_bottom']; ?>

</aside>
<div class="clear"></div>