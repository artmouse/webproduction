<?php
class document_control extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $document = DocumentService::Get()->getDocumentByID(
                $this->getArgument('id')
            );

            if (!DocumentService::Get()->isDocumentViewAllowed($document, $cuser)) {
                throw new ServiceUtils_Exception();
            }

            $allowEdit = DocumentService::Get()->isDocumentEditAllowed($document, $cuser);
            $allowFields = DocumentService::Get()->isDocumentFieldsAllowed($document, $cuser);

            $this->setValue('allowEdit', $allowEdit);
            $this->setValue('allowField', $allowFields);

            if ($this->getArgumentSecure('ok')) {
                try {
                    SQLObject::TransactionStart();

                    if ($allowFields) {
                        $fields = new XShopDocumentFieldValue();
                        $fields->setDocumentid($document->getId());

                        while ($field = $fields->getNext()) {
                            try {
                                $fieldValue = $this->getArgument('documentfield'.$field->getId());
                                $field->setValue($fieldValue);
                                $field->update();
                            } catch (Exception $fe) {

                            }
                        }
                    }

                    if ($allowEdit) {
                        DocumentService::Get()->editDocument(
                            $document,
                            $cuser,
                            $this->getControlValue('number'),
                            $this->getControlValue('name'),
                            $this->getControlValue('templateid'),
                            $this->getControlValue('contractorid'),
                            $this->getArgumentSecure('cdate', 'datetime'),
                            $this->getArgumentSecure('sdate', 'datetime'),
                            $this->getArgumentSecure('bdate', 'datetime'),
                            $this->getArgumentSecure('adate', 'datetime'),
                            $this->getArgumentSecure('edate', 'datetime'),
                            $this->getArgumentSecure('file'),
                            $this->getArgumentSecure('fileoriginal'),
                            $this->getArgumentSecure('content', 'string')
                        );
                    }

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $se) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'error');
                    $this->setValue('errorArray', $se->getErrorsArray());
                }
            }

            // ссылка на редактор полей
            if ($allowFields) {
                $this->setValue(
                    'urlDocumentField',
                    Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-admin-document-fieldeditor',
                        $document->getId()
                    )
                );
            }

            if ($allowEdit) {
                $this->setControlValue('name', $document->getName());
                $this->setControlValue('number', $document->getNumber());
                $this->setControlValue('cdate', DateTime_Object::Now()->preview());
                $this->setControlValue('content', $document->getContent());
                $this->setControlValue('templateid', $document->getTemplateid());
                $this->setControlValue('contractorid', $document->getContractorid());

                if (Checker::CheckDate($document->getSdate())) {
                    $this->setControlValue('sdate', $document->getSdate());
                }
                if (Checker::CheckDate($document->getBdate())) {
                    $this->setControlValue('bdate', $document->getBdate());
                }
                if (Checker::CheckDate($document->getAdate())) {
                    $this->setControlValue('adate', $document->getAdate());
                }
                if (Checker::CheckDate($document->getEdate())) {
                    $this->setControlValue('edate', $document->getEdate());
                }
            }

            $this->setValue('documentID', $document->getId());
            $this->setValue('content', $document->getContent());

            try {
                $this->setValue('authorName', $document->getUser()->makeName());
            } catch (Exception $e) {

            }

            //$this->setValue('urlFile', $document->makeURLFile());
            //$this->setValue('urlFileOriginal', $document->makeURLFileOriginal());

            if ($document->getFile()) {
                $this->setValue(
                    'urlFile',
                    Engine::GetLinkMaker()->makeURLByContentIDParams(
                        'shop-admin-document-download',
                        array(
                            'id' => $document->getId(),
                            'target' => 'scan'
                        )
                    )
                );
                $this->setValue('scan', $document->makeScanThumb(800));
            }

            if ($document->getFileoriginal()) {
                $this->setValue(
                    'urlFileOriginal',
                    Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-document-download', $document->getId())
                );
            }

            $this->setValue('urlPrint', $document->makeURLPrint());
            $this->setValue('urlPDF', $document->makeURLPDF());

            // список шаблонов
            $templates = DocumentService::Get()->getDocumentTemplatesActive();
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

            // меню
            if (preg_match("/^ShopOrder-(\d+)$/ius", $document->getLinkkey(), $r)) {
                try {
                    $order = Shop::Get()->getShopService()->getOrderByID($r[1]);

                    Engine::GetHTMLHead()->setTitle('Документы заказа '.$order->makeName());

                    if (Shop_ModuleLoader::Get()->isModuleInModulesArray('box')
                        && !Engine::Get()->getConfigFieldSecure('static-shop-menu')
                    ) {
                        try {
                            $tabMenuWorkflow = new XShopWorkflowMenu();
                            $tabMenuWorkflow->setWorkflowid($order->getWorkflow()->getId());
                            $tabMenuWorkflow->setName('parent');
                            if (!$tabMenuWorkflow->getNext()) {
                                throw new ServiceUtils_Exception();
                            }

                            $objParent = $this->_getWorkflowParentOrderWithMenu($order);

                            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
                            $menu->setValue('order', $objParent);
                            $menu->setValue('issue', $order);
                            $menu->setValue('selected', 'document');
                            $this->setValue('block_menu', $menu->render());
                        } catch (Exception $eparent) {
                            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
                            $menu->setValue('order', $order);
                            $menu->setValue('selected', 'document');
                            $this->setValue('block_menu', $menu->render());
                        }
                    } else {
                        $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
                        $menu->setValue('order', $order);
                        $menu->setValue('selected', 'document');
                        $this->setValue('block_menu', $menu->render());
                    }

                } catch (Exception $orderEx) {

                }
            } elseif (preg_match("/^User-(\d+)$/ius", $document->getLinkkey(), $r)) {
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($r[1]);

                    Engine::GetHTMLHead()->setTitle('Документы пользователя '.$user->makeName());

                    $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
                    $menu->setValue('selected', 'document');
                    $menu->setValue('userid', $user->getId());
                    $this->setValue('block_menu', $menu->render());
                } catch (Exception $userEx) {

                }
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    /**
     * Получить родительский menu если это возможно.
     *
     * @param ShopOrder $order
     *
     * @return XShopWorkflowMenu
     */
    private function _getWorkflowParentOrderWithMenu(ShopOrder $order, $recursionArray = array()) {
        $parent = $order->getParent();

        // защита от рекурсии
        if (in_array($parent->getId(), $recursionArray)) {
            throw new ServiceUtils_Exception();
        }

        $recursionArray[] = $parent->getId();

        $parentWorkflow = $parent->getWorkflow();
        $tabMenuWorkflow = new XShopWorkflowMenu();
        $tabMenuWorkflow->setWorkflowid($parentWorkflow->getId());
        $count = 0;

        while ($x = $tabMenuWorkflow->getNext()) {
            try {
                $parentObj = $this->_getWorkflowParentOrderWithMenu($parent, $recursionArray);
            } catch (Exception $eparent) {
                $parentObj = false;
            }

            if ($x->getName() == 'parent' && $parentObj) {
                return $parentObj;
            } elseif ($x->getName() != 'closed') {
                $count++;
            }
        }

        if ($count) {
            return $parent;
        }

        throw new ServiceUtils_Exception();
    }


}