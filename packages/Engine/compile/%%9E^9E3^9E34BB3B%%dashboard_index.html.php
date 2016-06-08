<?php /* Smarty version 2.6.27-optimized, created on 2015-11-06 00:08:27
         compiled from /var/www/shop.local/contents/shop/admin/dashboard/dashboard_index.html */ ?>
<?php if (count ( $this->_tpl_vars['myEmployeeArray'] ) > 1): ?>
    <div class="shop-filter-displace" style="padding: 10px 10px 0 10px; margin: -10px -10px 10px -10px;">
        <div class="ob-list-usersthumb js-list-usersthumb">
            <?php $_from = $this->_tpl_vars['myEmployeeArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                <div class="ob-list-usersthumb-element employee <?php if ($this->_tpl_vars['e']['selected']): ?>selected<?php endif; ?> js-tooltip" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" onclick="document.location='<?php echo $this->_tpl_vars['e']['url']; ?>
'" title="<?php echo $this->_tpl_vars['translate_vipolneno']; ?>
 <?php echo $this->_tpl_vars['e']['todayDone']; ?>
 <?php echo $this->_tpl_vars['translate_iz']; ?>
 <?php echo $this->_tpl_vars['e']['todayAll']; ?>
">
                    <?php if ($this->_tpl_vars['e']['image']): ?>
                        <div class="image nb-block-avatar" style="background-image: url('<?php echo $this->_tpl_vars['e']['image']; ?>
');"></div>
                    <?php endif; ?>
                    <div class="name">
                        <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                    </div>
                    <div class="info">
                        <?php if ($this->_tpl_vars['e']['roleArray']): ?>
                            <?php $_from = $this->_tpl_vars['e']['roleArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['r']):
?>
                                <?php echo $this->_tpl_vars['r']; ?>

                            <?php endforeach; endif; unset($_from); ?>
                        <?php endif; ?>
                        <?php $this->assign('issueProgress', $this->_tpl_vars['e']['todayDone']/$this->_tpl_vars['e']['todayAll']*100); ?>
                        <div class="ob-progressbar <?php if ($this->_tpl_vars['issueProgress'] == '0'): ?>red<?php elseif ($this->_tpl_vars['issueProgress'] < 50): ?>orange<?php else: ?>green<?php endif; ?>">
                            <span style="width: <?php if ($this->_tpl_vars['issueProgress'] == '0'): ?>100<?php else: ?><?php echo $this->_tpl_vars['issueProgress']; ?>
<?php endif; ?>%;"></span>
                        </div>
                        <?php if ($this->_tpl_vars['e']['noPriority'] > 0): ?>
                            <span class="ob-icon-new"></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; endif; unset($_from); ?>
            <div class="clear"></div>
        </div>
        <script>
            animation('.js-list-usersthumb .ob-list-usersthumb-element', 'blind');
        </script>
    </div>
<?php endif; ?>

<?php echo $this->_tpl_vars['block_issue']; ?>