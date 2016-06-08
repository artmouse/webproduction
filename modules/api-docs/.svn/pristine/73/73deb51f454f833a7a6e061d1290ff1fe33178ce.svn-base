<?php
class doc_editor extends Engine_Class {

    public function process() {
        try {
            $key = $this->getArgument('key');

            $pageArray = Shop_ModuleLoader::Get()->getHelpItemArray();
            $page = false;
            foreach ($pageArray as $x) {
                if ($x['key'] == $key) {
                    $page = $x;
                    break;
                }
            }

            // ничего не нашли
            if (!$page) {
                throw new ServiceUtils_Exception('key');
            }

            if ($this->getArgumentSecure('save')) {
                $content = $this->getArgument('doccontent');

                // сохраняем в файл
                file_put_contents($x['file'], $content, LOCK_EX);
            } else {
                $content = file_get_contents($x['file']);
            }
            $this->setValue('doccontent', $content);
            $this->setValue('previewURL', '/doc/'.$x['key']);

            PackageLoader::Get()->import('CKEditor');

        } catch (Exception $ge) {
            //print_r($ge);
        }
    }

}