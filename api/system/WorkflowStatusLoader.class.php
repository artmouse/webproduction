<?php

class WorkflowStatusLoader {
    /**
     * Добавление блоков
     *
     * @param $contentId
     * @param $blockName
     */
    public function addBlock($actionName, $contentId, $description = false) {
        $block = new XShopOrderStatusActionBlock();
        $block->setContentid(trim($contentId));

        if ($block->select()) {
            $block->setName(trim($actionName));
            $block->setDescription(trim($description));
            $block->setDeleted(0);
            $block->update();
        } else {
            $block->setName(trim($actionName));
            $block->setDescription(trim($description));
            $block->insert();
        }
    }

    /**
     * Добавить информацию
     *
     * @param $contentId
     * @param $blockName
     */
    public function addBlockData(ShopOrderStatus $status, $contentId, $index, $data = false) {
        $block = new XShopOrderStatusActionBlockStructure();
        $block->setStatusid($status->getId());
        $block->setContentid($contentId);
        $block->setSort($index);
        $block->setData($data);
        $block->insert();
    }


    /**
     * Удалить блоки для данного статуса
     *
     * @param ShopOrderStatus $status
     *
     * @throws SQLObject_Exception
     */
    public function deleteBlockDataByStatus (ShopOrderStatus $status) {
        $block = new XShopOrderStatusActionBlockStructure();
        $block->setStatusid($status->getId());
        while ($x = $block->getNext()) {
            try{
                if (Engine_ContentDataSource::Get()->getDataByID($x->getContentid())) {
                    $content = Engine::GetContentDriver()->getContent($x->getContentid());
                    if (method_exists($content, 'processDataDelete')) {
                        $content->setValue('status', $status);
                        $content->processDataDelete();
                    }
                }
            } catch (Exception $e) {

            }
        }
        $block->delete(true);
    }

    /**
     * Пометить все блоки под удаление
     *
     * @throws SQLObject_Exception
     */
    public function startBuildActionBlocks() {
        $blocks = new XShopOrderStatusActionBlock();
        $blocks->setDeleted(1, true);
        $blocks->update(true);
    }

    /**
     * Удалить все блоки с флагом удаления
     *
     * @throws SQLObject_Exception
     */
    public function endBuildActionBlocks() {
        $blocks = new XShopOrderStatusActionBlock();
        $blocks->setDeleted(1);
        $blocks->delete(true);

    }

    /**
     * Удалить все блоки
     *
     * @throws SQLObject_Exception
     */
    public function clearBlocksData() {
        $blocks = new XShopOrderStatusActionBlockStructure();
        $blocks->delete(true);
    }

    /**
     * Получить контенты в массиве
     *
     * @return array
     */

    public function getContentsArray() {
        $a = array();

        $blocks = new XShopOrderStatusActionBlock();
        while ($x = $blocks->getNext()) {
            $a[] = array(
                'name' => $x->getName(),
                'contentId' => $x->getContentid(),
                'description' => $x->getDescription()
            );
        }
        return $a;
    }

    /**
     * Получить контенты
     *
     * @return array
     */

    public function getContents() {
        $blocks = new XShopOrderStatusActionBlock();
        return $blocks;
    }

    /**
     * Получить контент для статуса
     *
     * @param ShopOrderStatus $status
     *
     * @return XShopOrderStatusActionBlockStructure
     */

    public function getContentByStatus(ShopOrderStatus $status) {
        $blocks = new XShopOrderStatusActionBlockStructure();
        $blocks->setStatusid($status->getId());
        return $blocks;
    }

    private function __construct() {

    }

    /**
     * Получить сервис.
     *
     * @return WorkflowStatusLoader
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
     * Подменяемый объект сервиса
     *
     * @var WorkflowStatusLoader
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

    private $_blockArray = array();

}