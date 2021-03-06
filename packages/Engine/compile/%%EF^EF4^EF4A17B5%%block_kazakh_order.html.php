<?php /* Smarty version 2.6.27-optimized, created on 2015-11-18 16:16:53
         compiled from /var/www/shop.local/modules/kazakhfilm-adaptive/contents/block/block_kazakh_order.html */ ?>
<div class="kzh-modal-wrapp bookingForm-1">
    <div class="modal-black-mask">&nbsp;</div>
    <div class="kzh-modal" style="margin-left: -273px;">
        <div class="kzh-modal-header">
            Бронирование номеров
        </div>
        <div class="kzh-modal-content">
            <div class="kzh-booking-form">
                <?php if ($this->_tpl_vars['orderSuccess']): ?>
                    <script type="text/javascript">
                        $j(function() {
                            //$j('.booking-button-block>a').click();
                            $j('.js_menu_booking').click();
                        });
                    </script>
                    <div class="shop-message-success">
                        Заказ на бронирование номера отослан.<br>
                        В ближайшее время с Вами свяжется наш менеджер.
                    </div>
                    <!-- Google Code for &#1047;&#1072;&#1073;&#1088;&#1086;&#1085;&#1080;&#1088;&#1086;&#1074;&#1072;&#1090;&#1100; &#1086;&#1090;&#1077;&#1083;&#1100; Conversion Page -->
                    <script type="text/javascript">
                        /* <![CDATA[ */
                        var google_conversion_id = 1010099357;
                        var google_conversion_language = "en";
                        var google_conversion_format = "3";
                        var google_conversion_color = "ffffff";
                        var google_conversion_label = "UL0qCKuB7QgQncnT4QM";
                        var google_conversion_value = 5.000000;
                        var google_remarketing_only = false;
                        /* ]]> */
                    </script>
                    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
                    </script>
                    <noscript>
                        <div style="display:inline;">
                            <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1010099357/?value=5.000000&amp;label=UL0qCKuB7QgQncnT4QM&amp;guid=ON&amp;script=0"/>
                        </div>
                    </noscript>
                <?php else: ?>
                    <?php if ($this->_tpl_vars['errorArray']): ?>
                        <script type="text/javascript">
                            $j(function() {
                                $j('.booking-button-block>a').click();
                            });
                        </script>
                        <div class="shop-message-error">
                            <?php $_from = $this->_tpl_vars['errorArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                                <?php if ($this->_tpl_vars['e'] == 'name'): ?>
                                    Не указано имя или фамилия.<br>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['e'] == 'phone'): ?>
                                    Указан некорректный телефон.<br>
                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        </div>
                    <?php endif; ?>
                    <form method="post">
                        <label>
                            <span>Имя</span><br />
                            <input type="text" class="long" name="clientname" value="<?php echo $this->_tpl_vars['control_clientname']; ?>
"/>
                        </label>
                        <label style="margin-left: 15px">
                            <span>Фамилия</span><br />
                            <input type="text" class="long" name="clientfamilyname" value="<?php echo $this->_tpl_vars['control_clientfamilyname']; ?>
"/>
                        </label>
                        <br />
                        <label>
                            <span>Номер телефона</span><br />
                            <input type="text" class="long js-phone-formatter" name="clientphone" value="<?php echo $this->_tpl_vars['control_clientphone']; ?>
" placeholder="+_ (___)___-__-__" />
                        </label>
                        <br />
                        <label>
                            <span>Дата заезда</span><br />
                            <input type="text" class="semi-long" name="datefrom" id="datefrom" value="<?php echo $this->_tpl_vars['control_datefrom']; ?>
"/>
                            <script type="text/javascript">
                                $j('#datefrom').datepicker({
                                    closeText: 'Закрыть',
                                    prevText: '&#x3c;Пред',
                                    nextText: 'След&#x3e;',
                                    currentText: 'Сегодня',
                                    monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
                                        'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                                    monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
                                        'Июл','Авг','Сен','Окт','Ноя','Дек'],
                                    dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
                                    dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
                                    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                                    dateFormat: 'dd.mm.yy', firstDay: 1,
                                    isRTL: false
                                });
                            </script>
                        </label>
                        <label style="margin-left: 15px">
                            <span>Дата выезда</span><br />
                            <input type="text" class="semi-long" name="dateto" id="dateto" value="<?php echo $this->_tpl_vars['control_dateto']; ?>
" />
                            <script type="text/javascript">
                                $j('#dateto').datepicker({
                                    closeText: 'Закрыть',
                                    prevText: '&#x3c;Пред',
                                    nextText: 'След&#x3e;',
                                    currentText: 'Сегодня',
                                    monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
                                        'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                                    monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
                                        'Июл','Авг','Сен','Окт','Ноя','Дек'],
                                    dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
                                    dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
                                    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                                    dateFormat: 'dd.mm.yy', firstDay: 1,
                                    isRTL: false
                                });
                            </script>
                        </label>
                        <br />
                        <label>
                            <span>Количесто человек</span><br />
                            <select class="people-count" name="peoplecount" >
                                <option value="1" <?php if ($this->_tpl_vars['control_peoplecount'] == 1): ?>selected<?php endif; ?>>1</option>
                                <option value="2" <?php if ($this->_tpl_vars['control_peoplecount'] == 2): ?>selected<?php endif; ?>>2</option>
                                <option value="3" <?php if ($this->_tpl_vars['control_peoplecount'] == 3): ?>selected<?php endif; ?>>3</option>
                                <option value="10" <?php if ($this->_tpl_vars['control_peoplecount'] == 10): ?>selected<?php endif; ?>>Больше</option>
                            </select>
                        </label>
                        <label style="margin-left: 43px">
                            <span>Тип номера</span><br />
                            <select class="room-type" name="roomtype" id="roomtype">
                                <?php $_from = $this->_tpl_vars['productsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
                                    <option value="<?php echo $this->_tpl_vars['p']['id']; ?>
" <?php if ($this->_tpl_vars['control_roomtype'] == $this->_tpl_vars['p']['id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['p']['name']; ?>
 <?php echo $this->_tpl_vars['p']['price']; ?>
 <?php echo $this->_tpl_vars['p']['currency']; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </label>
                        <br />
                        <label>
                            <span>Дополнительные пожелания</span><br />
                            <textarea name="comment"><?php echo $this->_tpl_vars['control_comment']; ?>
</textarea>
                        </label>
                        <div class="kzh-modal-submit">
                            <input type="hidden" name="ajs" class="ajs" value="1" />
                            <input type="submit" name="kazakh_order" value="Отправить запрос" class="kzh-btn-default" />
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>