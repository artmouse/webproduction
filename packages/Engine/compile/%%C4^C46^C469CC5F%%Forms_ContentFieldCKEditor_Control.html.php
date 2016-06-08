<?php /* Smarty version 2.6.27-optimized, created on 2015-11-18 16:46:04
         compiled from /var/www/shop.local/packages/Forms/Forms_ContentFieldCKEditor_Control.html */ ?>
<textarea name="<?php echo $this->_tpl_vars['key']; ?>
" style="width: 99%; height: 100px;" id="id-<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['value']; ?>
</textarea>

<script type="text/javascript" src="/packages/CKEditor/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.replace('id-<?php echo $this->_tpl_vars['key']; ?>
', {
    filebrowserBrowseUrl : '/packages/CKFinder/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : '/packages/CKFinder/ckfinder/ckfinder.html?Type=Images',
    filebrowserFlashBrowseUrl : '/packages/CKFinder/ckfinder/ckfinder.html?Type=Flash',
    filebrowserUploadUrl : '/packages/CKFinder/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : '/packages/CKFinder/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : '/packages/CKFinder/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
    height : '350px'
});
</script>