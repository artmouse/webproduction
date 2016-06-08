<?php
class workflow_status_action_new extends Engine_Class {

    public function process() {
        try{
            $statusid = $this->getArgument('id');
            $status = WorkflowService::Get()->getStatusByID($statusid);
            $this->setValue('statusId', $status->getId());

            // set workflow status name as title
            $curWorkflow = $status->getWorkflow();
            Engine_HTMLHead::Get()->setTitle($status->makeName() . ' - ' . $curWorkflow->makeName());

            if ($this->getArgumentSecure('ok')) {
                $this->_backupFile($status);

                $indexes = $this->getArgumentSecure('index');
                try{
                    SQLObject::TransactionStart();
                    // удаляем старое
                    WorkflowStatusLoader::Get()->deleteBlockDataByStatus($status);

                    $sort = 0;
                    foreach ($indexes as $index) {
                        $sort++;

                        $contentId = $this->getArgument($index.'_contentid');
                        $block = Engine::GetContentDriver()->getContent($contentId);
                        $block->setValue('index', $index);
                        $block->setValue('sort', $sort);
                        $block->setValue('contentID', $contentId);
                        $block->setValue('status', $status);
                        $block->processData();
                    }
                    $this->setValue('edit_ok', true);
                    SQLObject::TransactionCommit();
                } catch (Exception $e2) {
                    SQLObject::TransactionRollback();
                }

            }


            // выводим сохраненные блоки
            $blocks = WorkflowStatusLoader::Get()->getContentByStatus($status);
            $blockArray = array();
            $maxIndex = 0;
            while ($x = $blocks->getNext()) {
                if (Engine::GetContentDataSource()->getDataByID($x->getContentid())) {
                    $block = Engine::GetContentDriver()->getContent($x->getContentid());
                    $block->setValue('status', $status);
                    $block->setValue('index', $x->getSort());
                    $block->setValue('data', $x->getData());
                    $block->setValue('contentID', $x->getContentid());

                    $contentBlock = new XShopOrderStatusActionBlock();
                    $contentBlock->setContentid($x->getContentid());
                    $contentBlock = $contentBlock->getNext();
                    if ($contentBlock) {
                        $block->setValue('description', $contentBlock->getDescription());
                        $block->setValue('blockName', $contentBlock->getName());
                    }

                    $blockArray[] = array(
                        'id' => $x->getId(),
                        'contentid' => $x->getContentid(),
                        'sort' => $x->getSort(),
                        'data' => $x->getData(),
                        'html' => $block->render()
                    );

                    if ($x->getSort() > $maxIndex) {
                        $maxIndex = $x->getSort();
                    }

                }

            }
            $this->setValue('actionBlockStructure', $blockArray);
            $this->setValue('indexCount', $maxIndex);

            // список блоков
            $blocks = WorkflowStatusLoader::Get()->getContentsArray();

            function cmp($a, $b) {
                if ($a['name'] == $b['name']) {
                    return 0;
                }
                return ($a['name'] < $b['name']) ? -1 : 1;
            }
            uasort($blocks, 'cmp');

            $this->setValue('actionBlocks', $blocks);

            $category = $status->getWorkflow();
            $this->setValue('name', htmlspecialchars($status->getName()));
            $this->setValue('categoryid', $category->getId());
            $this->setValue('categoryName', $category->makeName());

            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            $this->setValue('box', $isBox);
        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

    private function _backupFile (ShopOrderStatus $status) {
        /*$text = '';
        $subWorkflow = new XShopOrderStatusSubWorkflow();
        $subWorkflow->setStatusid($status->getId());
        $subWorkflow->setOrder('sort');

        while ($x = $subWorkflow->getNext()) {
            if ($x->getSubworkflowid() || $x->getSubworkflowname()
                || $x->getSubworkflowdate() || $x->getSubworkflowdescription()
            ) {
                $text.='№ '.$x->getSort()."\r\n";
                if ($x->getSubworkflowid()) {
                    $text.=Shop::Get()->getTranslateService()->getTranslateSecure('translate_biznesprotsess_').
                        $x->getSubworkflowid()."\r\n";
                }

                if ($x->getSubworkflowname()) {
                    $text.=Shop::Get()->getTranslateService()->getTranslateSecure('translate_imya_zadachi_').
                        $x->getSubworkflowname()."\r\n";
                }

                if ($x->getSubworkflowdate()) {
                    $text.=Shop::Get()->getTranslateService()->getTranslateSecure('translate_smeshchenie_v_dnyah_').
                        $x->getSubworkflowdate()."\r\n";
                }

                if ($x->getSubworkflowdescription()) {
                    $text.=Shop::Get()->getTranslateService()->getTranslateSecure('translate_opisanie_').
                        $x->getSubworkflowdescription()."\r\n\r\n";
                }
            }
        }*/

        $block = new XShopOrderStatusActionBlockStructure();
        $block->setStatusid($status->getId());
        $block->setContentid('box-order-status-action-block-sub-workflow2');
        $text = '';
        $index = 0;
        while ($x = $block->getNext()) {
            $index++;
            $text .= "\nБлок ".$index;
            $text.= $x->getData();
        }

        if ($text) {
            file_put_contents(
                PackageLoader::Get()->getProjectPath().'/media/backup/workflow/workflowStatus'.
                $status->getId().'_'.DateTime_Object::Now()->setFormat('YmdHis').'.txt',
                $text,
                LOCK_EX
            );
        }

    }

}