<?php /* Smarty version 2.6.27-optimized, created on 2015-11-24 12:07:11
         compiled from /var/www/shop.local/api/forms/Shop_ContentFieldImage.html */ ?>
<script type="text/javascript">
    $j(function(){
        var $loading = false;
        var $productid = 0;
        var $element;

        $j('.js-image').click(function(e){
            $element = $j(this).parent().find('.js-image-add');
            $element.show();
            $productid = $element.data('id');
            e.preventDefault();
        });

        $j('.close').click(function(e){
            // Во время загрузки изображения нельзя скрывать
            if ($j('.uploadify-queue-item').length < 1) {
                $j(this).parent().hide();
            }
            return false;
        })

        // файл-аплоадер
        if($j('.js-file_upload').is('.js-file_upload')) {
            $j('.js-file_upload').uploadify({
                swf           : '/media/uploadify/uploadify.swf',
                uploader      : '/admin/shop/uplodify/',
                buttonText    : 'Загрузить',
                'onUploadSuccess' : function(file, data, response) {
                    if (data != 'Не коректный фаил.' && data != 'Изображение слишком велико.') {
                        $j.ajax({
                            url: '/admin/shop/products/imageupload/',
                            type:'GET',
                            data: {
                                file: data,
                                id: $productid,
                                main: true
                            },
                            success: function(image) {
                                $j('.js-image-add').hide();
                                $j($element).parent().find('.js-image').find('img').attr('src','/media/shop/'+data);
                            },
                            fail: function() {
                            },
                            always: function() {
                            }
                        });
                    } else {
                        $j('.js-image-add').append('<div>'+data+'</div>');
                    }
                }

            });
        }
    });
</script>
<div class="shop-productimage-preview">
    <div class="image-add js-image-add" data-id="<?php echo $this->_tpl_vars['productid']; ?>
" style="display: none;">
        <a href="#" class="close">x</a>
        <input type="file" name="file_upload" class="js-file_upload" id="<?php echo $this->_tpl_vars['productid']; ?>
"/>
    </div>
    <?php if ($this->_tpl_vars['image']): ?>
        <div class="image js-image"><img data-imageid="<?php echo $this->_tpl_vars['productid']; ?>
" src="<?php echo $this->_tpl_vars['image']; ?>
" /></div>
    <?php endif; ?>
</div>