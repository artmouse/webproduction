<?php
class imagecropper_upload_ajax extends Engine_Class {

    public function process() {
        $file = Engine::GetURLParser()->getArgument('Filedata');

        if (!empty($file)) {
            $tempFile = $file['tmp_name'];
            $imageMb = round($file['size'] / 1048576, 2);
            $imagesize = @getimagesize($tempFile);
            $cropWidth = (int)Shop::Get()->getSettingsService()->getSettingValue('cropwidth');
            $cropHeight = (int)Shop::Get()->getSettingsService()->getSettingValue('cropheight');
            if (!$cropWidth || !$cropHeight) {
                $cropWidth = 93;
                $cropHeight = 70;
            }
            if ($imageMb  > 10  || empty($imagesize[1])) {
                echo 'Изображение слишком велико.';
                exit();
            } elseif ($imagesize[1] < $cropWidth || $imagesize[0] < $cropHeight) {
                echo 'Изображение слишком мало.';
                exit();
            }

            // конвертация изображения в необходимый формат
            // и допустимый размер
            $tempFile = Shop::Get()->getShopService()->convertImage($tempFile);
            $imagesize = @getimagesize($tempFile);
            if ($imagesize[2] == 2) {
                $ext = 'jpg';
            } else {
                $ext = 'png';
            }
            $filename = $this->_makeImagesUploadUrl($tempFile,'imagecropper/',$ext);
            if (Checker::CheckImageFormat($tempFile)) {
                if (!file_exists($filename)) {
                    copy($tempFile, PackageLoader::Get()->getProjectPath().$filename);
                }
                $json['src'] = $filename;

                /*
                //прикинем приемлимые размеры для окошка превьюхи
                if ($imagesize[0] > $cropWidth && $imagesize[1] > $cropHeight ) {
                    $koef = $imagesize[0]/$cropWidth < $imagesize[1]/$cropHeight ? $imagesize[0]/$cropWidth : $imagesize[1]/$cropHeight;
                    $json['widthdiv'] = $cropWidth*$koef;
                    $json['heightdiv'] = $cropHeight*$koef;
                } else {
                    $json['widthdiv'] = $cropWidth;
                    $json['heightdiv'] = $cropHeight;
                }
                */
                $width = 0;
                $height = 0;
                $koe = 1;
                // подганяем под розмеры попапа
                if( $imagesize[1] <  $imagesize[0]){
                    $koe = $imagesize[0]/580;
                    $width = 580;
                    $height =  $imagesize[1]/$koe;
                    $json['cropWidth'] = $cropWidth;
                    $json['cropHeight'] = $cropHeight;
                }else{
                    $koe = $imagesize[1]/500;
                    $height = 500;
                    $width =  $imagesize[0]/$koe;
                    $json['cropWidth'] = $cropHeight;
                    $json['cropHeight'] = $cropWidth;
                }
                $json['koef'] = $koe;
                $json['width'] = $width;
                $json['height'] = $height;

                $json['widthdiv'] = $width;
                $json['heightdiv'] = $height;

                $json['filename'] = $filename;
                $json['ext'] = $ext;

                print json_encode($json);

            } else {
                echo 'Не корректный файл.';
            }
        }
        exit(0);
    }

    private function _makeImagesUploadUrl($image, $folder = 'imagecropper/', $fileformat = 'png') {
        $imagemd5 = md5_file($image);
        $imagemd5 = '/media/'.$folder.$imagemd5.'.'.$fileformat;
        return $imagemd5;
    }


}