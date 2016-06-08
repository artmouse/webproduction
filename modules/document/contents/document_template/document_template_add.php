<?php
class document_template_add extends Engine_Class {

    public function process() {
        try {
            if ($this->getArgumentSecure('ok')) {
                try{
                    $ex = new ServiceUtils_Exception();

                    $name = trim($this->getControlValue('name'));
                    if (!$name) {
                        $ex->addError('name');
                    }

                    if ($ex->getCount()) {
                        throw $ex;
                    }

                    $document = new XShopDocumentTemplate();

                    $content = trim($this->getControlValue('content'));

                    if (strpos($content, 'file:') === 0) {
                        // пусть к файлу
                        $document->setContent($content);
                    } else {
                        // контент
                        if (strpos($document->getContent(), 'file:') === 0) {
                            // записываем в файл
                            $file = PackageLoader::Get()->getProjectPath();
                            $file.= str_replace('file:', '', $document->getContent());
                            file_put_contents($file, $content);

                        } else {
                            // записываем в таблицу
                            $document->setContent($content);
                        }

                    }

                    $document->setName($name);
                    $document->setType($this->getControlValue('type'));
                    $document->setHidden($this->getControlValue('hidden'));
                    $document->setRequired($this->getControlValue('required'));
                    $document->setPeriod(trim($this->getControlValue('period')));
                    $document->setSort(trim($this->getControlValue('sort')));
                    $document->setNumberprocessor(trim($this->getControlValue('numberprocessor')));


                    $document->insert();
                    header('Location: /admin/shop/document/templates/'.$document->getId().'/control/');
                    exit;
                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $oke) {
                    $this->setValue('errorArray', $oke->getErrorsArray());
                    $this->setValue('message', 'error');
                }

            }

            $this->setValue('storage', Shop_ModuleLoader::Get()->isImported('storage'));

        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}