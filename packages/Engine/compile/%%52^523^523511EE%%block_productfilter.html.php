<?php /* Smarty version 2.6.27-optimized, created on 2015-12-08 11:53:21
         compiled from /var/www/shop.local/modules/collars/contents/block/block_productfilter.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/shop.local/modules/collars/contents/block/block_productfilter.html', 22, false),)), $this); ?>
<div class="cl-block-filter js-block-filter">
    
    <?php if ($this->_tpl_vars['filterSelectedArray'] || $this->_tpl_vars['productCountWithOutFilters']): ?>
    <div class="filter-element">
        <?php if ($this->_tpl_vars['productCountWithOutFilters']): ?>
        <div class="title">
            <?php if ($this->_tpl_vars['productCountWithOutFilters'] > $this->_tpl_vars['productCountWithFilter']): ?>
                <?php echo $this->_tpl_vars['productCountWithFilter']; ?>
 <?php echo $this->_tpl_vars['translate_from']; ?>
 <?php echo $this->_tpl_vars['productCountWithOutFilters']; ?>
 <?php echo $this->_tpl_vars['translate_s_filtrami']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['productCountWithOutFilters']; ?>
 filtered product
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php $_from = $this->_tpl_vars['filterSelectedArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['e']):
?>
            <div class="active-element">
                <div class="active-name"><?php echo $this->_tpl_vars['key']; ?>
</div>
                <?php $_from = $this->_tpl_vars['e']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                    <a class="remove-link js-remove-filter" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['deleteUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                    </a>
                    <br />
                <?php endforeach; endif; unset($_from); ?>
            </div>
        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['filterSelectedArray']): ?>
            <div class="active-element clear-filter">
                <a class="remove-link js-remove-filter" href="<?php echo $this->_tpl_vars['urlWithoutFilters']; ?>
<?php if ($this->_tpl_vars['control_query']): ?>?query=<?php echo $this->_tpl_vars['control_query']; ?>
<?php endif; ?>">
                    <?php echo $this->_tpl_vars['translate_reset_filter_small']; ?>

                </a>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <form method="get" action="<?php echo $this->_tpl_vars['currentURL']; ?>
">
        <?php if ($this->_tpl_vars['categoryArray']): ?>
        <div class="filter-element">
            <div class="title"><?php echo $this->_tpl_vars['translate_category']; ?>
</div>
                <span class="group">
                    <?php $_from = $this->_tpl_vars['categoryArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['b']):
?>
                        <?php if ($this->_tpl_vars['b']['selected']): ?>
                            <label>
                                <input type="checkbox" value="<?php echo $this->_tpl_vars['b']['id']; ?>
" name="category[]" <?php if ($this->_tpl_vars['b']['selected']): ?> checked <?php endif; ?>/>
                                <?php echo $this->_tpl_vars['b']['name']; ?>

                            </label>
                            <br />
                        <?php else: ?>
                            <label <?php if (! $this->_tpl_vars['b']['count']): ?>class="disabled"<?php endif; ?>>
                                <input type="checkbox" value="<?php echo $this->_tpl_vars['b']['id']; ?>
" name="category[]" <?php if (! $this->_tpl_vars['b']['count']): ?>disabled<?php endif; ?>/>
                                <?php if ($this->_tpl_vars['currentURL'] && $this->_tpl_vars['b']['count']): ?>
                                    <a href="<?php echo $this->_tpl_vars['currentURL']; ?>
category=<?php echo $this->_tpl_vars['b']['id']; ?>
/" title="<?php echo $this->_tpl_vars['b']['name']; ?>
 <?php echo $this->_tpl_vars['titleH1']; ?>
">
                                        <?php echo $this->_tpl_vars['b']['name']; ?>

                                        <?php if ($this->_tpl_vars['b']['count']): ?><span class="count">(<?php echo $this->_tpl_vars['b']['count']; ?>
)</span><?php endif; ?>
                                    </a>
                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['b']['name']; ?>

                                    <?php if ($this->_tpl_vars['b']['count']): ?><span class="count">(<?php echo $this->_tpl_vars['b']['count']; ?>
)</span><?php endif; ?>
                                <?php endif; ?>
                    </label>
                    <br />
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </span>
        </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['brandArray']): ?>
        <div class="filter-element">
            <div class="title"><?php echo $this->_tpl_vars['translate_brands']; ?>
</div>
                <span class="group">
                    <?php $_from = $this->_tpl_vars['brandArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['b']):
?>
                        <?php if ($this->_tpl_vars['b']['selected']): ?>
                            <label>
                                <input type="checkbox" value="<?php echo $this->_tpl_vars['b']['id']; ?>
" name="brand[]" <?php if ($this->_tpl_vars['b']['selected']): ?> checked <?php endif; ?>/>
                                <?php echo $this->_tpl_vars['b']['name']; ?>

                            </label>
                            <br />
                        <?php else: ?>
                            <label <?php if (! $this->_tpl_vars['b']['count']): ?>class="disabled"<?php endif; ?>>
                                <input type="checkbox" value="<?php echo $this->_tpl_vars['b']['id']; ?>
" name="brand[]" <?php if (! $this->_tpl_vars['b']['count']): ?>disabled<?php endif; ?>/>
                                <?php if ($this->_tpl_vars['currentURL'] && $this->_tpl_vars['b']['count']): ?>
                                    <a href="<?php echo $this->_tpl_vars['currentURL']; ?>
brand=<?php echo $this->_tpl_vars['b']['id']; ?>
<?php if ($this->_tpl_vars['b']['url']): ?>-<?php echo $this->_tpl_vars['b']['url']; ?>
<?php endif; ?>/" title="<?php echo $this->_tpl_vars['b']['name']; ?>
 <?php echo $this->_tpl_vars['titleH1']; ?>
">
                                        <?php echo $this->_tpl_vars['b']['name']; ?>

                                        <?php if ($this->_tpl_vars['b']['count']): ?><span class="count">(<?php echo $this->_tpl_vars['b']['count']; ?>
)</span><?php endif; ?>
                                    </a>
                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['b']['name']; ?>

                                    <?php if ($this->_tpl_vars['b']['count']): ?><span class="count">(<?php echo $this->_tpl_vars['b']['count']; ?>
)</span><?php endif; ?>
                                <?php endif; ?>
                    </label>
                    <br />
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </span>
        </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['maxPrice'] > 0): ?>
        <div class="filter-element">
            <div class="title"><?php echo $this->_tpl_vars['translate_price']; ?>
</div>
            <?php echo $this->_tpl_vars['translate_from']; ?>

            <input type="text"  id="minCost" name="filterpricefrom" value="<?php echo $this->_tpl_vars['control_filterpricefrom']; ?>
" />
            <?php echo $this->_tpl_vars['translate_to']; ?>

            <input type="text" id="maxCost"  name="filterpriceto" value="<?php echo $this->_tpl_vars['control_filterpriceto']; ?>
" />
            <br /><br />

            <div class="filter-slider">
                <div id="slider"></div>
                <script type="text/javascript">
                    jQuery("#slider").slider({
                            min: 0,
                            max: <?php echo $this->_tpl_vars['maxPrice']; ?>
,
                        values: [<?php echo $this->_tpl_vars['filterpricefrom_value']; ?>
,<?php echo $this->_tpl_vars['filterpriceto_value']; ?>
],
                    range: true,
                        stop: function(event, ui) {
                        minVal = ui.values[0];
                        maxVal = ui.values[1];

                        jQuery("input#minCost").val(minVal);
                        jQuery("input#maxCost").val(maxVal);
                    },
                    slide: function(event, ui){
                        minVal = ui.values[0];
                        maxVal = ui.values[1];
                        jQuery("input#minCost").val(minVal);
                        jQuery("input#maxCost").val(maxVal);
                    }
                    });
                </script>
            </div>
        </div>
        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['filtersArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['e']):
?>
        <div class="filter-element">
            <div class="title"><?php echo $this->_tpl_vars['e']['name']; ?>
</div>

            <?php if ($this->_tpl_vars['e']['type'] == 'interval'): ?>
            <?php echo $this->_tpl_vars['translate_from']; ?>

            <input type="text" name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value[]" value="<?php echo $this->_tpl_vars['e']['selectedArray'][0]; ?>
" class="from-to" />
            <?php echo $this->_tpl_vars['translate_to']; ?>

            <input type="text" name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value[]" value="<?php echo $this->_tpl_vars['e']['selectedArray'][1]; ?>
" class="from-to" />
            <br />
            <?php elseif ($this->_tpl_vars['e']['type'] == 'intervalselect'): ?>
            <?php echo $this->_tpl_vars['translate_from_small']; ?>

            <select name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value[]" style="width: 60px;">
                <option value="">---</option>
                <?php $_from = $this->_tpl_vars['e']['valuesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['v']['value'] == $this->_tpl_vars['e']['selectedArray'][0]): ?>selected <?php endif; ?> ><?php echo $this->_tpl_vars['v']['name']; ?>
</option>

                                                <?php endforeach; endif; unset($_from); ?>
            </select>
            <?php echo $this->_tpl_vars['translate_to']; ?>

            <select name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value[]" style="width: 60px;">
                <option value="">---</option>
                <?php $_from = $this->_tpl_vars['e']['valuesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['v']['value'] == $this->_tpl_vars['e']['selectedArray'][1]): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['v']['name']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>
            <br />
            <?php elseif ($this->_tpl_vars['e']['type'] == 'intervalslider'): ?>
            <?php if ($this->_tpl_vars['e']['valueMin'] && $this->_tpl_vars['e']['valueMax']): ?>
            <?php echo $this->_tpl_vars['translate_from']; ?>

            <input type="text" id="js-slider-<?php echo $this->_tpl_vars['e']['id']; ?>
-min" name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value[]" value="<?php echo $this->_tpl_vars['e']['selectedArray'][0]; ?>
" />
            <?php echo $this->_tpl_vars['translate_to']; ?>

            <input type="text" id="js-slider-<?php echo $this->_tpl_vars['e']['id']; ?>
-max" name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value[]" value="<?php echo $this->_tpl_vars['e']['selectedArray'][1]; ?>
" />
            <br /><br />
            <div class="filter-slider">
                <div id="js-slider-<?php echo $this->_tpl_vars['e']['id']; ?>
"></div>
                <script type="text/javascript">
                    jQuery("#js-slider-<?php echo $this->_tpl_vars['e']['id']; ?>
").slider({
                            min: <?php echo $this->_tpl_vars['e']['valueMin']; ?>
,
                        max: <?php echo $this->_tpl_vars['e']['valueMax']; ?>
,
                    step: 0.1,
                    <?php if ($this->_tpl_vars['e']['selectedArray']): ?>
                    values: ['<?php echo $this->_tpl_vars['e']['selectedArray'][0]; ?>
','<?php echo $this->_tpl_vars['e']['selectedArray'][1]; ?>
'],
                    <?php else: ?>
                    values: ['<?php echo $this->_tpl_vars['e']['valueMin']; ?>
','<?php echo $this->_tpl_vars['e']['valueMax']; ?>
'],
                    <?php endif; ?>
                    range: true,
                        stop: function(event, ui) {
                        minVal = ui.values[0];
                        maxVal = ui.values[1];

                        jQuery("input#js-slider-<?php echo $this->_tpl_vars['e']['id']; ?>
-min").val(minVal);
                        jQuery("input#js-slider-<?php echo $this->_tpl_vars['e']['id']; ?>
-max").val(maxVal);
                    },
                    slide: function(event, ui){
                        minVal = ui.values[0];
                        maxVal = ui.values[1];

                        jQuery("input#js-slider-<?php echo $this->_tpl_vars['e']['id']; ?>
-min").val(minVal);
                        jQuery("input#js-slider-<?php echo $this->_tpl_vars['e']['id']; ?>
-max").val(maxVal);
                    }
                    });
                </script>
            </div>
            <?php endif; ?>
            <?php elseif ($this->_tpl_vars['e']['type'] == 'select'): ?>
            <select name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value">
                <option value="">---</option>
                <?php $_from = $this->_tpl_vars['e']['valuesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                <?php if ($this->_tpl_vars['v']['selected']): ?>
                <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" selected><?php echo $this->_tpl_vars['v']['name']; ?>
</option>
                <?php else: ?>
                <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if (! $this->_tpl_vars['v']['count']): ?>disabled<?php endif; ?> ><?php echo $this->_tpl_vars['v']['name']; ?>
 <?php if ($this->_tpl_vars['v']['count']): ?><span class="count">(<?php echo $this->_tpl_vars['v']['count']; ?>
)</span><?php endif; ?></option>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
            </select>
            <?php elseif ($this->_tpl_vars['e']['type'] == 'checkbox'): ?>
                    <span class="group">
                        <?php $_from = $this->_tpl_vars['e']['valuesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                            <?php if ($this->_tpl_vars['v']['selected']): ?>
                                <label>
                                    <?php if ($this->_tpl_vars['v']['color']): ?>
                                    <input type="checkbox" name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value[]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" checked >
                                    <span class="color" style="background-color: <?php echo $this->_tpl_vars['v']['color']; ?>
;"><?php echo $this->_tpl_vars['v']['name']; ?>
</span>
                                    <?php else: ?>
                                    <input type="checkbox" name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value[]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" checked>
                                    <?php echo $this->_tpl_vars['v']['name']; ?>
 <?php echo $this->_tpl_vars['v']['color']; ?>

                                    <?php endif; ?>
                                </label>
                                <br />
                            <?php else: ?>
                                <label <?php if (! $this->_tpl_vars['v']['count']): ?>class="disabled"<?php endif; ?>>
                                    <?php if ($this->_tpl_vars['v']['color']): ?>
                                        <input type="checkbox" name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value[]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" >
                                        <span class="color" style="background-color: <?php echo $this->_tpl_vars['v']['color']; ?>
;">
                                            <?php echo $this->_tpl_vars['v']['name']; ?>

                                            <span class="count">(<?php echo $this->_tpl_vars['v']['count']; ?>
)</span>
                                        </span>
                                    <?php else: ?>
                                        <input type="checkbox" name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value[]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if (! $this->_tpl_vars['v']['count']): ?>disabled<?php endif; ?>>
                                        <?php if ($this->_tpl_vars['currentURL'] && $this->_tpl_vars['v']['count']): ?>
                                            <a href="<?php echo $this->_tpl_vars['currentURL']; ?>
<?php echo $this->_tpl_vars['v']['url']; ?>
" <?php if (! $this->_tpl_vars['v']['seo']): ?> rel="nofollow" <?php endif; ?> title="<?php echo $this->_tpl_vars['v']['name']; ?>
 <?php echo $this->_tpl_vars['titleH1']; ?>
">
                                                <?php echo $this->_tpl_vars['v']['name']; ?>

                                                <span class="count">(<?php echo $this->_tpl_vars['v']['count']; ?>
)</span>
                        </a>
                        <?php else: ?>
                                            <?php echo $this->_tpl_vars['v']['name']; ?>

                                            <?php if ($this->_tpl_vars['v']['count']): ?><span class="count">(<?php echo $this->_tpl_vars['v']['count']; ?>
)</span><?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                        </label>
                        <br />
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                    </span>
            <?php elseif ($this->_tpl_vars['e']['type'] == 'radiobox'): ?>
                    <span class="group">
                        <?php $_from = $this->_tpl_vars['e']['valuesArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                            <label>
                                <?php if ($this->_tpl_vars['v']['color']): ?>
                                <input type="radio" name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['v']['selected']): ?>checked<?php endif; ?> >
                                <span class="color" style="background-color: <?php echo $this->_tpl_vars['v']['color']; ?>
;"><?php echo $this->_tpl_vars['v']['name']; ?>
 <?php if ($this->_tpl_vars['v']['selected']): ?><span class="count">(<?php echo $this->_tpl_vars['v']['count']; ?>
)</span><?php endif; ?></span>
                                <?php else: ?>
                                <input type="radio" name="filter<?php echo $this->_tpl_vars['e']['id']; ?>
value" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['v']['selected']): ?>checked<?php endif; ?> >
                                <?php if ($this->_tpl_vars['currentURL']): ?>
                                <a href="<?php echo $this->_tpl_vars['currentURL']; ?>
<?php echo $this->_tpl_vars['v']['url']; ?>
" <?php if (! $this->_tpl_vars['v']['seo']): ?> rel="nofollow" <?php endif; ?> title="<?php echo $this->_tpl_vars['v']['name']; ?>
 <?php echo $this->_tpl_vars['titleH1']; ?>
">
                                <?php echo $this->_tpl_vars['v']['name']; ?>
 <?php if (! $this->_tpl_vars['v']['selected']): ?><span class="count">(<?php echo $this->_tpl_vars['v']['count']; ?>
)</span><?php endif; ?>
                                </a>
                                <?php else: ?>
                                <?php echo $this->_tpl_vars['v']['name']; ?>
 <?php if (! $this->_tpl_vars['v']['selected']): ?><span class="count">(<?php echo $this->_tpl_vars['v']['count']; ?>
)</span><?php endif; ?>
                                <?php endif; ?>
                                <?php endif; ?>
                            </label>
                            <br />

                        <?php endforeach; endif; unset($_from); ?>
                    </span>
            <?php endif; ?>
        </div>
        <?php endforeach; endif; unset($_from); ?>

        <div class="filter-element">
            <label>
                <input type="radio" name="filterpresence" value="" <?php if (! $this->_tpl_vars['control_filterpresence']): ?> checked <?php endif; ?>>
                <?php echo $this->_tpl_vars['translate_all']; ?>

            </label>
            <br />

            <label>
                <input type="radio" name="filterpresence" value="yes" <?php if ($this->_tpl_vars['control_filterpresence'] == 'yes'): ?> checked <?php endif; ?>>
                <?php echo $this->_tpl_vars['translate_available']; ?>

            </label>
            <br />

            <label>
                <input type="radio" name="filterpresence" value="no" <?php if ($this->_tpl_vars['control_filterpresence'] == 'no'): ?> checked <?php endif; ?>>
                <?php echo $this->_tpl_vars['translate_not_available']; ?>

            </label>
            </label>
        </div>

        <div class="button">
            <input class="cl-button grey js-submit-filter" type="submit" value="<?php echo $this->_tpl_vars['translate_search_capital']; ?>
" />
        </div>
    </form>
</div>