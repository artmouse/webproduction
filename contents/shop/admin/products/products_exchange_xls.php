<?php
class products_exchange_xls extends Engine_Class {

    public function process() {
        // скачать всю базу товаров в формате XLS
        if ($this->getArgumentSecure('download')) {
            $this->_xlsExport(
                $this->getArgumentSecure('category'),
                $this->getControlValue('emails')
            );
        }

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

        // список категорий
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'hidden' => $x->getHidden(),
            );
        }
        $this->setValue('categoryArray', $this->_makeCategoryTree(0, 0, $a));

        $emailToArray = $this->_getNotificationEmailArray('email-tehnical');
        $this->setControlValue('emails', implode("\n", $emailToArray));
    }

    private function _xlsExport($categoryID = 0, $emails = '') {
        try {
            // если все ок - создаем задачу
            $task = new XShopExport();
            $task->setCdate(date('Y-m-d H:i:s'));
            $task->setUserid($this->getUser()->getId());
            $task->setCategoryid($categoryID);
            $task->setEmails($emails);
            $task->insert();

            $this->setValue('message_export', 'ok');
        } catch (Exception $e) {
            $this->setValue('message_export', 'error');
        }
    }

    private function _xlsImport($file) {
        try {
            PackageLoader::Get()->import('XLS');

            $mediaFile = md5(file_get_contents($file)).'.xls';
            copy($file, PackageLoader::Get()->getProjectPath().'media/import/'.$mediaFile);

            // если все ок - создаем задачу
            $task = new XShopImport();
            $task->setCdate(date('Y-m-d H:i:s'));
            $task->setUserid($this->getUser()->getId());
            $task->setFile($mediaFile);
            $task->insert();

            $this->setValue('message', 'ok');
        } catch (Exception $e) {
            $this->setValue('message', 'error');
        }
    }

    private function _makeCategoryTree($parentID, $level, $categoryArray) {
        $a = array();
        if (empty($categoryArray[$parentID])) {
            return $a;
        }
        foreach ($categoryArray[$parentID] as $x) {
            $x['level'] = $level;
            $a[] = $x;
            $childs = $this->_makeCategoryTree($x['id'], $level + 1, $categoryArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
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