<?php
class finance_payment_download extends Engine_Class {

    public function process() {
        try {
            $payment = PaymentService::Get()->getPaymentByID(
            $this->getArgument('key')
            );

            $cuser = $this->getUser();

            // проверка ACL
            if ($cuser->isDenied('finance-account-'.$payment->getAccountid().'-view')) {
                throw new ServiceUtils_Exception();
            }
            if ($cuser->isDenied('finance-account-'.$payment->getAccountid().'-control')) {
                throw new ServiceUtils_Exception();
            }
            
            $file = PackageLoader::Get()->getProjectPath().'/media/shop/'.$payment->getFile();
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
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.$payment->getFilename());
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));

            // читаем файл и отправляем его пользователю
            readfile($file);

            exit();
        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}