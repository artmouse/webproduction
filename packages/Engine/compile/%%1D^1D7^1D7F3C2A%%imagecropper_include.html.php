<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 11:42:52
         compiled from /var/www/shop.local/contents/shop/admin/imagecropper/imagecropper_include.html */ ?>
<div class="shop-block-popup js-croper-popup" style="display: none;">
    <div class="dark"></div>
    <div class="popupblock cropper">
        <a href="#" class="close" onclick="popupClose('.js-croper-popup'); $j('[style*=cursor]').hide(); $j('.imgareaselect-outer').hide(); return false;">
            <svg viewBox="0 0 16 16">
                <use xlink:href="#icon-close"></use>
            </svg>
        </a>
        <div class="head"><?php echo $this->_tpl_vars['translate_main_image_small']; ?>
</div>
        <div class="window-content window-form">
            <div class="ob-block-cropper js-cropper"></div>
            <div class="cropper-buttons">
                <a class="ob-button js-cropper-zoomout" href="#"><?php echo $this->_tpl_vars['translate_zoom_out']; ?>
</a>
                <a class="ob-button js-cropper-zoomin" href="#"><?php echo $this->_tpl_vars['translate_zoom_in']; ?>
</a>

                <a class="ob-button button-green" href="#" onclick="$j('#imageSave').val('ok'); $j('.ob-button-fixed .button-green').click(); return false;"><?php echo $this->_tpl_vars['translate_save_image']; ?>
</a>
                <a class="ob-button button-cancel" href="#" onclick="popupClose('.js-croper-popup'); $j('[style*=cursor]').hide(); $j('.imgareaselect-outer').hide(); return false;"><?php echo $this->_tpl_vars['translate_cancel']; ?>
</a>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<input type="hidden" name="imagecropper-x1" id="imagecropper-x1" />
<input type="hidden" name="imagecropper-y1" id="imagecropper-y1" />
<input type="hidden" name="imagecropper-x2" id="imagecropper-x2" />
<input type="hidden" name="imagecropper-y2" id="imagecropper-y2" />
<input type="hidden" name="imagecropper-name" id="imagecropper-name" value="noChange"/>
<input type="hidden" name="big-image-main" id="big-image-main"/>
<input type="hidden" name="imagecropper-ext" id="imagecropper-ext" />
<input type="hidden" name="imagecropper-koef" id="imagecropper-koef" />
<br>
<input type="file" name="file_upload_crop" id="file_upload_crop" />
<input type="hidden" name="imageSave" id="imageSave" value="">

<?php if ($this->_tpl_vars['cropEnable']): ?>
    <input type="hidden" class="js-imagecropper-enable" value="1" />
<?php endif; ?>