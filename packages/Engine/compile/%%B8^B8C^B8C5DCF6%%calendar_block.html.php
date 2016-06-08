<?php /* Smarty version 2.6.27-optimized, created on 2015-12-02 18:05:32
         compiled from /var/www/shop.local/modules/box/contents//admin/order/mode/calendar/calendar_block.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '/var/www/shop.local/modules/box/contents//admin/order/mode/calendar/calendar_block.html', 36, false),array('modifier', 'date_format', '/var/www/shop.local/modules/box/contents//admin/order/mode/calendar/calendar_block.html', 81, false),array('modifier', 'escape', '/var/www/shop.local/modules/box/contents//admin/order/mode/calendar/calendar_block.html', 97, false),)), $this); ?>
<div class="js-calendar-block">
    <div class="shop-block-calendar">
        <div class="by-week js-by-week" <?php if ($this->_tpl_vars['weekMonth'] != 'week'): ?>style="display: none;"<?php endif; ?> >
            <div class="calendar-head">
                <div class="legend">
                    <em>
                        <span class="ob-icon-done"></span>
                        <?php echo $this->_tpl_vars['translate_done_zadacha']; ?>

                    </em>
                    <em>
                        <span class="ob-icon-new"></span>
                        <?php echo $this->_tpl_vars['translate_novaya_zadacha']; ?>

                    </em>
                    <em>
                        <span class="ob-icon-overdue"></span>
                        <?php echo $this->_tpl_vars['translate_srochnaya_zadacha']; ?>

                    </em>
                </div>

                <div class="block-name">
                     Мой бокс на
                    <span class="toggle-name"><?php echo $this->_tpl_vars['dataMonthName']['month']; ?>
 <?php echo $this->_tpl_vars['dataMonthName']['year']; ?>
</span>
                </div>

                <div class="tabs">
                    <a class="js-week-next-prev prev" href="#">&lsaquo;</a>
                    <a class="js-calendar-today today" href="#"><?php echo $this->_tpl_vars['translate_segodnya']; ?>
</a>
                    <a class="js-week-next-prev next" href="#">&rsaquo;</a>
                    <span class="js-calendar-tabs">
                        <a href="#" class="<?php if ($this->_tpl_vars['weekMonth'] == 'day'): ?>selected<?php endif; ?>"  data-nav="js-by-day"><?php echo $this->_tpl_vars['translate_day']; ?>
</a>
                        <a href="#" class="<?php if ($this->_tpl_vars['weekMonth'] == 'week'): ?>selected<?php endif; ?>"  data-nav="js-by-week"><?php echo $this->_tpl_vars['translate_nedelya_big']; ?>
</a>
                        <a href="#" class="<?php if ($this->_tpl_vars['weekMonth'] == 'month'): ?>selected<?php endif; ?>" data-nav="js-by-month"><?php echo $this->_tpl_vars['translate_month']; ?>
</a>
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="js-data-week" style="display: none" data-currentweek="<?php echo ((is_array($_tmp=$this->_tpl_vars['calendarCurrentWeek'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0) : number_format($_tmp, 0)); ?>
"></div>
                <div class="clear"></div>
            </div>
            <div class="list">
                <div class="list-row">
                    <div class="day-name">
                        <span class="date-number js-week-day-1"></span>
                        <?php echo $this->_tpl_vars['translate_monday_short']; ?>

                    </div>
                    <div class="day-name">
                        <span class="date-number js-week-day-2"></span>
                        <?php echo $this->_tpl_vars['translate_tuesday_short']; ?>
</div>
                    <div class="day-name">
                        <span class="date-number js-week-day-3"></span>
                        <?php echo $this->_tpl_vars['translate_wednesday_short']; ?>

                    </div>
                    <div class="day-name">
                        <span class="date-number js-week-day-4"></span>
                        <?php echo $this->_tpl_vars['translate_thursday_short']; ?>

                    </div>
                    <div class="day-name">
                        <span class="date-number js-week-day-5"></span>
                        <?php echo $this->_tpl_vars['translate_friday_short']; ?>

                    </div>
                    <div class="day-name">
                        <span class="date-number js-week-day-6"></span>
                        <?php echo $this->_tpl_vars['translate_saturday_short']; ?>

                    </div>
                    <div class="day-name">
                        <span class="date-number js-week-day-7"></span>
                        <?php echo $this->_tpl_vars['translate_sunday_short']; ?>

                    </div>
                </div>
                <?php $_from = $this->_tpl_vars['calendarWeekDateArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['week']):
        $this->_foreach['foo']['iteration']++;
?>
                    <?php $this->assign('innerInLine', 0); ?>
                    <div class="list-row <?php echo $this->_tpl_vars['k']; ?>
 js-week" style="display: <?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['calendarCurrentWeek']): ?>table-row<?php else: ?>none<?php endif; ?>;">
                        <?php if (($this->_foreach['foo']['iteration'] <= 1)): ?>
                            <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['skipDay']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
                                <?php $this->assign('innerInLine', $this->_tpl_vars['innerInLine']+1); ?>
                                <div class="day othermonth">&nbsp;</div>
                            <?php endfor; endif; ?>
                        <?php endif; ?>

                        <?php $_from = $this->_tpl_vars['week']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['date']):
?>
                            <?php $this->assign('innerInLine', $this->_tpl_vars['innerInLine']+1); ?>
                            <div class="day issues <?php if ($this->_tpl_vars['date']['date'] == $this->_tpl_vars['dateCurrent']): ?>current<?php endif; ?> <?php if ($this->_tpl_vars['date']['otherMonth']): ?>othermonth<?php endif; ?>" data-date="<?php echo $this->_tpl_vars['date']['date']; ?>
" data-day="<?php echo ((is_array($_tmp=$this->_tpl_vars['date']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d") : smarty_modifier_date_format($_tmp, "%d")); ?>
">
                                <?php if ($this->_tpl_vars['date']['date'] >= $this->_tpl_vars['dateCurrent']): ?>
                                    <div class="add-element">
                                        <a href="#" class="ob-button button-cancel js-create-issues" data-date="<?php echo $this->_tpl_vars['date']['date']; ?>
" data-type="week"><span class="ob-link-add"><?php echo $this->_tpl_vars['translate_service_tasks_add']; ?>
</span></a>
                                    </div>
                                <?php endif; ?>
                                <?php $_from = $this->_tpl_vars['calendarWeekArray'][$this->_tpl_vars['k']][$this->_tpl_vars['date']['date']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                    <?php if ($this->_tpl_vars['e']['type'] == 'user'): ?>
                                        <a class="day-element js-contact-preview" data-type="user" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" href="<?php echo $this->_tpl_vars['e']['url']; ?>
">
                                            <span class="identifier"></span>
                                            <?php echo $this->_tpl_vars['e']['name']; ?>

                                        </a>
                                    <?php else: ?>
                                        <a class="day-element <?php if ($this->_tpl_vars['e']['statusName']): ?>stage-workflow-element<?php endif; ?> <?php if ($this->_tpl_vars['e']['closed']): ?>complete<?php endif; ?>" data-url="<?php echo $this->_tpl_vars['e']['url']; ?>
" data-type="<?php if ($this->_tpl_vars['e']['isProject']): ?>project<?php elseif ($this->_tpl_vars['e']['statusName'] || $this->_tpl_vars['e']['colour']): ?>workflow<?php else: ?>issue<?php endif; ?>" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" data-employerid="<?php echo $this->_tpl_vars['e']['employerId']; ?>
" data-statusid="<?php echo $this->_tpl_vars['e']['statusId']; ?>
" <?php if ($this->_tpl_vars['e']['colour']): ?>style="background-color: <?php echo $this->_tpl_vars['e']['colour']; ?>
;"<?php endif; ?> <?php if ($this->_tpl_vars['e']['isSortable']): ?>data-isSortable="1"<?php endif; ?> href="javascript:void(0);" onclick="smart_popup_open('<?php echo $this->_tpl_vars['e']['id']; ?>
');">
                                            <span class="identifier" <?php if ($this->_tpl_vars['e']['iColor']): ?>style="background-color: <?php echo $this->_tpl_vars['e']['iColor']; ?>
;"<?php endif; ?>></span>
                                            <?php if ($this->_tpl_vars['e']['time']): ?><span class="time"><?php echo $this->_tpl_vars['e']['time']; ?>
</span><?php endif; ?>
                                            <?php echo ((is_array($_tmp=$this->_tpl_vars['e']['nameClear'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                                            <?php if (! $this->_tpl_vars['e']['nameClear'] && $this->_tpl_vars['e']['clientName']): ?>
                                                <span style="font-size: 11px; color: grey;"><?php echo $this->_tpl_vars['e']['clientName']; ?>
</span>
                                            <?php endif; ?>
                                            <span class="clear"></span>

                                            <span class="icons">
                                                <?php if ($this->_tpl_vars['e']['fireIssue']): ?>
                                                    <span class="ob-icon-overdue"></span>
                                                <?php endif; ?>
                                                <?php if ($this->_tpl_vars['e']['allClosed']): ?>
                                                    <span class="ob-icon-done"></span>
                                                <?php endif; ?>
                                                <?php if ($this->_tpl_vars['e']['new']): ?>
                                                    <span class="ob-icon-new"></span>
                                                <?php endif; ?>
                                            </span>
                                            <?php if ($this->_tpl_vars['e']['done'] && ! $this->_tpl_vars['e']['closed']): ?>
                                                <span class="light important"><?php echo $this->_tpl_vars['translate_neobhodimo_proverit']; ?>
</span><br />
                                            <?php endif; ?>
                                            <?php if ($this->_tpl_vars['e']['clientName'] && $this->_tpl_vars['e']['nameClear']): ?><span class="light"><?php echo $this->_tpl_vars['translate_client_small']; ?>
: <?php echo $this->_tpl_vars['e']['clientName']; ?>
</span><br /><?php endif; ?>
                                            <?php if ($this->_tpl_vars['e']['projectName']): ?><span class="light"><?php echo $this->_tpl_vars['translate_proekt']; ?>
: <?php echo $this->_tpl_vars['e']['projectName']; ?>
</span><br /><?php endif; ?>
                                            <?php if ($this->_tpl_vars['e']['statusName']): ?>
                                                <span class="status-name"><?php echo $this->_tpl_vars['e']['statusName']; ?>
</span>
                                            <?php endif; ?>
                                            <span class="clear"></span>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?>
                            </div>
                        <?php endforeach; endif; unset($_from); ?>
                        <?php if ($this->_tpl_vars['innerInLine'] > 0): ?>
                            <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)$this->_tpl_vars['innerInLine'];
$this->_sections['foo']['loop'] = is_array($_loop=7) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
                                <div class="day othermonth">&nbsp;</div>
                            <?php endfor; endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; endif; unset($_from); ?>
            </div>
        </div>

        <div class="by-month js-by-month" <?php if ($this->_tpl_vars['weekMonth'] != 'month'): ?>style="display: none;"<?php endif; ?>>
            <div class="calendar-head">
                <div class="legend">
                    <em>
                        <span class="ob-icon-done"></span>
                        <?php echo $this->_tpl_vars['translate_done_zadacha']; ?>

                    </em>
                    <em>
                        <span class="ob-icon-new"></span>
                        <?php echo $this->_tpl_vars['translate_novaya_zadacha']; ?>

                    </em>
                    <em>
                        <span class="ob-icon-overdue"></span>
                        <?php echo $this->_tpl_vars['translate_srochnaya_zadacha']; ?>

                    </em>
                </div>

                <div class="block-name">
                    Мой бокс на
                    <span class="toggle-name"><?php echo $this->_tpl_vars['dataMonthName']['month']; ?>
 <?php echo $this->_tpl_vars['dataMonthName']['year']; ?>
</span>
                </div>

                <div class="tabs">
                    <a class="js-month-next-prev prev" href="#">&lsaquo;</a>
                    <a class="js-calendar-today today" href="#"><?php echo $this->_tpl_vars['translate_segodnya']; ?>
</a>
                    <a class="js-month-next-prev next" href="#">&rsaquo;</a>
                    <span class="js-calendar-tabs">
                        <a href="#" class="<?php if ($this->_tpl_vars['weekMonth'] == 'day'): ?>selected<?php endif; ?>"  data-nav="js-by-day"><?php echo $this->_tpl_vars['translate_day']; ?>
</a>
                        <a href="#" class="<?php if ($this->_tpl_vars['weekMonth'] == 'week'): ?>selected<?php endif; ?>"  data-nav="js-by-week"><?php echo $this->_tpl_vars['translate_nedelya_big']; ?>
</a>
                        <a href="#" class="<?php if ($this->_tpl_vars['weekMonth'] == 'month'): ?>selected<?php endif; ?>" data-nav="js-by-month"><?php echo $this->_tpl_vars['translate_month']; ?>
</a>
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="js-data-month" style="display: none" data-month="<?php echo $this->_tpl_vars['dataMonth']; ?>
" data-year="<?php echo $this->_tpl_vars['dataYear']; ?>
" data-show="month" data-currentweeklast=""></div>
                <div class="clear"></div>
            </div>

            <div class="list">
                <div class="list-row">
                    <div class="day-name"><?php echo $this->_tpl_vars['translate_monday_short']; ?>
</div>
                    <div class="day-name"><?php echo $this->_tpl_vars['translate_tuesday_short']; ?>
</div>
                    <div class="day-name"><?php echo $this->_tpl_vars['translate_wednesday_short']; ?>
</div>
                    <div class="day-name"><?php echo $this->_tpl_vars['translate_thursday_short']; ?>
</div>
                    <div class="day-name"><?php echo $this->_tpl_vars['translate_friday_short']; ?>
</div>
                    <div class="day-name"><?php echo $this->_tpl_vars['translate_saturday_short']; ?>
</div>
                    <div class="day-name"><?php echo $this->_tpl_vars['translate_sunday_short']; ?>
</div>
                </div>
                <div class="list-row">
                    <?php $this->assign('innerInLine', 0); ?>
                    <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['skipDay']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
                        <?php $this->assign('innerInLine', $this->_tpl_vars['innerInLine']+1); ?>
                        <div class="day othermonth">&nbsp;</div>
                    <?php endfor; endif; ?>

                    <?php $this->assign('monthLine', 0); ?>
                    <?php $_from = $this->_tpl_vars['calendarMonthDateArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['date']):
?>
                        <?php $this->assign('innerInLine', $this->_tpl_vars['innerInLine']+1); ?>
                        <div class="day <?php if ($this->_tpl_vars['date']['date'] == $this->_tpl_vars['dateCurrent']): ?>current<?php endif; ?> <?php if ($this->_tpl_vars['date']['otherMonth']): ?>othermonth<?php endif; ?> issues" data-date="<?php echo $this->_tpl_vars['date']['date']; ?>
">
                            <div class="d-title">
                                <?php echo ((is_array($_tmp=$this->_tpl_vars['date']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d") : smarty_modifier_date_format($_tmp, "%d")); ?>

                            </div>
                            <?php if ($this->_tpl_vars['date']['date'] >= $this->_tpl_vars['dateCurrent']): ?>
                                <div class="add-element">
                                    <a href="#" class="ob-button button-cancel js-create-issues" data-date="<?php echo $this->_tpl_vars['date']['date']; ?>
" data-type="month"><span class="ob-link-add"><?php echo $this->_tpl_vars['translate_service_tasks_add']; ?>
</span></a>
                                </div>
                            <?php endif; ?>

                            <?php $_from = $this->_tpl_vars['calendarMonthArray'][$this->_tpl_vars['date']['date']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <?php if ($this->_tpl_vars['e']['type'] == 'user'): ?>
                                    <a class="day-element js-contact-preview" data-type="user" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" href="<?php echo $this->_tpl_vars['e']['url']; ?>
">
                                        <span class="identifier"></span>
                                        <?php echo $this->_tpl_vars['e']['name']; ?>

                                    </a>
                                <?php else: ?>
                                    <a class="day-element <?php if ($this->_tpl_vars['e']['statusName']): ?>stage-workflow-element<?php endif; ?> <?php if ($this->_tpl_vars['e']['closed']): ?>complete<?php endif; ?>" data-url="<?php echo $this->_tpl_vars['e']['url']; ?>
" data-type="<?php if ($this->_tpl_vars['e']['isProject']): ?>project<?php elseif ($this->_tpl_vars['e']['statusName'] || $this->_tpl_vars['e']['colour']): ?>workflow<?php else: ?>issue<?php endif; ?>" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" data-employerid="<?php echo $this->_tpl_vars['e']['employerId']; ?>
" data-statusid="<?php echo $this->_tpl_vars['e']['statusId']; ?>
" <?php if ($this->_tpl_vars['e']['colour']): ?>style="background-color: <?php echo $this->_tpl_vars['e']['colour']; ?>
;"<?php endif; ?> <?php if ($this->_tpl_vars['e']['isSortable']): ?>data-isSortable="1"<?php endif; ?> href="javascript:void(0);" onclick="smart_popup_open('<?php echo $this->_tpl_vars['e']['id']; ?>
');">
                                        <span class="identifier" <?php if ($this->_tpl_vars['e']['iColor']): ?>style="background-color: <?php echo $this->_tpl_vars['e']['iColor']; ?>
"<?php endif; ?>></span>
                                        <?php if ($this->_tpl_vars['e']['time']): ?><span class="time"><?php echo $this->_tpl_vars['e']['time']; ?>
</span><?php endif; ?>
                                        <?php echo ((is_array($_tmp=$this->_tpl_vars['e']['nameClear'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                                        <?php if (! $this->_tpl_vars['e']['nameClear'] && $this->_tpl_vars['e']['clientName']): ?>
                                            <span class="light"><?php echo $this->_tpl_vars['e']['clientName']; ?>
</span><br />
                                        <?php endif; ?>
                                        <span class="clear"></span>

                                        <span class="icons">
                                            <?php if ($this->_tpl_vars['e']['fireIssue']): ?>
                                                <span class="ob-icon-overdue"></span>
                                            <?php endif; ?>
                                            <?php if ($this->_tpl_vars['e']['allClosed']): ?>
                                                <span class="ob-icon-done"></span>
                                            <?php endif; ?>
                                            <?php if ($this->_tpl_vars['e']['new']): ?>
                                                <span class="ob-icon-new"></span>
                                            <?php endif; ?>
                                        </span>
                                        <?php if ($this->_tpl_vars['e']['done']): ?>
                                            <span class="light important"><?php echo $this->_tpl_vars['translate_neobhodimo_proverit']; ?>
</span><br />
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['e']['clientName'] && $this->_tpl_vars['e']['nameClear']): ?><span class="light"><?php echo $this->_tpl_vars['translate_client_small']; ?>
: <?php echo $this->_tpl_vars['e']['clientName']; ?>
</span><br /><?php endif; ?>
                                        <?php if ($this->_tpl_vars['e']['projectName']): ?><span class="light"><?php echo $this->_tpl_vars['translate_proekt']; ?>
: <?php echo $this->_tpl_vars['e']['projectName']; ?>
</span><br /><?php endif; ?>
                                        <?php if ($this->_tpl_vars['e']['statusName']): ?>
                                            <span class="light"><?php echo $this->_tpl_vars['e']['statusName']; ?>
</span><br />
                                        <?php endif; ?>
                                        <span class="clear"></span>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        </div>
                        <?php if (( $this->_tpl_vars['key'] + 1 + $this->_tpl_vars['skipDay'] ) == ( ( $this->_tpl_vars['monthLine'] + 1 ) * 7 )): ?>
                            <?php $this->assign('monthLine', $this->_tpl_vars['monthLine']+1); ?>
                            <?php $this->assign('innerInLine', 0); ?>
                            </div>
                            <div class="list-row">
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                    <?php if ($this->_tpl_vars['innerInLine'] > 0): ?>
                        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)$this->_tpl_vars['innerInLine'];
$this->_sections['foo']['loop'] = is_array($_loop=7) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
                            <div class="day othermonth">&nbsp;</div>
                        <?php endfor; endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="by-day js-by-day" <?php if ($this->_tpl_vars['weekMonth'] != 'day'): ?>style="display: none;"<?php endif; ?>>
            <div class="calendar-head">
                <div class="legend">
                    <em>
                        <span class="ob-icon-done"></span>
                        <?php echo $this->_tpl_vars['translate_done_zadacha']; ?>

                    </em>
                    <em>
                        <span class="ob-icon-new"></span>
                        <?php echo $this->_tpl_vars['translate_novaya_zadacha']; ?>

                    </em>
                    <em>
                        <span class="ob-icon-overdue"></span>
                        <?php echo $this->_tpl_vars['translate_srochnaya_zadacha']; ?>

                    </em>
                </div>

                <div class="block-name">
                    Мой бокс на
                    <span class="toggle-name"><?php echo $this->_tpl_vars['dataMonthName']['month']; ?>
 <?php echo $this->_tpl_vars['dataMonthName']['year']; ?>
</span>
                </div>

                <div class="tabs">
                    <a class="js-day-next-prev prev" href="#">&lsaquo;</a>
                    <a class="js-calendar-today today" href="#"><?php echo $this->_tpl_vars['translate_segodnya']; ?>
</a>
                    <a class="js-day-next-prev next" href="#">&rsaquo;</a>
                    <span class="js-calendar-tabs">
                        <a href="#" class="<?php if ($this->_tpl_vars['weekMonth'] == 'day'): ?>selected<?php endif; ?>"  data-nav="js-by-day"><?php echo $this->_tpl_vars['translate_day']; ?>
</a>
                        <a href="#" class="<?php if ($this->_tpl_vars['weekMonth'] == 'week'): ?>selected<?php endif; ?>"  data-nav="js-by-week"><?php echo $this->_tpl_vars['translate_nedelya_big']; ?>
</a>
                        <a href="#" class="<?php if ($this->_tpl_vars['weekMonth'] == 'month'): ?>selected<?php endif; ?>" data-nav="js-by-month"><?php echo $this->_tpl_vars['translate_month']; ?>
</a>
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="js-data-day" style="display: none" data-currentday="<?php echo $this->_tpl_vars['calendarCurrentDay']['dayClear']; ?>
" ></div>
                <div class="clear"></div>
            </div>

            <div class="list">
                <div class="list-row">
                    <div class="day-name js-day-name">
                        <div class="date-number"><?php echo $this->_tpl_vars['calendarCurrentDay']['day']; ?>
</div>
                        <?php echo $this->_tpl_vars['calendarCurrentDay']['dayNameFull']; ?>

                    </div>
                </div>
                <?php $_from = $this->_tpl_vars['calendarMonthDateClearArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['date']):
?>
                    <div class="list-row js-day <?php echo $this->_tpl_vars['date']['dayClear']; ?>
" <?php if ($this->_tpl_vars['key'] != $this->_tpl_vars['calendarCurrentDay']['key']): ?> style="display: none; " <?php endif; ?> data-dayclear="<?php echo $this->_tpl_vars['date']['dayClear']; ?>
" data-day="<?php echo $this->_tpl_vars['date']['day']; ?>
" data-name="<?php echo $this->_tpl_vars['date']['dayNameFull']; ?>
">
                        <div class="day <?php if ($this->_tpl_vars['date']['date'] == $this->_tpl_vars['dateCurrent']): ?>current<?php endif; ?> issues" data-date="<?php echo $this->_tpl_vars['date']['date']; ?>
">
                            <?php if ($this->_tpl_vars['date']['date'] >= $this->_tpl_vars['dateCurrent']): ?>
                                <div class="add-element">
                                    <a href="#" class="ob-button button-cancel js-create-issues" data-date="<?php echo $this->_tpl_vars['date']['date']; ?>
" data-type="day"><span class="ob-link-add"><?php echo $this->_tpl_vars['translate_service_tasks_add']; ?>
</span></a>
                                </div>
                            <?php endif; ?>

                            <?php $_from = $this->_tpl_vars['calendarMonthArray'][$this->_tpl_vars['date']['date']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <?php if ($this->_tpl_vars['e']['type'] == 'user'): ?>
                                    <a class="day-element js-contact-preview" data-type="user" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
" href="<?php echo $this->_tpl_vars['e']['url']; ?>
">
                                        <span class="identifier"></span>
                                        <?php echo $this->_tpl_vars['e']['name']; ?>

                                    </a>
                                <?php else: ?>
                                    <a class="day-element <?php if ($this->_tpl_vars['e']['statusName']): ?>stage-workflow-element<?php endif; ?> <?php if ($this->_tpl_vars['e']['closed']): ?>complete<?php endif; ?>"
                                    data-type="<?php if ($this->_tpl_vars['e']['isProject']): ?>project<?php elseif ($this->_tpl_vars['e']['statusName'] || $this->_tpl_vars['e']['colour']): ?>workflow<?php else: ?>issue<?php endif; ?>" data-url="<?php echo $this->_tpl_vars['e']['url']; ?>
" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
"
                                    data-employerid="<?php echo $this->_tpl_vars['e']['employerId']; ?>
" data-statusid="<?php echo $this->_tpl_vars['e']['statusId']; ?>
" <?php if ($this->_tpl_vars['e']['colour']): ?>style="background-color: <?php echo $this->_tpl_vars['e']['colour']; ?>
;"<?php endif; ?>
                                    href="javascript:void(0);" onclick="smart_popup_open('<?php echo $this->_tpl_vars['e']['id']; ?>
');"
                                    <?php if ($this->_tpl_vars['e']['isSortable']): ?>data-isSortable="1"<?php endif; ?>>
                                        <span class="identifier" <?php if ($this->_tpl_vars['e']['iColor']): ?>style="background-color: <?php echo $this->_tpl_vars['e']['iColor']; ?>
"<?php endif; ?>></span>
                                        <?php if ($this->_tpl_vars['e']['time']): ?><span class="time"><?php echo $this->_tpl_vars['e']['time']; ?>
</span><?php endif; ?>
                                        <?php echo ((is_array($_tmp=$this->_tpl_vars['e']['nameClear'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                                        <?php if (! $this->_tpl_vars['e']['nameClear'] && $this->_tpl_vars['e']['clientName']): ?>
                                            <span class="light"><?php echo $this->_tpl_vars['e']['clientName']; ?>
</span><br />
                                        <?php endif; ?>
                                        <span class="clear"></span>

                                        <span class="icons">
                                            <?php if ($this->_tpl_vars['e']['fireIssue']): ?>
                                                <span class="ob-icon-overdue"></span>
                                            <?php endif; ?>
                                            <?php if ($this->_tpl_vars['e']['allClosed']): ?>
                                                <span class="ob-icon-done"></span>
                                            <?php endif; ?>
                                            <?php if ($this->_tpl_vars['e']['new']): ?>
                                                <span class="ob-icon-new"></span>
                                            <?php endif; ?>
                                        </span>
                                        <?php if ($this->_tpl_vars['e']['done']): ?>
                                            <span class="light important"><?php echo $this->_tpl_vars['translate_neobhodimo_proverit']; ?>
</span><br />
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['e']['clientName'] && $this->_tpl_vars['e']['nameClear']): ?><span class="light"><?php echo $this->_tpl_vars['translate_client_small']; ?>
: <?php echo $this->_tpl_vars['e']['clientName']; ?>
</span><br /><?php endif; ?>
                                        <?php if ($this->_tpl_vars['e']['projectName']): ?><span class="light"><?php echo $this->_tpl_vars['translate_proekt']; ?>
: <?php echo $this->_tpl_vars['e']['projectName']; ?>
</span><br /><?php endif; ?>
                                        <?php if ($this->_tpl_vars['e']['description']): ?><span class="light"><?php echo $this->_tpl_vars['e']['description']; ?>
</span><br /><?php endif; ?>
                                        <?php if ($this->_tpl_vars['e']['statusName']): ?>
                                            <span class="light"><?php echo $this->_tpl_vars['e']['statusName']; ?>
</span><br />
                                        <?php endif; ?>
                                        <span class="clear"></span>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        </div>
                    </div>
                <?php endforeach; endif; unset($_from); ?>
            </div>
        </div>

        <div class="shop-block-popup js-settings-stage-popup" style="display: none;">
            <div class="dark"></div>
            <div class="popupblock">
                <a href="#" class="close" onclick="popupClose('.js-settings-stage-popup');">
                    <svg viewBox="0 0 16 16">
                        <use xlink:href="#icon-close"></use>
                    </svg>
                </a>
                <div class="head"><?php echo $this->_tpl_vars['translate_nastroyki_etapa']; ?>
</div>
                <div class="window-content window-form">
                    <div id="js-settings-stage-popup-content"></div>
                </div>
            </div>
        </div>

        <div class="shop-block-popup js-modal-create-issue" style="display: none;">
            <div class="dark"></div>
            <div class="popupblock">
                <a href="#" class="close" onclick="popupClose('.js-modal-create-issue');">
                    <svg viewBox="0 0 16 16">
                        <use xlink:href="#icon-close"></use>
                    </svg>
                </a>
                <div class="head">
                    <div class="nb-block-tabs js-slide-tabs">
                        <div class="tab-element"><a class="js-calendar-add-issue selected" href="javascript:void(0);"><?php echo $this->_tpl_vars['translate_sozdat_zadachu']; ?>
</a>
                        </div>
                        <div class="tab-element"><a class="js-calendar-add-order" href="javascript:void(0);"><?php echo $this->_tpl_vars['translate_create_order']; ?>
</a>
                        </div>
                        <span class="hover"></span>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="window-content window-form">
                    <form class="" action="">
                        <div class="ob-block-doubleform js-add-issue-droppable-zone">
                            <div class="wrap">
                                <div class="left-column">
                                    <div class="form-element">
                                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_proekt']; ?>
</div>
                                        <input type="text" class="js-issue-parent-autocomplete" value="<?php echo $this->_tpl_vars['parentId']; ?>
"
                                               placeholder="<?php echo $this->_tpl_vars['parentName']; ?>
" data-input-value="#js-issue-add-parent-value" />
                                        <input type="hidden" name="projectid" id="js-issue-add-parent-value" value="<?php echo $this->_tpl_vars['control_projectid']; ?>
"/>
                                        <?php if ($this->_tpl_vars['lastProject']): ?>
                                            <div class="ob-block-lastproject">
                                                <span class="name"><?php echo $this->_tpl_vars['translate_poslednie_proekti']; ?>
:</span>
                                                <?php $_from = $this->_tpl_vars['lastProject']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                                    <a class="ob-wf-stage js-last-project-link" href="#" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
">#<?php echo $this->_tpl_vars['e']['id']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
                                                <?php endforeach; endif; unset($_from); ?>
                                                <script>
                                                    $j('.js-last-project-link').click(function(){
                                                        $j('#js-issue-add-parent-value').val($j(this).data('id'));
                                                        $j('.js-issue-parent-autocomplete').val($j(this).text());
                                                    });
                                                </script>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <script type="text/javascript">
                                            $j('.js-week, .js-by-month').each(function(){
                                                if ($j(this).is(':visible')) {
                                                    $j(this).addClass('current');
                                                }
                                            });

                                            // # 2012099594
                                            //  animation('.current .day-element', 'blind-calendar-fast');
                                        </script>
                                    </div>

                                    <div class="form-element">
                                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_nazvanie_zadachi']; ?>
</div>
                                        <input type="hidden" name="type" value=""/>
                                        <input type="hidden" name="date" value=""/>
                                        <input type="text" name="issue_name" />
                                    </div>

                                    <div class="form-element">
                                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_responsible']; ?>
</div>
                                        <select name="managerid" class="chzn-select">
                                            <option value="0">---</option>
                                            <?php $_from = $this->_tpl_vars['managerArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                                <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" <?php if ($this->_tpl_vars['e']['selected']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </div>

                                    <div class="form-element">
                                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_description']; ?>
</div>
                                        <textarea class="js-autosize js-usertextcomplete" name="issue_description" style="height: 100px;"></textarea>
                                    </div>

                                    <div class="form-element js-calendar-add-issue-products" style="display: none;">
                                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_dobavit_produkti']; ?>
</div>
                                        <input class="js-calendar-products" value="">
                                    </div>

                                    <div class="form-element">
                                        <div class="ob-block-attach">
                                            <a href="#" name="file[]" class="ob-button-attach js-add-issue-uploader dz-clickable"><?php echo $this->_tpl_vars['translate_prilozhit_fayli']; ?>
...</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="right-column">
                                    <div class="form-element">
                                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_client_small']; ?>
</div>
                                        <input type="text" class="js-user-autocomplete" value="<?php echo $this->_tpl_vars['client']; ?>
" data-input-value="#js-issue-client-value" />
                                        <input type="hidden" name="clientid" id="js-issue-client-value" value="<?php echo $this->_tpl_vars['control_clientid']; ?>
"/>
                                    </div>

                                    <div class="form-element">
                                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_workflow']; ?>
</div>
                                        <select name="workflowid" class="chzn-select js-calendar-add-issue-workflow">
                                            <option value="0">---</option>
                                            <?php $_from = $this->_tpl_vars['workflowArrayIssue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                                <option value="<?php echo $this->_tpl_vars['e']['id']; ?>
" ><?php echo $this->_tpl_vars['e']['name']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </div>

                                    <div class="form-element">
                                        <div class="element-caption"><?php echo $this->_tpl_vars['translate_srok_ispolneniya']; ?>
</div>
                                        <input type="text" name="dateto" value="<?php echo $this->_tpl_vars['control_dateto']; ?>
" class="js-datetime js-dateto"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ob-button-fixed">
                            <input type="button" class="ob-button button-green js-ajax-create-issue" value="<?php echo $this->_tpl_vars['translate_create']; ?>
"/>
                            <input type="button" class="ob-button button-cancel" value="<?php echo $this->_tpl_vars['translate_cancel']; ?>
" onclick="popupClose('.js-modal-create-issue');" />
                        </div>

                        <script type="text/javascript">
                            // detecting which mouse btn was pressed, and handling event
                            $j('.day-element').on('mousedown', function(event){
                                var itemUrl = $j(this).data("url");
                                if(event.which == 2){
                                    // if middle btn mouse > open in new tab
                                    window.open(itemUrl,'_blank');
                                    event.preventDefault();
                                }
                            });

                            initIssueParentAutocomplete();
                            initUserAutocomplete();

                            // загрузка файлов
                            var uploader = new DropUploader('.js-add-issue-droppable-zone', '.js-add-issue-uploader');

                            var form = '';
                            $j('.js-ajax-create-issue').on('click', function () {
                                var myInput = $j(this);
                                form = $j(this).closest('form');
                                var date = form.find('input[name="date"]').val();
                                var dateto = form.find('input[name="dateto"]').val();
                                var name = form.find('input[name="issue_name"]').val();
                                var description = form.find('textarea[name="issue_description"]').val();
                                var parentID = form.find('#js-issue-add-parent-value').val();
                                var clientID = form.find('#js-issue-client-value').val();
                                var managerID = form.find('select[name="managerid"]').val();
                                var workflowID = form.find('select[name="workflowid"]').val();
                                var products = form.find('input.js-calendar-products').val();

                                // проверка, заполнено ли имя задачи
                                if (!name) {
                                    messagePush('Введите имя задачи!', 'error');
                                    setTimeout(function(){
                                        messageHide('.js-error');
                                    }, 2000);
                                    return false;
                                }

                                myInput.attr('disabled', true);

                                var fileIDArray = [];

                                form.find('input[name="fileid[]"]').each(function() {
                                    fileIDArray.push($j(this).val())
                                });

                                $j.ajax({
                                    url: '/admin/issue/ajax/add/',
                                    type: 'post',
                                    dataType: "json",
                                    data:{
                                        date: date,
                                        dateto: dateto,
                                        name: name,
                                        description: description,
                                        parentid: parentID,
                                        managerid: managerID,
                                        workflowid: workflowID,
                                        clientid: clientID,
                                        fileid: fileIDArray,
                                        products: products
                                    },
                                    success: function(data) {
                                        setTimeout(function () {
                                            myInput.removeAttr('disabled');
                                        }, 1000);

                                        if (data.error) {
                                            // отменяем проверку на изменения попапа
                                            $j('.js-modal-create-issue').removeClass('js-changed');

                                            // закрываем попап
                                            popupClose('.js-modal-create-issue');

                                            return false;
                                        }
                                        $j('.js-by-'+form.find('input[name="type"]').val()+' .list .day').each(function () {
                                            if ($j(this).data('date') == date) {
                                                $j(this).find('.add-element').after('<a class="day-element" data-isSortable="1" data-id="'+data.id+'" href="javascript:void(0);" onclick="smart_popup_open('+data.id+');">'+data.name+'</a>');

                                                // отменяем проверку на изменения попапа
                                                $j('.js-modal-create-issue').removeClass('js-changed');

                                                // закрываем попап
                                                popupClose('.js-modal-create-issue');

                                                // Очищаем поля.
                                                form.find('input[name="date"]').val('');
                                                form.find('input[name="dateto"]').val('');
                                                form.find('input[name="issue_name"]').val('');
                                                form.find('textarea[name="issue_description"]').val('');
                                                form.find('select[name="managerid"]').select2('val', '<?php echo $this->_tpl_vars['managerid']; ?>
');
                                                form.find('.js-uploaded-file').each(function() {
                                                    $j(this).remove();
                                                });
                                            }
                                        });
                                    }, error: function(){
                                        $j('.js-ajax-create-issue').removeAttr('disabled');
                                    }
                                });
                            });

                            var dataOrder = [
                                <?php $_from = $this->_tpl_vars['workflowArrayOrder']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['wo']):
?>
                                    { id: <?php echo $this->_tpl_vars['wo']['id']; ?>
, text: '<?php echo $this->_tpl_vars['wo']['name']; ?>
', def:'<?php echo $this->_tpl_vars['wo']['default']; ?>
'},
                                <?php endforeach; endif; unset($_from); ?>
                            ];

                            var dataIssue = [
                                <?php $_from = $this->_tpl_vars['workflowArrayIssue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['wi']):
?>
                                    { id: <?php echo $this->_tpl_vars['wi']['id']; ?>
, text: '<?php echo $this->_tpl_vars['wi']['name']; ?>
'},
                                <?php endforeach; endif; unset($_from); ?>
                            ];

                            $j('.js-calendar-add-issue').click(function () {
                                $j('.js-calendar-add-issue-products').hide();

                                $j(".js-calendar-add-issue-workflow").select2("destroy");
                                $j('.js-calendar-add-issue-workflow').empty();

                                $j(".js-calendar-add-issue-workflow").append( $j('<option value="0">---</option>'));
                                $j(dataIssue).each(function(key, item) {
                                    $j(".js-calendar-add-issue-workflow").append( $j('<option value="'+item.id+'">'+item.text+'</option>'));
                                });
                                $j(".js-calendar-add-issue-workflow").select2().trigger('change');
                            });

                            $j('.js-calendar-add-order').click(function () {
                                $j('.js-calendar-add-issue-products').show();

                                $j(".js-calendar-add-issue-workflow").select2("destroy");
                                $j('.js-calendar-add-issue-workflow').empty();

                                //$j(".js-calendar-add-issue-workflow").append( $j('<option value="0">---</option>'));
                                $j(dataOrder).each(function(key, item) {
                                    if (item.def == '1') {
                                        $j(".js-calendar-add-issue-workflow").append( $j('<option selected value="'+item.id+'">'+item.text+'</option>'));

                                    } else {
                                        $j(".js-calendar-add-issue-workflow").append( $j('<option value="'+item.id+'">'+item.text+'</option>'));

                                    }
                                });
                                $j(".js-calendar-add-issue-workflow").select2().trigger('change');
                            });
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form class="js-argument-form">
        <?php $_from = $this->_tpl_vars['valueArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['e']):
?>
            <input type="hidden" name="<?php echo $this->_tpl_vars['k']; ?>
" value="<?php echo $this->_tpl_vars['e']; ?>
" />
        <?php endforeach; endif; unset($_from); ?>
    </form>

    <form class="js-where-form">
        <?php $_from = $this->_tpl_vars['whereArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['e']):
?>
            <input type="hidden" name="<?php echo $this->_tpl_vars['k']; ?>
" value="<?php echo $this->_tpl_vars['e']; ?>
" />
        <?php endforeach; endif; unset($_from); ?>
    </form>

    <script type="text/javascript">

        // всплывающие подсказки
        $j('.stage-workflow-element').each(function (i, e) {
            var $element = $j(e);
            var statusID = $element.data('statusid');
            var orderID = $element.data('id');

            $element.tooltipster({
                theme: 'ob-block-preview',
                interactive: true,
                contentAsHTML: true,
                position: 'right',
                minWidth: 350,
                maxWidth: 600,
                offsetY: 0,
                onlyOne: true,
                content: '<div class="loading"><?php echo $this->_tpl_vars['translate_load']; ?>
...</div>',
                updateAnimation: false,
                functionBefore: function (origin, continueTooltip) {
                    continueTooltip();

                    $j.get('/admin/order/workflow-info/', {
                        statusid: statusID,
                        orderid: orderID
                    }, function(data) {
                        if (!data) {
                            $element.tooltipster('hide');
                        }
                        origin.tooltipster('content', data);
                    });
                }
            });
        });

        $j('.js-calendar-tabs a').click(function(){
            var currentType = $j(this).data('nav');
            $j('.js-calendar-tabs a').removeClass('selected');
            $j('.js-calendar-tabs a[data-nav="' + currentType + '"]').addClass('selected');
            $j('.js-by-week, .js-by-month, .js-by-day').hide();
            $j('.' + currentType).show();

            updateWeekDays();
            return false;
        });

        $j('.js-by-week .issues').sortable({
            connectWith: ".js-by-week .issues",
            revert: "invalid",
            items: ".day-element:not([data-type='user'])",
            placeholder: "day-element-placeholder",
            helper : 'clone',
            stop: function (event, ui) {
                var $item = $j(ui.item);

                var id = $item.data('id');
                var date = $item.closest('.issues').data('date');
                var employerId = $item.data('employerid');

                var idArray = [];
                var priorityArray = [];
                var i = 1;
                $item.parent().find('.day-element[data-isSortable="1"]').each(function() {
                    idArray.push($j(this).data('id'));
                    priorityArray.push(i);
                    i++;
                });

                $j.ajax({
                    url: '/calendar/issue/update/',
                    type: 'post',
                    data: {
                        id: id,
                        date: date,
                        employerId: employerId,
                        idArray: idArray,
                        priorityArray: priorityArray
                    }
                });
            }
        });

        $j('.js-by-month .issues').sortable({
            connectWith: ".js-by-month .issues",
            revert: "invalid",
            items: ".day-element:not([data-type='user'])",
            placeholder: "day-element-placeholder",
            helper : 'clone',
            stop: function (event, ui) {
                var $item = $j(ui.item);

                var id = $item.data('id');
                var date = $item.closest('.issues').data('date');
                var employerId = $item.data('employerid');

                var idArray = [];
                var priorityArray = [];
                var i = 1;
                $item.parent().find('.day-element[data-isSortable="1"]').each(function() {
                    idArray.push($j(this).data('id'));
                    priorityArray.push(i);
                    i++;
                });

                $j.ajax({
                    url: '/calendar/issue/update/',
                    type: 'post',
                    data: {
                        id: id,
                        date: date,
                        employerId: employerId,
                        idArray: idArray,
                        priorityArray: priorityArray
                    }
                });
            }
        });

        $j('.js-by-day .issues').sortable({
            revert: "invalid",
            items: ".day-element:not([data-type='user'])",
            placeholder: "day-element-placeholder",
            helper : 'clone',
            stop: function (event, ui) {
                var $item = $j(ui.item);
                var idArray = [];
                var priorityArray = [];
                var i = 1;
                $item.parent().find('.day-element[data-isSortable="1"]').each(function() {
                    idArray.push($j(this).data('id'));
                    priorityArray.push(i);
                    i++;
                });

                $j.ajax({
                    url: '/calendar/issue/update/',
                    type: 'post',
                    data: {
                        id: $item.data('id'),
                        idArray: idArray,
                        priorityArray: priorityArray
                    }
                });
            }
        });

        // Create issue
        $j('.js-create-issues').on('click', function () {
            $j('.js-modal-create-issue').find('form').find('input[name="type"]').val($j(this).data('type'));
            $j('.js-modal-create-issue').find('form').find('input[name="date"]').val($j(this).data('date'));
            $j('.js-modal-create-issue').find('form').find('input[name="dateto"]').val($j(this).data('date'));
            popupOpen('.js-modal-create-issue');
            $j('.js-modal-create-issue').find('form').find('input[name="issue_name"]').focus();

            // slide tabs init
            if ($j('.js-slide-tabs').length) {
                setTimeout(function(){
                    $j('.js-slide-tabs').each(function(){
                        jsSlidePosition($j(this).find('.selected'));
                    });
                }, 500);
            }
        });

        // Переключатель месяцев и недель (Вперед, назад)
        $j(function () {
            $j('.js-month-next-prev').on('click', function () {
                var element = $j(this);
                var currentMonth = $j('.js-data-month').data('month');
                var currentYear = $j('.js-data-month').data('year');
                var lastWeek = $j('.js-data-month').data('currentweeklast');
                var show = $j('.js-data-month').data('show');

                if (element.hasClass('next')) {
                    if (currentMonth == 12) {
                        currentYear = currentYear + 1;
                        currentMonth = '1';
                    } else {
                        currentMonth = currentMonth + 1;
                    }
                }

                if (element.hasClass('prev')) {
                    if (currentMonth == 1) {
                        currentYear = currentYear - 1;
                        currentMonth = '12';
                    } else {
                        currentMonth = currentMonth - 1;
                    }
                }

                var arguments = $j('.js-argument-form').serializeArray();
                var where = $j('.js-where-form').serializeArray();

                $j.ajax({
                    url: '/admin/shop/calendal/load/month/ajax/',
                    type: 'post',
                    data: {
                        'month': currentMonth,
                        'year': currentYear,
                        'lastWeek': lastWeek,
                        'managerid': '<?php echo $this->_tpl_vars['managerid']; ?>
',
                        'show': show,
                        'arguments': arguments,
                        'where': where,
                        'calendarType': $j.cookie("calendarTypeCookie")
                    },
                    success: function (html) {
                        $j('.js-calendar-block').html(html);
                        $j('.js-calendar-block .chzn-select').select2();
                        $j('.js-calendar-block .chzn-select-tree').select2({
                            formatResult: chznResultTree
                        });
                    }
                });
            });

            var currentweek = $j('.js-data-week').data('currentweek');
            $j('.js-week-next-prev').on('click', function () {
                var element = $j(this);

                if (element.hasClass('next')) {
                    currentweek = currentweek + 1;

                    if (!$j('.js-week.'+currentweek).length && !$j('.js-week.0'+currentweek).length) {
                        $j('.js-data-month').data('show', 'week');
                        $j('.js-by-month').find('.js-month-next-prev.next').click();
                        updateWeekDays();

                        return;
                    }
                }

                if (element.hasClass('prev')) {
                    currentweek = currentweek - 1;

                    if (!$j('.js-week.'+currentweek).length && !$j('.js-week.0'+currentweek).length) {
                        $j('.js-data-month').data('currentweeklast', '1');
                        $j('.js-data-month').data('show', 'week');

                        $j('.js-by-month').find('.js-month-next-prev.prev').click();
                        updateWeekDays();

                        return;

                    }
                }

                $j('.js-week').each(function () {
                    if ($j(this).hasClass(currentweek) || $j(this).hasClass('0'+currentweek)) {
                        $j(this).show();
                    } else {
                        $j(this).hide();
                    }
                });
                updateWeekDays();
            });

            var currentday = $j('.js-data-day').data('currentday');
            $j('.js-day-next-prev').on('click', function () {
                var element = $j(this);

                if (element.hasClass('next')) {
                    currentday = currentday + 1;

                    if (!$j('.js-day.' + currentday).length) {
                        $j('.js-data-month').data('show', 'day');
                        $j('.js-by-month').find('.js-month-next-prev.next').click();

                        return;
                    }
                }

                if (element.hasClass('prev')) {
                    currentday = currentday - 1;
                    if (!$j('.js-day.' + currentday).length || currentday < 0) {
                        $j('.js-data-month').data('currentweeklast', '1');
                        $j('.js-data-month').data('show', 'day');

                        $j('.js-by-month').find('.js-month-next-prev.prev').click();

                        return;
                    }
                }

                $j('.js-day').each(function () {
                    if ($j(this).hasClass(currentday)) {
                        $j(this).show();

                        $j('.js-day-name').html("<div class='date-number'>"+$j(this).attr('data-day')+"</div>"+$j(this).attr('data-name'));
                    } else {
                        $j(this).hide();
                    }
                });
            });

            $j('.js-calendar-today').on('click', function () {
                var show = $j('.js-data-month').data('show');
                var arguments = $j('.js-argument-form').serializeArray();
                var where = $j('.js-where-form').serializeArray();

                $j.ajax({
                    url: '/admin/shop/calendal/load/month/ajax/',
                    type: 'post',
                    data: {
                        'managerid': '<?php echo $this->_tpl_vars['managerid']; ?>
',
                        'show': show,
                        'arguments': arguments,
                        'where': where
                    },
                    success: function (html) {
                        $j('.js-calendar-block').html(html);
                        $j('.js-calendar-block .chzn-select').select2();
                        $j('.js-calendar-block .chzn-select-tree').select2({
                            formatResult: chznResultTree
                        });
                        updateWeekDays();
                    }
                });
            });
        });

        // Месяц / неделя
        function cookieFromCalendarType(){
            var type = [];
            $j(".js-calendar-tabs a").each(function(){
                if($j(this).hasClass("selected")){
                    type.push($j(this).data("nav"));
                }
            });
            //$j.cookie("calendarTypeCookie", type.join(','));
        }

        $j(function() {
            $j(".js-calendar-tabs a").click(function(){
                setTimeout("cookieFromCalendarType();", 100);
                $j.cookie("calendarTypeCookie", $j(this).data('nav'));
            });
        });

        function settings_stage_popup (orderId, statusId) {
            if (!statusId || !orderId) {
                return false;
            }

            $j.get('/admin/order/workflow-setting-info/', {
                statusid: statusId,
                orderid: orderId
            }, function(data) {
                if (data) {
                    $j('#js-settings-stage-popup-content').empty();
                    $j('#js-settings-stage-popup-content').append(data);
                    popupOpen('.js-settings-stage-popup');
                }
            });

            return false;
        }

        $j(function () {
            $j('.js-issue-parent-autocomplete').change(function () {
                setTimeout(function () {
                    if (!$j('.js-issue-parent-autocomplete').val() && $j('#js-issue-add-parent-value').val()) {
                        $j('#js-issue-add-parent-value').val('');
                    }
                }, 500);
            });
        });

        $j(function() {
            $j(".js-calendar-products").select2({
                width: '100%',
                height: '500px',
                delay: 200,
                placeholder: '<?php echo $this->_tpl_vars['translate_dobavit_produkti']; ?>
',
                minimumInputLength: 3,
                multiple: true,
                ajax:{
                    url: '/admin/products/json/autocomtlite/ajax/',
                    dataType: 'json',
                    data: function(term,page){
                        return {
                            name: term,
                            add: 'no'
                        }
                    },
                    results: function(data,page){
                        return {results: data}
                    }
                },
                formatResult :function(data){
                    return data.name;
                },
                formatSelection: function(data){
                    return data.id;
                }
            });

        });

        $j(function () {
            updateWeekDays();
        });

        // прописать числа
        function updateWeekDays() {
            $j('.js-week:visible').children().each(function (i, elem) {
                $j('.js-week-day-'+(i+1)).text($j(elem).data('day'));
            });
        }
    </script>
</div>