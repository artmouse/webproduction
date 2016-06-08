<?php
class orders_exchange_xls extends Engine_Class {

    public function process() {
        // вгрузить всю базу товаров из принятого XLS
        if ($this->getArgumentSecure('upload')) {
            $file = $this->getArgumentSecure('file');
            if ($file['type'] == 'application/vnd.ms-excel') {
                $file = @$file['tmp_name'];
                $this->_xlsImport($file);
            } else {
                $this->setValue('invalidfile', true);
            }
        }

        $emailToArray = $this->_getNotificationEmailArray('email-tehnical');
        $this->setControlValue('emails', implode("\n", $emailToArray));
    }

    private function _xlsImport($file) {
        try {
            PackageLoader::Get()->import('XLS');

            $mediaFile = md5(file_get_contents($file)).'.xls';
            copy($file, PackageLoader::Get()->getProjectPath().'media/import/'.$mediaFile);

            // если все ок - создаем задачу
            $task = new XShopImportOrder();
            $task->setCdate(date('Y-m-d H:i:s'));
            $task->setUserid($this->getUser()->getId());
            $task->setFile($mediaFile);
            $task->insert();

            $this->setValue('message', 'ok');
        } catch (Exception $e) {
            $this->setValue('message', 'error');
        }
    }

    /**
     * Получить список notification-емейлов
     *
     * @return array
     */
    private function _getNotificationEmailArray($emailKey = 'email-orders') {
        $orderEmails = Shop::Get()->getSettingsService()->getSettingValue($emailKey);
        $orderEmails = str_replace(array("\r", "\n", "\t"), ' ', $orderEmails);
        $orderEmails = preg_replace("/([\s\,\;]+)/ius", ' ', $orderEmails);
        $orderEmailsArray = explode(' ', $orderEmails);
        $a = array();
        foreach ($orderEmailsArray as $x) {
            $x = trim($x);
            if (Checker::CheckEmail($x)) {
                $a[] = $x;
            }
        }
        return $a;
    }

}