<?php /* Smarty version 2.6.27-optimized, created on 2015-12-02 18:05:44
         compiled from /var/www/shop.local/contents/shop/admin/ticket/ticket_index.html */ ?>
<div class="nb-top-nav-place js-top-nav-buffer"></div>
<div class="nb-top-nav js-top-nav">
    <div class="nb-block-tabs">
        <div class="tab-element"><a href="" class="selected">Support ticket</a></div>
        <div class="clear"></div>
    </div>
</div>

<?php if (! $this->_tpl_vars['message'] == 'ok'): ?>
    <div class="shop-message-info">
        <?php echo $this->_tpl_vars['translate_you_send_question_to_support']; ?>
<?php if ($this->_tpl_vars['branding']): ?> <?php echo $this->_tpl_vars['branding']; ?>
<?php endif; ?>.
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'ok'): ?>
    <div class="shop-message-success">
        <?php echo $this->_tpl_vars['translate_requests_sent_success']; ?>
.<br />
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['message'] == 'error'): ?>
    <div class="shop-message-error">
        <?php echo $this->_tpl_vars['translate_send_error']; ?>
.<br />
        <?php $_from = $this->_tpl_vars['errorsArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
            <?php if ($this->_tpl_vars['e'] == 'email'): ?>
                <?php echo $this->_tpl_vars['translate_profile_error_mail']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'name'): ?>
                <?php echo $this->_tpl_vars['translate_enter_name']; ?>
.<br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['e'] == 'message'): ?>
                <?php echo $this->_tpl_vars['translate_text_error']; ?>
.<br />
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>
<form action="" method="post">
    <div class="ob-block-doubleform">
        <div class="wrap">
            <div class="left-column">
                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_kak_mi_mozhem_k_vam_obrashchatsya']; ?>
?</div>
                    <input type="text" name="name" value="<?php echo $this->_tpl_vars['control_name']; ?>
" />
                </div>

                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_na_kakoy_email_vam_prislat_otvet']; ?>
?</div>
                    <input type="text" name="email" value="<?php echo $this->_tpl_vars['control_email']; ?>
" />
                </div>

                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_mozhem_li_mi_vam_pozvonit']; ?>
?</div>
                    <input type="text" name="phone" value="<?php echo $this->_tpl_vars['control_phone']; ?>
" />
                </div>

                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_opishite_vash_vopros_ili_problemu']; ?>
</div>
                    <textarea name="message"><?php echo $this->_tpl_vars['control_message']; ?>
</textarea>
                </div>

                <div class="form-element">
                    <div class="element-caption"><?php echo $this->_tpl_vars['translate_prilozhite_fayli_esli_nuzhno']; ?>
</div>
                    <div class="ob-block-attach js-droppable-zone">
                        <a href="#" name="file[]" class="ob-button-attach js-uploader"><?php echo $this->_tpl_vars['translate_prilozhit_fayli']; ?>
...</a>
                    </div>
                </div>
            </div>
    
            <script>
                $j(function() {
                    // загрузка файлов
                    var uploader = new DropUploader('.js-droppable-zone', '.js-uploader', 'fileid');
                     $j('.js-phone-formatter').mask("+38 (999) 999-99-99");
                     
                });
            </script>

            <div class="right-column half">
                <div class="form-element">
                    <?php echo $this->_tpl_vars['translate_esli_u_vas_est_kakaya_libo_problema_chto_to_ne_ponyatno_chto_to_ne_poluchaetsya_ili_kazhetsya_chto_rabotaet_ne_tak_mozhete_otpravit_vopros_nashey_tehnicheskoy_podderzhke']; ?>
.
                    <br>
                    <?php echo $this->_tpl_vars['translate_mi_postaraemsya_vam_pomoch_kak_mozhno_bistree']; ?>
.
                </div>
                <div class="form-element">
                    <?php echo $this->_tpl_vars['translate_postaraytes_opisat_vash_vopros_ili_problemu_maksimalno_podrobno_esli_nuzhno_prilozhite_skrinshot_interfeysa']; ?>
.
                    <br>
                    <?php echo $this->_tpl_vars['translate_tak_mi_smozhem_bistree_ponyat_chto_ne_tak_i_ustranit_problemu']; ?>
.
                </div>
                <div class="form-element">
                    <?php echo $this->_tpl_vars['translate_tak_zhe_u_nas_est']; ?>
 <a href="/doc/"><?php echo $this->_tpl_vars['translate_dokumentatsiya']; ?>
</a> <?php echo $this->_tpl_vars['translate_i_spisok_samih_chasto_zadavaemih_voprosov_nashih_klientov_on_opublikovan_na_sayte']; ?>

                    <a href="http://onebox-system.com/">onebox-system.com</a>)
                </div>
            </div>
        </div>
    </div>

    <div class="ob-button-fixed">
        <input type="submit" name="ok" value="<?php echo $this->_tpl_vars['translate_send_request_to_technical_support']; ?>
" class="ob-button button-green" />
    </div>
    <div class="ob-button-fixed-place"></div>
</form>