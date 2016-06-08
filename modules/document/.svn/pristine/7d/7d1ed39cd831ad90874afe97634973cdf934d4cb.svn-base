<?php
class document_template_control extends Engine_Class {

    public function process() {
        try {
            $id = $this->getArgument('id');
            $document = DocumentService::Get()->getDocumentTemplateByID($id);

            if ($this->getArgumentSecure('delete')) {
                $document->delete();
                header('Location: /admin/shop/document/templates/');
                exit;
            }

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

                    // делаем backup старого документа
                    $backupFile = PackageLoader::Get()->getProjectPath().
                        '/modules/document/media/backup/document'.$id.'_'.
                        DateTime_Object::Now()->setFormat('Y-m-d_h-m-s')->__toString().'.html';
                    $oldContent = $document->getContent();
                    if (strpos($oldContent, 'file:') === 0) {
                        // ссылка на файл
                        $oldContent = str_replace('file:', '', $oldContent);
                        file_put_contents(
                            $backupFile,
                            file_get_contents(PackageLoader::Get()->getProjectPath().$oldContent)
                        );
                    } else {
                        // просто текст
                        file_put_contents(
                            $backupFile,
                            $oldContent
                        );
                    }

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
                    $document->setGroupname($this->getControlValue('groupname'));
                    $document->setDirection($this->getControlValue('direction'));
                    $document->setType($this->getControlValue('type'));
                    $document->setHidden($this->getControlValue('hidden'));
                    $document->setRequired($this->getControlValue('required'));
                    $document->setPeriod(trim($this->getControlValue('period')));
                    $document->setSort(trim($this->getControlValue('sort')));
                    $document->setNumberprocessor(trim($this->getControlValue('numberprocessor')));


                    $document->update();
                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $oke) {
                    $this->setValue('errorArray', $oke->getErrorsArray());
                    $this->setValue('message', 'error');
                }
            }

            $this->setControlValue('name', $document->getName());
            $this->setControlValue('groupname', $document->getGroupname());
            $this->setControlValue('direction', $document->getDirection());
            $this->setControlValue('type', $document->getType());
            $this->setControlValue('hidden', $document->getHidden());
            $this->setControlValue('required', $document->getRequired());
            $this->setControlValue('period', $document->getPeriod());
            $this->setControlValue('sort', $document->getSort());
            $this->setControlValue('numberprocessor', $document->getNumberprocessor());

            $content = $document->getContent();
            if (strpos($content, 'file:') === 0) {
                $content = str_replace('file:', '', $content);
                if (file_exists(PackageLoader::Get()->getProjectPath().$content)) {
                    $content = file_get_contents(PackageLoader::Get()->getProjectPath().$content);
                } else {
                    $content = false;
                }
            }
            $this->setControlValue('content', $content);

            $this->setValue('storage', Shop_ModuleLoader::Get()->isImported('storage'));
            
        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}