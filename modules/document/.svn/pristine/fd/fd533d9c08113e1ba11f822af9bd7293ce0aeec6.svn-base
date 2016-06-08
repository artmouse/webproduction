<?php
class document_list_block extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $linkkey = $this->getValue('linkkey');
            preg_match("/^(\w+)-(\d+)$/ius", $linkkey, $r);
            if (!isset($r[1]) || !isset($r[2])) {
                throw new ServiceUtils_Exception();
            }

            $classname = $r[1];
            $id = $r[2];

            $object = DocumentService::Get()->getObjectByID($id, $classname);
            if (!method_exists($object, 'makeAssignArrayForDocument')) {
                throw new ServiceUtils_Exception();
            }

            if (method_exists($object, 'makeLegalForDocument')) {
                $legal = $object->makeLegalForDocument();
                $a = array();
                while ($x = $legal->getNext()) {
                    $a[$x->getId()] = $x->getName();
                }
                $this->setValue('legalArray', $a);
            }

            // добавление документа
            if ($this->getControlValue('add')) {
                try {
                    $document = DocumentService::Get()->addDocument(
                        $cuser,
                        $this->getControlValue('documentname'),
                        $this->getControlValue('templateid'),
                        $linkkey,
                        $this->getControlValue('contractorid'),
                        $this->getControlValue('sdate'),
                        $this->getControlValue('bdate'),
                        $this->getControlValue('adate'),
                        $this->getControlValue('fileoriginal'),
                        $object->makeAssignArrayForDocument(),
                        $this->getControlValue('legalid')
                    );

                    if ($document->getContent()) {
                        $this->setValue('addDocumentUrl', $document->makeURLPrint());
                        $this->setValue('redirectUrl', Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array()));
                    } else {
                        header(
                            'location: '.str_replace(
                                '&amp;',
                                '&',
                                Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array())
                            )
                        );
                    }

                } catch (ServiceUtils_Exception $ee) {
                    $this->setValue('message', 'error');
                }
            } elseif ($object instanceof ShopOrder) {
                $this->setControlValue('contractorid', $object->getContractorid());
            }

            // удаление документа
            if ($this->getControlValue('documentdeleteid')) {
                try {
                    $document = DocumentService::Get()->getDocumentByID(
                        $this->getControlValue('documentdeleteid')
                    );

                    DocumentService::Get()->deleteDocument(
                        $document,
                        $cuser
                    );

                } catch (ServiceUtils_Exception $ee) {

                }
            }

            // список документов
            $documents = DocumentService::Get()->getDocumentsByLinkKey($linkkey, $cuser);
            $documents2 = clone $documents;

            $block_documents = Engine::Get()->GetContentDriver()->getContent('shop-admin-document-table-block');
            $block_documents->setValue('documents', $documents);
            $this->setValue('table_block', $block_documents->render());

            if ($documents2->getNext()) {
                $this->setValue('isDocument', true);
            }

            // список шаблонов
            $templates = DocumentService::Get()->getDocumentTemplatesByClassname($classname);
            $templateArray = array();
            while ($x = $templates->getNext()) {
                if ($this->getUser()->isAllowed('document-print-'.$x->getId())) {
                    $templateArray[] = array(
                    'id' => $x->getId(),
                    'name' => htmlspecialchars($x->getName()),
                    );
                }
            }
            $this->setValue('templateArray', $templateArray);

            // юр лица
            $contractors = Shop::Get()->getShopService()->getContractorsActive();
            $this->setValue('contractorArray', $contractors->toArray());

            $this->setValue('linkkey', $linkkey);
        } catch (Exception $ge) {

        }
    }

}