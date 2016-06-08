<?php
class workflow_delete extends Engine_Class {

    public function process() {
        try {
            $orderCategory = Shop::Get()->getShopService()->getOrderCategoryByID(
                $this->getArgument('id')
            );

            $user = $this->getUser();

            $this->setValue('orderCategoryId', $orderCategory->getId());

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_udalenie_biznes_protsessa_').
                $orderCategory->getId()
            );

            // проверка прав пользователя на просмотр/управление этим бизнес процессом
            if (!$user->isAllowed('orders-category-'.$orderCategory->getId().'-view')) {
                throw new ServiceUtils_Exception();
            }

            if ($this->getControlValue('ok')) {
                try {
                    Shop::Get()->getShopService()->deleteOrderCategory($orderCategory);

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}