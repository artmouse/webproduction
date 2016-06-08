<?php /* Smarty version 2.6.27-optimized, created on 2015-11-09 14:02:05
         compiled from /var/www/shop.local/contents/shop/admin/customorder/issue_add.html */ ?>
<?php if ($this->_tpl_vars['message'] == 'ok'): ?>
    <div class="shop-message-success">
        <?php echo $this->_tpl_vars['typeName']; ?>
 <?php if ($this->_tpl_vars['messageIssueInfo']): ?><a href="<?php echo $this->_tpl_vars['messageIssueInfo']['url']; ?>
">#<?php echo $this->_tpl_vars['messageIssueInfo']['id']; ?>
</a><?php endif; ?> <?php echo $this->_tpl_vars['translate_uspeshno_sozdan']; ?>
.
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'error'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_oshibka_sozdaniya_imya_biznes_protses_zadachi_obyazatelno']; ?>
.
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['urlredirect']): ?>
    <script type="text/javascript">
        document.location = '<?php echo $this->_tpl_vars['urlredirect']; ?>
';
    </script>
<?php endif; ?>

<h1><?php echo $this->_tpl_vars['translate_add']; ?>
 <?php echo $this->_tpl_vars['typeName']; ?>
</h1>
<br />

<form action="" method="post" onsubmit="shopWaitShow('<?php echo $this->_tpl_vars['translate_vipolnyaetsya_sohranenie']; ?>
.');" >
    <div class="ob-block-doubleform">
        <div class="wrap">
            <div class="left-column">
                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_box_name_small']; ?>
</div>
                    <input type="text" name="issue_name" class="js-issuename" value="<?php if (! $this->_tpl_vars['clearFields']): ?><?php echo $this->_tpl_vars['control_issue_name']; ?>
<?php endif; ?>" />
                </div>
                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_description']; ?>
</div>
                    <textarea name="content" style="height: 100px;" class="js-autosize" rows="5"><?php if (! $this->_tpl_vars['clearFields']): ?><?php echo $this->_tpl_vars['control_content']; ?>
<?php endif; ?></textarea>
                </div>

                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_k_kakomu_proektu_otnositsya']; ?>
?</div>
                    <input type="text" id="js-parent-name" name="parentid" value="<?php echo $this->_tpl_vars['control_parentid']; ?>
" />
                    <?php if ($this->_tpl_vars['lastProject']): ?>
                        <?php echo $this->_tpl_vars['translate_poslednie_proekti']; ?>
 <br />
                        <?php $_from = $this->_tpl_vars['lastProject']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <a href="#" class="last-project" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
"><small>#<?php echo $this->_tpl_vars['e']['id']; ?>
 <?php echo $this->_tpl_vars['e']['name']; ?>
</small></a><br>
                        <?php endforeach; endif; unset($_from); ?>
                    <?php endif; ?>
                </div>
                
                <div class="double">
                    <div class="form-element">
                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_srok_ispolneniya']; ?>
?</div>
                        <input type="text" name="dateto" value="<?php echo $this->_tpl_vars['control_dateto']; ?>
" class="js-datetime js-dateto"/>
                    </div>

                    <div class="form-element">
                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_kogda_start']; ?>
?</div>
                        <input type="text" name="datefrom" value="<?php echo $this->_tpl_vars['control_datefrom']; ?>
" class="js-datetime"/>
                    </div>
                </div>

                <div class="form-element">
                    <a class="ob-link-dashed" href="javascript:void(0);" onclick="$j('.js-result-block').slideToggle();"><?php echo $this->_tpl_vars['translate_dopolnitelnie_nastroyki']; ?>
</a>
                </div>

                <div class="js-result-block" style="display: block;">
                    <div class="form-element">
                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_v_kakom_vide_dolzhen_bit_rezultat']; ?>
?</div>
                        <textarea name="result" style="height: 100px;" class="js-autosize" rows="5"><?php if (! $this->_tpl_vars['clearFields']): ?><?php echo $this->_tpl_vars['control_result']; ?>
<?php endif; ?></textarea>
                    </div>

                    <div class="double">
                        <div class="form-element">
                            <div class="element-caption"><?php echo $this->_tpl_vars['translate_otsenochnoe_vremya']; ?>
 <span>(ч.)</span></div>
                            <input type="text" name="estimatetime" value="<?php echo $this->_tpl_vars['control_estimatetime']; ?>
"/>
                        </div>

                        <div class="form-element">
                            <div class="element-caption"><?php echo $this->_tpl_vars['translate_otsenochnie_dengi']; ?>
 <span>(<?php echo $this->_tpl_vars['currency']; ?>
)</span></div>
                            <input type="text" name="estimatemoney" value="<?php echo $this->_tpl_vars['control_estimatemoney']; ?>
"/>
                        </div>
                    </div>

                    <div class="form-element">
                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_prochie_resursi']; ?>
</div>
                        <textarea name="resource" style="height: 100px;" class="js-autosize" rows="5"><?php if (! $this->_tpl_vars['clearFields']): ?><?php echo $this->_tpl_vars['control_resource']; ?>
<?php endif; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="right-column">
                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_contact']; ?>
</div>
                    <input type="text" name="clientname" id="id-clientid-name" value="<?php echo $this->_tpl_vars['control_clientname']; ?>
" placeholder="<?php echo $this->_tpl_vars['translate_client_select']; ?>
" />
                    <input type="hidden" name="clientid" id="id-clientid-value" value="<?php echo $this->_tpl_vars['control_clientid']; ?>
"/>
                </div>

                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_workflow']; ?>
</div>
                    <select name="workflowid" class="js-workflowid chzn-select" id="js-workflow">
                        <option value="0">---</option>
                        <?php $_from = $this->_tpl_vars['workflowArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_workflowid']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>

                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_kto_otvetstvenniy']; ?>
?</div>
                    <select id="managerid" name="managerid" class="chzn-select js-managerid" style="width: 100%;">
                        <?php $_from = $this->_tpl_vars['managerArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['selected']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="js-workflow-container"></div>

    <input type="hidden" value="eventid" value="<?php echo $this->_tpl_vars['eventid']; ?>
" />

    <div class="ob-button-fixed">
        <input type="submit" name="ok" value="<?php echo $this->_tpl_vars['translate_save']; ?>
" class="ob-button button-green" />
        <input type="submit" name="oknext" value="<?php echo $this->_tpl_vars['translate_save_plus_add']; ?>
" class="ob-button" />
    </div>
    <div class="ob-button-fixed-place"></div>
</form>
<input id="js-user-id" type="hidden" value="<?php echo $this->_tpl_vars['userId']; ?>
">

<?php if ($this->_tpl_vars['block_event']): ?>
    <?php echo $this->_tpl_vars['block_event']; ?>

<?php endif; ?>