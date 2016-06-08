<?php /* Smarty version 2.6.27-optimized, created on 2015-12-17 00:05:44
         compiled from /var/www/shop.local/modules/document/contents//document/document_table_block.html */ ?>
<div class="filter-toggle <?php if ($this->_tpl_vars['filterpanelCookie']): ?>open<?php endif; ?>"></div>
<div class="shop-filter-panel <?php if ($this->_tpl_vars['filterpanelCookie']): ?>open<?php endif; ?>">
    <div class="inner-pannel">
        <form action="" method="get">
            <div class="element">
                <input type="hidden" name="filter1_key" value="number" />
                <input type="hidden" name="filter1_type" value="search" />
                <input type="text" name="filter1_value" value="<?php echo $this->_tpl_vars['control_filter1_value']; ?>
" placeholder="Номер" />
            </div>

            <div class="element">
                <input type="hidden" name="filter2_key" value="name" />
                <input type="hidden" name="filter2_type" value="search" />
                <input type="text" name="filter2_value" value="<?php echo $this->_tpl_vars['control_filter2_value']; ?>
" placeholder="Название" />
            </div>

            <div class="element">
                <div class="caption-field">Направление</div>
                <select name="filterdirection" class="chzn-select">
                    <option value="">Все</option>
                    <option value="in" <?php if ('in' == $this->_tpl_vars['control_filterdirection']): ?> selected <?php endif; ?>>Входящие</option>
                    <option value="out" <?php if ('our' == $this->_tpl_vars['control_filterdirection']): ?> selected <?php endif; ?>>Исходящие</option>
                    <option value="our" <?php if ('out' == $this->_tpl_vars['control_filtertdirection']): ?> selected <?php endif; ?>>Внутренние</option>
                </select>
            </div>

            <?php if ($this->_tpl_vars['groupArray']): ?>
                <div class="element">
                    <div class="caption-field">Группа</div>
                    <select name="filtergroupname" class="chzn-select">
                        <option value="">Все группы</option>
                        <?php $_from = $this->_tpl_vars['groupArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <option value="<?php echo $this->_tpl_vars['e']; ?>
" <?php if ($this->_tpl_vars['e'] == $this->_tpl_vars['control_filtergroupname']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="element">
                <div class="caption-field">Подгруппа</div>
                <select name="filtertemplateid" class="chzn-select">
                    <option value="">Все шаблоны</option>
                    <?php $_from = $this->_tpl_vars['templateArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                        <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['id'] == $this->_tpl_vars['control_filtertemplateid']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </div>

            <div class="element">
                <div class="caption-field">Автор</div>
                <input type="hidden" name="filter3_key" value="userid" />
                <input type="hidden" name="filter3_type" value="equals" />
                <select name="filter3_value" class="chzn-select">
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

            <div class="element">
                <div class="caption-field"><?php echo $this->_tpl_vars['translate_ord']; ?>
</div>
                <input type="hidden" name="filterorderid" value="<?php echo $this->_tpl_vars['control_filterorderid']; ?>
" class="js-select2 js-select2-orderid" data-url="/admin/shop/order/jsonautocomplete/select2/" style="width: 200px;" />
                <script type="text/javascript">
                $j(function () {
                    var tags = [
                        <?php $_from = $this->_tpl_vars['filterOrderArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foreach2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foreach2']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['p']):
        $this->_foreach['foreach2']['iteration']++;
?>
                            {'id':<?php echo $this->_tpl_vars['p']['id']; ?>
, 'text':'<?php echo $this->_tpl_vars['p']['text']; ?>
'}
                            <?php if (! ($this->_foreach['foreach2']['iteration'] == $this->_foreach['foreach2']['total'])): ?>,<?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                    ];

                    $j(".js-select2-orderid").select2('data', tags);
                });
                </script>
            </div>

            <div class="element ulist">
                <label>
                    <input type="radio" name="status" value="new" <?php if ($this->_tpl_vars['control_status'] == 'new'): ?>checked<?php endif; ?>>
                    Сформирован
                </label>
            </div>

            <div class="element ulist">
                <label>
                    <input type="radio" name="status" value="sent" <?php if ($this->_tpl_vars['control_status'] == 'sent'): ?>checked<?php endif; ?>>
                    Отправлен
                </label>
            </div>

            <div class="element ulist">
                <label>
                    <input type="radio" name="status" value="recieved" <?php if ($this->_tpl_vars['control_status'] == 'recieved'): ?>checked<?php endif; ?>>
                    Получен
                </label>
            </div>

            <div class="element ulist">
                <label>
                    <input type="radio" name="status" value="archive" <?php if ($this->_tpl_vars['control_status'] == 'archive'): ?>checked<?php endif; ?>>
                    В архиве
                </label>
            </div>

            <div class="element">
                <input type="hidden" name="filter8_key" value="cdate" />
                <input type="hidden" name="filter8_type" value="gte" />
                <input type="text" class="js-date" name="filter8_value" value="<?php echo $this->_tpl_vars['control_filter8_value']; ?>
" placeholder="Дата формирования от" />
            </div>

            <div class="element">
                <input type="hidden" name="filter9_key" value="cdate" />
                <input type="hidden" name="filter9_type" value="lte" />
                <input type="text" class="js-date" name="filter9_value" value="<?php echo $this->_tpl_vars['control_filter9_value']; ?>
" placeholder="Дата формирования до" />
            </div>

            <div class="element">
                <input type="hidden" name="filter10_key" value="sdate" />
                <input type="hidden" name="filter10_type" value="gte" />
                <input type="text" class="js-date" name="filter10_value" value="<?php echo $this->_tpl_vars['control_filter10_value']; ?>
" placeholder="Дата отправки от" />
            </div>

            <div class="element">
                <input type="hidden" name="filter11_key" value="sdate" />
                <input type="hidden" name="filter11_type" value="lte" />
                <input type="text" class="js-date" name="filter11_value" value="<?php echo $this->_tpl_vars['control_filter11_value']; ?>
" placeholder="Дата отправки до" />
            </div>

            <div class="element">
                <input type="hidden" name="filter12_key" value="bdate" />
                <input type="hidden" name="filter12_type" value="gte" />
                <input type="text" class="js-date" name="filter12_value" value="<?php echo $this->_tpl_vars['control_filter12_value']; ?>
" placeholder="Дата получения от" />
            </div>

            <div class="element">
                <input type="hidden" name="filter13_key" value="bdate" />
                <input type="hidden" name="filter13_type" value="lte" />
                <input type="text" class="js-date" name="filter13_value" value="<?php echo $this->_tpl_vars['control_filter13_value']; ?>
" placeholder="Дата получения до" />
            </div>

            <div class="element">
                <input type="hidden" name="filter14_key" value="adate" />
                <input type="hidden" name="filter14_type" value="gte" />
                <input type="text" class="js-date" name="filter14_value" value="<?php echo $this->_tpl_vars['control_filter14_value']; ?>
" placeholder="Дата архивации от" />
            </div>

            <div class="element">
                <input type="hidden" name="filter15_key" value="adate" />
                <input type="hidden" name="filter15_type" value="lte" />
                <input type="text" class="js-date" name="filter15_value" value="<?php echo $this->_tpl_vars['control_filter15_value']; ?>
" placeholder="Дата архивации до" />
            </div>

            <div class="element">
                <input type="hidden" name="filter16_key" value="edate" />
                <input type="hidden" name="filter16_type" value="gte" />
                <input type="text" class="js-date" name="filter16_value" value="<?php echo $this->_tpl_vars['control_filter16_value']; ?>
" placeholder="Срок окончания от" />
            </div>

            <div class="element">
                <input type="hidden" name="filter17_key" value="edate" />
                <input type="hidden" name="filter17_type" value="lte" />
                <input type="text" class="js-date" name="filter17_value" value="<?php echo $this->_tpl_vars['control_filter17_value']; ?>
" placeholder="Срок окончания до" />
            </div>

            <input class="ob-button button-orange help-hint-filter-submit" type="submit" value="<?php echo $this->_tpl_vars['translate_filter']; ?>
" />
        </form>
    </div>
</div>

<div class="shop-result-list">
    <div class="inner-list <?php if ($this->_tpl_vars['filterpanelCookie']): ?>filter-reserve<?php endif; ?>">
    <?php echo $this->_tpl_vars['table']; ?>

    <div class="js-table-footer"></div>
    </div>
</div>
<div class="clear"></div>