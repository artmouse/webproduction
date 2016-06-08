<?php
class workflow_status_interface extends Engine_Class {

    public function process() {

        try {
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            $this->setValue('box', $isBox);

            $dynamicWorkflow = !Engine::Get()->getConfigFieldSecure('static-shop-menu');
            $this->setValue('dynamic_workflow_menu', $dynamicWorkflow);

            $statusID = $this->getArgument('id');
            $status =  WorkflowService::Get()->getStatusByID($statusID);
            $this->setValue('statusid', $statusID);
            $this->setValue('name', $status->makeName());

            $category = $status->getWorkflow();

            $this->setValue('categoryid', $category->getId());
            $this->setValue('categoryName', $category->makeName());

            // set workflow and status name as title
            Engine_HTMLHead::Get()->setTitle($status->makeName() . ' - ' . $category->makeName());

            // сохранение формы
            if ($this->getArgumentSecure('send_edit')) {
                $category->setShowOrderMenu($this->getArgumentSecure('orderMenu'));
                $category->update();
                try {
                    if ($dynamicWorkflow) {
                        // сохранение меню
                        $menu = new XShopWorkflowMenu();
                        $menu->setWorkflowid($category->getId());
                        $menu->delete(true);

                        $tabMenu = $this->getArgumentSecure('tabmenu', 'array');
                        if ($tabMenu) {
                            foreach ($tabMenu as $tab) {
                                $menu = new XShopWorkflowMenu();
                                $menu->setWorkflowid($category->getId());
                                $menu->setName($tab);
                                $menu->insert();
                            }
                        }
                    }

                    // запоминаем блоки

                    $structure = $this->getArgumentSecure('block_structure');

                    // удаляем старые
                    $blocks = new XShopWorkflowStatusStructureBlock();
                    $blocks->setStatusid($status->getId());
                    $blocks->delete(true);

                    // записываем новые
                    $structureArray = json_decode($structure);
                    foreach ($structureArray as $structureId => $arr) {
                        foreach ($arr as $index => $blockId) {
                            if (!$blockId) {
                                continue;
                            }

                            $block = new XShopWorkflowStatusStructureBlock();
                            $block->setStatusid($status->getId());
                            $block->setStructureid($structureId);
                            $block->setBlockid($blockId);
                            $block->setSort($index);
                            $block->insert();
                        }

                    }

                    $this->setValue('edit_ok', true);
                } catch (ServiceUtils_Exception $e) {
                    Engine::GetURLParser()->setArgument('error', 1);
                    $this->setValue('error_edit', $e->getErrors());
                }
            }

            // используемые блоки
            $blocksUsedArray = array();
            $blocksUsedStructureArray = array();
            $blocksUsed = new XShopWorkflowStatusStructureBlock();
            $blocksUsed->setStatusid($status->getId());
            $blocksUsed->setOrder('sort', 'ASC');
            while ($x = $blocksUsed->getNext()) {
                $blockTmp = new XShopWorkflowStatusBlock($x->getBlockid());
                if ($blockTmp) {
                    $blocksUsedArray[] = $x->getBlockid();

                    $blocksUsedStructureArray[$x->getStructureid()][] = array(
                        'id' => $x->getBlockid(),
                        'name' => $blockTmp->getName()
                    );
                }

            }
            $this->setValue('blocksUsedStructureArray', $blocksUsedStructureArray);


            // не используемые блоки
            $blocksArray = array();
            $blocks = new XShopWorkflowStatusBlock();
            $blocks->addWhereArray($blocksUsedArray, 'id', '<>', 'AND');
            while ($x = $blocks->getNext()) {
                $blocksArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName()
                );
            }
            $this->setValue('blocksArray', $blocksArray);

            if ($dynamicWorkflow) {
                $menu = new XShopWorkflowMenu();
                $menu->setWorkflowid($category->getId());
                $menuArray = array();
                while ($x = $menu->getNext()) {
                    $menuArray[$x->getName()] = $x->getName();
                }

                $this->setValue('menuArray', $menuArray);

                // дополнительные табы от модулей
                $moduleTabArray = Shop_ModuleLoader::Get()->getOrderTabArray($this->getUser());
                foreach ($moduleTabArray as $key=>$item) {
                    if (in_array($item['contentID'], $menuArray)) {
                        $moduleTabArray[$key]['selected'] = 1;
                    }
                }
                $this->setValue('moduleTabArray', $moduleTabArray);

                // типы бд
                $workflowType = new XShopWorkflowType();

                $workflowTypeArray = array();
                while ($x = $workflowType->getNext()) {
                    $workflowTypeArray[] = array(
                        'id' => $x->getId(),
                        'type' => $x->getType(),
                        'name' => $x->getMultiplename() ? $x->getMultiplename() : $x->getName()
                    );
                }

                $this->setValue('workflowType', $workflowTypeArray);
                $this->setControlValue('orderMenu', $category->getShowOrderMenu());
            }

        } catch (Exception $e) {
            print $e;
        }
    }

}