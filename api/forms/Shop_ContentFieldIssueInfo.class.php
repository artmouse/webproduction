<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentFieldIssueInfo extends Forms_ContentFieldSelectList {

    public function __construct($keyValue) {
        parent::__construct($keyValue, true);
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $issueId = @$cellsArray['id'];
        if ($issueId) {
            try {
                $issue = Shop::Get()->getShopService()->getOrderByID($issueId);
                $assigns['url'] = $issue->makeURLEdit();

                $assigns['name'] = $issue->makeName();
                $assigns['id'] = $issue->getId();
            } catch (Exception $e) {
                $assigns['name'] = $issueId;
            }
        }

        return $this->getContentView()->render($assigns);
    }

}