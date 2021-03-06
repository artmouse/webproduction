<?php
/**
 * Собственный процессор изображений с автоматическим
 * наложением водяного знака
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ImageProcessor {

    /**
     * Create image thumb by parameters and return path to file thumb
     *
     * @param string $filepath
     * @param int $width
     * @param int $height
     * @return string
     */
    public static function MakeThumbProportional($filepath, $width = false, $height = false, $format = 'png', $watermark = true) {
        // задано условие сохранения
        $pathinfo = pathinfo($filepath);
        $ext = @$pathinfo['extension'];
        if ($ext) {
            $thumbPath = str_replace('.'.$ext, '.ipthumb'.$width.'x'.$height.'prop.'.$format, $filepath);
        } else {
            $thumbPath = $filepath.'.ipthumb'.$width.'x'.$height.'prop.'.$format;
        }
        if (!file_exists($thumbPath)) {
            $ip = new ImageProcessor($filepath);
            $ip->addAction(new ImageProcessor_ActionResizeProportional($width, $height));

            // водяной знак
            if ($width >= 200 && $watermark) {
                $watermarkImage = Shop::Get()->getSettingsService()->getSettingValue('watermark-image');
                $watermarkPositionX = Shop::Get()->getSettingsService()->getSettingValue('watermark-position-x');
                $watermarkPositionY = Shop::Get()->getSettingsService()->getSettingValue('watermark-position-y');
                if ($watermarkImage && $watermarkPositionX && $watermarkPositionY) {
                    $watermarkImage = PackageLoader::Get()->getProjectPath().$watermarkImage;

                    try {
                        $ip->addAction(new ImageProcessor_ActionWatermarkPNG(
                        $watermarkImage, $watermarkPositionX, $watermarkPositionY
                        ));
                    } catch (Exception $watermarkEx) {

                    }
                }
            }

            if ($format == 'png') {
                $ip->addAction(new ImageProcessor_ActionToPNG($thumbPath));
            } else {
                $ip->addAction(new ImageProcessor_ActionToJPEG($thumbPath));
            }

            if (!$ip->process()) {
                return false;
            }
        }

        return $thumbPath;
    }

    /**
     * Create image thumb by parameters and return path to file thumb
     *
     * @param string $filepath
     * @param int $width
     * @param int $height
     * @return string
     */
    public static function MakeThumbCrop($filepath, $width = false, $height = false, $format = 'png', $watermark = true) {
        // задано условие сохранения
        $pathinfo = pathinfo($filepath);
        $ext = @$pathinfo['extension'];
        if ($ext) {
            $thumbPath = str_replace('.'.$ext, '.ipthumb'.$width.'x'.$height.'crop.'.$format, $filepath);
        } else {
            $thumbPath = $filepath.'.ipthumb'.$width.'x'.$height.'crop.'.$format;
        }

        if (!file_exists($thumbPath)) {
            $ip = new ImageProcessor($filepath);
            $ip->addAction(new ImageProcessor_ActionResizeCrop($width, $height));

            // водяной знак
            if ($width >= 200 && $watermark) {
                $watermarkImage = Shop::Get()->getSettingsService()->getSettingValue('watermark-image');
                $watermarkPositionX = Shop::Get()->getSettingsService()->getSettingValue('watermark-position-x');
                $watermarkPositionY = Shop::Get()->getSettingsService()->getSettingValue('watermark-position-y');
                if ($watermarkImage && $watermarkPositionX && $watermarkPositionY) {
                    $watermarkImage = PackageLoader::Get()->getProjectPath().$watermarkImage;

                    try {
                        $ip->addAction(new ImageProcessor_ActionWatermarkPNG(
                        $watermarkImage, $watermarkPositionX, $watermarkPositionY
                        ));
                    } catch (Exception $watermarkEx) {

                    }
                }
            }

            if ($format == 'png') {
                $ip->addAction(new ImageProcessor_ActionToPNG($thumbPath));
            } else {
                $ip->addAction(new ImageProcessor_ActionToJPEG($thumbPath));
            }

            if (!$ip->process()) {
                return false;
            }
        }

        return $thumbPath;
    }

    /**
     * Create image thumb by parameters and return path to file thumb
     *
     * @param string $filepath Полный путь к файлу
     * @param mixed $width Желаяемая ширина
     * @param mixed $height Желаемая высота
     * @param string $method Желаемый метод обрезки
     * @return string
     * @access static
     */
    public static function MakeThumbUniversal($filepath, $width = false, $height = false, $method = false, $format = 'png', $watermark = true) {
        if ($method == 'crop') {
            $x = self::MakeThumbCrop($filepath, $width, $height, $format, $watermark);
        } else {
            $x = self::MakeThumbProportional($filepath, $width, $height, $format, $watermark);
        }

        $x = str_replace(PackageLoader::Get()->getProjectPath(), '/', $x);
        $x = str_replace('//', '/', $x);

        return $x;
    }

}