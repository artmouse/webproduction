<?php
class issue_preview extends Engine_Class {

    public function process() {
        try {
            $issue = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            $this->setValue('name', $issue->makeName());
            $this->setValue('urlEdit', $issue->makeURLEdit());

            // Относиться к:
            try {
                $parent = $issue->getParent();
                if ($parent) {
                    $this->setValue('parent', true);
                    $this->setValue('parentName', $parent->makeName());
                    $this->setValue('parentUrlEdit', $parent->makeURLEdit());
                }
            } catch (Exception $e) {

            }


            // Ответственный
            try {
                $manager = $issue->getManager();
                if ($manager) {
                    $this->setValue('managerName', $manager->makeName(true, 'lfm'));
                    $this->setValue('managerUrlEdit', $manager->makeURLEdit());
                }
            } catch (Exception $e) {

            }

            // Дата создания
            $cdate = $issue->getCdate();
            if (Checker::CheckDate($cdate)) {
                if (date("H:i", strtotime($cdate)) == '00:00') {
                    $cdate = date("d.m.Y", strtotime($cdate));
                } else {
                    $cdate = date("d.m.Y в H:i", strtotime($cdate));
                }
                $this->setValue('cdate', $cdate);
            }

            // На когда выполнить
            $dateTo = $issue->getDateto();
            if (Checker::CheckDate($dateTo)) {
                if (date("H:i", strtotime($dateTo)) == '00:00') {
                    $dateTo = date("d.m.Y", strtotime($dateTo));
                } else {
                    $dateTo = date("d.m.Y в H:i", strtotime($dateTo));
                }
                $this->setValue('dateto', $dateTo);
            }

            // Клиент
            try {
                $user = $issue->getClient();
                if ($user) {
                    $this->setValue('clientName', $user->makeName());
                    $this->setValue('clientUrl', $user->makeURLEdit());
                    $this->setValue('emailArray', $user->getEmailArray());
                    $this->setValue('phoneArray', $user->getPhoneArray());
                }
            } catch (Exception $e) {

            }

            if ($issue->getOrderProductsCount($issue->getId())) {
                $this->setValue(
                    'urlBarcode',
                    Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-order-barcode', $issue->getId())
                );
            }

        } catch (Exception $e) {
            exit();
        }
    }

}