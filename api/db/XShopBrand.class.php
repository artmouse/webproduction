<?php
/**
 * Class XShopBrand is ORM to table shopbrand
 * @author SQLObject
 * @package SQLObject
 */
class XShopBrand extends SQLObject {

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
     * Get image
     * @return string
     */
    public function getImage() { return $this->getField('image');}

    /**
     * Set image
     * @param string $image
     */
    public function setImage($image, $update = false) {$this->setField('image', $image, $update);}

    /**
     * Filter image
     * @param string $image
     * @param string $operation
     */
    public function filterImage($image, $operation = false) {$this->filterField('image', $image, $operation);}

    /**
     * Get url
     * @return string
     */
    public function getUrl() { return $this->getField('url');}

    /**
     * Set url
     * @param string $url
     */
    public function setUrl($url, $update = false) {$this->setField('url', $url, $update);}

    /**
     * Filter url
     * @param string $url
     * @param string $operation
     */
    public function filterUrl($url, $operation = false) {$this->filterField('url', $url, $operation);}

    /**
     * Get showtype
     * @return string
     */
    public function getShowtype() { return $this->getField('showtype');}

    /**
     * Set showtype
     * @param string $showtype
     */
    public function setShowtype($showtype, $update = false) {$this->setField('showtype', $showtype, $update);}

    /**
     * Filter showtype
     * @param string $showtype
     * @param string $operation
     */
    public function filterShowtype($showtype, $operation = false) {$this->filterField('showtype', $showtype, $operation);}

    /**
     * Get siteurl
     * @return string
     */
    public function getSiteurl() { return $this->getField('siteurl');}

    /**
     * Set siteurl
     * @param string $siteurl
     */
    public function setSiteurl($siteurl, $update = false) {$this->setField('siteurl', $siteurl, $update);}

    /**
     * Filter siteurl
     * @param string $siteurl
     * @param string $operation
     */
    public function filterSiteurl($siteurl, $operation = false) {$this->filterField('siteurl', $siteurl, $operation);}

    /**
     * Get top
     * @return int
     */
    public function getTop() { return $this->getField('top');}

    /**
     * Set top
     * @param int $top
     */
    public function setTop($top, $update = false) {$this->setField('top', $top, $update);}

    /**
     * Filter top
     * @param int $top
     * @param string $operation
     */
    public function filterTop($top, $operation = false) {$this->filterField('top', $top, $operation);}

    /**
     * Get description
     * @return string
     */
    public function getDescription() { return $this->getField('description');}

    /**
     * Set description
     * @param string $description
     */
    public function setDescription($description, $update = false) {$this->setField('description', $description, $update);}

    /**
     * Filter description
     * @param string $description
     * @param string $operation
     */
    public function filterDescription($description, $operation = false) {$this->filterField('description', $description, $operation);}

    /**
     * Get productcount
     * @return int
     */
    public function getProductcount() { return $this->getField('productcount');}

    /**
     * Set productcount
     * @param int $productcount
     */
    public function setProductcount($productcount, $update = false) {$this->setField('productcount', $productcount, $update);}

    /**
     * Filter productcount
     * @param int $productcount
     * @param string $operation
     */
    public function filterProductcount($productcount, $operation = false) {$this->filterField('productcount', $productcount, $operation);}

    /**
     * Get seodescription
     * @return string
     */
    public function getSeodescription() { return $this->getField('seodescription');}

    /**
     * Set seodescription
     * @param string $seodescription
     */
    public function setSeodescription($seodescription, $update = false) {$this->setField('seodescription', $seodescription, $update);}

    /**
     * Filter seodescription
     * @param string $seodescription
     * @param string $operation
     */
    public function filterSeodescription($seodescription, $operation = false) {$this->filterField('seodescription', $seodescription, $operation);}

    /**
     * Get seotitle
     * @return string
     */
    public function getSeotitle() { return $this->getField('seotitle');}

    /**
     * Set seotitle
     * @param string $seotitle
     */
    public function setSeotitle($seotitle, $update = false) {$this->setField('seotitle', $seotitle, $update);}

    /**
     * Filter seotitle
     * @param string $seotitle
     * @param string $operation
     */
    public function filterSeotitle($seotitle, $operation = false) {$this->filterField('seotitle', $seotitle, $operation);}

    /**
     * Get seoh1
     * @return string
     */
    public function getSeoh1() { return $this->getField('seoh1');}

    /**
     * Set seoh1
     * @param string $seoh1
     */
    public function setSeoh1($seoh1, $update = false) {$this->setField('seoh1', $seoh1, $update);}

    /**
     * Filter seoh1
     * @param string $seoh1
     * @param string $operation
     */
    public function filterSeoh1($seoh1, $operation = false) {$this->filterField('seoh1', $seoh1, $operation);}

    /**
     * Get seocontent
     * @return string
     */
    public function getSeocontent() { return $this->getField('seocontent');}

    /**
     * Set seocontent
     * @param string $seocontent
     */
    public function setSeocontent($seocontent, $update = false) {$this->setField('seocontent', $seocontent, $update);}

    /**
     * Filter seocontent
     * @param string $seocontent
     * @param string $operation
     */
    public function filterSeocontent($seocontent, $operation = false) {$this->filterField('seocontent', $seocontent, $operation);}

    /**
     * Get seokeywords
     * @return string
     */
    public function getSeokeywords() { return $this->getField('seokeywords');}

    /**
     * Set seokeywords
     * @param string $seokeywords
     */
    public function setSeokeywords($seokeywords, $update = false) {$this->setField('seokeywords', $seokeywords, $update);}

    /**
     * Filter seokeywords
     * @param string $seokeywords
     * @param string $operation
     */
    public function filterSeokeywords($seokeywords, $operation = false) {$this->filterField('seokeywords', $seokeywords, $operation);}

    /**
     * Get country
     * @return string
     */
    public function getCountry() { return $this->getField('country');}

    /**
     * Set country
     * @param string $country
     */
    public function setCountry($country, $update = false) {$this->setField('country', $country, $update);}

    /**
     * Filter country
     * @param string $country
     * @param string $operation
     */
    public function filterCountry($country, $operation = false) {$this->filterField('country', $country, $operation);}

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
     * Get linkkey
     * @return string
     */
    public function getLinkkey() { return $this->getField('linkkey');}

    /**
     * Set linkkey
     * @param string $linkkey
     */
    public function setLinkkey($linkkey, $update = false) {$this->setField('linkkey', $linkkey, $update);}

    /**
     * Filter linkkey
     * @param string $linkkey
     * @param string $operation
     */
    public function filterLinkkey($linkkey, $operation = false) {$this->filterField('linkkey', $linkkey, $operation);}

    /**
     * Get code1c
     * @return string
     */
    public function getCode1c() { return $this->getField('code1c');}

    /**
     * Set code1c
     * @param string $code1c
     */
    public function setCode1c($code1c, $update = false) {$this->setField('code1c', $code1c, $update);}

    /**
     * Filter code1c
     * @param string $code1c
     * @param string $operation
     */
    public function filterCode1c($code1c, $operation = false) {$this->filterField('code1c', $code1c, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopbrand');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopBrand
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopBrand
     */
    public static function Get($key) {return self::GetObject("XShopBrand", $key);}

}

SQLObject::SetFieldArray('shopbrand', array('id', 'name', 'image', 'url', 'showtype', 'siteurl', 'top', 'description', 'productcount', 'seodescription', 'seotitle', 'seoh1', 'seocontent', 'seokeywords', 'country', 'hidden', 'linkkey', 'code1c'));
SQLObject::SetPrimaryKey('shopbrand', 'id');
