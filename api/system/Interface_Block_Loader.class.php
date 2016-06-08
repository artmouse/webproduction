<?php

class Interface_Block_Loader {
    /**
     * Добавление блоков
     *
     * @param $contentId
     * @param $blockName
     */
    public function addBlock($contentId, $blockName, $priority = 0) {
        $block = new XShopWorkflowStatusBlock();
        $block->setContentid($contentId);
        $block->setName($blockName);

        if (!$block->select()) {
            $block->setPriority($priority);
            $block->insert();
        } else {
            $block->setPriority($priority);
            $block->update();
        }
    }

    public function getBlockPriorityByContentId ($contentId) {
        $block = new XShopWorkflowStatusBlock();
        $block->setContentid($contentId);
        $block = $block->getNext();
        if (!$block) {
            return $block->getPriority();
        } else {
            return 0;
        }
    }


    public function getContentArrayByStatus(ShopOrderStatus $status) {
        $blockArray = array();

        $blocks = new XShopWorkflowStatusStructureBlock();
        $blocks->setStatusid($status->getId());
        if (!$blocks->getCount()) {
            // кастомных блоков нету
            //ищем по другим статусам этого БП
            try{
                $workflow = $status->getWorkflow();
                $statuses = $workflow->getStatuses();
                while ($x = $statuses->getNext()) {
                    $blocks = new XShopWorkflowStatusStructureBlock();
                    $blocks->setStatusid($x->getId());
                    if ($blocks->getCount()) {
                        // нашли блоки в другом статусе
                        break;
                    }
                }
            } catch (Exception $e) {
                $blocks = false;
            }
        }

        if ($blocks) {
            while ($x = $blocks->getNext()) {
                $block = new XShopWorkflowStatusBlock($x->getBlockid());
                if ($block) {
                    $blockArray[$x->getStructureid()][] = array(
                        'id' => $x->getId(),
                        'contentId' => $block->getContentid(),
                        'name' => $block->getName(),
                        'priority' => $block->getPriority()
                    );
                }

            }
        }



        if (!$blockArray) {
            // выдаем стандартные блоки
            return $this->getIssueBlocksDefaultArray($status->getWorkflow()->getType());

        }

        return $blockArray;
    }


    /**
     * Костыль для отображения внешнего вида задача, проектов, заказов
     * Необходим как переходный режим на новый, настраиваемый интерфейс
     * + защита от экрана без блоков
     *
     * @param bool $type
     *
     * @return array
     */
    public function getIssueBlocksDefaultArray($type = false) {
        $blockArray = array();

        if ($type == 'project') {
            // структура 1
            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-project-tree');
            $block = $block->getNext();
            if ($block) {
                $blockArray[1][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-client-info');
            $block = $block->getNext();
            if ($block) {
                $blockArray[1][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-status-info');
            $block = $block->getNext();
            if ($block) {
                $blockArray[1][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-product-list-short');
            $block = $block->getNext();
            if ($block) {
                $blockArray[1][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-name');
            $block = $block->getNext();
            if ($block) {

                $blockArray[2][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }


            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-graph-activities');
            $block = $block->getNext();
            if ($block) {

                $blockArray[3][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            // структура 4
            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-graph-load');
            $block = $block->getNext();
            if ($block) {

                $blockArray[4][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }


            // структура 5
            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-comment-list');
            $block = $block->getNext();
            if ($block) {
                $blockArray[5][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

        } elseif ($type == 'issue') {
            // структура 1
            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-issue-structure');
            $block = $block->getNext();
            if ($block) {

                $blockArray[1][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            // структура 2
            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-name');
            $block = $block->getNext();
            if ($block) {

                $blockArray[2][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-stage-history');
            $block = $block->getNext();
            if ($block) {

                $blockArray[2][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-stage-instruction');
            $block = $block->getNext();
            if ($block) {
                $blockArray[2][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-description');
            $block = $block->getNext();
            if ($block) {
                $blockArray[2][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-info');
            $block = $block->getNext();
            if ($block) {
                $blockArray[2][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-comment-list');
            $block = $block->getNext();
            if ($block) {
                $blockArray[2][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

        } else {
            // структура 1
            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-active-order');
            $block = $block->getNext();
            if ($block) {

                $blockArray[1][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            // структура 2
            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-name');
            $block = $block->getNext();
            if ($block) {

                $blockArray[2][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-stage-history');
            $block = $block->getNext();
            if ($block) {

                $blockArray[2][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-description');
            $block = $block->getNext();
            if ($block) {
                $blockArray[2][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-info');
            $block = $block->getNext();
            if ($block) {
                $blockArray[3][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-client-info');
            $block = $block->getNext();
            if ($block) {
                $blockArray[4][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-product-list');
            $block = $block->getNext();
            if ($block) {
                $blockArray[5][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-workflow-visual');
            $block = $block->getNext();
            if ($block) {
                $blockArray[5][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }

            $block = new XShopWorkflowStatusBlock();
            $block->setContentid('box-admin-block-comment-list');
            $block = $block->getNext();
            if ($block) {
                $blockArray[5][] = array(
                    'id' => $block->getId(),
                    'contentId' => $block->getContentid(),
                    'name' => $block->getName(),
                    'priority' => $block->getPriority()
                );
            }
        }


        return $blockArray;

    }

    private function __construct() {

    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Interface_Block_Loader
     */
    public static function Get() {
        if (!self::$_Instance) {
            $classname = self::$_Classname;
            if ($classname) {
                self::$_Instance = new $classname();
            } else {
                self::$_Instance = new self();
            }
        }
        return self::$_Instance;
    }

    /**
     * Задать класс сервиса.
     * override-метод.
     *
     * @param string $classname
     */
    public static function Set($classname) {
        self::$_Classname = $classname;
        self::$_Instance = null;
    }

    /**
     * Подменяемый объект сервиса
     *
     * @var Interface_Block_Loader
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}