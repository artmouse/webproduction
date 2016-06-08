<?php
class ckeditor_image_upload_ajax extends Engine_Class {



    public function process() {
        // задача скрипта - принять и положить файл в /media/shop/
        // и выдать ссылку на него

        $file = Engine::GetURLParser()->getArgument('Filedata');

        if (!empty($file)) {
            $tempFile = $file['tmp_name'];
            $imageMb = round($file['size'] / 1048576, 2);
            $imagesize = @getimagesize($tempFile);
            if ($imageMb  > 10) {
                echo 'Изображение слишком велико.';
                exit();
            }

            // конвертация изображения в необходимый формат
            // и допустимый размер
            $tempFile = Shop::Get()->getShopService()->convertImage($tempFile);

            $fileUrl = Shop::Get()->getShopService()->makeImagesUploadUrl($tempFile);
            $targetFile = PackageLoader::Get()->getProjectPath().'media/shop/'.$fileUrl;
            $fileUrl = '/media/shop/'.$fileUrl;
            if (Checker::CheckImageFormat($tempFile)) {
                if (!file_exists($targetFile)) {
                    copy($tempFile, $targetFile);
                }
                echo $fileUrl;
            } else {
                echo 'Не корректный файл.';
            }
        }
        exit(0);
    }

}