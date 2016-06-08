<?php

class BoxNotify_Documents {

    public function process() {
        $issueIDArray = array();

        $requiredTemplateIDArray = array(-1);
        $templates = DocumentService::Get()->getDocumentTemplatesActive();
        $templates->setRequired(1);
        while ($x = $templates->getNext()) {
            $requiredTemplateIDArray[$x->getType()][$x->getId()] = $x->getName();
        }

        // все статусы с требованием документов
        $statusIDArray = array(-1);
        $status = Shop::Get()->getShopService()->getStatusAll();
        $status->setNeeddocument(1);
        while ($x = $status->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        $clientIDArray = array(-1);

        $orders = Shop::Get()->getShopService()->getOrdersAll();
        $orders->addWhereArray($statusIDArray, 'statusid');
        while ($order = $orders->getNext()) {
            $clientIDArray[] = $order->getUserid();
        }

        // проверка клиентов с заказами
        if (isset($requiredTemplateIDArray['User'])) {
            $clients = Shop::Get()->getUserService()->getUsersAll();
            $clients->addWhereArray($clientIDArray, 'id');
            while ($client = $clients->getNext()) {

                try {
                    $manager = $client->getManager();
                } catch (Exception $e) {
                    try {
                        $manager = $client->getAuthor();
                    } catch (Exception $e) {
                        continue;
                    }
                }

                foreach ($requiredTemplateIDArray['User'] as $templateID => $templateName) {
                    $documents = DocumentService::Get()->getDocumentsActive();
                    $documents->setLinkkey('User-'.$client->getId());
                    $documents->setTemplateid($templateID);
                    $documents->setLimitCount(1);
                    $doc = $documents->getNext();
                    if (!$doc) {
                        $issueIDArray[] = NotifyService::Get()->addNotify(
                            $manager,
                            'contact-'.$client->getId().'-document-'.$templateID,
                            'Нет документа '.$templateName,
                            'В клиенте '.$client->makeName(false).' не хватает обязательного документа '.
                            $templateName.', хотя у клиента уже есть оплаченные заказы и вы с ним работаете.',
                            false,
                            false,
                            $client->getId()
                        );
                    } elseif (!$doc->getFile()) {
                        $issueIDArray[] = NotifyService::Get()->addNotify(
                            $manager,
                            'contact-'.$client->getId().'-document-'.$templateID.'-sign',
                            'Не подписан документ '.$templateName,
                            'В клиенте '.$client->makeName(false).' не подписан документ '.
                            $templateName.' '.$doc->getNumber().'.',
                            $doc->makeURLEdit(),
                            false,
                            $client->getId()
                        );
                    }
                }
            }
        }

        return $issueIDArray;
    }

}