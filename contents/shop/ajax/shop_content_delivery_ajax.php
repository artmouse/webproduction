<?php
class shop_content_delivery_ajax extends Engine_Class {

    public function process() {
        try {
            $id = $this->getArgument('id');
            $cityRef = $this->getArgumentSecure('city');
            $adminContent = $this->getArgumentSecure('admin');
            $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID($id);
            $logicclass = $delivery->getLogicclass();

            $contentId = false;
            if (!$logicclass) {
                $logicclass = 'ShopDelivery_Default';
            }

            try {
                if (class_exists($logicclass)) {
                    $processor = new $logicclass($delivery);
                    if (method_exists($processor, 'getDeliveryContentId')) {
                        $contentId = $processor->getDeliveryContentId();
                    }
                }
            } catch (Exception $statusEx) {

            }

            if (!$contentId) {
                $logicclass = 'ShopDelivery_Default';
                if (class_exists($logicclass)) {
                    $processor = new $logicclass($delivery);
                    if (method_exists($processor, 'getDeliveryContentId')) {
                        $contentId = $processor->getDeliveryContentId();
                    }
                }
            }

            $content = Engine::GetContentDriver()->getContent($contentId);
            $content->setValue('id', $id);
            $content->setValue('contentAdmin', $adminContent);
            if ($cityRef) {
                $content->setValue('cityRef', $cityRef);
            }

            echo json_encode($content->render());
            exit;
        } catch (Exception $e) {
            echo json_encode('');
            exit();
        }
    }

}