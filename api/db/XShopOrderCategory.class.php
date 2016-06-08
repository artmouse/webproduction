<?php
/**
 * Class XShopOrderCategory is ORM to table shopordercategory
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderCategory extends SQLObject {

    /**
     * Get id
     * @return int
     */
    public function getId() { return $this->getField('id');}

    /**
     * Set id
     * @param int $id
     */
    public function setId($id, $update = false) {$this->setField('id', $id, $update);}

    /**
     * Filter id
     * @param int $id
     * @param string $operation
     */
    public function filterId($id, $operation = false) {$this->filterField('id', $id, $operation);}

    /**
     * Get name
     * @return string
     */
    public function getName() { return $this->getField('name');}

    /**
     * Set name
     * @param string $name
     */
    public function setName($name, $update = false) {$this->setField('name', $name, $update);}

    /**
     * Filter name
     * @param string $name
     * @param string $operation
     */
    public function filterName($name, $operation = false) {$this->filterField('name', $name, $operation);}

    /**
     * Get issue
     * @return int
     */
    public function getIssue() { return $this->getField('issue');}

    /**
     * Set issue
     * @param int $issue
     */
    public function setIssue($issue, $update = false) {$this->setField('issue', $issue, $update);}

    /**
     * Filter issue
     * @param int $issue
     * @param string $operation
     */
    public function filterIssue($issue, $operation = false) {$this->filterField('issue', $issue, $operation);}

    /**
     * Get type
     * @return string
     */
    public function getType() { return $this->getField('type');}

    /**
     * Set type
     * @param string $type
     */
    public function setType($type, $update = false) {$this->setField('type', $type, $update);}

    /**
     * Filter type
     * @param string $type
     * @param string $operation
     */
    public function filterType($type, $operation = false) {$this->filterField('type', $type, $operation);}

    /**
     * Get currencyid
     * @return int
     */
    public function getCurrencyid() { return $this->getField('currencyid');}

    /**
     * Set currencyid
     * @param int $currencyid
     */
    public function setCurrencyid($currencyid, $update = false) {$this->setField('currencyid', $currencyid, $update);}

    /**
     * Filter currencyid
     * @param int $currencyid
     * @param string $operation
     */
    public function filterCurrencyid($currencyid, $operation = false) {$this->filterField('currencyid', $currencyid, $operation);}

    /**
     * Get productsDefault
     * @return string
     */
    public function getProductsDefault() { return $this->getField('productsDefault');}

    /**
     * Set productsDefault
     * @param string $productsDefault
     */
    public function setProductsDefault($productsDefault, $update = false) {$this->setField('productsDefault', $productsDefault, $update);}

    /**
     * Filter productsDefault
     * @param string $productsDefault
     * @param string $operation
     */
    public function filterProductsDefault($productsDefault, $operation = false) {$this->filterField('productsDefault', $productsDefault, $operation);}

    /**
     * Get default
     * @return int
     */
    public function getDefault() { return $this->getField('default');}

    /**
     * Set default
     * @param int $default
     */
    public function setDefault($default, $update = false) {$this->setField('default', $default, $update);}

    /**
     * Filter default
     * @param int $default
     * @param string $operation
     */
    public function filterDefault($default, $operation = false) {$this->filterField('default', $default, $operation);}

    /**
     * Get hidden
     * @return int
     */
    public function getHidden() { return $this->getField('hidden');}

    /**
     * Set hidden
     * @param int $hidden
     */
    public function setHidden($hidden, $update = false) {$this->setField('hidden', $hidden, $update);}

    /**
     * Filter hidden
     * @param int $hidden
     * @param string $operation
     */
    public function filterHidden($hidden, $operation = false) {$this->filterField('hidden', $hidden, $operation);}

    /**
     * Get noautodateto
     * @return int
     */
    public function getNoautodateto() { return $this->getField('noautodateto');}

    /**
     * Set noautodateto
     * @param int $noautodateto
     */
    public function setNoautodateto($noautodateto, $update = false) {$this->setField('noautodateto', $noautodateto, $update);}

    /**
     * Filter noautodateto
     * @param int $noautodateto
     * @param string $operation
     */
    public function filterNoautodateto($noautodateto, $operation = false) {$this->filterField('noautodateto', $noautodateto, $operation);}

    /**
     * Get term
     * @return int
     */
    public function getTerm() { return $this->getField('term');}

    /**
     * Set term
     * @param int $term
     */
    public function setTerm($term, $update = false) {$this->setField('term', $term, $update);}

    /**
     * Filter term
     * @param int $term
     * @param string $operation
     */
    public function filterTerm($term, $operation = false) {$this->filterField('term', $term, $operation);}

    /**
     * Get issuename
     * @return string
     */
    public function getIssuename() { return $this->getField('issuename');}

    /**
     * Set issuename
     * @param string $issuename
     */
    public function setIssuename($issuename, $update = false) {$this->setField('issuename', $issuename, $update);}

    /**
     * Filter issuename
     * @param string $issuename
     * @param string $operation
     */
    public function filterIssuename($issuename, $operation = false) {$this->filterField('issuename', $issuename, $operation);}

    /**
     * Get projectid
     * @return int
     */
    public function getProjectid() { return $this->getField('projectid');}

    /**
     * Set projectid
     * @param int $projectid
     */
    public function setProjectid($projectid, $update = false) {$this->setField('projectid', $projectid, $update);}

    /**
     * Filter projectid
     * @param int $projectid
     * @param string $operation
     */
    public function filterProjectid($projectid, $operation = false) {$this->filterField('projectid', $projectid, $operation);}

    /**
     * Get managerid
     * @return int
     */
    public function getManagerid() { return $this->getField('managerid');}

    /**
     * Set managerid
     * @param int $managerid
     */
    public function setManagerid($managerid, $update = false) {$this->setField('managerid', $managerid, $update);}

    /**
     * Filter managerid
     * @param int $managerid
     * @param string $operation
     */
    public function filterManagerid($managerid, $operation = false) {$this->filterField('managerid', $managerid, $operation);}

    /**
     * Get outcoming
     * @return int
     */
    public function getOutcoming() { return $this->getField('outcoming');}

    /**
     * Set outcoming
     * @param int $outcoming
     */
    public function setOutcoming($outcoming, $update = false) {$this->setField('outcoming', $outcoming, $update);}

    /**
     * Filter outcoming
     * @param int $outcoming
     * @param string $operation
     */
    public function filterOutcoming($outcoming, $operation = false) {$this->filterField('outcoming', $outcoming, $operation);}

    /**
     * Get changeType
     * @return int
     */
    public function getChangeType() { return $this->getField('changeType');}

    /**
     * Set changeType
     * @param int $changeType
     */
    public function setChangeType($changeType, $update = false) {$this->setField('changeType', $changeType, $update);}

    /**
     * Filter changeType
     * @param int $changeType
     * @param string $operation
     */
    public function filterChangeType($changeType, $operation = false) {$this->filterField('changeType', $changeType, $operation);}

    /**
     * Get showOrderMenu
     * @return int
     */
    public function getShowOrderMenu() { return $this->getField('showOrderMenu');}

    /**
     * Set showOrderMenu
     * @param int $showOrderMenu
     */
    public function setShowOrderMenu($showOrderMenu, $update = false) {$this->setField('showOrderMenu', $showOrderMenu, $update);}

    /**
     * Filter showOrderMenu
     * @param int $showOrderMenu
     * @param string $operation
     */
    public function filterShowOrderMenu($showOrderMenu, $operation = false) {$this->filterField('showOrderMenu', $showOrderMenu, $operation);}

    /**
     * Get keywords
     * @return string
     */
    public function getKeywords() { return $this->getField('keywords');}

    /**
     * Set keywords
     * @param string $keywords
     */
    public function setKeywords($keywords, $update = false) {$this->setField('keywords', $keywords, $update);}

    /**
     * Filter keywords
     * @param string $keywords
     * @param string $operation
     */
    public function filterKeywords($keywords, $operation = false) {$this->filterField('keywords', $keywords, $operation);}

    /**
     * Get colorMenu
     * @return string
     */
    public function getColorMenu() { return $this->getField('colorMenu');}

    /**
     * Set colorMenu
     * @param string $colorMenu
     */
    public function setColorMenu($colorMenu, $update = false) {$this->setField('colorMenu', $colorMenu, $update);}

    /**
     * Filter colorMenu
     * @param string $colorMenu
     * @param string $operation
     */
    public function filterColorMenu($colorMenu, $operation = false) {$this->filterField('colorMenu', $colorMenu, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopordercategory');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderCategory
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderCategory
     */
    public static function Get($key) {return self::GetObject("XShopOrderCategory", $key);}

}

SQLObject::SetFieldArray('shopordercategory', array('id', 'name', 'issue', 'type', 'currencyid', 'productsDefault', 'default', 'hidden', 'noautodateto', 'term', 'issuename', 'projectid', 'managerid', 'outcoming', 'changeType', 'showOrderMenu', 'keywords', 'colorMenu'));
SQLObject::SetPrimaryKey('shopordercategory', 'id');
