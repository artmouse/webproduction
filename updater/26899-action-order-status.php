<?php
require_once(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$orderStatuses = new ShopOrderStatus();
// чистим старое
WorkflowStatusLoader::Get()->clearBlocksData();

while ($x = $orderStatuses->getNext()) {
    print "update status #".$x->getId()."\n";

    $index = 0;

    // shop

    // Считать заказ закрытым
    if ($x->getClosed()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-order-closed',
            $index,
            1
        );
    }

    // Ожидает проверки
    if ($x->getDone()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-awaiting-verification',
            $index,
            1
        );
    }

    // Срок
    if ($x->getTerm()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-term',
            $index,
            json_encode(
                array(
                    'term' => $x->getTerm(),
                    'period' => $x->getTermperiod()
                )
            )
        );
    }

    // Изменить статус на
    if ($x->getNextstatusid() || $x->getNextworkflowid()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-status-change',
            $index,
            json_encode(
                array(
                    'nextworkflowid' => $x->getNextworkflowid(),
                    'nextstatusid' => $x->getNextstatusid()
                )
            )
        );
    }

    // Отправлять уведомление по email клиенту
    if ($x->getMessage()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-notice-client-email',
            $index,
            $x->getMessage()
        );
    }

    // Отправлять уведомление по смс клиенту
    if ($x->getSms()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-notice-client-sms',
            $index,
            $x->getSms()
        );
    }

    // Отправлять уведомление по email менеджеру
    if ($x->getMessageadmin()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-notice-manager-email',
            $index,
            $x->getMessageadmin()
        );
    }

    // Отправлять уведомление по смс менеджеру
    if ($x->getSmsadmin()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-notice-manager-sms',
            $index,
            $x->getSmsadmin()
        );
    }

    // Автоматический заказ постащику
    if ($x->getCancelOrderSupplier() || $x->getCreateOrderSupplier()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-supplier-order',
            $index,
            $x->getCancelOrderSupplier() ? 'cancel' : 'create'
        );
    }

    // Выгружать заказ в CSV
    if ($x->getCreateCsv()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-upload-csv',
            $index,
            1
        );
    }

    // Выгружать заказ в XML
    if ($x->getCreateXml()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-upload-xml',
            $index,
            1
        );
    }

    // Считать заказ проданным
    if ($x->getSaled()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-order-saled',
            $index,
            1
        );
    }

    // Считать заказ отгруженным
    if ($x->getShipped()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-order-shipped',
            $index,
            1
        );
    }

    // Необходимы документы
    if ($x->getNeeddocument()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-document-need',
            $index,
            1
        );
    }

    // Необходимо содержание
    if ($x->getNeedcontent()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-content-need',
            $index,
            1
        );
    }

    // Должна быть оплата
    if ($x->getPayed()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-payment-need',
            $index,
            1
        );
    }

    // Должна быть предоплата
    if ($x->getPrepayed()) {
        $index++;
        WorkflowStatusLoader::Get()->addBlockData(
            $x,
            'shop-order-status-action-block-prepayment-need',
            $index,
            1
        );
    }


    // box

    if (Engine::Get()->getConfigFieldSecure('project-box')) {
        // Ответственная роль
        if ($x->getRoleid()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'box-order-status-action-block-role',
                $index,
                $x->getRoleid()
            );
        }

        // При переходе в этот этап менять ответственного
        if ($x->getJumpmanager()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'box-order-status-action-block-manager-change',
                $index,
                $x->getManagerid()
            );
        }

        // Автоматически выполнять переход на следующий этап по истечению срока этапа
        if ($x->getAutonextstatusid()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'box-order-status-action-block-status-change-auto',
                $index,
                $x->getAutonextstatusid()
            );
        }

        // Этап нельзя выбирать вручную
        if ($x->getOnlyauto()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'box-order-status-action-block-status-change-by-hand',
                $index,
                1
            );
        }

        // С этапа нельзя уходить пока не решены все подзадачи данного этапа
        if ($x->getOnlyissue()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'box-order-status-action-block-status-not-change',
                $index,
                1
            );
        }

        // Уведомлять, если не было связи с клиентом
        if ($x->getNo_communication()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'box-order-status-action-block-notification-client-no-link',
                $index,
                $x->getNo_communication()
            );
        }

        // Уведомлять, если не было связи с клиентом через звонки
        if ($x->getNo_communication_call()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'box-order-status-action-block-notification-client-no-link-phone',
                $index,
                $x->getNo_communication_call()
            );
        }

        // Уведомлять, если не было связи с клиентом через email
        if ($x->getNo_communication_email()) {
                $index++;
                WorkflowStatusLoader::Get()->addBlockData(
                    $x,
                    'box-order-status-action-block-notification-client-no-link-email',
                    $index,
                    $x->getNo_communication_email()
                );
        }

        // Автоматически повторять заказ после завершения(функционал убран)
        /*if ($x->getAutorepeat()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'box-order-status-action-block-auto-repetition',
                $index,
                1
            );
        }*/

        // Автоматически переносить задачу на следующий день, если она не готова
        if ($x->getNextdate()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'box-order-status-action-block-auto-transfer',
                $index,
                $x->getNextdate()
            );
        }

        // Подзадачи с указанным бизнес-процессом будут созданы в этом же проекте и назначены на исполнителя этапа
        $subWorkflow = new XShopOrderStatusSubWorkflow();
        $subWorkflow->setStatusid($x->getId());
        $subWorkflow->setOrder('sort');

        $isdata = false;

        while ($s = $subWorkflow->getNext()) {
            $blockDataArray = array(
                'id' => $s->getSubworkflowid(),
                'name' => $s->getSubworkflowname(),
                'date' => $s->getSubworkflowdate(),
                'description' => $s->getSubworkflowdescription(),
            );

            if (
                $s->getSubworkflowid() || $s->getSubworkflowname()
                || $s->getSubworkflowdate() || $s->getSubworkflowdescription()
            ) {
                $index++;
                WorkflowStatusLoader::Get()->addBlockData(
                    $x,
                    'box-order-status-action-block-sub-workflow2',
                    $index,
                    json_encode($blockDataArray)
                );
            }
        }
    }

    // storage

    if (Shop_ModuleLoader::Get()->isImported('storage')) {
        // Автоматически приходовать заказ на склад
        if ($x->getStorage_incoming() && $x->getStoragenameid_incoming()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'storage-order-status-action-block-debit-order-auto',
                $index,
                $x->getStoragenameid_incoming()
            );
        }

        // Автоматически снимать резерв товара на складе
        if ($x->getStorage_unreserve()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'storage-order-status-action-block-reserve-unset',
                $index,
                1
            );
        }

        // Автоматически возвращать товар на склад
        if ($x->getStorage_return()) {
            $index++;
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'storage-order-status-action-block-product-return',
                $index,
                1
            );
        }

        // Автоматически продавать заказ со склада
        if ($x->getStorage_sale()) {
            $index++;
            $storageName = StorageNameService::Get()->getStorageNamesForSale()->getNext();
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'storage-order-status-action-block-order-sale-auto',
                $index,
                $storageName ? $storageName->getId() : 0
            );
        }

         // Автоматически резервировать товар на складе
        if ($x->getStorage_reserve()) {
            $index++;
            $storageName = StorageNameService::Get()->getStorageNamesForSale()->getNext();
            WorkflowStatusLoader::Get()->addBlockData(
                $x,
                'storage-order-status-action-block-product-reserve-auto',
                $index,
                $storageName ? $storageName->getId() : 0
            );
        }

    }

}

print "\n\ndone\n\n";