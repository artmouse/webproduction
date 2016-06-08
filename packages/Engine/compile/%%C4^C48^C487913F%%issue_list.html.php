<?php /* Smarty version 2.6.27-optimized, created on 2015-11-09 14:02:03
         compiled from /var/www/shop.local/contents/shop/admin/customorder/issue_list.html */ ?>
<?php if ($this->_tpl_vars['message'] == 'errordate'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_error']; ?>
 <?php echo $this->_tpl_vars['translate_date_of_completion']; ?>
.<br />
    </div>
<?php endif; ?>

<div class="filter-toggle <?php if ($this->_tpl_vars['filterpanelCookie']): ?>open<?php endif; ?>"></div>
<div class="shop-filter-panel <?php if ($this->_tpl_vars['filterpanelCookie']): ?>open<?php endif; ?>">
    <div class="inner-pannel">
        <form action="" method="get">
            <?php if ($this->_tpl_vars['moduleViewModeArray']): ?>
                <div class="element">
                    <div class="caption-field"><?php echo $this->_tpl_vars['translate_viewing_mode']; ?>
</div>
                    <select name="mode" class="chzn-select">
                        <option value="" <?php if ($this->_tpl_vars['control_mode'] == ''): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['translate_spiskom']; ?>
</option>
                        <?php $_from = $this->_tpl_vars['moduleViewModeArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <option value="<?php echo $this->_tpl_vars['e']['modeName']; ?>
" <?php if ($this->_tpl_vars['control_mode'] == $this->_tpl_vars['e']['modeName']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="element">
                <div class="caption-field"><?php echo $this->_tpl_vars['translate_responsible']; ?>
</div>
                <select name="filtermanagerid" class="chzn-select">
                    <option value=""><?php echo $this->_tpl_vars['translate_all_managers']; ?>
</option>
                    <?php $_from = $this->_tpl_vars['managerArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_filtermanagerid']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </div>

            <div class="element">
                <div class="caption-field"><?php echo $this->_tpl_vars['translate_client_small']; ?>
</div>
                <input type="hidden" name="filterclientid" value="<?php echo $this->_tpl_vars['control_filterclientid']; ?>
" class="js-select2 js-select2-clientid" data-type="user" />
                <script type="text/javascript">
                    $j(function () {
                        var tags = [
                            <?php $_from = $this->_tpl_vars['filterClientArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foreach1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foreach1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['p']):
        $this->_foreach['foreach1']['iteration']++;
?>
                                {'id':<?php echo $this->_tpl_vars['p']['id']; ?>
, 'text':'<?php echo $this->_tpl_vars['p']['text']; ?>
'}
                                <?php if (! ($this->_foreach['foreach1']['iteration'] == $this->_foreach['foreach1']['total'])): ?>,<?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        ];

                        $j(".js-select2-clientid").select2('data', tags);
                    });
                </script>
            </div>

            <?php if ($this->_tpl_vars['customOrderNumber']): ?>
                <div class="element">
                    <input type="text" name="filternumber" value="<?php echo $this->_tpl_vars['control_filternumber']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_order_number']; ?>
" />
                </div>
            <?php endif; ?>

            <div class="element">
                <input type="text" name="filtername" value="<?php echo $this->_tpl_vars['control_filtername']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_box_name_small']; ?>
" />
            </div>

            <div class="element">
                <input type="text" name="filterid" value="<?php echo $this->_tpl_vars['control_filterid']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_code']; ?>
" />
            </div>

            <div class="element">
                <input type="text" name="filteraddress" value="<?php echo $this->_tpl_vars['control_filteraddress']; ?>
" placeholder="Адрес" />
            </div>

            <div class="element">
                <input type="text" class="js-date" name="filtercdatefrom" value="<?php echo $this->_tpl_vars['control_filtercdatefrom']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_data_sozdaniya_ot']; ?>
" />
            </div>

            <div class="element">
                <input type="text" class="js-date" name="filtercdateto" value="<?php echo $this->_tpl_vars['control_filtercdateto']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_data_sozdaniya_do']; ?>
" />
            </div>

            <?php if ($this->_tpl_vars['mode'] != 'funnel'): ?>
                <div class="element ulist">
                    <label>
                        <input type="checkbox" name="filtershowclosed" value="1" <?php if ($this->_tpl_vars['control_filtershowclosed']): ?>checked<?php endif; ?> class="js-filtershowclosed">
                        <?php echo $this->_tpl_vars['translate_pokazivat_zakritie']; ?>

                    </label>

                    <input type="hidden" name="filtershowclosed" value="0" class="js-filtershowclosed-hidden" <?php if ($this->_tpl_vars['control_filtershowclosed']): ?>disabled<?php endif; ?> />
                    <script type="text/javascript">
                        $j(function () {
                            $j('.js-filtershowclosed').change(function(event) {
                                $j('.js-filtershowclosed-hidden').prop('disabled', $j(this).is(':checked'));
                            });
                        });
                    </script>
                </div>
            <?php endif; ?>

            <div class="element ulist">
                <label>
                    <input type="checkbox" name="filtershownotissue" value="1" <?php if ($this->_tpl_vars['control_filtershownotissue']): ?>checked<?php endif; ?> class="js-filtershowclosed">
                    <?php echo $this->_tpl_vars['translate_pokazivat_tolko_bez_zadach']; ?>

                </label>
            </div>

            <?php echo $this->_tpl_vars['block_workflow_filter']; ?>


            <?php if ($this->_tpl_vars['managerArray']): ?>
                <div class="element">
                    <div class="caption-field"><?php echo $this->_tpl_vars['translate_avtor_zadachi']; ?>
</div>
                    <select name="filterauthorid" class="chzn-select">
                        <option value=""><?php echo $this->_tpl_vars['translate_all_managers']; ?>
</option>
                        <?php $_from = $this->_tpl_vars['managerArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_filterauthorid']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="element">
                <input type="text" name="filterproductname" value="<?php echo $this->_tpl_vars['control_filterproductname']; ?>
" class="help-hint-filter-login" placeholder="<?php echo $this->_tpl_vars['translate_item_title']; ?>
" />
            </div>

            <div class="element">
                <input type="text" name="filterproductid" value="<?php echo $this->_tpl_vars['control_filterproductid']; ?>
" class="help-hint-filter-login" placeholder="<?php echo $this->_tpl_vars['translate_item_code']; ?>
" />
            </div>

            <div class="element">
                <input type="text" name="filterproductserial" value="<?php echo $this->_tpl_vars['control_filterproductserial']; ?>
" class="help-hint-filter-login" placeholder="<?php echo $this->_tpl_vars['translate_product_serial_number']; ?>
" />
            </div>

            <div class="element">
                <input type="text" class="js-date" name="filterdatetofrom" value="<?php echo $this->_tpl_vars['control_filterdatetofrom']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_data_vipolneniya_ot']; ?>
" />
            </div>

            <div class="element">
                <input type="text" class="js-date" name="filterdatetoto" value="<?php echo $this->_tpl_vars['control_filterdatetoto']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_data_vipolneniya_do']; ?>
" />
            </div>

            <input class="ob-button button-orange" type="submit" value="<?php echo $this->_tpl_vars['translate_filter']; ?>
" />

            <div class="clear"></div>
        </form>
    </div>
</div>

<div class="shop-result-list">
    <div class="inner-list <?php if ($this->_tpl_vars['filterpanelCookie']): ?>filter-reserve<?php endif; ?>">
        <?php if ($this->_tpl_vars['block_show_custom']): ?>
            <?php echo $this->_tpl_vars['block_show_custom']; ?>

        <?php else: ?>
            <div class="js-table-footer"></div>
        
            <?php echo $this->_tpl_vars['table']; ?>


            <?php if ($this->_tpl_vars['dataCount']): ?>
                <div class="ob-block-details">
                    <div class="ob-data-element">
                        <div class="data-view">
                            <div class="el-caption static"><?php echo $this->_tpl_vars['translate_kolichestvo_zadach']; ?>
:</div>
                            <div class="el-value"><?php echo $this->_tpl_vars['dataCount']; ?>
</div>
                        </div>
                    </div>

                    <form id="massSend" action="/admin/shop/users/mailing/" method="post">
                        <input type="hidden" name="arrUserId" value="<?php echo $this->_tpl_vars['arrUserId']; ?>
">
                        <input class="ob-button" id="sendAll" type="submit" name="sendAll" value="<?php echo $this->_tpl_vars['translate_users_mailing']; ?>
" />
                        <?php if ($this->_tpl_vars['canSMS']): ?>
                            <input class="ob-button" type="submit" name="sendAllSms" value="<?php echo $this->_tpl_vars['translate_users_mailing']; ?>
 SMS" onclick="$j('#massSend').attr('action', '/admin/shop/users/smsmailing/');" />
                        <?php endif; ?>
                    </form>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<div class="clear"></div>

<div class="nb-right-sidebar disable" >
    <div class="toggle"></div>

    <form action="" method="post" >
        <input type="hidden" id="id-issue" name="moveids" />

        <?php if ($this->_tpl_vars['managerArray']): ?>
            <div class="element double">
                <?php echo $this->_tpl_vars['translate_naznachit_na']; ?>
:
                <select class="chzn-select" name="manager">
                    <option value="">---</option>
                    <?php $_from = $this->_tpl_vars['managerArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['statusArray'] || $this->_tpl_vars['statusCategoryArray']): ?>
            <div class="element">
                <?php echo $this->_tpl_vars['translate_cgange_status']; ?>
:
                <select class="chzn-select" name="status">
                    <option value="">---</option>
                    <?php $_from = $this->_tpl_vars['statusArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" ><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                    <?php $_from = $this->_tpl_vars['statusCategoryArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['s']):
?>
                        <optgroup label="<?php echo $this->_tpl_vars['key']; ?>
">
                            <?php $_from = $this->_tpl_vars['s']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s2']):
?>
                                <option value="<?php echo $this->_tpl_vars['s2']['id']; ?>
" ><?php echo $this->_tpl_vars['s2']['name']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </optgroup>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="element">
            <?php echo $this->_tpl_vars['translate_date_of_completion']; ?>
:
            <input type="text" name="dueDate" class="js-datetime">
        </div>

        <div class="element">
            <label>
                <input type="radio" name="action" value="open" />
                <?php echo $this->_tpl_vars['translate_otkrit_zadachi']; ?>

            </label>
            <br />
            <label>
                <input type="radio" name="action" value="closed" />
                <?php echo $this->_tpl_vars['translate_zakrit_zadachi']; ?>

            </label>
        </div>
        <div class="clear"></div>

        <div class="element">
            <input class="ob-button" type="submit" name="change" value="<?php echo $this->_tpl_vars['translate_user_change']; ?>
" onclick="return confirm('<?php echo $this->_tpl_vars['translate_button_comfirm_change_data']; ?>
');" />
        </div>

        <div class="element">
            <input class="ob-button" type="submit" name="delete" value="<?php echo $this->_tpl_vars['translate_delete']; ?>
"  onclick="return confirm('<?php echo $this->_tpl_vars['translate_button_comfirm_order_delete']; ?>
');" />
        </div>
        <div class="element double">
            <br />
            <?php echo $this->_tpl_vars['translate_mass_orders_add_comment']; ?>

            <br />
            <div class="comment-wrap">
                <div class="comment-cell">
                    <div class="js-order-comment-div">                      
                        <textarea id="js-postcomment" name="postcomments" class="js-autosize js-usertextcomplete" placeholder="<?php echo $this->_tpl_vars['translate_message']; ?>
"></textarea>
                    </div>
                </div>
            </div>
            <br />
        </div>
        
        <div class="element">
            <input class="ob-button" type="submit" name="add_comments" value="<?php echo $this->_tpl_vars['translate_add']; ?>
" onclick="return confirm('<?php echo $this->_tpl_vars['translate_add_comment']; ?>
');" />
        </div>
    </form>
</div>