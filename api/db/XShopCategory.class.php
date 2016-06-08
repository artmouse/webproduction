<?php
/**
 * Class XShopCategory is ORM to table shopcategory
 * @author SQLObject
 * @package SQLObject
 */
class XShopCategory extends SQLObject {

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
     * Get nameformula
     * @return string
     */
    public function getNameformula() { return $this->getField('nameformula');}

    /**
     * Set nameformula
     * @param string $nameformula
     */
    public function setNameformula($nameformula, $update = false) {$this->setField('nameformula', $nameformula, $update);}

    /**
     * Filter nameformula
     * @param string $nameformula
     * @param string $operation
     */
    public function filterNameformula($nameformula, $operation = false) {$this->filterField('nameformula', $nameformula, $operation);}

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
     * Get imagecrop
     * @return string
     */
    public function getImagecrop() { return $this->getField('imagecrop');}

    /**
     * Set imagecrop
     * @param string $imagecrop
     */
    public function setImagecrop($imagecrop, $update = false) {$this->setField('imagecrop', $imagecrop, $update);}

    /**
     * Filter imagecrop
     * @param string $imagecrop
     * @param string $operation
     */
    public function filterImagecrop($imagecrop, $operation = false) {$this->filterField('imagecrop', $imagecrop, $operation);}

    /**
     * Get parentid
     * @return int
     */
    public function getParentid() { return $this->getField('parentid');}

    /**
     * Set parentid
     * @param int $parentid
     */
    public function setParentid($parentid, $update = false) {$this->setField('parentid', $parentid, $update);}

    /**
     * Filter parentid
     * @param int $parentid
     * @param string $operation
     */
    public function filterParentid($parentid, $operation = false) {$this->filterField('parentid', $parentid, $operation);}

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
     * Get hiddenold
     * @return int
     */
    public function getHiddenold() { return $this->getField('hiddenold');}

    /**
     * Set hiddenold
     * @param int $hiddenold
     */
    public function setHiddenold($hiddenold, $update = false) {$this->setField('hiddenold', $hiddenold, $update);}

    /**
     * Filter hiddenold
     * @param int $hiddenold
     * @param string $operation
     */
    public function filterHiddenold($hiddenold, $operation = false) {$this->filterField('hiddenold', $hiddenold, $operation);}

    /**
     * Get sort
     * @return int
     */
    public function getSort() { return $this->getField('sort');}

    /**
     * Set sort
     * @param int $sort
     */
    public function setSort($sort, $update = false) {$this->setField('sort', $sort, $update);}

    /**
     * Filter sort
     * @param int $sort
     * @param string $operation
     */
    public function filterSort($sort, $operation = false) {$this->filterField('sort', $sort, $operation);}

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
     * Get codesupplier
     * @return string
     */
    public function getCodesupplier() { return $this->getField('codesupplier');}

    /**
     * Set codesupplier
     * @param string $codesupplier
     */
    public function setCodesupplier($codesupplier, $update = false) {$this->setField('codesupplier', $codesupplier, $update);}

    /**
     * Filter codesupplier
     * @param string $codesupplier
     * @param string $operation
     */
    public function filterCodesupplier($codesupplier, $operation = false) {$this->filterField('codesupplier', $codesupplier, $operation);}

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
     * Get subdomain
     * @return string
     */
    public function getSubdomain() { return $this->getField('subdomain');}

    /**
     * Set subdomain
     * @param string $subdomain
     */
    public function setSubdomain($subdomain, $update = false) {$this->setField('subdomain', $subdomain, $update);}

    /**
     * Filter subdomain
     * @param string $subdomain
     * @param string $operation
     */
    public function filterSubdomain($subdomain, $operation = false) {$this->filterField('subdomain', $subdomain, $operation);}

    /**
     * Get sortdefault
     * @return string
     */
    public function getSortdefault() { return $this->getField('sortdefault');}

    /**
     * Set sortdefault
     * @param string $sortdefault
     */
    public function setSortdefault($sortdefault, $update = false) {$this->setField('sortdefault', $sortdefault, $update);}

    /**
     * Filter sortdefault
     * @param string $sortdefault
     * @param string $operation
     */
    public function filterSortdefault($sortdefault, $operation = false) {$this->filterField('sortdefault', $sortdefault, $operation);}

    /**
     * Get color
     * @return string
     */
    public function getColor() { return $this->getField('color');}

    /**
     * Set color
     * @param string $color
     */
    public function setColor($color, $update = false) {$this->setField('color', $color, $update);}

    /**
     * Filter color
     * @param string $color
     * @param string $operation
     */
    public function filterColor($color, $operation = false) {$this->filterField('color', $color, $operation);}

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
     * Get logicclass
     * @return string
     */
    public function getLogicclass() { return $this->getField('logicclass');}

    /**
     * Set logicclass
     * @param string $logicclass
     */
    public function setLogicclass($logicclass, $update = false) {$this->setField('logicclass', $logicclass, $update);}

    /**
     * Filter logicclass
     * @param string $logicclass
     * @param string $operation
     */
    public function filterLogicclass($logicclass, $operation = false) {$this->filterField('logicclass', $logicclass, $operation);}

    /**
     * Get level
     * @return int
     */
    public function getLevel() { return $this->getField('level');}

    /**
     * Set level
     * @param int $level
     */
    public function setLevel($level, $update = false) {$this->setField('level', $level, $update);}

    /**
     * Filter level
     * @param int $level
     * @param string $operation
     */
    public function filterLevel($level, $operation = false) {$this->filterField('level', $level, $operation);}

    /**
     * Get imageInModel
     * @return int
     */
    public function getImageInModel() { return $this->getField('imageInModel');}

    /**
     * Set imageInModel
     * @param int $imageInModel
     */
    public function setImageInModel($imageInModel, $update = false) {$this->setField('imageInModel', $imageInModel, $update);}

    /**
     * Filter imageInModel
     * @param int $imageInModel
     * @param string $operation
     */
    public function filterImageInModel($imageInModel, $operation = false) {$this->filterField('imageInModel', $imageInModel, $operation);}

    /**
     * Get filter1id
     * @return int
     */
    public function getFilter1id() { return $this->getField('filter1id');}

    /**
     * Set filter1id
     * @param int $filter1id
     */
    public function setFilter1id($filter1id, $update = false) {$this->setField('filter1id', $filter1id, $update);}

    /**
     * Filter filter1id
     * @param int $filter1id
     * @param string $operation
     */
    public function filterFilter1id($filter1id, $operation = false) {$this->filterField('filter1id', $filter1id, $operation);}

    /**
     * Get filter2id
     * @return int
     */
    public function getFilter2id() { return $this->getField('filter2id');}

    /**
     * Set filter2id
     * @param int $filter2id
     */
    public function setFilter2id($filter2id, $update = false) {$this->setField('filter2id', $filter2id, $update);}

    /**
     * Filter filter2id
     * @param int $filter2id
     * @param string $operation
     */
    public function filterFilter2id($filter2id, $operation = false) {$this->filterField('filter2id', $filter2id, $operation);}

    /**
     * Get filter3id
     * @return int
     */
    public function getFilter3id() { return $this->getField('filter3id');}

    /**
     * Set filter3id
     * @param int $filter3id
     */
    public function setFilter3id($filter3id, $update = false) {$this->setField('filter3id', $filter3id, $update);}

    /**
     * Filter filter3id
     * @param int $filter3id
     * @param string $operation
     */
    public function filterFilter3id($filter3id, $operation = false) {$this->filterField('filter3id', $filter3id, $operation);}

    /**
     * Get filter4id
     * @return int
     */
    public function getFilter4id() { return $this->getField('filter4id');}

    /**
     * Set filter4id
     * @param int $filter4id
     */
    public function setFilter4id($filter4id, $update = false) {$this->setField('filter4id', $filter4id, $update);}

    /**
     * Filter filter4id
     * @param int $filter4id
     * @param string $operation
     */
    public function filterFilter4id($filter4id, $operation = false) {$this->filterField('filter4id', $filter4id, $operation);}

    /**
     * Get filter5id
     * @return int
     */
    public function getFilter5id() { return $this->getField('filter5id');}

    /**
     * Set filter5id
     * @param int $filter5id
     */
    public function setFilter5id($filter5id, $update = false) {$this->setField('filter5id', $filter5id, $update);}

    /**
     * Filter filter5id
     * @param int $filter5id
     * @param string $operation
     */
    public function filterFilter5id($filter5id, $operation = false) {$this->filterField('filter5id', $filter5id, $operation);}

    /**
     * Get filter6id
     * @return int
     */
    public function getFilter6id() { return $this->getField('filter6id');}

    /**
     * Set filter6id
     * @param int $filter6id
     */
    public function setFilter6id($filter6id, $update = false) {$this->setField('filter6id', $filter6id, $update);}

    /**
     * Filter filter6id
     * @param int $filter6id
     * @param string $operation
     */
    public function filterFilter6id($filter6id, $operation = false) {$this->filterField('filter6id', $filter6id, $operation);}

    /**
     * Get filter7id
     * @return int
     */
    public function getFilter7id() { return $this->getField('filter7id');}

    /**
     * Set filter7id
     * @param int $filter7id
     */
    public function setFilter7id($filter7id, $update = false) {$this->setField('filter7id', $filter7id, $update);}

    /**
     * Filter filter7id
     * @param int $filter7id
     * @param string $operation
     */
    public function filterFilter7id($filter7id, $operation = false) {$this->filterField('filter7id', $filter7id, $operation);}

    /**
     * Get filter8id
     * @return int
     */
    public function getFilter8id() { return $this->getField('filter8id');}

    /**
     * Set filter8id
     * @param int $filter8id
     */
    public function setFilter8id($filter8id, $update = false) {$this->setField('filter8id', $filter8id, $update);}

    /**
     * Filter filter8id
     * @param int $filter8id
     * @param string $operation
     */
    public function filterFilter8id($filter8id, $operation = false) {$this->filterField('filter8id', $filter8id, $operation);}

    /**
     * Get filter9id
     * @return int
     */
    public function getFilter9id() { return $this->getField('filter9id');}

    /**
     * Set filter9id
     * @param int $filter9id
     */
    public function setFilter9id($filter9id, $update = false) {$this->setField('filter9id', $filter9id, $update);}

    /**
     * Filter filter9id
     * @param int $filter9id
     * @param string $operation
     */
    public function filterFilter9id($filter9id, $operation = false) {$this->filterField('filter9id', $filter9id, $operation);}

    /**
     * Get filter10id
     * @return int
     */
    public function getFilter10id() { return $this->getField('filter10id');}

    /**
     * Set filter10id
     * @param int $filter10id
     */
    public function setFilter10id($filter10id, $update = false) {$this->setField('filter10id', $filter10id, $update);}

    /**
     * Filter filter10id
     * @param int $filter10id
     * @param string $operation
     */
    public function filterFilter10id($filter10id, $operation = false) {$this->filterField('filter10id', $filter10id, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopcategory');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopCategory
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopCategory
     */
    public static function Get($key) {return self::GetObject("XShopCategory", $key);}

}

SQLObject::SetFieldArray('shopcategory', array('id', 'name', 'description', 'nameformula', 'image', 'imagecrop', 'parentid', 'hidden', 'hiddenold', 'sort', 'showtype', 'url', 'productcount', 'code1c', 'codesupplier', 'seodescription', 'seotitle', 'seoh1', 'seocontent', 'seokeywords', 'subdomain', 'sortdefault', 'color', 'linkkey', 'logicclass', 'level', 'imageInModel', 'filter1id', 'filter2id', 'filter3id', 'filter4id', 'filter5id', 'filter6id', 'filter7id', 'filter8id', 'filter9id', 'filter10id'));
SQLObject::SetPrimaryKey('shopcategory', 'id');
