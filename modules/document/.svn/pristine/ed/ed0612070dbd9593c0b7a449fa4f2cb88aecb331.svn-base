<?php
class action_block_document_need extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = json_decode($this->getValue('data'));
        foreach ($data as $template) {
            $templateSelectedArray[] = (int) $template;
        }

        // список шаблонов
        $templates = DocumentService::Get()->getDocumentTemplatesByClassname('ShopOrder');
        $templates->setRequired(1);
        $templateArray = array();
        while ($x = $templates->getNext()) {
            if ($this->getUser()->isAllowed('document-print-'.$x->getId())) {
                $templateArray[] = array(
                    'id' => $x->getId(),
                    'name' => htmlspecialchars($x->getName()),
                    'selected' => in_array($x->getId(), $templateSelectedArray)
                );
            }
        }
        $this->setValue('templateArray', $templateArray);
    }

    public function processData() {
        $index = $this->getValue('index');
        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($this->getArgumentSecure($index.'_document'))
        );

        $status = $this->_getStatus();
        $status->setNeeddocument(1);
        $status->update();
    }

    public function processDataDelete() {
        $status = $this->_getStatus();
        $status->setNeeddocument(0);
        $status->update();
    }

    public function processStatus(Events_Event $event) {
        $order = $this->_getEventOrder($event);
        $data = json_decode($this->getValue('data'));
        if ($data != '1') {
            foreach ($data as $templateID) {
                $templateID = (int) $templateID;
                $documents = DocumentService::Get()->getDocumentsActive();
                $documents->setLinkkey('ShopOrder-'.$order->getId());
                $documents->setTemplateid($templateID);
                $documents->setLimitCount(1);
                $doc = $documents->getNext();
                if (!$doc) {
                    throw new ServiceUtils_Exception('document_document-need');
                }
            }
        }

    }

    public function processCronHour(Events_Event $event) {
        $event;

        if (Engine::Get()->getConfigFieldSecure('project-box-notify')
            && in_array('BoxNotify_Documents', Engine::Get()->getConfigFieldSecure('project-box-notify'))
        ) {
            $status = $this->_getStatus();
            $data = json_decode($this->getValue('data'));

            $orders = Shop::Get()->getShopService()->getOrdersAll();
            $orders->setStatusid($status->getId());

            while ($order = $orders->getNext()) {
                try {
                    $manager = $order->getManager();
                } catch (Exception $e) {
                    try {
                        $manager = $order->getAuthor();
                    } catch (Exception $e) {
                        continue;
                    }
                }

                if ($data != '1') {
                    // если есть выбранные документы, берем только их
                    foreach ($data as $templateID) {
                        $templateID = (int) $templateID;
                        $documents = DocumentService::Get()->getDocumentsActive();
                        $documents->setLinkkey('ShopOrder-'.$order->getId());
                        $documents->setTemplateid($templateID);
                        $documents->setLimitCount(1);
                        $doc = $documents->getNext();
                        if (!$doc) {
                            $templateName = DocumentService::Get()->getDocumentTemplateByID($templateID)->getName();
                            $issueIDArray[] = NotifyService::Get()->addNotify(
                                $manager,
                                'order-'.$order->getId().'-document-'.$templateID,
                                'Нет документа '.$templateName,
                                'В заказе '.$order->makeName().' не хватает обязательного документа '.$templateName,
                                $order->makeURLEdit(),
                                false,
                                $order->getUserid(),
                                $order->getId()
                            );
                        } elseif (!$doc->getFile()) {
                            $issueIDArray[] = NotifyService::Get()->addNotify(
                                $manager,
                                'order-'.$order->getId().'-document-'.$templateID.'-sign',
                                'Нет оригинала документа '.$templateName,
                                'В заказе '.$order->makeName().
                                ' не хватает скана документа '.$templateName.' '.$doc->getNumber(),
                                $doc->makeURLEdit(),
                                false,
                                $order->getUserid(),
                                $order->getId()
                            );
                        }
                    }
                } else {
                    // иначе все обязательные для заказа
                    $requiredTemplateIDArray = array();
                    $templates = DocumentService::Get()->getDocumentTemplatesActive();
                    $templates->setRequired(1);
                    while ($x = $templates->getNext()) {
                        $requiredTemplateIDArray[$x->getType()][$x->getId()] = $x->getName();
                    }

                    if (!$requiredTemplateIDArray) {
                        return false;
                    }

                    foreach ($requiredTemplateIDArray['ShopOrder'] as $templateID => $templateName) {
                        $documents = DocumentService::Get()->getDocumentsActive();
                        $documents->setLinkkey('ShopOrder-'.$order->getId());
                        $documents->setTemplateid($templateID);
                        $documents->setLimitCount(1);
                        $doc = $documents->getNext();
                        if (!$doc) {
                            $issueIDArray[] = NotifyService::Get()->addNotify(
                                $manager,
                                'order-'.$order->getId().'-document-'.$templateID,
                                'Нет документа '.$templateName,
                                'В заказе '.$order->makeName().' не хватает обязательного документа '.$templateName,
                                $order->makeURLEdit(),
                                false,
                                $order->getUserid(),
                                $order->getId()
                            );
                        } elseif (!$doc->getFile()) {
                            $issueIDArray[] = NotifyService::Get()->addNotify(
                                $manager,
                                'order-'.$order->getId().'-document-'.$templateID.'-sign',
                                'Нет оригинала документа '.$templateName,
                                'В заказе '.$order->makeName().
                                ' не хватает скана документа '.$templateName.' '.$doc->getNumber(),
                                $doc->makeURLEdit(),
                                false,
                                $order->getUserid(),
                                $order->getId()
                            );
                        }
                    }

                }

            }
        }


    }


    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

    /**
     * Обертка
     *
     * @return ShopOrder
     */
    private function _getEventOrder($event) {
        return $event->getOrder();
    }

}