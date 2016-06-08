<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 18:00:39
         compiled from /var/www/shop.local/modules/order/contents/admin//orders/orders_control_block_info.html */ ?>
<?php if ($this->_tpl_vars['message'] == 'error'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_box_message_error']; ?>
.<br />

        <?php $_from = $this->_tpl_vars['errorsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <?php if ($this->_tpl_vars['e'] == 'notlinked'): ?>
                <?php echo $this->_tpl_vars['translate_order_error_not_linked']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'issue-stop'): ?>
                <?php echo $this->_tpl_vars['translate_izmenenie_sostoyanie_zapreshcheno_poka_ne_vipolneni_vse_vnutrennie_zadachi']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'saled'): ?>
                <?php echo $this->_tpl_vars['translate_order_error_saled']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'user'): ?>
                <?php echo $this->_tpl_vars['translate_box_error_user']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'phone'): ?>
                <?php echo $this->_tpl_vars['translate_order_error_phone']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'email'): ?>
                <?php echo $this->_tpl_vars['translate_order_error_login']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'lack'): ?>
                <?php echo $this->_tpl_vars['translate_dlya_proizvodstva_ne_hvataet_produktov_na_sklade']; ?>
.
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['IdBusy']): ?>
            <?php echo $this->_tpl_vars['translate_ne_udalos_pomenyat_nomer_zakaza_takoy_nomer_uzhe_ispolzuetsya']; ?>
.<br />
        <?php endif; ?>

        <?php echo $this->_tpl_vars['errorText']; ?>

    </div>
<?php endif; ?>

<div class="ob-block-element">
    <div class="ob-data-element js-data-element">
        <div class="data-view">
            <div class="el-value ob-text order-info">
                <?php if ($this->_tpl_vars['orderComment']): ?>
                    <span style="font-size: 18px;"><?php echo $this->_tpl_vars['orderComment']; ?>
</span>
                <?php else: ?>
                    <?php echo $this->_tpl_vars['translate_primechanie_otsutstvuet']; ?>

                <?php endif; ?>
                <a class="ob-link-edit" href="#"></a>
            </div>
        </div>
        <div class="data-edit">
            <a class="ob-link-delete" href="#"></a>
            <a class="ob-link-accept" href="#"></a>
            <textarea name="comments" style="height: 150px;" id="js-text-comment-edit"><?php echo $this->_tpl_vars['control_comments']; ?>
</textarea>
        </div>
    </div>
</div>

<div class="ob-block-details">
    <div class="flex-wrap">
        <?php if ($this->_tpl_vars['box']): ?>
            <div class="ob-data-element js-data-element">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_nomer']; ?>
:</div>
                    <div class="el-value">
                        <?php echo $this->_tpl_vars['control_number']; ?>

                        <a class="ob-link-edit" href="#"></a>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <input type="text" name="number"
                           value="<?php echo $this->_tpl_vars['control_number']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['box']): ?>
            <div class="ob-data-element js-data-element">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_name_small']; ?>
:</div>
                    <div class="el-value">
                        <?php echo $this->_tpl_vars['control_name']; ?>

                        <a class="ob-link-edit" href="#"></a>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <input type="text" name="name" value="<?php echo $this->_tpl_vars['control_name']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['box'] || $this->_tpl_vars['workflowVisualEnable']): ?>
            <div class="ob-data-element js-data-element">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_etap']; ?>
:</div>
                    <div class="el-value">
                        <?php if ($this->_tpl_vars['statusColor']): ?>
                            <div class="ob-wf-stage" style="background-color: <?php echo $this->_tpl_vars['statusColor']; ?>
;"><?php echo $this->_tpl_vars['statusName']; ?>
</div>
                        <?php else: ?>
                            <?php echo $this->_tpl_vars['statusName']; ?>

                        <?php endif; ?>
                                            </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <select id="js-statusid" name="status" class="chzn-select">
                        <?php $_from = $this->_tpl_vars['statusNextArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_status']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            </div>
        <?php else: ?>
            <div class="ob-data-element js-data-element">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_etap']; ?>
:</div>
                    <div class="el-value">
                        <?php if ($this->_tpl_vars['statusColor']): ?>
                            <div class="ob-wf-stage" style="background-color: <?php echo $this->_tpl_vars['statusColor']; ?>
;"><?php echo $this->_tpl_vars['statusName']; ?>
</div>
                        <?php else: ?>
                            <?php echo $this->_tpl_vars['statusName']; ?>

                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['statusArray']): ?>
                            <a class="ob-link-edit" href="#"></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <select id="js-statusid" name="status" class="chzn-select">
                        <?php $_from = $this->_tpl_vars['statusArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_status']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>

        <div class="ob-data-element js-data-element">
            <div class="data-view">
                <div class="el-caption"><?php if ($this->_tpl_vars['control_direction']): ?><?php echo $this->_tpl_vars['translate_vendor']; ?>
<?php else: ?><?php echo $this->_tpl_vars['translate_client_small']; ?>
<?php endif; ?>:</div>
                <div class="el-value">
                    <?php if ($this->_tpl_vars['clientName']): ?>
                        <a href="<?php if ($this->_tpl_vars['clientURL']): ?><?php echo $this->_tpl_vars['clientURL']; ?>
<?php else: ?>#<?php endif; ?>" class="js-contact-preview"
                           data-id="<?php echo $this->_tpl_vars['clientID']; ?>
"><?php echo $this->_tpl_vars['clientName']; ?>
</a>
                    <?php endif; ?>
                    <a class="ob-link-edit" href="#"></a>
                </div>
            </div>
            <div class="data-edit" style="padding-right: 70px;">
                <a class="ob-link-delete" href="#"></a>
                <a class="ob-link-accept" href="#"></a>
                <?php if ($this->_tpl_vars['box']): ?>
                    <?php if ($this->_tpl_vars['canEdit']): ?>
                        <a href="#" class="ob-link-editmore js-user-edit-button"
                           title="<?php echo $this->_tpl_vars['translate_redaktirovat_kartochku_klienta_tolko_dlya_etogo_zakaza']; ?>
"></a>
                    <?php endif; ?>
                <?php endif; ?>
                                <input type="text" id="id-user-name" value="<?php echo $this->_tpl_vars['client']; ?>
" placeholder="<?php echo $this->_tpl_vars['clientName']; ?>
"/>
                <input type="hidden" name="changeuser" id="id-user-value"/>
            </div>
        </div>

        <div class="ob-data-element js-user-edit">
            <div class="data-view">
                <div class="el-caption"><?php echo $this->_tpl_vars['translate_fio']; ?>
:</div>
                <div class="el-value"><input type="text" name="clientname" value="<?php echo $this->_tpl_vars['control_clientname']; ?>
"/>
                </div>
            </div>
        </div>
        <div class="ob-data-element js-user-edit">
            <div class="data-view">
                <div class="el-caption">Email:</div>
                <div class="el-value"><input type="text" name="clientemail" value="<?php echo $this->_tpl_vars['control_clientemail']; ?>
"/>
                </div>
            </div>
        </div>
        <div class="ob-data-element js-user-edit">
            <div class="data-view">
                <div class="el-caption"><?php echo $this->_tpl_vars['translate_phone']; ?>
:</div>
                <div class="el-value"><input type="text" name="clientphone" value="<?php echo $this->_tpl_vars['control_clientphone']; ?>
"
                                             class="js-phone-formatter"/></div>
            </div>
        </div>
        <div class="ob-data-element js-user-edit">
            <div class="data-view">
                <div class="el-caption"><?php echo $this->_tpl_vars['translate_clientaddress']; ?>
:</div>
                <div class="el-value"><textarea name="clientaddress"
                                                class="js-autosize small"><?php echo $this->_tpl_vars['control_clientaddress']; ?>
</textarea>
                </div>
            </div>
        </div>
        <div class="ob-data-element js-user-edit">
            <div class="data-view">
                <div class="el-caption"></div>
                <div class="el-value">
                    <label>
                        <input type="checkbox" name="updateUserInfo" value="1"/>
                        <?php echo $this->_tpl_vars['translate_update_user_card']; ?>

                    </label>
                </div>
            </div>
        </div>

        <?php if (! $this->_tpl_vars['box']): ?>
            <div class="ob-data-element js-data-element js-user-view">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_fio']; ?>
:</div>
                    <div class="el-value">
                        <?php echo $this->_tpl_vars['control_clientname']; ?>

                        <a class="ob-link-edit" onclick="$j('#update_user_card').show();" href="#"></a>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <input type="text" name="clientname" value="<?php echo $this->_tpl_vars['control_clientname']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                </div>
            </div>
            <div class="ob-data-element js-data-element js-user-view">
                <div class="data-view">
                    <div class="el-caption">Email:</div>
                    <div class="el-value">
                        <?php echo $this->_tpl_vars['control_clientemail']; ?>

                        <a class="ob-link-edit" onclick="$j('#update_user_card').show();" href="#"></a>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <input type="text" name="clientemail" value="<?php echo $this->_tpl_vars['control_clientemail']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                </div>
            </div>
            <div class="ob-data-element js-data-element js-user-view">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_phone']; ?>
:</div>
                    <div class="el-value">
                        <?php echo $this->_tpl_vars['control_clientphone']; ?>

                        <a class="ob-link-edit" onclick="$j('#update_user_card').show();" href="#"></a>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <input type="text" name="clientphone" value="<?php echo $this->_tpl_vars['control_clientphone']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                </div>
            </div>
            <div class="ob-data-element js-data-element js-user-view">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_clientaddress']; ?>
:</div>
                    <div class="el-value">
                        <?php echo $this->_tpl_vars['control_clientaddress']; ?>

                        <a class="ob-link-edit" onclick="$j('#update_user_card').show();" href="#"></a>
                    </div>
                </div>
                <div class="data-edit js-data-element">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <input type="text" name="clientaddress" value="<?php echo $this->_tpl_vars['control_clientaddress']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                </div>
            </div>
        <?php else: ?>
            <div class="ob-data-element js-data-element js-user-view">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_fio']; ?>
:</div>
                    <div class="el-value"><?php echo $this->_tpl_vars['control_clientname']; ?>

                        <a class="ob-link-edit" onclick="$j('#update_user_card').show();" href="#"></a>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <input type="text" name="clientname" value="<?php echo $this->_tpl_vars['control_clientname']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                </div>
            </div>
            <div class="ob-data-element js-data-element js-user-view">
                <div class="data-view">
                    <div class="el-caption">Email:</div>
                    <div class="el-value">
                        <?php if ($this->_tpl_vars['control_clientemail']): ?>
                            <a class="ob-link-email ob-link-dashed js-email-write js-tooltip tooltipstered" data-email="<?php echo $this->_tpl_vars['control_clientemail']; ?>
" href="javascript:void(0);"><?php echo $this->_tpl_vars['control_clientemail']; ?>
</a>
                        <?php endif; ?>
                        <a class="ob-link-edit" onclick="$j('#update_user_card').show();" href="#"></a>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <input type="text" name="clientemail" value="<?php echo $this->_tpl_vars['control_clientemail']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                </div>
            </div>
            <div class="ob-data-element js-data-element js-user-view">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_phone']; ?>
:</div>
                    <div class="el-value">
                        <?php if ($this->_tpl_vars['control_clientphone']): ?>
                            <a class="ob-link-phone ob-link-dashed js-call-originate js-tooltip" href="#" data-phone="<?php echo $this->_tpl_vars['control_clientphone']; ?>
" title="<?php echo $this->_tpl_vars['translate_pozvonit']; ?>
"><?php echo $this->_tpl_vars['control_clientphone']; ?>
</a>
                        <?php endif; ?>
                        <a class="ob-link-edit" onclick="$j('#update_user_card').show();" href="#"></a>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <input type="text" name="clientphone" value="<?php echo $this->_tpl_vars['control_clientphone']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                </div>
            </div>
            <div class="ob-data-element js-data-element js-user-view">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_clientaddress']; ?>
:</div>
                    <div class="el-value"><?php echo $this->_tpl_vars['control_clientaddress']; ?>

                        <a class="ob-link-edit" onclick="$j('#update_user_card').show();" href="#"></a>
                    </div>
                </div>
                <div class="data-edit js-data-element">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <input type="text" name="clientaddress" value="<?php echo $this->_tpl_vars['control_clientaddress']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
                </div>
            </div>

            <div class="ob-data-element" id="update_user_card" style="display: none;">
                <div class="data-view">
                    <div class="el-caption"></div>
                    <div class="el-value">
                        <label>
                            <input type="checkbox" name="updateUserInfo" value="1"/>
                            <?php echo $this->_tpl_vars['translate_update_user_card']; ?>

                        </label>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php $_from = $this->_tpl_vars['customFieldArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['keyc'] => $this->_tpl_vars['c']):
?>
            <?php if ($this->_tpl_vars['keyc']%2): ?>
                <div class="ob-data-element js-data-element">
                    <div class="data-view">
                        <div class="el-caption"><?php echo $this->_tpl_vars['c']['name']; ?>
:</div>
                        <div class="el-value">
                            <?php echo $this->_tpl_vars['c']['value']; ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['deliveryArray']): ?>
            <div class="ob-data-element js-data-element">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_dostavka_zakaza']; ?>
:</div>
                    <div class="el-value">
                        <?php $_from = $this->_tpl_vars['deliveryArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['d']):
?>
                            <?php if ($this->_tpl_vars['d']['id'] == $this->_tpl_vars['control_delivery']): ?><?php echo $this->_tpl_vars['d']['name']; ?>
<?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                        <a class="ob-link-edit" href="#"></a>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <select name="delivery" <?php if (! $this->_tpl_vars['canEdit']): ?>disabled<?php endif; ?> class="chzn-select">
                        <option value="">---</option>
                        <?php $_from = $this->_tpl_vars['deliveryArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['d']):
?>
                            <option value="<?php echo $this->_tpl_vars['d']['id']; ?>
" <?php if ($this->_tpl_vars['d']['id'] == $this->_tpl_vars['control_delivery']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['d']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['paymentArray']): ?>
            <div class="ob-data-element js-data-element">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_oplati_zakaza']; ?>
:</div>
                    <div class="el-value">
                        <?php $_from = $this->_tpl_vars['paymentArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['d']):
?>
                            <?php if ($this->_tpl_vars['d']['id'] == $this->_tpl_vars['control_payment']): ?>
                                <?php echo $this->_tpl_vars['d']['name']; ?>

                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                        <a class="ob-link-edit" href="#"></a>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <select name="payment" <?php if (! $this->_tpl_vars['canEdit']): ?>disabled<?php endif; ?> class="chzn-select">
                        <option value="">---</option>
                        <?php $_from = $this->_tpl_vars['paymentArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['d']):
?>
                            <option value="<?php echo $this->_tpl_vars['d']['id']; ?>
" <?php if ($this->_tpl_vars['d']['id'] == $this->_tpl_vars['control_payment']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['d']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>

        <div class="ob-data-element js-data-element">
            <div class="data-view">
                <div class="el-caption"><?php echo $this->_tpl_vars['translate_invoice_delivery']; ?>
:</div>
                <div class="el-value">
                    <?php if ($this->_tpl_vars['deliveryNoteUrl']): ?>
                        <a href="<?php echo $this->_tpl_vars['deliveryNoteUrl']; ?>
"><?php echo $this->_tpl_vars['control_deliveryNote']; ?>
</a>
                    <?php else: ?>
                        <?php echo $this->_tpl_vars['control_deliveryNote']; ?>

                    <?php endif; ?>
                    <a class="ob-link-edit" href="#"></a>
                </div>
            </div>
            <div class="data-edit">
                <a class="ob-link-delete" href="#"></a>
                <a class="ob-link-accept" href="#"></a>
                <input type="text" name="deliveryNote"
                       value="<?php echo $this->_tpl_vars['control_deliveryNote']; ?>
" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
            </div>
        </div>

        <div class="ob-data-element js-data-element">
            <div class="data-view">
                <div class="el-caption"><?php echo $this->_tpl_vars['translate_set_up']; ?>
:</div>
                <div class="el-value">
                    <?php echo $this->_tpl_vars['control_cdate']; ?>

                    <a class="ob-link-edit" href="#"></a>
                </div>
            </div>
            <div class="data-edit">
                <a class="ob-link-delete" href="#"></a>
                <a class="ob-link-accept" href="#"></a>
                <input type="text" name="cdate" value="<?php echo $this->_tpl_vars['control_cdate']; ?>
"
                       class="js-datetime" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
            </div>
        </div>

        <div class="ob-data-element js-data-element">
            <div class="data-view">
                <div class="el-caption"><?php echo $this->_tpl_vars['translate_run_up']; ?>
:</div>
                <div class="el-value">
                    <?php echo $this->_tpl_vars['control_dateto']; ?>

                    <a class="ob-link-edit" href="#"></a>
                </div>
            </div>
            <div class="data-edit">
                <a class="ob-link-delete" href="#"></a>
                <a class="ob-link-accept" href="#"></a>
                <input type="text" name="dateto" value="<?php echo $this->_tpl_vars['control_dateto']; ?>
"
                       class="js-datetime" <?php if (! $this->_tpl_vars['canEdit']): ?> disabled <?php endif; ?> />
            </div>
        </div>

        <div class="ob-data-element js-data-element">
            <div class="data-view">
                <div class="el-caption"><?php echo $this->_tpl_vars['translate_responsible']; ?>
:</div>
                <div class="el-value">
                    <?php if ($this->_tpl_vars['managerName']): ?>
                        <a href="<?php if ($this->_tpl_vars['managerURL']): ?><?php echo $this->_tpl_vars['managerURL']; ?>
<?php else: ?>#<?php endif; ?>" class="js-contact-preview"
                           data-id="<?php echo $this->_tpl_vars['managerID']; ?>
"><?php echo $this->_tpl_vars['managerName']; ?>
</a>
                    <?php endif; ?>
                    <a class="ob-link-edit" href="#"></a>
                </div>
            </div>
            <div class="data-edit">
                <a class="ob-link-delete" href="#"></a>
                <a class="ob-link-accept" href="#"></a>
                <select name="manager" <?php if (! $this->_tpl_vars['canEdit']): ?>disabled<?php endif; ?> class="chzn-select">
                    <option value="">---</option>
                    <?php $_from = $this->_tpl_vars['managerArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_managerid']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </div>
        </div>

        <?php if ($this->_tpl_vars['sourceArray']): ?>
            <div class="ob-data-element js-data-element">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['translate_istochnik']; ?>
:</div>
                    <div class="el-value">
                        <?php echo $this->_tpl_vars['sourceName']; ?>

                        <a class="ob-link-edit" href="#"></a>
                    </div>
                </div>
                <div class="data-edit">
                    <a class="ob-link-delete" href="#"></a>
                    <a class="ob-link-accept" href="#"></a>
                    <select name="sourceid" <?php if (! $this->_tpl_vars['canEdit']): ?>disabled<?php endif; ?> class="chzn-select">
                        <option value="">---</option>
                        <?php $_from = $this->_tpl_vars['sourceArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_sourceid']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['customFieldArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['keyc'] => $this->_tpl_vars['c']):
?>
            <?php if (! $this->_tpl_vars['keyc']%2): ?>
                <div class="ob-data-element js-data-element">
                    <div class="data-view">
                        <div class="el-caption"><?php echo $this->_tpl_vars['c']['name']; ?>
:</div>
                        <div class="el-value">
                            <?php echo $this->_tpl_vars['c']['value']; ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>

        <?php $_from = $this->_tpl_vars['customFieldViewArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
            <div class="ob-data-element js-data-element">
                <div class="data-view">
                    <div class="el-caption"><?php echo $this->_tpl_vars['c']['name']; ?>
:</div>
                    <div class="el-value">
                        <?php echo $this->_tpl_vars['c']['value']; ?>
 <?php echo $this->_tpl_vars['c']['text']; ?>

                    </div>
                </div>
            </div>
        <?php endforeach; endif; unset($_from); ?>

        <div class="ob-data-empty"></div>
        <div class="ob-data-empty"></div>
        <div class="ob-data-empty"></div>
    </div>
</div>