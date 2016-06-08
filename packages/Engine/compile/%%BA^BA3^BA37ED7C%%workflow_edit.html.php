<?php /* Smarty version 2.6.27-optimized, created on 2015-11-26 17:57:11
         compiled from /var/www/shop.local/contents/shop/admin/workflow/workflow_edit.html */ ?>
<div class="nb-top-nav-place js-top-nav-buffer"></div>
<div class="nb-top-nav js-top-nav">
    <div class="nb-block-tabs">
        <div class="tab-element"><a href="/admin/shop/workflow/">&lsaquo; <?php echo $this->_tpl_vars['translate_biznes_protsessi']; ?>
</a></div>
        <div class="tab-element"><a href="/admin/shop/workflow/<?php echo $this->_tpl_vars['categoryid']; ?>
/" class="selected"><?php echo $this->_tpl_vars['translate_workflow']; ?>
 <?php echo $this->_tpl_vars['name']; ?>
</a></div>
        <div class="tab-element"><a href="./delete/" ><?php echo $this->_tpl_vars['translate_delete']; ?>
</a></div>
        <div class="clear"></div>
    </div>
</div>

<?php if ($this->_tpl_vars['edit_ok']): ?>
    <div class="shop-message-success">
        <?php echo $this->_tpl_vars['translate_protsess_uspeshno_sohranen']; ?>
.
    </div>
<?php endif; ?>

<h1><?php echo $this->_tpl_vars['translate_redaktirovanie_biznes_protsessa']; ?>
</h1>
<br />

<form action="" method="post">
    <?php if ($this->_tpl_vars['elementArray'] && ( $this->_tpl_vars['box'] || $this->_tpl_vars['workflowVisualEnable'] )): ?>
        <?php $_from = $this->_tpl_vars['elementArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <?php $_from = $this->_tpl_vars['elementArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e1']):
?>
                <input type="hidden" class="js-state js-connection-<?php echo $this->_tpl_vars['e']['id']; ?>
-<?php echo $this->_tpl_vars['e1']['id']; ?>
" name="change<?php echo $this->_tpl_vars['e']['id']; ?>
_<?php echo $this->_tpl_vars['e1']['id']; ?>
"
                data-from=<?php echo $this->_tpl_vars['e']['id']; ?>

                data-to=<?php echo $this->_tpl_vars['e1']['id']; ?>

                <?php if ($this->_tpl_vars['changesArray'][$this->_tpl_vars['e']['id']][$this->_tpl_vars['e1']['id']] || $this->_tpl_vars['e']['id'] == $this->_tpl_vars['e1']['id']): ?>
                    value="1"
                <?php else: ?>
                    value="0"
                <?php endif; ?>
                />
            <?php endforeach; endif; unset($_from); ?>
        <?php endforeach; endif; unset($_from); ?>

                <div class="onebox-workflow-layout" style="height: 350px;">
            <?php $_from = $this->_tpl_vars['elementArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                <div id="js-wfe-<?php echo $this->_tpl_vars['e']['id']; ?>
" class="onebox-workflow-element" data-id=<?php echo $this->_tpl_vars['e']['id']; ?>

                style="left: <?php echo $this->_tpl_vars['e']['positionx']; ?>
px; top: <?php echo $this->_tpl_vars['e']['positiony']; ?>
px; width: <?php echo $this->_tpl_vars['e']['width']; ?>
px; height: <?php echo $this->_tpl_vars['e']['height']; ?>
px; <?php if ($this->_tpl_vars['e']['colour']): ?> background-color: <?php echo $this->_tpl_vars['e']['colour']; ?>
; <?php endif; ?>">
                    <span class="inner"><?php echo $this->_tpl_vars['e']['name']; ?>
</span>
                </div>
            <?php endforeach; endif; unset($_from); ?>
        </div>

                <?php $_from = $this->_tpl_vars['elementArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <input type="hidden" name="position_<?php echo $this->_tpl_vars['e']['id']; ?>
_x" value="<?php echo $this->_tpl_vars['e']['positionx']; ?>
" id="js-position-<?php echo $this->_tpl_vars['e']['id']; ?>
-x" />
            <input type="hidden" name="position_<?php echo $this->_tpl_vars['e']['id']; ?>
_y" value="<?php echo $this->_tpl_vars['e']['positiony']; ?>
" id="js-position-<?php echo $this->_tpl_vars['e']['id']; ?>
-y" />
            <input type="hidden" name="position_<?php echo $this->_tpl_vars['e']['id']; ?>
_width" value="<?php echo $this->_tpl_vars['e']['width']; ?>
" id="js-position-<?php echo $this->_tpl_vars['e']['id']; ?>
-width" />
            <input type="hidden" name="position_<?php echo $this->_tpl_vars['e']['id']; ?>
_height" value="<?php echo $this->_tpl_vars['e']['height']; ?>
" id="js-position-<?php echo $this->_tpl_vars['e']['id']; ?>
-height" />
        <?php endforeach; endif; unset($_from); ?>
        <br />
        <br />
    <?php endif; ?>

    <div class="ob-block-doubleform">
        <div class="wrap">
            <div class="left-column">
                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_nazvanie_protsessa']; ?>
</div>
                    <input type="text" name="name" value="<?php echo $this->_tpl_vars['name']; ?>
" />
                </div>

                <?php if ($this->_tpl_vars['box']): ?>
                    <div class="double">
                        <div class="form-element">
                            <div class="element-caption"><?php echo $this->_tpl_vars['translate_prednaznachen_dlya']; ?>
</div>
                            <select class="chzn-select" name="type">
                                <?php $_from = $this->_tpl_vars['workflowTypeArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['t']):
?>
                                    <option value="<?php echo $this->_tpl_vars['t']['type']; ?>
" <?php if ($this->_tpl_vars['t']['selected']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['t']['name']; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </div>

                        <div class="form-element">
                            <div class="element-caption"><?php echo $this->_tpl_vars['translate_currency_default']; ?>
</div>
                            <select class="chzn-select" name="currency">
                                <option value="0">---</option>
                                <?php $_from = $this->_tpl_vars['currencyArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['currency']):
?>
                                    <option value="<?php echo $this->_tpl_vars['currency']['id']; ?>
"
                                            <?php if ($this->_tpl_vars['currency']['selected']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['currency']['name']; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="form-element">
                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_product_list']; ?>
</div>
                        <ul id="js-product-tag" data-input="#js-product-input" style="height: 50px;"></ul>
                        <input id="js-product-input" type="text" name="productlist" value="<?php echo $this->_tpl_vars['control_productlist']; ?>
" style="display: none;"/>
                    </div>

                    <div class="form-element">
                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_rekomenduemiy_srok_zhizni_biznes_protsessa']; ?>
</div>
                        <input type="text" name="term" value="<?php echo $this->_tpl_vars['control_term']; ?>
" style="width: 50px;" /> <?php echo $this->_tpl_vars['translate_dney']; ?>

                    </div>
                    <div class="form-element">
                        <div class="element-caption">Цвет меню</div>
                        <input type="text" class="js-color" name="color_menu" value="<?php echo $this->_tpl_vars['control_color_menu']; ?>
" style="width: 80px;" />
                    </div>

                    <div class="form-element">
                        <label>
                            <input type="checkbox" value="1" name="noautodateto" <?php if ($this->_tpl_vars['control_noautodateto']): ?> checked <?php endif; ?> />
                            <?php echo $this->_tpl_vars['translate_ne_ustanavlivat_srok_zhizni_biznes_protsessa_avtomaticheski']; ?>

                        </label>
                    </div>
                <?php endif; ?>

                <div class="form-element">
                    <label>
                        <input type="checkbox" value="1" name="workflowdefault" <?php if ($this->_tpl_vars['control_workflowdefault']): ?> checked <?php endif; ?> />
                        <?php echo $this->_tpl_vars['translate_eto_biznes_protsess_po_umolchaniyu_dlya_novih_zakazov_ili_zadach']; ?>

                    </label>
                </div>

                <?php if ($this->_tpl_vars['box']): ?>
                    <div class="form-element">
                        <strong><?php echo $this->_tpl_vars['translate_klyuchevie_slova']; ?>
</strong> <?php echo $this->_tpl_vars['translate_v_nazvanii_zadachi_po_kotorim_sistema_avtomaticheski_viberet_etot_protsess']; ?>
:<br />
                        <textarea name="keywords" class="js-autosize"><?php echo $this->_tpl_vars['control_keywords']; ?>
</textarea>
                        <br />
                        <br />
                    </div>


                <?php endif; ?>
            </div>
            <div class="right-column">
                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_napravlenie_zakaza_proekta_zadachi']; ?>
</div>
                    <select class="chzn-select" name="outcoming">
                        <option value="0"><?php echo $this->_tpl_vars['translate_vhodyashchiy']; ?>
</option>
                        <option value="1" <?php if ($this->_tpl_vars['control_outcoming']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['translate_ishodyashchiy']; ?>
</option>
                    </select>
                </div>

                <?php if ($this->_tpl_vars['box']): ?>
                    <div class="form-element">
                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_shablon_imeni_dlya_novoy_zadachi']; ?>
</div>
                        <input type="text" name="issuename" value="<?php echo $this->_tpl_vars['control_issuename']; ?>
" />
                    </div>

                    <div class="form-element">
                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_otvetstvenniy_dlya_starta_novih_zadach']; ?>
</div>
                        <select name="managerid" class="chzn-select">
                            <option value="0">---</option>
                            <?php $_from = $this->_tpl_vars['managerArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_managerid']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </div>

                    <div class="form-element">
                        <label>
                            <input type="checkbox" value="1" name="hidden" <?php if ($this->_tpl_vars['control_hidden']): ?> checked <?php endif; ?> />
                            <?php echo $this->_tpl_vars['translate_ustarevshiy_protsess_skritiy_']; ?>

                        </label>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="shop-overflow-table">
        <table class="shop-table">
            <thead>
                <tr>
                    <td></td>
                    <td align="center" width="30">ID</td>
                    <td><?php echo $this->_tpl_vars['translate_etap']; ?>
</td>

                    <?php if ($this->_tpl_vars['box']): ?>
                        <td><?php echo $this->_tpl_vars['translate_rol']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['translate_opisanie_etapa']; ?>
</td>
                    <?php endif; ?>

                    <td><?php echo $this->_tpl_vars['translate_startoviy']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['translate_tsvet']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['translate_settings']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['translate_delete']; ?>
?</td>
                </tr>
            </thead>
            <tbody class="js-wfstage-sort">
                <?php $_from = $this->_tpl_vars['elementArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                    <tr>
                        <td><div class="move"></div></td>
                        <td align="center">#<?php echo $this->_tpl_vars['e']['id']; ?>
</td>
                        <td>
                            <input type="text" name="name_<?php echo $this->_tpl_vars['e']['id']; ?>
" value="<?php echo $this->_tpl_vars['e']['name']; ?>
" style="width: 300px;" />
                        </td>

                        <?php if ($this->_tpl_vars['box']): ?>
                            <td>
                                <select class="chzn-select-tree" name="role_<?php echo $this->_tpl_vars['e']['id']; ?>
">
                                    <option>---</option>
                                    <?php $_from = $this->_tpl_vars['roleArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['role']):
?>
                                        <option value="<?php echo $this->_tpl_vars['role']['id']; ?>
" <?php if ($this->_tpl_vars['role']['id'] == $this->_tpl_vars['e']['roleid']): ?> selected <?php endif; ?> data-level="<?php echo $this->_tpl_vars['role']['level']; ?>
">
                                            <?php echo $this->_tpl_vars['role']['name']; ?>

                                        </option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                            </td>
                            <td>
                                <textarea name="description_<?php echo $this->_tpl_vars['e']['id']; ?>
" style="width: 300px;" class="js-autosize" rows="1"><?php echo $this->_tpl_vars['e']['description']; ?>
</textarea>
                            </td>
                        <?php endif; ?>

                        <td align="center">
                            <input type="radio" name="default" value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['default']): ?> checked <?php endif; ?> />
                        </td>
                        <td>
                            <input type="text" class="js-color" name="colour_<?php echo $this->_tpl_vars['e']['id']; ?>
" value="<?php echo $this->_tpl_vars['e']['colour']; ?>
" style="width: 80px;" />
                        </td>
                        <td>
                            <a href="<?php echo $this->_tpl_vars['e']['urlEdit']; ?>
" ><?php echo $this->_tpl_vars['translate_settings']; ?>
</a>
                            <?php if ($this->_tpl_vars['box']): ?>
                                <a href="<?php echo $this->_tpl_vars['e']['urlInterface']; ?>
" ><?php echo $this->_tpl_vars['translate_interfeys']; ?>
</a>
                            <?php endif; ?>
                            <a href="<?php echo $this->_tpl_vars['e']['urlAction']; ?>
" ><?php echo $this->_tpl_vars['translate_motion']; ?>
</a>
                        </td>
                        <td align="center">
                            <input type="checkbox" name="delete_<?php echo $this->_tpl_vars['e']['id']; ?>
" value="1" />
                            <input type="hidden" class="js-sort-value" name="sort_<?php echo $this->_tpl_vars['e']['id']; ?>
" value="<?php echo $this->_tpl_vars['e']['sort']; ?>
" />
                        </td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2" align="center"><?php echo $this->_tpl_vars['translate_dobavit_etap']; ?>
</td>
                    <td>
                        <textarea class="js-autosize" name="element_name" placeholder="<?php echo $this->_tpl_vars['translate_nazvanie_etapov']; ?>
" style="width: 300px;"><?php echo $this->_tpl_vars['element_name']; ?>
</textarea>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="ob-button-fixed">
        <input type="submit" name="send_edit" value="<?php echo $this->_tpl_vars['translate_save']; ?>
" <?php if ($this->_tpl_vars['confirmDefault'] && $this->_tpl_vars['confirmDefault'] != $this->_tpl_vars['categoryid']): ?>onclick="return confirmDefault();"<?php endif; ?> class="ob-button button-green" />
    </div>
    <div class="ob-button-fixed-place"></div>

    <script type="text/javascript">
        $j(function(){
            <?php $_from = $this->_tpl_vars['productsDefaultArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prod']):
?>
                $j("#js-product-tag").tagit("createTag", "<?php echo $this->_tpl_vars['prod']; ?>
");
            <?php endforeach; endif; unset($_from); ?>
        });

        function confirmDefault () {
            if ($j('input[name="workflowdefault"]').prop('checked')) {
                return confirm("<?php echo $this->_tpl_vars['translate_bizness_protsess_po_umolchaniyu_uzhe_est']; ?>
.\n<?php echo $this->_tpl_vars['translate_nazhmite_da_chtobi_vibrat_etot_i_sbrosit_ostalnie']; ?>
");
            }
        }
    </script>
</form>

<?php echo $this->_tpl_vars['smartyContentBlock']; ?>