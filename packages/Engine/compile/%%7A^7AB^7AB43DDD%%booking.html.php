<?php /* Smarty version 2.6.27-optimized, created on 2015-12-17 00:04:10
         compiled from /var/www/shop.local/modules/kazakhfilm-adaptive/contents/booking.html */ ?>
<div class="kzh-page-content">
    <h1>Номера и цены</h1>

    <?php $_from = $this->_tpl_vars['productsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['p']):
?>
        <div class="kzh-room-preview-block">
            <div class="room-preview-images">
                <div class="fancy-bg">
                    <a class="grup-<?php echo $this->_tpl_vars['k']+1; ?>
" href="<?php echo $this->_tpl_vars['p']['images'][0]['originalUrl']; ?>
" rel="grup-<?php echo $this->_tpl_vars['k']+1; ?>
">
                        <img src="<?php echo $this->_tpl_vars['p']['images'][0]['mediumUrl']; ?>
" alt=""/>
                    </a>
                </div>

                <div class="room-preview-additional-img">
                    <?php $_from = $this->_tpl_vars['p']['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['im']):
?>
                        <?php if ($this->_tpl_vars['key']): ?>
                            <a class="grup-<?php echo $this->_tpl_vars['k']+1; ?>
" href="<?php echo $this->_tpl_vars['im']['originalUrl']; ?>
" rel="grup-<?php echo $this->_tpl_vars['k']+1; ?>
">
                                <img src="<?php echo $this->_tpl_vars['im']['cropUrl']; ?>
" width="90" height="60" alt=""/>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
            </div>

            <div class="room-preview-description">
                <h2 class="room-preview-description-header">
                    <?php echo $this->_tpl_vars['p']['name']; ?>

                </h2>
                <div class="room-preview-description-text">
                    <?php echo $this->_tpl_vars['p']['description']; ?>

                </div>

                <div class="room-futures-block">
                    <?php $_from = $this->_tpl_vars['p']['characteristic']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['characteristic']):
?>
                        <ul>
                            <li class="room-futures-list-header">
                                <?php echo $this->_tpl_vars['characteristic']['name']; ?>
:
                            </li>
                            <?php $_from = $this->_tpl_vars['characteristic']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch']):
?>
                                <?php if ($this->_tpl_vars['ch']): ?>
                                    <li><span class="room-future-name"><?php echo $this->_tpl_vars['ch']; ?>
</span></li>
                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        </ul>
                    <?php endforeach; endif; unset($_from); ?>
                    <div class="clear">&nbsp;</div>
                </div>
                <br />

                <div class="room-preview-price-block">
                    <div class="room-preview-price">
                        <table>
                            <tr style="display: block;" class="js-toggle-currency">
                                <td>Цена:</td>
                                <td>
                                    <strong><?php echo $this->_tpl_vars['p']['price']; ?>
 <?php echo $this->_tpl_vars['p']['currency']; ?>
</strong> / сутки<br />
                                    <?php if ($this->_tpl_vars['p']['price_half']): ?>
                                    <strong><?php echo $this->_tpl_vars['p']['price_half']; ?>
 <?php echo $this->_tpl_vars['p']['currency']; ?>
</strong> / полсуток
                                    <?php endif; ?>
                                </td>
                            </tr>


                            <tr style="display: none;" class="js-toggle-currency">
                                <td>Цена:</td>
                                <td>
                                    <strong><?php echo $this->_tpl_vars['p']['price_usd']; ?>
 <?php echo $this->_tpl_vars['p']['currency_usd']; ?>
</strong> / сутки<br />
                                    <?php if ($this->_tpl_vars['p']['price_half_usd']): ?>
                                    <strong><?php echo $this->_tpl_vars['p']['price_half_usd']; ?>
 <?php echo $this->_tpl_vars['p']['currency_usd']; ?>
</strong> / полсуток
                                    <?php endif; ?>
                                </td>
                            </tr>

                        </table>

                        <div class="flags">
                            <a href="javascript:void(0);" class="flag-kz js-toggle-currency-link"></a>
                            <a href="javascript:void(0);" class="flag-usa js-toggle-currency-link"></a>
                        </div>

                    </div>
                    <div class="booking-button-block">
                        <a href="javascript: void(0)" class="kzh-btn-default backcall book-me"  data-caption="callusModal">Получить консультацию</a>
                        <a href="javascript: void(0)" data-caption="bookingForm-1" class="kzh-btn-default book-me" data-id="<?php echo $this->_tpl_vars['p']['id']; ?>
">Забронировать номер</a>
                        <div class="booking-notice">
                            Бронирование и отмена<br />
                            бронирования бесплатные!
                        </div>
                    </div>
                    <div class="clear">&nbsp;</div>
                </div>
            </div>
            <div class="clear">&nbsp;</div>
        </div>
    <?php endforeach; endif; unset($_from); ?>
</div>