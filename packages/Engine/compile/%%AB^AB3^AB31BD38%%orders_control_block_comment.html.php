<?php /* Smarty version 2.6.27-optimized, created on 2015-12-11 18:00:38
         compiled from /var/www/shop.local/modules/order/contents/admin//orders/orders_control_block_comment.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/var/www/shop.local/modules/order/contents/admin//orders/orders_control_block_comment.html', 57, false),)), $this); ?>
<div class="ob-comment-add js-droppable-zone<?php echo $this->_tpl_vars['time']; ?>
">
    <div class="nb-block-tabs js-slide-tabs js-comment-tabs">
        <input id="js-comment-type" type="hidden" name="commenttype" value="comment">

        <div class="tab-element"><a class="selected js-order-comment-link-dashed" href="#" data-name="comment"><?php echo $this->_tpl_vars['translate_leave_comment']; ?>
</a></div>
        <?php if ($this->_tpl_vars['clientPostEmail']): ?>
            <div class="tab-element"><a href="#" class="js-order-comment-link-dashed" data-name="letter"><?php echo $this->_tpl_vars['translate_write_letter']; ?>
</a></div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['clientPostSmsArray']): ?>
            <div class="tab-element"><a href="#" class="js-order-comment-link-dashed" data-name="sms"><?php echo $this->_tpl_vars['translate_napisat_sms']; ?>
</a></div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['box']): ?>
            <div class="tab-element"><a href="#" class="js-order-comment-link-dashed" data-name="issue"><?php echo $this->_tpl_vars['translate_postavit_zadachu']; ?>
</a></div>
        <?php endif; ?>
        <span class="hover"></span>
        <div class="clear"></div>
    </div>

    <div class="comment-wrap">
        <div class="comment-cell">
            <div class="js-order-comment-div">
                <div class="js-order-comment-letter-div" style="display: none;">
                    <input type="text" placeholder="<?php echo $this->_tpl_vars['translate_vvedite_e_mail']; ?>
" value="<?php echo $this->_tpl_vars['clientPostEmail']; ?>
" name="post_letter_email" style="width: 100%;" />
                    <br />
                    <br />
                    <input type="text" placeholder="<?php echo $this->_tpl_vars['translate_ukazhite_temu']; ?>
" value="" name="post_letter_subject" style="width: 100%;" />
                    <br />
                    <br />
                </div>

                <div class="js-order-comment-sms-div" style="display: none;">
                    <select name="post_sms_number" class="chzn-select" style="width: 170px;">
                        <?php $_from = $this->_tpl_vars['clientPostSmsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
                            <option value="<?php echo $this->_tpl_vars['p']; ?>
"><?php echo $this->_tpl_vars['p']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                    <br />
                </div>

                <div class="area-wrap">
                    <textarea id="js-postcomment" name="postcomment" class="js-autosize js-field-localstorage js-usertextcomplete" data-storage="comment" placeholder="<?php echo $this->_tpl_vars['translate_message']; ?>
"></textarea>
                    <div class="quick-buttons">
                        <a class="js-add-codetag" href="#">[code]</a>
                    </div>
                </div>

                <?php if ($this->_tpl_vars['watcherArray']): ?>
                    <span class="watchers">
                        <?php echo $this->_tpl_vars['translate_poluchayut_uvedomleniya']; ?>
:
                        <?php $_from = $this->_tpl_vars['watcherArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
                            <a href="<?php echo $this->_tpl_vars['e']['url']; ?>
" class="js-contact-preview" data-id="<?php echo $this->_tpl_vars['e']['id']; ?>
"><?php echo $this->_tpl_vars['e']['name']; ?>
</a>
                        <?php endforeach; endif; unset($_from); ?>
                    </span>
                <?php endif; ?>

                <div class="js-order-comment-letter-div" style="display: none;">
                    <div <?php if (count($this->_tpl_vars['emailFromArray']) < 2): ?>style="display: none;"<?php endif; ?>>
                        Email <?php echo $this->_tpl_vars['translate_otpravitelya']; ?>
:
                        <select class="chzn-select" name="post_letter_email_from">
                            <?php $_from = $this->_tpl_vars['emailFromArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['em']):
?>
                                <option value="<?php echo $this->_tpl_vars['em']; ?>
"><?php echo $this->_tpl_vars['em']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                        <br />
                    </div>
                </div>
            </div>
        </div>

        <?php if ($this->_tpl_vars['commentTemplateArray']): ?>
            <div class="template-cell js-template-cell">
                <div class="list">
                    <?php $_from = $this->_tpl_vars['commentTemplateArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comment']):
?>
                        <a href="javascript:void(0);" class="ob-link-dashed" data-text="<?php echo $this->_tpl_vars['comment']['text']; ?>
"
                           onclick="
                           $j('#js-postcomment').val($j('#js-postcomment').val()+$j(this).data('text')).trigger('autosize.resize');"><?php echo $this->_tpl_vars['comment']['name']; ?>
</a>
                        <br>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($this->_tpl_vars['box']): ?>
        <div class="ob-block-attach">
            <a href="#" name="file[]" class="ob-button-attach js-uploader<?php echo $this->_tpl_vars['time']; ?>
"><?php echo $this->_tpl_vars['translate_prilozhit_fayli']; ?>
...</a>
        </div>
        <script type="text/javascript">
            var uploader = new DropUploader('.js-droppable-zone<?php echo $this->_tpl_vars['time']; ?>
', '.js-uploader<?php echo $this->_tpl_vars['time']; ?>
');
        </script>
    <?php endif; ?>
</div>

<?php echo $this->_tpl_vars['block_comment']; ?>


<div class="shop-block-popup js-edit-message-popup" style="display: none;">
    <div class="dark"></div>
    <div class="popupblock">
        <a href="#" class="close" onclick="popupClose('.js-edit-message-popup');">
            <svg viewBox="0 0 16 16">
                <use xlink:href="#icon-close"></use>
            </svg>
        </a>
        <div class="head">
            <span class="js-popup-title"><?php echo $this->_tpl_vars['translate_redaktirovat_soobshchenie']; ?>
</span>
        </div>
        <div class="window-content window-form">
            <div class="element">
                <textarea class="js-autosize js-edit-comment-text" val=""></textarea>
            </div>

            <div class="ob-button-fixed">
                <input type="button" value="" data-id="" data-action="" class="ob-button button-green js-edit-comment" />
                <input class="ob-button button-cancel" type="button" value="<?php echo $this->_tpl_vars['translate_cancel']; ?>
" onclick="popupClose('.js-edit-message-popup');"/>
            </div>
            <div class="ob-button-fixed-place"></div>
        </div>
    </div>
</div>