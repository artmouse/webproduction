<?php
/**
 * Class XShopProductComment is ORM to table shopproductcomment
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductComment extends SQLObject {

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
     * Get productid
     * @return int
     */
    public function getProductid() { return $this->getField('productid');}

    /**
     * Set productid
     * @param int $productid
     */
    public function setProductid($productid, $update = false) {$this->setField('productid', $productid, $update);}

    /**
     * Filter productid
     * @param int $productid
     * @param string $operation
     */
    public function filterProductid($productid, $operation = false) {$this->filterField('productid', $productid, $operation);}

    /**
     * Get userid
     * @return int
     */
    public function getUserid() { return $this->getField('userid');}

    /**
     * Set userid
     * @param int $userid
     */
    public function setUserid($userid, $update = false) {$this->setField('userid', $userid, $update);}

    /**
     * Filter userid
     * @param int $userid
     * @param string $operation
     */
    public function filterUserid($userid, $operation = false) {$this->filterField('userid', $userid, $operation);}

    /**
     * Get text
     * @return string
     */
    public function getText() { return $this->getField('text');}

    /**
     * Set text
     * @param string $text
     */
    public function setText($text, $update = false) {$this->setField('text', $text, $update);}

    /**
     * Filter text
     * @param string $text
     * @param string $operation
     */
    public function filterText($text, $operation = false) {$this->filterField('text', $text, $operation);}

    /**
     * Get cdate
     * @return string
     */
    public function getCdate() { return $this->getField('cdate');}

    /**
     * Set cdate
     * @param string $cdate
     */
    public function setCdate($cdate, $update = false) {$this->setField('cdate', $cdate, $update);}

    /**
     * Filter cdate
     * @param string $cdate
     * @param string $operation
     */
    public function filterCdate($cdate, $operation = false) {$this->filterField('cdate', $cdate, $operation);}

    /**
     * Get rating
     * @return int
     */
    public function getRating() { return $this->getField('rating');}

    /**
     * Set rating
     * @param int $rating
     */
    public function setRating($rating, $update = false) {$this->setField('rating', $rating, $update);}

    /**
     * Filter rating
     * @param int $rating
     * @param string $operation
     */
    public function filterRating($rating, $operation = false) {$this->filterField('rating', $rating, $operation);}

    /**
     * Get plus
     * @return string
     */
    public function getPlus() { return $this->getField('plus');}

    /**
     * Set plus
     * @param string $plus
     */
    public function setPlus($plus, $update = false) {$this->setField('plus', $plus, $update);}

    /**
     * Filter plus
     * @param string $plus
     * @param string $operation
     */
    public function filterPlus($plus, $operation = false) {$this->filterField('plus', $plus, $operation);}

    /**
     * Get minus
     * @return string
     */
    public function getMinus() { return $this->getField('minus');}

    /**
     * Set minus
     * @param string $minus
     */
    public function setMinus($minus, $update = false) {$this->setField('minus', $minus, $update);}

    /**
     * Filter minus
     * @param string $minus
     * @param string $operation
     */
    public function filterMinus($minus, $operation = false) {$this->filterField('minus', $minus, $operation);}

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
     * Get username
     * @return string
     */
    public function getUsername() { return $this->getField('username');}

    /**
     * Set username
     * @param string $username
     */
    public function setUsername($username, $update = false) {$this->setField('username', $username, $update);}

    /**
     * Filter username
     * @param string $username
     * @param string $operation
     */
    public function filterUsername($username, $operation = false) {$this->filterField('username', $username, $operation);}

    /**
     * Get answer
     * @return string
     */
    public function getAnswer() { return $this->getField('answer');}

    /**
     * Set answer
     * @param string $answer
     */
    public function setAnswer($answer, $update = false) {$this->setField('answer', $answer, $update);}

    /**
     * Filter answer
     * @param string $answer
     * @param string $operation
     */
    public function filterAnswer($answer, $operation = false) {$this->filterField('answer', $answer, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductcomment');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductComment
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductComment
     */
    public static function Get($key) {return self::GetObject("XShopProductComment", $key);}

}

SQLObject::SetFieldArray('shopproductcomment', array('id', 'productid', 'userid', 'text', 'cdate', 'rating', 'plus', 'minus', 'image', 'username', 'answer'));
SQLObject::SetPrimaryKey('shopproductcomment', 'id');
