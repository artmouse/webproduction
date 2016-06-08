<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Этап (статус) бизнес-процесса
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class ShopOrderStatus extends XShopOrderStatus {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Получить следующий элемент
     *
     * @return ShopOrderStatus
     */
    public function getNext($exception = false) {
        1;
        return parent::getNext($exception);
    }

    /**
     * Получить склад
     *
     * @return ShopStorageName
     */
    public function getStorageName() {
        return Shop::Get()->getStorageService()->getStorageNameByID(
            $this->getStoragenameid()
        );
    }

    public function getWidth() {
        return $this->_normalizeWorkflowElementWidth(
            parent::getWidth()
        );
    }

    public function getHeight() {
        return $this->_normalizeWorkflowElementHeight(
            parent::getHeight()
        );
    }

    public function getX() {
        return $this->_normalizeWorkflowElementPosition(
            parent::getX()
        );
    }

    public function getY() {
        return $this->_normalizeWorkflowElementPosition(
            parent::getY()
        );
    }

    /**
     * Преобразовать координату элемента к допустимым параметрам
     *
     * @param int $position
     *
     * @return int
     */
    private function _normalizeWorkflowElementPosition($position) {
        $position = (int) $position;

        // issue #34780 - приводим к сетке 20x20px
        $position = round($position - $position % 20);

        return $position;
    }

    /**
     * Преобразовать ширину элемента к допустимым параметрам
     *
     * @param int $width
     *
     * @return int
     */
    private function _normalizeWorkflowElementWidth($width) {
        $width = (int) $width;

        if ($width <= 100) {
            $width = 100;
        }

        if ($width >= 300) {
            $width = 300;
        }

        // issue #34780 - приводим к сетке 20x20px
        $width = round($width - $width % 20);

        return $width;
    }

    /**
     * Преобразовать высоту элемента к допустимым параметрам
     *
     * @param int $height
     *
     * @return int
     */
    private function _normalizeWorkflowElementHeight($height) {
        $height = (int) $height;

        if ($height <= 20) {
            $height = 20;
        }

        if ($height >= 300) {
            $height = 300;
        }

        // issue #34780 - приводим к сетке 20x20px
        $height = round($height - $height % 20);

        return $height;
    }

    /**
     * Получить бизнес-процесс
     *
     * @return ShopOrderCategory
     *
     * @deprecated
     */
    public function getCategory() {
        return $this->getWorkflow();
    }

    /**
     * Получить бизнес-процесс
     *
     * @return ShopOrderCategory
     */
    public function getWorkflow() {
        return WorkflowService::Get()->getWorkflowByID(
            $this->getCategoryid()
        );
    }

    /**
     * Построить имя
     *
     * @return string
     */
    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    /**
     * Проверка, можно ли выполнить переход в новый статус
     *
     * @param ShopOrderStatus $status
     *
     * @return bool
     */
    public function canChangeTo(ShopOrderStatus $status) {
        return WorkflowService::Get()->isStatusCanChangeToStatus(
            $this,
            $status
        );
    }

}