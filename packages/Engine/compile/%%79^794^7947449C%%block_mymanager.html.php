<?php /* Smarty version 2.6.27-optimized, created on 2015-11-13 16:34:31
         compiled from /var/www/shop.local//templates/default//block/block_mymanager.html */ ?>
<?php if ($this->_tpl_vars['showmanager']): ?>
    <div class="os-block-caption"><?php echo $this->_tpl_vars['translate_your_manager']; ?>
</div>
    <div class="os-block-manager">
        <div class="image"><img src="<?php echo $this->_tpl_vars['manageravatar']; ?>
" width="35" alt="<?php echo $this->_tpl_vars['managername']; ?>
" title="<?php echo $this->_tpl_vars['managername']; ?>
" /></div>
        <div class="text">
            <div class="name"><?php echo $this->_tpl_vars['managername']; ?>
</div>
            <?php if ($this->_tpl_vars['managerphone']): ?>
                <?php echo $this->_tpl_vars['managerphone']; ?>
<br />
            <?php endif; ?>
            <a class="os-link-dashed" href="mailto:<?php echo $this->_tpl_vars['manageremail']; ?>
"><?php echo $this->_tpl_vars['translate_contact_by_mail']; ?>
</a>
        </div>
        <div class="clear"></div>
    </div>
<?php endif; ?>