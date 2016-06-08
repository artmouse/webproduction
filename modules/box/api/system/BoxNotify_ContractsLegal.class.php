<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_ContractsLegal {

    public function process() {
        $issueIDArray = array();

        // все заказы в состоянии оплачен или подобном
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
        $templates = DocumentService::Get()->getDocumentTemplatesByClassname('User');
        if ($templates->getCount()) {
            $clients = Shop::Get()->getUserService()->getUsersAll();
            $clients->addWhereArray($clientIDArray, 'id');
            while ($client = $clients->getNext()) {

                // проверка чтобы в клиенте были юридические реквизиты
                $legal = new XShopUserLegal();
                $legal->setUserid($client->getId());
                if ($legal->select()) {
                    continue;
                }

                try {
                    $manager = $client->getManager();
                } catch (Exception $e) {
                    try {
                        $manager = $client->getAuthor();
                    } catch (Exception $e) {
                        continue;
                    }
                }

                $issueIDArray[] = NotifyService::Get()->addNotify(
                $manager,
                'contact-'.$client->getId().'-legal',
                'Нет реквизитов у '.$client->makeName(),
                'В клиенте '.$client->makeName(false).' не указаны юридические реквизиты, хотя у клиента уже заказы, которые требуют документов.',
                false,
                false,
                $client->getId()
                );

            }
        }

        return $issueIDArray;
    }

}