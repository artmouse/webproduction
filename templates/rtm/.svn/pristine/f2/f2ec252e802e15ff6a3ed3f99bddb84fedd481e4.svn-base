<?php
class rtm_loadxml extends Engine_Class {

    public function process() {
        $user = $this->getUser();
        $task = new XRtmImport();
        $task->setPdate('0000-00-00 00:00:00');
        $task->setImportimages(0);
        if ($task->select()) {
            $this->setValue('run',1);
        } else {

            if ($this->getArgumentSecure('upload')) {
                $file = $this->getArgumentSecure('file');
                if ($file['type'] == 'text/xml') {
                    $file = @$file['tmp_name'];
                    $this->_xlsImport($file,$this->getControlValue('storagenameid'));
                } else {
                    $this->setValue('invalidfile', true);
                }
            }
        }
    }

    private function _xlsImport($file,$storagenameid) {
        try {
            $mediaFile = date('YmdHis').'.xml';

            copy($file, PackageLoader::Get()->getProjectPath().'templates/rtm/media/import_xml/'.$mediaFile);

            // если все ок - создаем задачу
            $task = new XRtmImport();
            $task->setImportimages(0);
            $task->setCdate(date('Y-m-d H:i:s'));
            $task->setUserid($this->getUser()->getId());
            $task->setFile($mediaFile);
            $task->setStoragenameid($storagenameid);
            $task->insert();

            $this->setValue('message', 'ok');
        } catch (Exception $e) {
            $this->setValue('message', 'error');
        }
    }

}