<?php /* Smarty version 2.6.27-optimized, created on 2015-11-25 17:22:16
         compiled from /var/www/shop.local/modules/order/contents/admin//orders/order_menu.html */ ?>
<div class="nb-top-nav-place js-top-nav-buffer"></div>
<div class="nb-top-nav js-top-nav">
    <div class="nb-block-tabs">
        <?php if ($this->_tpl_vars['urlBack']): ?>
            <div class="tab-element"> <a href="<?php echo $this->_tpl_vars['urlBack']; ?>
">&lsaquo; <?php echo $this->_tpl_vars['translate_simple_back']; ?>
</a></div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['isProject']): ?>
            <div class="tab-element"><a href="/admin/projects/"><?php echo $this->_tpl_vars['translate_proekti']; ?>
</a></div>
        <?php else: ?>
            <div class="tab-element"><a href="/admin/shop/orders/"><?php echo $this->_tpl_vars['translate_ords']; ?>
</a></div>
        <?php endif; ?>
        <?php $_from = $this->_tpl_vars['parentArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <div class="tab-element"><a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['orderid'] && $this->_tpl_vars['selected'] == 'view'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</a></div>
        <?php endforeach; endif; unset($_from); ?>
        <?php if ($this->_tpl_vars['issueURL']): ?>
            <div class="tab-element"><a href="<?php echo $this->_tpl_vars['issueURL']; ?>
" class="selected"><?php echo $this->_tpl_vars['issueName']; ?>
</a></div>
        <?php endif; ?>

        <div class="tab-element">
            <form action="" style="display: inline-block;">
                <input class="quick-jump js-quick-jump" type="text" name="" value="" placeholder="<?php echo $this->_tpl_vars['translate_ord']; ?>
 №..."/>
                <input name="" type="hidden"/>

                <script>
                    $j('.js-quick-jump').on('change', function(){
                        $j(this).closest('form').attr('action', '/admin/shop/orders/'+ $j(this).val() +'/');
                    });
                </script>
            </form>
        </div>

        <div class="clear"></div>
    </div>
</div>

<div class="ob-block-head js-block-head">
    <div class="background" <?php if ($this->_tpl_vars['bigImage']): ?>style="background-image: url('<?php echo $this->_tpl_vars['bigImage']; ?>
');"<?php endif; ?>>
        <?php if ($this->_tpl_vars['menuColor']): ?><span style="background-color: <?php echo $this->_tpl_vars['menuColor']; ?>
;"></span><?php endif; ?>
    </div>
    <div class="head-wrap">
        <?php if ($this->_tpl_vars['image']): ?>
            <div class="image">
                <a class="js-colorbox nb-block-avatar" <?php if ($this->_tpl_vars['bigImage']): ?>href="<?php echo $this->_tpl_vars['bigImage']; ?>
"<?php else: ?>href="<?php echo $this->_tpl_vars['image']; ?>
"<?php endif; ?> style="background-image: url('<?php echo $this->_tpl_vars['image']; ?>
');"></a>
            </div>
        <?php endif; ?>

        <div class="info">
            <div class="caption">
                <?php if ($this->_tpl_vars['number']): ?>
                    <div class="tag">
                        <span>
                            #<?php echo $this->_tpl_vars['number']; ?>

                        </span>
                        <?php if ($this->_tpl_vars['statusName']): ?>
                            <span>
                                <?php if ($this->_tpl_vars['statusColor']): ?>
                                    <em class="status" style="background-color: <?php echo $this->_tpl_vars['statusColor']; ?>
;"></em>
                                <?php endif; ?>
                                <?php echo $this->_tpl_vars['statusName']; ?>

                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (! $this->_tpl_vars['isWatcher']): ?>
                    <a class="ob-link-follow js-tooltip" href="<?php echo $this->_tpl_vars['urlWatch']; ?>
" title="<?php echo $this->_tpl_vars['translate_sledit']; ?>
"></a>
                <?php else: ?>
                    <a class="ob-link-follow no js-tooltip" href="<?php echo $this->_tpl_vars['urlWatch']; ?>
" title="<?php echo $this->_tpl_vars['translate_ne_sledit']; ?>
"></a>
                <?php endif; ?>

                <h1><?php echo $this->_tpl_vars['orderName']; ?>
</h1>

                <?php if ($this->_tpl_vars['fireIssue']): ?>
                    <div class="ob-icon-overdue"></div>
                <?php endif; ?>

                <div class="clear"></div>
            </div>

            <?php if ($this->_tpl_vars['description']): ?>
                <div class="description">
                    <?php echo $this->_tpl_vars['description']; ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="navigation <?php if ($this->_tpl_vars['menuAnimation']): ?>js-ui-navigation<?php endif; ?>">
        <?php if ($this->_tpl_vars['isProject']): ?>
            <a href="<?php echo $this->_tpl_vars['orderUrl']; ?>
" <?php if ($this->_tpl_vars['selected'] == 'view'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_proekt']; ?>
</a>
            <a href="/admin/shop/orders/<?php echo $this->_tpl_vars['orderid']; ?>
/issue/" <?php if ($this->_tpl_vars['selected'] == 'issue'): ?> class="selected" <?php endif; ?>>
                <?php echo $this->_tpl_vars['acl_issue']; ?>

                <?php if ($this->_tpl_vars['issueCount'] > 0): ?>
                    <span class="ob-count-element"><?php echo $this->_tpl_vars['issueCount']; ?>
</span>
                <?php endif; ?>
            </a>
            <a href="/admin/project/<?php echo $this->_tpl_vars['orderid']; ?>
/order/" <?php if ($this->_tpl_vars['selected'] == 'order'): ?> class="selected" <?php endif; ?>>
                <?php echo $this->_tpl_vars['translate_ords']; ?>

                <?php if ($this->_tpl_vars['orderCount'] > 0): ?>
                    <span class="ob-count-element"><?php echo $this->_tpl_vars['orderCount']; ?>
</span>
                <?php endif; ?>
            </a>
            <a href="/admin/project/<?php echo $this->_tpl_vars['orderid']; ?>
/info/" <?php if ($this->_tpl_vars['selected'] == 'info'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_timework_small']; ?>
</a>
            <a href="/admin/project/<?php echo $this->_tpl_vars['orderid']; ?>
/products/" <?php if ($this->_tpl_vars['selected'] == 'products'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_many_products']; ?>
</a>
        <?php else: ?>
            <a href="<?php echo $this->_tpl_vars['orderUrl']; ?>
" <?php if ($this->_tpl_vars['selected'] == 'view'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_ord']; ?>
</a>
            <?php if ($this->_tpl_vars['box']): ?>
                <a href="/admin/shop/orders/<?php echo $this->_tpl_vars['orderid']; ?>
/issue/" <?php if ($this->_tpl_vars['selected'] == 'issue'): ?> class="selected" <?php endif; ?>>
                    <?php echo $this->_tpl_vars['acl_issue']; ?>

                    <?php if ($this->_tpl_vars['issueCount'] > 0): ?>
                        <span class="ob-count-element"><?php echo $this->_tpl_vars['issueCount']; ?>
</span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
            <a href="/admin/shop/orders/<?php echo $this->_tpl_vars['orderid']; ?>
/info/" <?php if ($this->_tpl_vars['selected'] == 'info'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_timework_small']; ?>
</a>
        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['moduleTabArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" <?php if ($this->_tpl_vars['selected'] == $this->_tpl_vars['e']['moduleName']): ?> class="selected" <?php endif; ?> ><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['canDelete']): ?>
            <?php if ($this->_tpl_vars['isDeleted']): ?>
                <a href="/admin/shop/orders/<?php echo $this->_tpl_vars['orderid']; ?>
/restore/" <?php if ($this->_tpl_vars['selected'] == 'restore'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_restore']; ?>
</a>
            <?php else: ?>
                <a href="/admin/shop/orders/<?php echo $this->_tpl_vars['orderid']; ?>
/delete/" <?php if ($this->_tpl_vars['selected'] == 'delete'): ?> class="selected" <?php endif; ?>><?php echo $this->_tpl_vars['translate_delete']; ?>
</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    // инициализация просмотра картинок
    $j('.js-colorbox').colorbox({
        maxWidth: '95%',
        maxHeight: '95%',
        current: false,
        returnFocus: false
    });
</script>