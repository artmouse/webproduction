<?php
class workflow_status_action extends Engine_Class {

    public function process() {

        try {
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            $this->setValue('box', $isBox);

            $statusID = $this->getArgument('id');
            $status = Shop::Get()->getShopService()->getStatusByID($statusID);
            $this->setValue('statusid', $statusID);

            $category = $status->getCategory();

            // сохранение формы
            if ($this->getArgumentSecure('send_edit')) {
                try {
                    Shop::Get()->getShopService()->editStatus(
                        $status,
                        $status->getName(),
                        $status->getContent(),
                        $this->getControlValue('term'),
                        $this->getControlValue('period'),
                        $this->getControlValue('roleid'),
                        $this->getControlValue('managerid'),
                        $this->getControlValue('jumpmanager'),
                        $status->getColour(),
                        $this->getControlValue('onlyauto'),
                        $this->getControlValue('onlyissue'),
                        $this->getControlValue('notify_sms_client'),
                        $this->getControlValue('notify_sms_admin'),
                        $this->getControlValue('notify_sms_manager'),
                        $this->getControlValue('notify_email_client'),
                        $this->getControlValue('notify_email_admin'),
                        $this->getControlValue('notify_email_manager'),
                        $this->getControlValue('need_payment'),
                        $this->getControlValue('need_prepayment'),
                        $this->getControlValue('need_content'),
                        $this->getControlValue('need_document'),
                        $this->getControlValue('done'),
                        $this->getControlValue('closed'),
                        $this->getControlValue('saled'),
                        $this->getControlValue('shipped'),
                        $this->getControlValue('orderSupplier'),
                        $this->getControlValue('orderxml'),
                        $this->getControlValue('ordercsv')
                    );

                    $status->setMessage($this->getControlValue('text_notify_email_client'));
                    $status->setMessageadmin($this->getControlValue('text_notify_email_admin'));
                    $status->setSms($this->getControlValue('text_notify_sms_client'));
                    $status->setSmsadmin($this->getControlValue('text_notify_sms_admin'));
                    $status->setNextworkflowid($this->getControlValue('nextworkflowid'));
                    $status->setNextstatusid($this->getControlValue('nextstatusid'));
                    $status->setAutonextstatusid($this->getControlValue('autonextstatusid'));

                    $status->update();

                    $this->setValue('edit_ok', true);
                } catch (ServiceUtils_Exception $e) {
                    Engine::GetURLParser()->setArgument('error', 1);
                    $this->setValue('error_edit', $e->getErrors());
                }
            }

            $this->setControlValue('notify_sms_client', $status->getNotifysmsclient());
            $this->setControlValue('notify_sms_admin', $status->getNotifysmsadmin());
            $this->setControlValue('notify_sms_manager', $status->getNotifysmsmanager());
            $this->setControlValue('notify_email_client', $status->getNotifyemailclient());
            $this->setControlValue('notify_email_admin', $status->getNotifyemailadmin());
            $this->setControlValue('notify_email_manager', $status->getNotifyemailmanager());

            $this->setControlValue('text_notify_email_client', $status->getMessage());
            $this->setControlValue('text_notify_email_admin', $status->getMessageadmin());
            $this->setControlValue('text_notify_sms_client', $status->getSms());
            $this->setControlValue('text_notify_sms_admin', $status->getSmsadmin());

            $this->setControlValue('autonextstatusid', $status->getAutonextstatusid());

            $this->setControlValue('done', $status->getDone());
            $this->setControlValue('closed', $status->getClosed());
            $this->setControlValue('saled', $status->getSaled());
            $this->setControlValue('shipped', $status->getShipped());
            $this->setControlValue('orderxml', $status->getCreateXml());
            $this->setControlValue('ordercsv', $status->getCreateCsv());
            if ($status->getCancelOrderSupplier()) {
                $this->setControlValue('orderSupplier', 'cancel');
            } elseif ($status->getCreateOrderSupplier()) {
                $this->setControlValue('orderSupplier', 'create');
            }

            $this->setValue('name', htmlspecialchars($status->getName()));
            $this->setValue('categoryid', $category->getId());
            $this->setValue('categoryName', $category->makeName());
            $this->setValue('issue', ($category->getType() == 'issue'));

            // список бизнес процессов
            $workflows = Shop::Get()->getShopService()->getWorkflowsAll($this->getUser());
            $workflowId = $status->getCategoryid();
            $nextWorkflowArray = array();
            while ($x = $workflows->getNext()) {
                // наш workflow не берем
                if ($workflowId == $x->getId()) {
                    continue;
                }

                $nextWorkflowArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName()
                );
            }

            $this->setValue('nextWorkflowArray', $nextWorkflowArray);
            $this->setControlValue('nextworkflowid', $status->getNextworkflowid());
            $this->setControlValue('nextstatusid', $status->getNextstatusid());

            // блоки, добавленные модулями
            /*$moduleBlockArray = Shop_ModuleLoader::Get()->getWorkflowStatusEditBlockArray();
            $block_module_additions = '';
            foreach ($moduleBlockArray as $moduleBlock) {
                $block = Engine::GetContentDriver()->getContent($moduleBlock);
                $block->setValue('status', $status);
                $block_module_additions .= $block->render();
            }
            $this->setValue('block_module_additions', $block_module_additions);*/

            if ($isBox) {
                $this->setControlValue('term', $status->getTerm());
                $this->setControlValue('roleid', $status->getRoleid());
                $this->setControlValue('period', $status->getTermperiod());
                $this->setControlValue('jumpmanager', $status->getJumpmanager());
                $this->setControlValue('managerid', $status->getManagerid());
                $this->setControlValue('onlyauto', $status->getOnlyauto());
                $this->setControlValue('onlyissue', $status->getOnlyissue());
                $this->setControlValue('need_payment', $status->getPayed());
                $this->setControlValue('need_prepayment', $status->getPrepayed());
                $this->setControlValue('need_content', $status->getNeedcontent());
                $this->setControlValue('need_document', $status->getNeeddocument());

                // список workflow
                $workflow = Shop::Get()->getShopService()->getOrderCategoryAll();
                $a = array();
                while ($x = $workflow->getNext()) {
                    $a[$x->getId()] = $x->makeName();
                }
                $this->setValue('workflowArray', $a);

                // список менеджеров
                $a = array();
                $manager = Shop::Get()->getUserService()->getUsersManagers();
                while ($x = $manager->getNext()) {
                    $a[] = array(
                        'id' => $x->getId(),
                        'name' => $x->makeName(true, 'lfm'),
                    );
                }
                $this->setValue('managerArray', $a);

                // список ролей
                $this->setValue('roleArray', RoleService::Get()->makeRoleListArray());

                $statuses = Shop::Get()->getShopService()->getStatusAll();
                $statuses->setCategoryid($status->getCategoryid());
                $statuses->addWhere('id', $status->getId(), '<>');
                $statusArray = array();
                while ($s = $statuses->getNext()) {
                    $statusArray[] = array(
                        'id' => $s->getId(),
                        'name' => $s->getName()
                    );
                }
                $this->setValue('statusArray', $statusArray);
            }
        } catch (Exception $e) {
            print $e;
        }

    }

}