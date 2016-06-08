<?php
class shop_product_download extends Engine_Class {

    public function process() {
        try {
            $hash = $this->getArgumentSecure('hash');

            $x = new XShopDownloadURL();
            $x->setHash($hash);
            $x->select();

            if ($x->getEdate() < date('Y-m-d H:i:s')) {
                throw new ServiceUtils_Exception();
            }

            $file = PackageLoader::Get()->getProjectPath().'/media/downloadfile/'.$x->getFile();
            if (!file_exists($file)) {
                throw new ServiceUtils_Exception();
            }

            // выдаем файл.
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) {
                ob_end_clean();
            }

            // заставляем браузер показать окно сохранения файла
            header('Content-Description: File Transfer');
            // header('Content-Type: application/octet-stream');
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename='.$file.'.zip');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));

            // читаем файл и отправляем его пользователю
            readfile($file);

            exit();
        } catch (Exception $ge) {
            if (method_exists($ge, 'log')) {
            	$ge->log();
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}