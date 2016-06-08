<?php /* Smarty version 2.6.27-optimized, created on 2015-12-02 18:05:35
         compiled from /var/www/shop.local/modules/box/contents//admin/menu/box_admin_menu_block.html */ ?>
<div class="nb-wrap-menuvertical">
    <div class="nb-block-menuvertical">
        <div class="menu-element logo">
            <div class="menu-element-part static">
                <a class="logo-image" href="/admin/">
                    <img src="/_images/admin/logo.svg" alt="">
                </a>
            </div>

            <div class="menu-element-part collapse">
                <a href="/admin/" class="logo-text" title="Мой <?php if ($this->_tpl_vars['branding']): ?><?php echo $this->_tpl_vars['branding']; ?>
<?php else: ?>OneBox<?php endif; ?>">
                    Мой
                    <?php if ($this->_tpl_vars['branding']): ?>
                        <?php echo $this->_tpl_vars['branding']; ?>

                    <?php else: ?>
                        OneBox
                    <?php endif; ?>
                </a>
            </div>
            <div class="clear"></div>
        </div>

        <div class="scroll-wrap js-scroll-wrap">
            <div class="menu-element">
                <div class="user-image-container">
                    <div class="user-image">
                        <a href="javascript:void(0);" style="background-image: url('<?php echo $this->_tpl_vars['userImage']; ?>
')" ></a>
                    </div>
                </div>

                <div class="menu-element-part collapse-full">
                    <a class="user-name" href="javascript:void(0);"><?php echo $this->_tpl_vars['userName']; ?>
</a>
                </div>
                <div class="clear"></div>
            </div>

            <div class="menu-element">
                <div class="menu-element-part collapse-full">
                    <div class="block-messages">
                        <a class="js-notification-toggle js-empty" href="javascript:void(0);">
                            <i>
                                <svg viewBox="0 0 16 16">
                                    <use xlink:href="#icon-notify"></use>
                                </svg>
                            </i>
                            <?php echo $this->_tpl_vars['translate_uvedomleniya']; ?>

                            <span class="count js-notification-count">
                                0
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="block-big-count">
                <div class="count js-notification-count">
                    0
                </div>
            </div>

            <div class="menu-element">
                <div class="menu-element-part collapse-full">
                    <div class="block-search">
                        <input class="js-search-helper" type="text" placeholder="Быстрый поиск">
                        <div class="icon">
                            <svg class="icon-svg icon-search" viewBox="0 0 16 16">
                                <use xlink:href="#icon-search"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nb-asidenav-drop">
                <li class="js-search-line">
                    <div class="menu-element">
                        <div class="menu-element-part static">
                            <a class="icon js-menu-toggle js-searchpopup-toggle" href="#">
                                <svg class="icon-svg icon-search" viewBox="0 0 16 16">
                                    <use xlink:href="#icon-search"></use>
                                </svg>
                            </a>
                        </div>

                        <div class="menu-element-part collapse">
                            <a class="menu-link js-searchpopup-toggle" href="javascript:void(0);"><?php echo $this->_tpl_vars['translate_globals_search']; ?>
</a>
                        </div>
                        <div class="clear"></div>
                    </div>
                </li>

                <?php if ($this->_tpl_vars['ticketacl']): ?>
                    <li class="js-search-line">
                        <div class="menu-element">
                            <div class="menu-element-part static">
                                <a class="icon js-menu-toggle" href="/admin/shop/ticket/support/">
                                    <svg class="icon-svg icon-support" viewBox="0 0 16 16">
                                        <use xlink:href="#icon-support"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="menu-element-part collapse">
                                <a class="menu-link js-menu-toggle" href="/admin/shop/ticket/support/"><?php echo $this->_tpl_vars['translate_technical_support_short']; ?>
</a>
                            </div>
                            <div class="clear"></div>

                        </div>
                    </li>
                <?php endif; ?>

                <?php $_from = $this->_tpl_vars['menuTopArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                    <?php if ($this->_tpl_vars['e']['top']): ?>
                        <li class="js-search-line">
                            <div class="menu-element">
                                <div class="menu-element-part static">
                                    <a class="icon js-menu-toggle" href="<?php if ($this->_tpl_vars['e']['childArray']): ?>javascript:void(0);<?php else: ?><?php echo $this->_tpl_vars['e']['url']; ?>
<?php endif; ?>">
                                        <svg class="icon-svg <?php echo $this->_tpl_vars['e']['class']; ?>
" viewBox="0 0 16 16">
                                            <use xlink:href="#<?php echo $this->_tpl_vars['e']['class']; ?>
"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-element-part collapse">
                                    <a class="menu-link js-menu-toggle" href="<?php if ($this->_tpl_vars['e']['childArray']): ?>javascript:void(0);<?php else: ?><?php echo $this->_tpl_vars['e']['url']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['e']['name']; ?>
 <?php if ($this->_tpl_vars['e']['childArray']): ?><i class="expand"></i><?php endif; ?></a>
                                </div>
                                <div class="clear"></div>

                                <?php if ($this->_tpl_vars['e']['childArray']): ?>
                                    <div class="menu-element-part collapse-full">
                                        <ul class="sub-nav">
                                            <?php $_from = $this->_tpl_vars['e']['childArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                                                <li class="js-search-line">
                                                    <a href="<?php echo $this->_tpl_vars['c']['url']; ?>
"><?php echo $this->_tpl_vars['c']['name']; ?>
</a>
                                                </li>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>

                <li class="js-search-line">
                    <div class="menu-element">
                        <div class="menu-element-part static">
                            <a class="icon js-menu-toggle" href="javascript:void(0);">
                                <svg class="icon-svg icon-add" viewBox="0 0 16 16">
                                    <use xlink:href="#icon-add"></use>
                                </svg>
                            </a>
                        </div>

                        <div class="menu-element-part collapse">
                            <a class="menu-link js-menu-toggle" href="javascript:void(0);"><?php echo $this->_tpl_vars['translate_create']; ?>
... <i class="expand"></i></a>
                        </div>
                        <div class="clear"></div>


                        <div class="menu-element-part collapse-full">
                            <ul class="sub-nav">
                                <li class="js-search-line"><a href="/admin/shop/users/add/"><strong>+</strong> <?php echo $this->_tpl_vars['translate_users_add']; ?>
</a></li>
                                <li class="js-search-line"><a href="/admin/shop/users/add/?typesex=company"><strong>+</strong> <?php echo $this->_tpl_vars['translate_company_add']; ?>
</a></li>
                                <?php if (! $this->_tpl_vars['workflowTypeArray'] && $this->_tpl_vars['workflowProject']): ?>
                                    <li class="js-search-line"><a href="/admin/project/add/"><strong>+</strong> <?php echo $this->_tpl_vars['translate_dobavit_proekt']; ?>
</a></li>
                                <?php endif; ?>
                                <?php if (! $this->_tpl_vars['workflowTypeArray'] && $this->_tpl_vars['workflowOrder']): ?>
                                    <li class="js-search-line"><a href="/admin/order/add/"><strong>+</strong> <?php echo $this->_tpl_vars['translate_dobavit_zakaz']; ?>
</a></li>
                                <?php endif; ?>

                                <li class="js-search-line"><a href="/admin/shop/finance/payment/add/"><strong>+</strong> <?php echo $this->_tpl_vars['translate_payment_add']; ?>
</a> </li>
                                <li class="js-search-line"><a href="/admin/shop/products/add/"><strong>+</strong> <?php echo $this->_tpl_vars['translate_product_add']; ?>
</a></li>
                                <li class="js-search-line"><a href="#" onclick="return box_email_popup_open();"><strong>+</strong> <?php echo $this->_tpl_vars['translate_write_letter']; ?>
</a> </li>
                                <?php if ($this->_tpl_vars['smsSendOk']): ?>
                                    <li class="js-search-line"><a href="#" onclick="return sms_popup_open();"><strong>+</strong> <?php echo $this->_tpl_vars['translate_napisat_sms']; ?>
</a> </li>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['workflowTypeArray']): ?>
                                    <?php $_from = $this->_tpl_vars['workflowTypeArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['t']):
?>
                                        <li class="js-search-line"><a href="<?php echo $this->_tpl_vars['t']['url']; ?>
"><strong>+</strong> <?php echo $this->_tpl_vars['translate_add']; ?>
 <?php echo $this->_tpl_vars['t']['name']; ?>
</a></li>
                                    <?php endforeach; endif; unset($_from); ?>
                                <?php elseif ($this->_tpl_vars['workflowIssue']): ?>
                                    <li class="js-search-line"><a href="/admin/issue/add/"><strong>+</strong> <?php echo $this->_tpl_vars['translate_service_tasks_add']; ?>
</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </li>

                <?php if ($this->_tpl_vars['workflowArray']): ?>
                    <li class="js-search-line">
                        <div class="menu-element">
                            <div class="menu-element-part static">
                                <a class="icon js-menu-toggle" href="javascript:void(0);">
                                    <svg class="icon-svg icon-bissness" viewBox="0 0 16 16">
                                        <use xlink:href="#icon-bissness"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="menu-element-part collapse">
                                <a class="menu-link js-menu-toggle" href="javascript:void(0);"><?php echo $this->_tpl_vars['translate_workflow']; ?>
 <i class="expand"></i></a>
                            </div>
                            <div class="clear"></div>

                            <div class="menu-element-part collapse-full">
                                <ul class="sub-nav">
                                    <?php $_from = $this->_tpl_vars['workflowArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                        <li class="js-search-line">
                                            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                                        </li>
                                    <?php endforeach; endif; unset($_from); ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>

                <li class="js-search-line">
                    <div class="menu-element">
                        <div class="menu-element-part static">
                            <a class="icon js-menu-toggle" href="/admin/">
                                <svg class="icon-svg icon-calendar" viewBox="0 0 16 16">
                                    <use xlink:href="#icon-calendar"></use>
                                </svg>
                            </a>
                        </div>

                        <div class="menu-element-part collapse">
                            <a class="menu-link js-menu-toggle" href="/admin/"><?php echo $this->_tpl_vars['translate_kalendar']; ?>
</a>
                        </div>
                        <div class="clear"></div>
                    </div>
                </li>

                <?php $_from = $this->_tpl_vars['menuArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['url'] => $this->_tpl_vars['name']):
?>
                    <li class="js-search-line">
                        <div class="menu-element">
                            <div class="menu-element-part static">
                                <a class="icon js-menu-toggle" href="<?php echo $this->_tpl_vars['url']; ?>
">

                                </a>
                            </div>

                            <div class="menu-element-part collapse">
                                <a class="menu-link js-menu-toggle" href="<?php echo $this->_tpl_vars['url']; ?>
"><?php echo $this->_tpl_vars['name']; ?>
</a>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </li>

                <?php endforeach; else: ?>

                    <?php if ($this->_tpl_vars['acl']['project'] && $this->_tpl_vars['showOrderMenu']): ?>
                        <li class="js-search-line">
                            <div class="menu-element">
                                <div class="menu-element-part static">
                                    <a class="icon js-menu-toggle" href="/admin/projects/">
                                        <svg class="icon-svg icon-project" viewBox="0 0 16 16">
                                            <use xlink:href="#icon-project"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-element-part collapse">
                                    <a class="menu-link js-menu-toggle" href="/admin/projects/"><?php echo $this->_tpl_vars['translate_proekti']; ?>
</a>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['acl']['issue'] && $this->_tpl_vars['showOrderMenu']): ?>
                        <li class="js-search-line">
                            <div class="menu-element">
                                <div class="menu-element-part static">
                                    <a class="icon js-menu-toggle" href="/admin/issue/">
                                        <svg class="icon-svg icon-issue" viewBox="0 0 16 16">
                                            <use xlink:href="#icon-issue"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-element-part collapse">
                                    <a class="menu-link js-menu-toggle" href="/admin/issue/"><?php echo $this->_tpl_vars['acl_issue']; ?>
</a>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['acl']['report_event']): ?>
                        <li class="js-search-line">
                            <div class="menu-element">
                                <div class="menu-element-part static">
                                    <a class="icon js-menu-toggle" href="/admin/shop/report/event/">
                                        <svg class="icon-svg icon-events" viewBox="0 0 16 16">
                                            <use xlink:href="#icon-events"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-element-part collapse">
                                    <a class="menu-link js-menu-toggle" href="/admin/shop/report/event/"><?php echo $this->_tpl_vars['translate_sobitiya']; ?>
</a>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['acl']['structure']): ?>
                        <li class="js-search-line">
                            <div class="menu-element">
                                <div class="menu-element-part static">
                                    <a class="icon js-menu-toggle" href="/admin/structure/">
                                        <svg class="icon-svg icon-structure" viewBox="0 0 16 16">
                                            <use xlink:href="#icon-structure"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-element-part collapse">
                                    <a class="menu-link js-menu-toggle" href="/admin/structure/"><?php echo $this->_tpl_vars['translate_struktura']; ?>
</a>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['acl']['products']): ?>
                        <li class="js-search-line">
                            <div class="menu-element">
                                <div class="menu-element-part static">
                                    <a class="icon js-menu-toggle" href="javascript:void(0);">
                                        <svg class="icon-svg icon-products" viewBox="0 0 16 16">
                                            <use xlink:href="#icon-products"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-element-part collapse">
                                    <a class="menu-link js-menu-toggle" href="javascript:void(0);"><?php echo $this->_tpl_vars['translate_many_products']; ?>
 <i class="expand"></i></a>
                                </div>
                                <div class="clear"></div>

                                <div class="menu-element-part collapse-full">
                                    <ul class="sub-nav">
                                        <li class="js-search-line"><a href="/admin/shop/products/list-table/"><?php echo $this->_tpl_vars['translate_many_products']; ?>
</a></li>
                                        <li class="js-search-line"><a href="/admin/shop/products/"><?php echo $this->_tpl_vars['translate_many_products_inlist']; ?>
</a></li>
                                        <li class="js-search-line"><a href="/admin/shop/products/add/"><strong>+</strong> <?php echo $this->_tpl_vars['translate_new_product']; ?>
</a></li>
                                        <li class="js-search-line"><a href="/admin/shop/products/copy/"><strong>+</strong> <?php echo $this->_tpl_vars['translate_products_copy']; ?>
</a></li>
                                        <li class="js-search-line"><a href="/admin/shop/products/exchange-xls/"><?php echo $this->_tpl_vars['translate_import_and_export_excel']; ?>
</a></li>
                                        <li class="js-search-line"><a href="/admin/shop/category/manage/"><?php echo $this->_tpl_vars['translate_category']; ?>
</a></li>
                                        <li class="js-search-line"><a href="/admin/shop/brands/"><?php echo $this->_tpl_vars['translate_brands']; ?>
</a></li>
                                        <li class="js-search-line"><a href="/admin/shop/products/filters/"><?php echo $this->_tpl_vars['translate_products_filters']; ?>
</a></li>
                                        <li class="js-search-line"><a href="/admin/product/merge/"><?php echo $this->_tpl_vars['translate_skleyka_tovarov']; ?>
</a></li>
                                        <li class="js-search-line"><a href="/admin/shop/products/productslist/"><?php echo $this->_tpl_vars['translate_products_list']; ?>
</a></li>
                                        <li class="js-search-line"><a href="/admin/shop/comments/"><?php echo $this->_tpl_vars['translate_many_comments']; ?>
</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php $_from = $this->_tpl_vars['menuTopArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <?php if (! $this->_tpl_vars['e']['top']): ?>
                            <li class="js-search-line">
                                <div class="menu-element">
                                    <div class="menu-element-part static">
                                        <a class="icon js-menu-toggle" href="<?php if ($this->_tpl_vars['e']['childArray']): ?>javascript:void(0);<?php else: ?><?php echo $this->_tpl_vars['e']['url']; ?>
<?php endif; ?>">
                                            <svg class="icon-svg <?php echo $this->_tpl_vars['e']['class']; ?>
" viewBox="0 0 16 16">
                                                <use xlink:href="#<?php echo $this->_tpl_vars['e']['class']; ?>
"></use>
                                            </svg>
                                        </a>
                                    </div>

                                    <div class="menu-element-part collapse">
                                        <a class="menu-link js-menu-toggle" href="<?php if ($this->_tpl_vars['e']['childArray']): ?>javascript:void(0);<?php else: ?><?php echo $this->_tpl_vars['e']['url']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['e']['name']; ?>
 <?php if ($this->_tpl_vars['e']['childArray']): ?><i class="expand"></i><?php endif; ?></a>
                                    </div>
                                    <div class="clear"></div>

                                    <?php if ($this->_tpl_vars['e']['childArray']): ?>
                                        <div class="menu-element-part collapse-full">
                                            <ul class="sub-nav">
                                                <?php $_from = $this->_tpl_vars['e']['childArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                                                    <li class="js-search-line"><a href="<?php echo $this->_tpl_vars['c']['url']; ?>
"><?php echo $this->_tpl_vars['c']['name']; ?>
</a></li>
                                                <?php endforeach; endif; unset($_from); ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                <?php endif; unset($_from); ?>

                <?php if ($this->_tpl_vars['menuReportArray']): ?>
                    <li class="js-search-line">
                        <div class="menu-element">
                            <div class="menu-element-part static">
                                <a class="icon js-menu-toggle" href="javascript:void(0);">
                                    <svg class="icon-svg icon-events" viewBox="0 0 16 16">
                                        <use xlink:href="#icon-events"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="menu-element-part collapse">
                                <a class="menu-link js-menu-toggle" href="javascript:void(0);"><?php echo $this->_tpl_vars['translate_reports']; ?>
 <i class="expand"></i></a>
                            </div>
                            <div class="clear"></div>


                            <div class="menu-element-part collapse-full">
                                <ul class="sub-nav">
                                    <?php $_from = $this->_tpl_vars['menuReportArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foreach_report'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foreach_report']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['e']):
        $this->_foreach['foreach_report']['iteration']++;
?>
                                        <li class="js-search-line"><a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a></li>
                                    <?php endforeach; endif; unset($_from); ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>

                <li class="js-search-line">
                    <div class="menu-element">
                        <div class="menu-element-part static">
                            <a class="icon js-menu-toggle" href="javascript:void(0);">
                                <svg class="icon-svg icon-settings" viewBox="0 0 20 20">
                                    <use xlink:href="#icon-settings"></use>
                                </svg>
                            </a>
                        </div>

                        <div class="menu-element-part collapse">
                            <a class="menu-link js-menu-toggle" href="javascript:void(0);"><?php echo $this->_tpl_vars['translate_settings']; ?>
 <i class="expand"></i></a>
                        </div>
                        <div class="clear"></div>


                        <div class="menu-element-part collapse-full">
                            <ul class="sub-nav">
                                <?php $_from = $this->_tpl_vars['menuSettingArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foreach_setting'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foreach_setting']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['e']):
        $this->_foreach['foreach_setting']['iteration']++;
?>
                                    <li class="js-search-line"><a href="<?php echo $this->_tpl_vars['e']['url']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a></li>
                                <?php endforeach; endif; unset($_from); ?>

                                <?php if ($this->_tpl_vars['acl']['settings']): ?>
                                    <li class="js-search-line"><a href="#" class="js-clear-cache"><?php echo $this->_tpl_vars['translate_cash_clear']; ?>
</a> </li>
                                <?php endif; ?>
                                <li class="js-search-line"><a href="/doc/" target="_blank"><?php echo $this->_tpl_vars['translate_help']; ?>
</a> </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="js-search-line">
                    <div class="menu-element">
                        <div class="menu-element-part static">
                            <a class="icon js-menu-toggle" href="javascript:void(0);">
                                <svg class="icon-svg icon-exit" viewBox="0 0 16 16">
                                    <use xlink:href="#icon-exit"></use>
                                </svg>
                            </a>
                        </div>

                        <div class="menu-element-part collapse">
                            <a class="menu-link js-menu-toggle" href="javascript:void(0);"><?php if ($this->_tpl_vars['user']['login']): ?><?php echo $this->_tpl_vars['user']['login']; ?>
<?php else: ?>admin<?php endif; ?> <i class="expand"></i></a>
                        </div>
                        <div class="clear"></div>

                        <div class="menu-element-part collapse-full">
                            <ul class="sub-nav">
                                <li class="js-search-line"><a href="/"><?php echo $this->_tpl_vars['translate_shop']; ?>
</a></li>
                                <li class="js-search-line"><a href="/client/orders/"><?php echo $this->_tpl_vars['translate_cabinet']; ?>
 <?php echo $this->_tpl_vars['translate_client']; ?>
</a> </li>
                                <li class="js-search-line"><a href="/logout/"><?php echo $this->_tpl_vars['translate_logout']; ?>
</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="nb-block-notification js-notification-list">
        <div class="scroll-wrap js-notify-scroll-block">
        </div>
        <div class="js-current-user-id" style="display:none; "><?php echo $this->_tpl_vars['cuserID']; ?>
</div>
    </div>
</div>

<div class="nb-wrap-notification js-wrap-notification">
    <div class="block-stat">
        <a class="ob-button button-red remove-button" onclick="deleteNotificationAll();" href="javascript:void(0);">Удалить все уведомления</a>

        <div class="nb-block-tabs js-slide-tabs">
            <div class="tab-element"><a href="#" class="selected line js-notify-my-toggle" data-acl="0">Все</a></div>
            <div class="tab-element"><a class="js-notify-my-toggle" href="#" data-acl="1">Мои</a></div>
            <span class="hover"></span>
            <div class="clear"></div>
        </div>

        <div class="stat-element">
            <div class="cell"><a href="javascript:void(0);" class="name js-stat-element" data-href="js-anchcor-comment">Комментариев</a></div>
            <div class="cell value" data-href-count="js-anchcor-comment">0</div>
        </div>
        <div class="stat-element" >
            <div class="cell"><a href="javascript:void(0);" class="name js-stat-element" data-href="js-anchcor-email">Писем</a></div>
            <div class="cell value" data-href-count="js-anchcor-email">0</div>
        </div>
        <div class="stat-element">
            <div class="cell"><a href="javascript:void(0);" class="name js-stat-element" data-href="js-anchcor-call">Звонков</a></div>
            <div class="cell value" data-href-count="js-anchcor-call">0</div>
        </div>
        <div class="stat-element">
            <div class="cell"><a href="javascript:void(0);" class="name js-stat-element" data-href="js-anchcor-notify">Уведомлений</a></div>
            <div class="cell value" data-href-count="js-anchcor-notify">0</div>
        </div>
        <div class="stat-element">
            <div class="cell"><a href="javascript:void(0);" class="name js-stat-element" data-href="js-anchcor-change">Изменений</a></div>
            <div class="cell value" data-href-count="js-anchcor-change">0</div>
        </div>
        <div class="stat-element">
            <div class="cell"><a href="javascript:void(0);" class="name js-stat-element" data-href="js-anchcor-commentresult">Результаты</a></div>
            <div class="cell value" data-href-count="js-anchcor-commentresult">20</div>
        </div>
    </div>

    <span class="nb-icon-close js-notification-toggle">
         <svg>
             <use xlink:href="#icon-close"></use>
         </svg>
    </span>
</div>