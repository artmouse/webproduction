<?php

class Action_Status_CronHour implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $blocks = new XShopOrderStatusActionBlockStructure();
        $blocks->setOrder('sort', 'ASC');

        while ($x = $blocks->getNext()) {
            if (!Engine::GetContentDataSource()->getDataByID($x->getContentid())) {
                continue;
            }

            $block = Engine::GetContentDriver()->getContent($x->getContentid());

            if (!method_exists($block, 'processCronHour')) {
                continue;
            }

            try {
                $status = Shop::Get()->getShopService()->getStatusByID($x->getStatusid());
            } catch (Exception $estatus) {
                continue;
            }

            ModeService::Get()->verbose(
                'Action_Status_CroHour statusID='.$x->getStatusid().' contentID='.$x->getContentid()
            );

            $block->setValue('data', $x->getData());
            $block->setValue('status', $status);
            $block->processCronHour($event);
        }
    }

}