<?php
class file_download extends Engine_Class {

    public function process() {
        try {
            $file = Shop::Get()->getFileService()->getFileByID(
                $this->getArgument('id')
            );

            $filePath = $file->makePath();
            if (!file_exists($filePath)) {
                throw new ServiceUtils_Exception();
            }

            $name = $file->getName();
            if (!$name) {
                $name = 'file-'.$file->getId();
            }

            $size = @filesize($filePath);

            // для каких mime-type не нужно окно сохранения файла?
            $realtimeArray = array();
            $realtimeArray[] = 'image';
            $realtimeArray[] = 'adobe';
            $realtimeArray[] = 'audio';

            header('Content-Type: '.$file->getContenttype());

            $stream = false;
            foreach ($realtimeArray as $x) {
                if (substr_count($file->getContenttype(), $x)) {
                    $stream = true;
                    break;
                }
            }
            if (!$stream) {
                // заставляем браузер показать окно сохранения файла
                header('Content-Description: File Transfer');
                header('Content-Transfer-Encoding: binary');
            }

            header('Content-Disposition: attachment; filename="'.$file->getName().'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            if ($size) {
                header('Content-Length: ' . $size);
            }
            // читаем файл и отправляем его пользователю
            readfile($filePath);
            exit();
        } catch (Exception $ge) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}