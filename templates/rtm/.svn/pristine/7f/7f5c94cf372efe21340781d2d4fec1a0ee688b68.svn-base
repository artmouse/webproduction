<?php
/**
 * Shop_CronImportImages
 *
 * @author Andrii Andriiets <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneClick
 */
class Shop_CronImportImages implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        set_time_limit(0);
        ini_set('pcre.backtrack_limit', 300000);
        require(dirname(__FILE__) . '/../../../../packages/Engine/include.2.6.php');
        Engine::Get()->enableErrorReporting();

        $pidFile = __FILE__ . '.pid';
        if (file_exists($pidFile)) {
            print "\n\nProcess already running...\n\n";
            exit();
        }
        file_put_contents($pidFile, date('Y-m-d H:i:s'), LOCK_EX);

        $this->_importTask();

        unlink($pidFile);

    }

    private function _importTask() {
        // выполняем импорт

        $tmpDir = PackageLoader::Get()->getProjectPath() . 'templates/rtm/media/import_images/';
        if (is_dir($tmpDir)) {

            $d = opendir($tmpDir);
            while ($x = readdir($d)) {
                if ($x != '.' && $x != '..') {

                    $filename = $x;

                    $code = substr($x, 0, strlen($x) - 6);
                    $imageNumber = substr($x, strlen($x) - 5, strlen($x) - 4);

                    try {

                        $products = new ShopProduct(); // Shop::Get()->getShopService()->getProductByCode1c($code);
                        $products->setCode1c($code);
                        $imageConvert = Shop::Get()->getShopService()->convertImage($tmpDir . $filename);
                        while ($product = $products->getNext()) {
                            $imageNumber = str_replace('.jpg', '', $imageNumber);
                            $imageNumber = str_replace('.png', '', $imageNumber);

                            if ($imageNumber == 1) { // main image

                                if (!Checker::CheckImageFormat($imageConvert)) {
                                    throw new ServiceUtils_Exception('Invalid image format');
                                }

                                $file = RtmService::Get()->makeImagesUploadUrl(
                                    $imageConvert, '', 'shop/', $product, $imageNumber
                                );

                                copy($imageConvert, MEDIA_PATH . '/shop/' . $file);

                                if ($product->getImage() != $file) {
                                    $product->setImage($file);
                                }
                                // такой товар пользователь может видеть на каталоге
                                $product->setUser_view(1);
                                $product->update();

                            } else {
                                RtmService::Get()->addProductImage($product, $imageConvert, $imageNumber);
                            }

                            print 'image ' . $imageNumber . ' for product ' . $code . ' processed' . "\n";
                        }

                        @unlink($tmpDir . $filename);

                    } catch (Exception $ge) {

                    }

                }
            }

            closedir($d);

            print "\n\nPhoto loaded\n\n";
        }

        // теперь ищем по субартикулам
        $tmpDir = PackageLoader::Get()->getProjectPath() . 'templates/rtm/media/import_images_subarticul/';
        if (is_dir($tmpDir)) {

            $d = opendir($tmpDir);
            while ($x = readdir($d)) {
                if ($x != '.' && $x != '..') {

                    $filename = $x;

                    $code = substr($x, 0, strlen($x) - 6);
                    $imageNumber = substr($x, strlen($x) - 5, strlen($x) - 4);

                    try {

                        $products = new ShopProduct(); // Shop::Get()->getShopService()->getProductByCode1c($code);
                        $products->setSubarticul($code);
                        $imageConvert = Shop::Get()->getShopService()->convertImage($tmpDir . $filename);
                        while ($product = $products->getNext()) {
                            $imageNumber = str_replace('.jpg', '', $imageNumber);
                            $imageNumber = str_replace('.png', '', $imageNumber);

                            if ($imageNumber == 1) { // main image

                                if (!Checker::CheckImageFormat($imageConvert)) {
                                    throw new ServiceUtils_Exception('Invalid image format');
                                }

                                $file = RtmService::Get()->makeImagesUploadUrl(
                                    $imageConvert, '', 'shop/', $product, $imageNumber
                                );

                                copy($imageConvert, MEDIA_PATH . '/shop/' . $file);

                                if ($product->getImage() != $file) {
                                    $product->setImage($file);
                                }

                                // такой товар пользователь может видеть на каталоге
                                $product->setUser_view(1);
                                $product->update();

                            } else {
                                RtmService::Get()->addProductImage($product, $imageConvert, $imageNumber);
                            }

                            print 'image ' . $imageNumber . ' for product ' . $code . ' processed' . "\n";
                        }

                        @unlink($tmpDir . $filename);

                    } catch (Exception $ge) {

                    }

                }
            }

            closedir($d);

            print "\n\nPhoto loaded\n\n";
        }

        // прописываем технические фото
        $tmpDir = PackageLoader::Get()->getProjectPath() . 'templates/rtm/media/import_tech_images/';
        if (is_dir($tmpDir)) {
            $d = opendir($tmpDir);
            while ($x = readdir($d)) {
                if ($x == '.' || $x == '..') {
                    continue;
                }

                $filename = $x;

                try {
                    $products = $this->_getProductByTechImage($filename);
                    if ($products->getCount()) {
                        $imageConvert = Shop::Get()->getShopService()->convertImage($tmpDir . $filename);
                        if (!Checker::CheckImageFormat($imageConvert)) {
                            throw new ServiceUtils_Exception('Invalid image format');
                        }
                        $namePrefix = 'tech_'.md5_file($imageConvert);
                        $file = RtmService::Get()->makeImagesUploadUrl($imageConvert, $namePrefix);
                        copy($imageConvert, MEDIA_PATH . '/shop/' . $file);
                        while ($p = $products->getNext()) {
                            $p->setImage($file);
                            $p->setUser_view(0);
                            $p->update();
                        }
                    }
                } catch (Exception $e) {

                }
            }

            closedir($d);

            print "\n\nPhoto loaded\n\n";
        }

    }

    /**
     * Получить товар по технической фотке (он должен не иметь индивидуальной фотки - $product->setUser_view(0);)
     *
     * @param $filename
     *
     * @return ShopProduct
     */
    private function _getProductByTechImage($filename) {
        $product = Shop::Get()->getShopService()->getProductsAll();
        $product->setTech_image($filename);
        $product->setUser_view(0);
        return $product;
    }


}