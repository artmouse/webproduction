<?php
/**
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$documents = DocumentService::Get()->getDocumentsAll();
while ($document = $documents->getNext()) {
    if (!$document->getContractorid()) {
        try {
            if (preg_match("/^ShopOrder-(\d+)$/ius", $document->getLinkkey(), $r)) {

                $order = Shop::Get()->getShopService()->getOrderByID($r[1]);

                $contractor = Shop::Get()->getShopService()->getContractorByID($order->getContractorid());
                $document->setContractorid($contractor->getId());
                $document->update();

            } else {
                throw new ServiceUtils_Exception();
            }

        } catch (ServiceUtils_Exception $se) {

            $contractor = Shop::Get()->getShopService()->getContractorDefault();
            $document->setContractorid($contractor->getId());
            $document->update();

        }
    }
}

print "\n\ndone.\n\n";