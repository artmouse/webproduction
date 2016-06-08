<?php /* Smarty version 2.6.27-optimized, created on 2015-11-26 17:16:40
         compiled from /var/www/shop.local//templates/default//shop_basket_makeorder.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '/var/www/shop.local//templates/default//shop_basket_makeorder.html', 197, false),)), $this); ?>
<div class="os-crumbs">
    <a href="/"><?php echo $this->_tpl_vars['translate_main']; ?>
</a>
    <a href="/basket/"><?php echo $this->_tpl_vars['translate_my_basket']; ?>
</a>
    <?php echo $this->_tpl_vars['translate_checkout']; ?>

</div>

<h1 class="title"><?php echo $this->_tpl_vars['translate_checkout']; ?>
</h1>

<?php if ($this->_tpl_vars['userIsNotAuthorithed']): ?>
    <?php echo $this->_tpl_vars['translate__place_order_must_login']; ?>

    <a class="os-link-dashed" onclick="popupOpen('.js-popup-auth-block');" href="javascript: void(0);"><?php echo $this->_tpl_vars['translate_sign_in']; ?>
</a>
     <?php echo $this->_tpl_vars['translate_or']; ?>

    <a href="/registration/"><?php echo $this->_tpl_vars['translate_sing_up']; ?>
</a>.
<?php else: ?>
    <div class="os-makeorder-list">
        <div class="inner-makeorder-list">
            <table class="os-table">
                <thead>
                <tr>
                    <td colspan="2"><?php echo $this->_tpl_vars['translate_product']; ?>
</td>
                    <td class="ta-center"><?php echo $this->_tpl_vars['translate_sum_shorted']; ?>
</td>
                    <td class="ta-center"><?php echo $this->_tpl_vars['translate_total']; ?>
</td>
                </tr>
                </thead>
                <?php $_from = $this->_tpl_vars['basketArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['setid'] => $this->_tpl_vars['set']):
?>
                    <?php if ($this->_tpl_vars['setid'] > 0): ?>
                        <tr>
                            <td class="ta-center" colspan="4">
                                <?php echo $this->_tpl_vars['translate_nabor']; ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_tpl_vars['set']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
                        <tr class="va-top">
                            <td><img src="<?php echo $this->_tpl_vars['p']['image']; ?>
"></td>
                            <td class="name"><a href="<?php echo $this->_tpl_vars['p']['pUrl']; ?>
"><?php echo $this->_tpl_vars['p']['name']; ?>
</a></td>
                            <td class="ta-center">
                                <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                    <div class="count">
                                        <?php echo $this->_tpl_vars['p']['count']; ?>
 <?php echo $this->_tpl_vars['p']['unit']; ?>

                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($this->_tpl_vars['setid'] == 0): ?>
                                    <?php if ($this->_tpl_vars['p']['sum'] == '0.00'): ?>
                                        <div class="os-price-specify"><?php echo $this->_tpl_vars['translate_specify_price']; ?>
.</div>
                                    <?php else: ?>
                                        <div class="os-price-available"><?php echo $this->_tpl_vars['p']['sum']; ?>
 <?php echo $this->_tpl_vars['p']['currency']; ?>
</div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; unset($_from); ?>
                    <?php if ($this->_tpl_vars['setid'] > 0): ?>
                        <tr>
                            <td>
                                <?php echo $this->_tpl_vars['translate_tsena_nabora']; ?>

                            </td>
                            <td class="name">
                                <div class="os-price-available"><?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['one']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</div>
                            </td>
                            <td class="ta-center">
                                <div class="count">
                                    <?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['count']; ?>

                                </div>
                            </td>
                            <td>
                                <div class="os-price-available"><?php echo $this->_tpl_vars['setSumArray'][$this->_tpl_vars['setid']]['total']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <tr>
                    <td class="ta-right" colspan="3"><?php echo $this->_tpl_vars['translate_delivery']; ?>
:</td>
                    <td class="ta-right nowrap">
                        <div class="os-price-available"><span id="deliverySum"></span> <?php echo $this->_tpl_vars['currency']; ?>
</div>
                    </td>
                </tr>
                <?php if ($this->_tpl_vars['discountSum']): ?>
                    <tr>
                        <td class="ta-right" colspan="3"><?php echo $this->_tpl_vars['translate_discount']; ?>
:</td>
                        <td class="ta-right nowrap">
                            <div class="os-price-available"><?php echo $this->_tpl_vars['discountSum']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</div>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td class="ta-right" colspan="3"><?php echo $this->_tpl_vars['translate_in_total']; ?>
:</td>
                    <td class="ta-right nowrap">
                        <div class="os-price-available"><span id="allSum"><?php echo $this->_tpl_vars['allSum']; ?>
</span> <?php echo $this->_tpl_vars['currency']; ?>
</div>
                        <input type="hidden" id="allSumClear" value="<?php echo $this->_tpl_vars['allSum']; ?>
">
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <form class="os-makeorder-form" method="post">

        <?php if ($this->_tpl_vars['message'] == 'error'): ?>
            <div class="os-message-error">
                <?php if ($this->_tpl_vars['errorEmail']): ?>
                    <?php echo $this->_tpl_vars['translate_mail_error']; ?>

                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="js-makeorder-step">
            <?php if ($this->_tpl_vars['clientsearch']): ?>
                <div class="os-block-tabs">
                    <a href="#" class="settings-tab" data-rel="#settings-tab-0" onclick="return tab_me_click(); "><?php echo $this->_tpl_vars['translate_at_itself']; ?>
</a>
                    <a href="#" class="settings-tab" data-rel="#settings-tab-1" onclick="return tab_client_click();" ><?php echo $this->_tpl_vars['translate_at_client']; ?>
</a>
                    <a href="#" class="settings-tab" data-rel="#settings-tab-2" onclick="return tab_addNewUser_click();" ><?php echo $this->_tpl_vars['translate_create_client']; ?>
</a>
                    <div class="clear"></div>
                </div>
            <?php endif; ?>

            <div class="os-block-form">
                <?php if ($this->_tpl_vars['clientsearch']): ?>
                    <div id="settings-tab-1">
                        <table>
                            <tr>
                                <td style="width: 120px;"><?php echo $this->_tpl_vars['translate_checkout_a_client']; ?>
:</td>
                                <td>
                                    <input type="text" name="client" value="<?php echo $this->_tpl_vars['control_client']; ?>
" id="id-client"/>
                                    <span class="light"><?php echo $this->_tpl_vars['translate_enter_client_name']; ?>
</span>

                                    <div class="JSPrototypeAutocomplete" id="id-client-autocomplete"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endif; ?>
                <div id="settings-tab-2">

                </div>

                <table>
                    <tr>
                        <td><?php echo $this->_tpl_vars['translate_name_last']; ?>
<span class="important">*</span>:</td>
                        <td><?php echo $this->_tpl_vars['translate_name_small']; ?>
<span class="important">*</span>:</td>
                        <td><?php echo $this->_tpl_vars['translate_name_middle']; ?>
:</td>
                    </tr>
                    <tr class="vtop">
                        <input type="hidden" name="addnewuser" value="0" id="id-newuser" />
                        <td><input class="js-required" type="text" id="usernamelast" name="namelast" value="<?php echo $this->_tpl_vars['control_namelast']; ?>
" style="width: 134px;" /></td>
                        <td><input class="js-required" type="text" id="username" name="name" value="<?php echo $this->_tpl_vars['control_name']; ?>
" style="width: 133px;" /></td>
                        <td><input type="text" id="usernamemiddle" name="namemiddle" value="<?php echo $this->_tpl_vars['control_namemiddle']; ?>
" style="width: 133px;" /></td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <td class="vtop" style="width: 120px;"><?php echo $this->_tpl_vars['translate_typesex']; ?>
:</td>
                        <td>
                            <label>
                                <input type="radio" name="typesex" value="man" <?php if ($this->_tpl_vars['control_typesex'] == 'man'): ?>checked<?php endif; ?>>
                                <?php echo $this->_tpl_vars['translate_user_man']; ?>

                            </label> 
                            &nbsp;
                            <label>
                                <input type="radio" name="typesex" value="woman" <?php if ($this->_tpl_vars['control_typesex'] == 'woman'): ?>checked<?php endif; ?>>
                                <?php echo $this->_tpl_vars['translate_user_woman']; ?>

                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="vtop" style="width: 120px;"><?php echo $this->_tpl_vars['translate_phone']; ?>
<span class="important">*</span>:</td>
                        <td>
                            <input type="text" id="userphone" name="phone" value="<?php echo $this->_tpl_vars['control_phone']; ?>
" class="js-required js-phone-formatter"/>
                            <span class="light"><?php echo $this->_tpl_vars['translate_example']; ?>
: 380672345667</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="vtop">
                            E-mail
                            <?php if ($this->_tpl_vars['requiredEmail']): ?>
                                <span class="important">*</span>
                            <?php endif; ?>
                            :
                        </td>
                        <td>
                            <input type="text" id="useremail" name="email"
                                   value="<?php echo $this->_tpl_vars['control_email']; ?>
" <?php if ($this->_tpl_vars['requiredEmail']): ?>class="js-required"<?php endif; ?>/>
                            <br/><span class="light"> <?php echo $this->_tpl_vars['translate_makeorder_email_message']; ?>
</span>
                        </td>
                    </tr>

                    <?php if ($this->_tpl_vars['deliveryArray']): ?>
                        <tr>
                            <td colspan="2">
                                <div class="caption-td"><?php echo $this->_tpl_vars['translate_delivery_way']; ?>
<span class="important">*</span>:</div>
                                <ul class="delivery-ways">
                                    <?php $_from = $this->_tpl_vars['deliveryArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['d']):
?>
                                        <li data-amount="<?php echo $this->_tpl_vars['d']['price']; ?>
" data-paydelivery="<?php echo $this->_tpl_vars['d']['paydelivery']; ?>
" data-id="<?php echo $this->_tpl_vars['d']['id']; ?>
" <?php if ($this->_tpl_vars['d']['selected']): ?>class="selected"<?php endif; ?>>
                                            <span class="price"><?php echo ((is_array($_tmp=$this->_tpl_vars['d']['price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</span>
                                            <a class="js-content-delivery-ajax js-select-delivery" data-amount="<?php echo $this->_tpl_vars['d']['price']; ?>
" data-paydelivery="<?php echo $this->_tpl_vars['d']['paydelivery']; ?>
" data-id="<?php echo $this->_tpl_vars['d']['id']; ?>
" href="javascript:void(0);" onclick="$j('#js-delivery').val($j(this).data('id'));"><?php echo $this->_tpl_vars['d']['name']; ?>
</a>
                                        </li>
                                    <?php endforeach; endif; unset($_from); ?>
                                </ul>
                                <input class="js-required" id="js-delivery" data-error="<?php echo $this->_tpl_vars['translate_delivery_way']; ?>
" type="hidden" name="delivery" value="<?php echo $this->_tpl_vars['deliveryDefault']; ?>
">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="no-padding" id="js-content-delivery-block">

                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td style="width: 120px;"><?php echo $this->_tpl_vars['translate_makeorder_forpresent']; ?>
:</td>
                        <td><input type="checkbox" name="gift" value="1"></td>
                    </tr>
                    <?php if ($this->_tpl_vars['paymentArray']): ?>
                        <tr>
                            <td><?php echo $this->_tpl_vars['translate_payment_method']; ?>
:</td>
                            <td>
                                <?php $_from = $this->_tpl_vars['paymentArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['paymentForeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['paymentForeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['p']):
        $this->_foreach['paymentForeach']['iteration']++;
?>
                                    <select id="payment<?php echo $this->_tpl_vars['key']; ?>
" name="payment" <?php if (! ($this->_foreach['paymentForeach']['iteration'] <= 1)): ?> style="display: none; width: 350px;" disabled<?php endif; ?>>
                                        <option value="0"><?php echo $this->_tpl_vars['translate_makeorder_waytopay']; ?>
</option>
                                        <?php $_from = $this->_tpl_vars['p']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['p2']):
?>
                                            <option value="<?php echo $this->_tpl_vars['id']; ?>
" <?php if ($this->_tpl_vars['p2']['selected']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['p2']['name']; ?>
</option>
                                        <?php endforeach; endif; unset($_from); ?>
                                    </select>
                                <?php endforeach; endif; unset($_from); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="vtop" style="width: 120px;"><?php echo $this->_tpl_vars['translate_notes']; ?>
:</td>
                        <td><textarea name="comments"><?php echo $this->_tpl_vars['control_comments']; ?>
</textarea></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <label>
                                <input type="checkbox" <?php if (! $this->_tpl_vars['used_user_info']): ?>style="display: none;"<?php endif; ?> checked name="zakon" value="1" onclick="this.checked ? $j('#demail').removeAttr('disabled') : $j('#demail').attr('disabled', 'disabled');"/>
                                <span class="light"><?php echo $this->_tpl_vars['used_user_info']; ?>
</span>
                            </label>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="makeorder-buttons">
                <a href="/"> <?php echo $this->_tpl_vars['translate_continue']; ?>
 <?php echo $this->_tpl_vars['translate_buying']; ?>
</a>
                <input type="hidden" name="ajs" class="ajs" value="1"/>
                <input class="os-submit green js-form-validation" type="submit" id="demail" name="makeorder" value="<?php echo $this->_tpl_vars['translate_place_an_order']; ?>
" />
            </div>
        </div>
    </form>
    <div class="clear"></div>
<?php endif; ?>

<script>
    $j('.js-basket, nav').hide();
</script>