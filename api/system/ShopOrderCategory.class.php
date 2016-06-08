<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */


class ShopOrderCategory extends XShopOrderCategory {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Next
     *
     * @return ShopOrderCategory
     */
    public function getNext($exception = false) {
        $i = 0;
        return parent::getNext($exception);
    }

    /**
     * Get
     *
     * @return ShopOrderCategory
     */
    public static function Get($key) {
        return self::GetObject('ShopOrderCategory', $key);
    }

    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    public function makeURL() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-workflow-edit',
            $this->getId()
        );
    }

    /**
     * Получить этапы (статусы) категории
     *
     * @return ShopOrderStatus
     */
    public function getStatuses() {
        return WorkflowService::Get()->getStatusesByWorkflow($this);
    }

    /**
     * Получить стартовый статус
     *
     * @return ShopOrderStatus
     */
    public function getStatusDefault() {
        return WorkflowService::Get()->getStatusDefault($this);
    }

    /**
     * Получить завершенный статус
     *
     * @return ShopOrderStatus
     */
    public function getStatusClosed() {
        return WorkflowService::Get()->getStatusClosed($this);
    }

}