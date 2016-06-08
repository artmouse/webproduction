<?php /* Smarty version 2.6.27-optimized, created on 2015-11-23 15:01:02
         compiled from /var/www/shop.local/contents/help/help_menu.html */ ?>
<div class="search-helper">
    <input class="js-search-helper" type="text" name="" value="" placeholder="Быстрый поиск"/>
</div>

<div class="menu-wrap js-menu-wrap">
    <?php if ($this->_tpl_vars['newMenuArray'][1]): ?>
        <ul>
            <?php $_from = $this->_tpl_vars['newMenuArray'][1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['m']):
?>
                <li>
                    <a href="<?php echo $this->_tpl_vars['m']['url']; ?>
" <?php if ($this->_tpl_vars['m']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['m']['name']; ?>
</a>
                    <?php if ($this->_tpl_vars['m']['selected'] && $this->_tpl_vars['m']['legArray']): ?>
                        <ul class="navi">
                            <?php $_from = $this->_tpl_vars['m']['legArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val'] => $this->_tpl_vars['link']):
?>
                                <li><a href="#" data-id="block<?php echo $this->_tpl_vars['link']['id']; ?>
"><?php echo $this->_tpl_vars['link']['name']; ?>
</a></li>
                            <?php endforeach; endif; unset($_from); ?>
                        </ul>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['newMenuArray'][$this->_tpl_vars['m']['key']]): ?>
                        <div class="expand"></div>
                        <ul style="display: none;">
                            <?php $_from = $this->_tpl_vars['newMenuArray'][$this->_tpl_vars['m']['key']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['m2']):
?>
                                <li>
                                    <a href="<?php echo $this->_tpl_vars['m2']['url']; ?>
" <?php if ($this->_tpl_vars['m2']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['m2']['name']; ?>
</a>
                                    <?php if ($this->_tpl_vars['m2']['selected'] && $this->_tpl_vars['m2']['legArray']): ?>
                                        <ul class="navi">
                                            <?php $_from = $this->_tpl_vars['m2']['legArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val'] => $this->_tpl_vars['link']):
?>
                                                <li><a href="#" data-id="block<?php echo $this->_tpl_vars['link']['id']; ?>
"><?php echo $this->_tpl_vars['link']['name']; ?>
</a></li>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </ul>
                                    <?php endif; ?>
                                    <?php if ($this->_tpl_vars['newMenuArray'][$this->_tpl_vars['m2']['key']]): ?>
                                        <div class="expand"></div>
                                        <ul style="display: none;">
                                            <?php $_from = $this->_tpl_vars['newMenuArray'][$this->_tpl_vars['m2']['key']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key3'] => $this->_tpl_vars['m3']):
?>
                                                <li>
                                                    <a href="<?php echo $this->_tpl_vars['m3']['url']; ?>
" <?php if ($this->_tpl_vars['m3']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['m3']['name']; ?>
</a>
                                                    <?php if ($this->_tpl_vars['m3']['selected'] && $this->_tpl_vars['m3']['legArray']): ?>
                                                        <ul class="navi">
                                                            <?php $_from = $this->_tpl_vars['m3']['legArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val'] => $this->_tpl_vars['link']):
?>
                                                                <li><a href="#" data-id="block<?php echo $this->_tpl_vars['link']['id']; ?>
"><?php echo $this->_tpl_vars['link']['name']; ?>
</a></li>
                                                            <?php endforeach; endif; unset($_from); ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                    <?php if ($this->_tpl_vars['newMenuArray'][$this->_tpl_vars['m3']['key']]): ?>
                                                        <div class="expand"></div>
                                                        <ul style="display: none;">
                                                            <?php $_from = $this->_tpl_vars['newMenuArray'][$this->_tpl_vars['m3']['key']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key4'] => $this->_tpl_vars['m4']):
?>
                                                                <li>
                                                                    <a href="<?php echo $this->_tpl_vars['m4']['url']; ?>
" <?php if ($this->_tpl_vars['m4']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['m4']['name']; ?>
</a>
                                                                    <?php if ($this->_tpl_vars['m4']['selected'] && $this->_tpl_vars['m4']['legArray']): ?>
                                                                        <ul class="navi">
                                                                            <?php $_from = $this->_tpl_vars['m4']['legArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val'] => $this->_tpl_vars['link']):
?>
                                                                                <li><a href="#" data-id="block<?php echo $this->_tpl_vars['link']['id']; ?>
"><?php echo $this->_tpl_vars['link']['name']; ?>
</a></li>
                                                                            <?php endforeach; endif; unset($_from); ?>
                                                                        </ul>
                                                                    <?php endif; ?>
                                                                    <?php if ($this->_tpl_vars['newMenuArray'][$this->_tpl_vars['m4']['key']]): ?>
                                                                        <div class="expand"></div>
                                                                        <ul style="display: none;">
                                                                            <?php $_from = $this->_tpl_vars['newMenuArray'][$this->_tpl_vars['m4']['key']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key5'] => $this->_tpl_vars['m5']):
?>
                                                                                <li>
                                                                                    <a href="<?php echo $this->_tpl_vars['m5']['url']; ?>
" <?php if ($this->_tpl_vars['m5']['selected']): ?>class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['m5']['name']; ?>
</a>
                                                                                </li>
                                                                            <?php endforeach; endif; unset($_from); ?>
                                                                        </ul>
                                                                    <?php endif; ?>
                                                                </li>
                                                            <?php endforeach; endif; unset($_from); ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; endif; unset($_from); ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    <?php endif; ?>
</div>