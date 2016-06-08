<?php
/**
 * Class XShopProduct is ORM to table shopproduct
 * @author SQLObject
 * @package SQLObject
 */
class XShopProduct extends SQLObject {

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
     * Get isbox
     * @return int
     */
    public function getIsbox() { return $this->getField('isbox');}

    /**
     * Set isbox
     * @param int $isbox
     */
    public function setIsbox($isbox, $update = false) {$this->setField('isbox', $isbox, $update);}

    /**
     * Filter isbox
     * @param int $isbox
     * @param string $operation
     */
    public function filterIsbox($isbox, $operation = false) {$this->filterField('isbox', $isbox, $operation);}

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
     * Get name1
     * @return string
     */
    public function getName1() { return $this->getField('name1');}

    /**
     * Set name1
     * @param string $name1
     */
    public function setName1($name1, $update = false) {$this->setField('name1', $name1, $update);}

    /**
     * Filter name1
     * @param string $name1
     * @param string $operation
     */
    public function filterName1($name1, $operation = false) {$this->filterField('name1', $name1, $operation);}

    /**
     * Get name2
     * @return string
     */
    public function getName2() { return $this->getField('name2');}

    /**
     * Set name2
     * @param string $name2
     */
    public function setName2($name2, $update = false) {$this->setField('name2', $name2, $update);}

    /**
     * Filter name2
     * @param string $name2
     * @param string $operation
     */
    public function filterName2($name2, $operation = false) {$this->filterField('name2', $name2, $operation);}

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
     * Get tags
     * @return string
     */
    public function getTags() { return $this->getField('tags');}

    /**
     * Set tags
     * @param string $tags
     */
    public function setTags($tags, $update = false) {$this->setField('tags', $tags, $update);}

    /**
     * Filter tags
     * @param string $tags
     * @param string $operation
     */
    public function filterTags($tags, $operation = false) {$this->filterField('tags', $tags, $operation);}

    /**
     * Get characteristics
     * @return string
     */
    public function getCharacteristics() { return $this->getField('characteristics');}

    /**
     * Set characteristics
     * @param string $characteristics
     */
    public function setCharacteristics($characteristics, $update = false) {$this->setField('characteristics', $characteristics, $update);}

    /**
     * Filter characteristics
     * @param string $characteristics
     * @param string $operation
     */
    public function filterCharacteristics($characteristics, $operation = false) {$this->filterField('characteristics', $characteristics, $operation);}

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
     * Get tmpimageurl
     * @return string
     */
    public function getTmpimageurl() { return $this->getField('tmpimageurl');}

    /**
     * Set tmpimageurl
     * @param string $tmpimageurl
     */
    public function setTmpimageurl($tmpimageurl, $update = false) {$this->setField('tmpimageurl', $tmpimageurl, $update);}

    /**
     * Filter tmpimageurl
     * @param string $tmpimageurl
     * @param string $operation
     */
    public function filterTmpimageurl($tmpimageurl, $operation = false) {$this->filterField('tmpimageurl', $tmpimageurl, $operation);}

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
     * Get price
     * @return float
     */
    public function getPrice() { return $this->getField('price');}

    /**
     * Set price
     * @param float $price
     */
    public function setPrice($price, $update = false) {$this->setField('price', $price, $update);}

    /**
     * Filter price
     * @param float $price
     * @param string $operation
     */
    public function filterPrice($price, $operation = false) {$this->filterField('price', $price, $operation);}

    /**
     * Get priceold
     * @return float
     */
    public function getPriceold() { return $this->getField('priceold');}

    /**
     * Set priceold
     * @param float $priceold
     */
    public function setPriceold($priceold, $update = false) {$this->setField('priceold', $priceold, $update);}

    /**
     * Filter priceold
     * @param float $priceold
     * @param string $operation
     */
    public function filterPriceold($priceold, $operation = false) {$this->filterField('priceold', $priceold, $operation);}

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
     * Get categoryid
     * @return int
     */
    public function getCategoryid() { return $this->getField('categoryid');}

    /**
     * Set categoryid
     * @param int $categoryid
     */
    public function setCategoryid($categoryid, $update = false) {$this->setField('categoryid', $categoryid, $update);}

    /**
     * Filter categoryid
     * @param int $categoryid
     * @param string $operation
     */
    public function filterCategoryid($categoryid, $operation = false) {$this->filterField('categoryid', $categoryid, $operation);}

    /**
     * Get brandid
     * @return int
     */
    public function getBrandid() { return $this->getField('brandid');}

    /**
     * Set brandid
     * @param int $brandid
     */
    public function setBrandid($brandid, $update = false) {$this->setField('brandid', $brandid, $update);}

    /**
     * Filter brandid
     * @param int $brandid
     * @param string $operation
     */
    public function filterBrandid($brandid, $operation = false) {$this->filterField('brandid', $brandid, $operation);}

    /**
     * Get model
     * @return string
     */
    public function getModel() { return $this->getField('model');}

    /**
     * Set model
     * @param string $model
     */
    public function setModel($model, $update = false) {$this->setField('model', $model, $update);}

    /**
     * Filter model
     * @param string $model
     * @param string $operation
     */
    public function filterModel($model, $operation = false) {$this->filterField('model', $model, $operation);}

    /**
     * Get articul
     * @return string
     */
    public function getArticul() { return $this->getField('articul');}

    /**
     * Set articul
     * @param string $articul
     */
    public function setArticul($articul, $update = false) {$this->setField('articul', $articul, $update);}

    /**
     * Filter articul
     * @param string $articul
     * @param string $operation
     */
    public function filterArticul($articul, $operation = false) {$this->filterField('articul', $articul, $operation);}

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
     * Get rating
     * @return float
     */
    public function getRating() { return $this->getField('rating');}

    /**
     * Set rating
     * @param float $rating
     */
    public function setRating($rating, $update = false) {$this->setField('rating', $rating, $update);}

    /**
     * Filter rating
     * @param float $rating
     * @param string $operation
     */
    public function filterRating($rating, $operation = false) {$this->filterField('rating', $rating, $operation);}

    /**
     * Get ratingcount
     * @return int
     */
    public function getRatingcount() { return $this->getField('ratingcount');}

    /**
     * Set ratingcount
     * @param int $ratingcount
     */
    public function setRatingcount($ratingcount, $update = false) {$this->setField('ratingcount', $ratingcount, $update);}

    /**
     * Filter ratingcount
     * @param int $ratingcount
     * @param string $operation
     */
    public function filterRatingcount($ratingcount, $operation = false) {$this->filterField('ratingcount', $ratingcount, $operation);}

    /**
     * Get viewed
     * @return int
     */
    public function getViewed() { return $this->getField('viewed');}

    /**
     * Set viewed
     * @param int $viewed
     */
    public function setViewed($viewed, $update = false) {$this->setField('viewed', $viewed, $update);}

    /**
     * Filter viewed
     * @param int $viewed
     * @param string $operation
     */
    public function filterViewed($viewed, $operation = false) {$this->filterField('viewed', $viewed, $operation);}

    /**
     * Get ordered
     * @return int
     */
    public function getOrdered() { return $this->getField('ordered');}

    /**
     * Set ordered
     * @param int $ordered
     */
    public function setOrdered($ordered, $update = false) {$this->setField('ordered', $ordered, $update);}

    /**
     * Filter ordered
     * @param int $ordered
     * @param string $operation
     */
    public function filterOrdered($ordered, $operation = false) {$this->filterField('ordered', $ordered, $operation);}

    /**
     * Get storaged
     * @return int
     */
    public function getStoraged() { return $this->getField('storaged');}

    /**
     * Set storaged
     * @param int $storaged
     */
    public function setStoraged($storaged, $update = false) {$this->setField('storaged', $storaged, $update);}

    /**
     * Filter storaged
     * @param int $storaged
     * @param string $operation
     */
    public function filterStoraged($storaged, $operation = false) {$this->filterField('storaged', $storaged, $operation);}

    /**
     * Get lastordered
     * @return string
     */
    public function getLastordered() { return $this->getField('lastordered');}

    /**
     * Set lastordered
     * @param string $lastordered
     */
    public function setLastordered($lastordered, $update = false) {$this->setField('lastordered', $lastordered, $update);}

    /**
     * Filter lastordered
     * @param string $lastordered
     * @param string $operation
     */
    public function filterLastordered($lastordered, $operation = false) {$this->filterField('lastordered', $lastordered, $operation);}

    /**
     * Get divisibility
     * @return float
     */
    public function getDivisibility() { return $this->getField('divisibility');}

    /**
     * Set divisibility
     * @param float $divisibility
     */
    public function setDivisibility($divisibility, $update = false) {$this->setField('divisibility', $divisibility, $update);}

    /**
     * Filter divisibility
     * @param float $divisibility
     * @param string $operation
     */
    public function filterDivisibility($divisibility, $operation = false) {$this->filterField('divisibility', $divisibility, $operation);}

    /**
     * Get unit
     * @return string
     */
    public function getUnit() { return $this->getField('unit');}

    /**
     * Set unit
     * @param string $unit
     */
    public function setUnit($unit, $update = false) {$this->setField('unit', $unit, $update);}

    /**
     * Filter unit
     * @param string $unit
     * @param string $operation
     */
    public function filterUnit($unit, $operation = false) {$this->filterField('unit', $unit, $operation);}

    /**
     * Get barcode
     * @return string
     */
    public function getBarcode() { return $this->getField('barcode');}

    /**
     * Set barcode
     * @param string $barcode
     */
    public function setBarcode($barcode, $update = false) {$this->setField('barcode', $barcode, $update);}

    /**
     * Filter barcode
     * @param string $barcode
     * @param string $operation
     */
    public function filterBarcode($barcode, $operation = false) {$this->filterField('barcode', $barcode, $operation);}

    /**
     * Get warranty
     * @return string
     */
    public function getWarranty() { return $this->getField('warranty');}

    /**
     * Set warranty
     * @param string $warranty
     */
    public function setWarranty($warranty, $update = false) {$this->setField('warranty', $warranty, $update);}

    /**
     * Filter warranty
     * @param string $warranty
     * @param string $operation
     */
    public function filterWarranty($warranty, $operation = false) {$this->filterField('warranty', $warranty, $operation);}

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
     * Get deleted
     * @return int
     */
    public function getDeleted() { return $this->getField('deleted');}

    /**
     * Set deleted
     * @param int $deleted
     */
    public function setDeleted($deleted, $update = false) {$this->setField('deleted', $deleted, $update);}

    /**
     * Filter deleted
     * @param int $deleted
     * @param string $operation
     */
    public function filterDeleted($deleted, $operation = false) {$this->filterField('deleted', $deleted, $operation);}

    /**
     * Get sync
     * @return int
     */
    public function getSync() { return $this->getField('sync');}

    /**
     * Set sync
     * @param int $sync
     */
    public function setSync($sync, $update = false) {$this->setField('sync', $sync, $update);}

    /**
     * Filter sync
     * @param int $sync
     * @param string $operation
     */
    public function filterSync($sync, $operation = false) {$this->filterField('sync', $sync, $operation);}

    /**
     * Get unsyncable
     * @return int
     */
    public function getUnsyncable() { return $this->getField('unsyncable');}

    /**
     * Set unsyncable
     * @param int $unsyncable
     */
    public function setUnsyncable($unsyncable, $update = false) {$this->setField('unsyncable', $unsyncable, $update);}

    /**
     * Filter unsyncable
     * @param int $unsyncable
     * @param string $operation
     */
    public function filterUnsyncable($unsyncable, $operation = false) {$this->filterField('unsyncable', $unsyncable, $operation);}

    /**
     * Get avail
     * @return int
     */
    public function getAvail() { return $this->getField('avail');}

    /**
     * Set avail
     * @param int $avail
     */
    public function setAvail($avail, $update = false) {$this->setField('avail', $avail, $update);}

    /**
     * Filter avail
     * @param int $avail
     * @param string $operation
     */
    public function filterAvail($avail, $operation = false) {$this->filterField('avail', $avail, $operation);}

    /**
     * Get suppliered
     * @return int
     */
    public function getSuppliered() { return $this->getField('suppliered');}

    /**
     * Set suppliered
     * @param int $suppliered
     */
    public function setSuppliered($suppliered, $update = false) {$this->setField('suppliered', $suppliered, $update);}

    /**
     * Filter suppliered
     * @param int $suppliered
     * @param string $operation
     */
    public function filterSuppliered($suppliered, $operation = false) {$this->filterField('suppliered', $suppliered, $operation);}

    /**
     * Get availtext
     * @return string
     */
    public function getAvailtext() { return $this->getField('availtext');}

    /**
     * Set availtext
     * @param string $availtext
     */
    public function setAvailtext($availtext, $update = false) {$this->setField('availtext', $availtext, $update);}

    /**
     * Filter availtext
     * @param string $availtext
     * @param string $operation
     */
    public function filterAvailtext($availtext, $operation = false) {$this->filterField('availtext', $availtext, $operation);}

    /**
     * Get seriesname
     * @return string
     */
    public function getSeriesname() { return $this->getField('seriesname');}

    /**
     * Set seriesname
     * @param string $seriesname
     */
    public function setSeriesname($seriesname, $update = false) {$this->setField('seriesname', $seriesname, $update);}

    /**
     * Filter seriesname
     * @param string $seriesname
     * @param string $operation
     */
    public function filterSeriesname($seriesname, $operation = false) {$this->filterField('seriesname', $seriesname, $operation);}

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
     * Get collectionid
     * @return int
     */
    public function getCollectionid() { return $this->getField('collectionid');}

    /**
     * Set collectionid
     * @param int $collectionid
     */
    public function setCollectionid($collectionid, $update = false) {$this->setField('collectionid', $collectionid, $update);}

    /**
     * Filter collectionid
     * @param int $collectionid
     * @param string $operation
     */
    public function filterCollectionid($collectionid, $operation = false) {$this->filterField('collectionid', $collectionid, $operation);}

    /**
     * Get length
     * @return string
     */
    public function getLength() { return $this->getField('length');}

    /**
     * Set length
     * @param string $length
     */
    public function setLength($length, $update = false) {$this->setField('length', $length, $update);}

    /**
     * Filter length
     * @param string $length
     * @param string $operation
     */
    public function filterLength($length, $operation = false) {$this->filterField('length', $length, $operation);}

    /**
     * Get width
     * @return string
     */
    public function getWidth() { return $this->getField('width');}

    /**
     * Set width
     * @param string $width
     */
    public function setWidth($width, $update = false) {$this->setField('width', $width, $update);}

    /**
     * Filter width
     * @param string $width
     * @param string $operation
     */
    public function filterWidth($width, $operation = false) {$this->filterField('width', $width, $operation);}

    /**
     * Get height
     * @return string
     */
    public function getHeight() { return $this->getField('height');}

    /**
     * Set height
     * @param string $height
     */
    public function setHeight($height, $update = false) {$this->setField('height', $height, $update);}

    /**
     * Filter height
     * @param string $height
     * @param string $operation
     */
    public function filterHeight($height, $operation = false) {$this->filterField('height', $height, $operation);}

    /**
     * Get weight
     * @return string
     */
    public function getWeight() { return $this->getField('weight');}

    /**
     * Set weight
     * @param string $weight
     */
    public function setWeight($weight, $update = false) {$this->setField('weight', $weight, $update);}

    /**
     * Filter weight
     * @param string $weight
     * @param string $operation
     */
    public function filterWeight($weight, $operation = false) {$this->filterField('weight', $weight, $operation);}

    /**
     * Get unitbox
     * @return int
     */
    public function getUnitbox() { return $this->getField('unitbox');}

    /**
     * Set unitbox
     * @param int $unitbox
     */
    public function setUnitbox($unitbox, $update = false) {$this->setField('unitbox', $unitbox, $update);}

    /**
     * Filter unitbox
     * @param int $unitbox
     * @param string $operation
     */
    public function filterUnitbox($unitbox, $operation = false) {$this->filterField('unitbox', $unitbox, $operation);}

    /**
     * Get discount
     * @return int
     */
    public function getDiscount() { return $this->getField('discount');}

    /**
     * Set discount
     * @param int $discount
     */
    public function setDiscount($discount, $update = false) {$this->setField('discount', $discount, $update);}

    /**
     * Filter discount
     * @param int $discount
     * @param string $operation
     */
    public function filterDiscount($discount, $operation = false) {$this->filterField('discount', $discount, $operation);}

    /**
     * Get preorderDiscount
     * @return int
     */
    public function getPreorderDiscount() { return $this->getField('preorderDiscount');}

    /**
     * Set preorderDiscount
     * @param int $preorderDiscount
     */
    public function setPreorderDiscount($preorderDiscount, $update = false) {$this->setField('preorderDiscount', $preorderDiscount, $update);}

    /**
     * Filter preorderDiscount
     * @param int $preorderDiscount
     * @param string $operation
     */
    public function filterPreorderDiscount($preorderDiscount, $operation = false) {$this->filterField('preorderDiscount', $preorderDiscount, $operation);}

    /**
     * Get tax
     * @return int
     */
    public function getTax() { return $this->getField('tax');}

    /**
     * Set tax
     * @param int $tax
     */
    public function setTax($tax, $update = false) {$this->setField('tax', $tax, $update);}

    /**
     * Filter tax
     * @param int $tax
     * @param string $operation
     */
    public function filterTax($tax, $operation = false) {$this->filterField('tax', $tax, $operation);}

    /**
     * Get payment
     * @return string
     */
    public function getPayment() { return $this->getField('payment');}

    /**
     * Set payment
     * @param string $payment
     */
    public function setPayment($payment, $update = false) {$this->setField('payment', $payment, $update);}

    /**
     * Filter payment
     * @param string $payment
     * @param string $operation
     */
    public function filterPayment($payment, $operation = false) {$this->filterField('payment', $payment, $operation);}

    /**
     * Get delivery
     * @return string
     */
    public function getDelivery() { return $this->getField('delivery');}

    /**
     * Set delivery
     * @param string $delivery
     */
    public function setDelivery($delivery, $update = false) {$this->setField('delivery', $delivery, $update);}

    /**
     * Filter delivery
     * @param string $delivery
     * @param string $operation
     */
    public function filterDelivery($delivery, $operation = false) {$this->filterField('delivery', $delivery, $operation);}

    /**
     * Get denycomments
     * @return int
     */
    public function getDenycomments() { return $this->getField('denycomments');}

    /**
     * Set denycomments
     * @param int $denycomments
     */
    public function setDenycomments($denycomments, $update = false) {$this->setField('denycomments', $denycomments, $update);}

    /**
     * Filter denycomments
     * @param int $denycomments
     * @param string $operation
     */
    public function filterDenycomments($denycomments, $operation = false) {$this->filterField('denycomments', $denycomments, $operation);}

    /**
     * Get descriptionshort
     * @return string
     */
    public function getDescriptionshort() { return $this->getField('descriptionshort');}

    /**
     * Set descriptionshort
     * @param string $descriptionshort
     */
    public function setDescriptionshort($descriptionshort, $update = false) {$this->setField('descriptionshort', $descriptionshort, $update);}

    /**
     * Filter descriptionshort
     * @param string $descriptionshort
     * @param string $operation
     */
    public function filterDescriptionshort($descriptionshort, $operation = false) {$this->filterField('descriptionshort', $descriptionshort, $operation);}

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
     * Get share
     * @return string
     */
    public function getShare() { return $this->getField('share');}

    /**
     * Set share
     * @param string $share
     */
    public function setShare($share, $update = false) {$this->setField('share', $share, $update);}

    /**
     * Filter share
     * @param string $share
     * @param string $operation
     */
    public function filterShare($share, $operation = false) {$this->filterField('share', $share, $operation);}

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
     * Get iconid
     * @return int
     */
    public function getIconid() { return $this->getField('iconid');}

    /**
     * Set iconid
     * @param int $iconid
     */
    public function setIconid($iconid, $update = false) {$this->setField('iconid', $iconid, $update);}

    /**
     * Filter iconid
     * @param int $iconid
     * @param string $operation
     */
    public function filterIconid($iconid, $operation = false) {$this->filterField('iconid', $iconid, $operation);}

    /**
     * Get filedownload
     * @return string
     */
    public function getFiledownload() { return $this->getField('filedownload');}

    /**
     * Set filedownload
     * @param string $filedownload
     */
    public function setFiledownload($filedownload, $update = false) {$this->setField('filedownload', $filedownload, $update);}

    /**
     * Filter filedownload
     * @param string $filedownload
     * @param string $operation
     */
    public function filterFiledownload($filedownload, $operation = false) {$this->filterField('filedownload', $filedownload, $operation);}

    /**
     * Get supplierid
     * @return int
     */
    public function getSupplierid() { return $this->getField('supplierid');}

    /**
     * Set supplierid
     * @param int $supplierid
     */
    public function setSupplierid($supplierid, $update = false) {$this->setField('supplierid', $supplierid, $update);}

    /**
     * Filter supplierid
     * @param int $supplierid
     * @param string $operation
     */
    public function filterSupplierid($supplierid, $operation = false) {$this->filterField('supplierid', $supplierid, $operation);}

    /**
     * Get udate
     * @return string
     */
    public function getUdate() { return $this->getField('udate');}

    /**
     * Set udate
     * @param string $udate
     */
    public function setUdate($udate, $update = false) {$this->setField('udate', $udate, $update);}

    /**
     * Filter udate
     * @param string $udate
     * @param string $operation
     */
    public function filterUdate($udate, $operation = false) {$this->filterField('udate', $udate, $operation);}

    /**
     * Get rrc
     * @return int
     */
    public function getRrc() { return $this->getField('rrc');}

    /**
     * Set rrc
     * @param int $rrc
     */
    public function setRrc($rrc, $update = false) {$this->setField('rrc', $rrc, $update);}

    /**
     * Filter rrc
     * @param int $rrc
     * @param string $operation
     */
    public function filterRrc($rrc, $operation = false) {$this->filterField('rrc', $rrc, $operation);}

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
     * Get imagegrouped
     * @return int
     */
    public function getImagegrouped() { return $this->getField('imagegrouped');}

    /**
     * Set imagegrouped
     * @param int $imagegrouped
     */
    public function setImagegrouped($imagegrouped, $update = false) {$this->setField('imagegrouped', $imagegrouped, $update);}

    /**
     * Filter imagegrouped
     * @param int $imagegrouped
     * @param string $operation
     */
    public function filterImagegrouped($imagegrouped, $operation = false) {$this->filterField('imagegrouped', $imagegrouped, $operation);}

    /**
     * Get notdiscount
     * @return int
     */
    public function getNotdiscount() { return $this->getField('notdiscount');}

    /**
     * Set notdiscount
     * @param int $notdiscount
     */
    public function setNotdiscount($notdiscount, $update = false) {$this->setField('notdiscount', $notdiscount, $update);}

    /**
     * Filter notdiscount
     * @param int $notdiscount
     * @param string $operation
     */
    public function filterNotdiscount($notdiscount, $operation = false) {$this->filterField('notdiscount', $notdiscount, $operation);}

    /**
     * Get maxdiscount
     * @return float
     */
    public function getMaxdiscount() { return $this->getField('maxdiscount');}

    /**
     * Set maxdiscount
     * @param float $maxdiscount
     */
    public function setMaxdiscount($maxdiscount, $update = false) {$this->setField('maxdiscount', $maxdiscount, $update);}

    /**
     * Filter maxdiscount
     * @param float $maxdiscount
     * @param string $operation
     */
    public function filterMaxdiscount($maxdiscount, $operation = false) {$this->filterField('maxdiscount', $maxdiscount, $operation);}

    /**
     * Get price1
     * @return float
     */
    public function getPrice1() { return $this->getField('price1');}

    /**
     * Set price1
     * @param float $price1
     */
    public function setPrice1($price1, $update = false) {$this->setField('price1', $price1, $update);}

    /**
     * Filter price1
     * @param float $price1
     * @param string $operation
     */
    public function filterPrice1($price1, $operation = false) {$this->filterField('price1', $price1, $operation);}

    /**
     * Get price2
     * @return float
     */
    public function getPrice2() { return $this->getField('price2');}

    /**
     * Set price2
     * @param float $price2
     */
    public function setPrice2($price2, $update = false) {$this->setField('price2', $price2, $update);}

    /**
     * Filter price2
     * @param float $price2
     * @param string $operation
     */
    public function filterPrice2($price2, $operation = false) {$this->filterField('price2', $price2, $operation);}

    /**
     * Get price3
     * @return float
     */
    public function getPrice3() { return $this->getField('price3');}

    /**
     * Set price3
     * @param float $price3
     */
    public function setPrice3($price3, $update = false) {$this->setField('price3', $price3, $update);}

    /**
     * Filter price3
     * @param float $price3
     * @param string $operation
     */
    public function filterPrice3($price3, $operation = false) {$this->filterField('price3', $price3, $operation);}

    /**
     * Get price4
     * @return float
     */
    public function getPrice4() { return $this->getField('price4');}

    /**
     * Set price4
     * @param float $price4
     */
    public function setPrice4($price4, $update = false) {$this->setField('price4', $price4, $update);}

    /**
     * Filter price4
     * @param float $price4
     * @param string $operation
     */
    public function filterPrice4($price4, $operation = false) {$this->filterField('price4', $price4, $operation);}

    /**
     * Get price5
     * @return float
     */
    public function getPrice5() { return $this->getField('price5');}

    /**
     * Set price5
     * @param float $price5
     */
    public function setPrice5($price5, $update = false) {$this->setField('price5', $price5, $update);}

    /**
     * Filter price5
     * @param float $price5
     * @param string $operation
     */
    public function filterPrice5($price5, $operation = false) {$this->filterField('price5', $price5, $operation);}

    /**
     * Get category1id
     * @return int
     */
    public function getCategory1id() { return $this->getField('category1id');}

    /**
     * Set category1id
     * @param int $category1id
     */
    public function setCategory1id($category1id, $update = false) {$this->setField('category1id', $category1id, $update);}

    /**
     * Filter category1id
     * @param int $category1id
     * @param string $operation
     */
    public function filterCategory1id($category1id, $operation = false) {$this->filterField('category1id', $category1id, $operation);}

    /**
     * Get category2id
     * @return int
     */
    public function getCategory2id() { return $this->getField('category2id');}

    /**
     * Set category2id
     * @param int $category2id
     */
    public function setCategory2id($category2id, $update = false) {$this->setField('category2id', $category2id, $update);}

    /**
     * Filter category2id
     * @param int $category2id
     * @param string $operation
     */
    public function filterCategory2id($category2id, $operation = false) {$this->filterField('category2id', $category2id, $operation);}

    /**
     * Get category3id
     * @return int
     */
    public function getCategory3id() { return $this->getField('category3id');}

    /**
     * Set category3id
     * @param int $category3id
     */
    public function setCategory3id($category3id, $update = false) {$this->setField('category3id', $category3id, $update);}

    /**
     * Filter category3id
     * @param int $category3id
     * @param string $operation
     */
    public function filterCategory3id($category3id, $operation = false) {$this->filterField('category3id', $category3id, $operation);}

    /**
     * Get category4id
     * @return int
     */
    public function getCategory4id() { return $this->getField('category4id');}

    /**
     * Set category4id
     * @param int $category4id
     */
    public function setCategory4id($category4id, $update = false) {$this->setField('category4id', $category4id, $update);}

    /**
     * Filter category4id
     * @param int $category4id
     * @param string $operation
     */
    public function filterCategory4id($category4id, $operation = false) {$this->filterField('category4id', $category4id, $operation);}

    /**
     * Get category5id
     * @return int
     */
    public function getCategory5id() { return $this->getField('category5id');}

    /**
     * Set category5id
     * @param int $category5id
     */
    public function setCategory5id($category5id, $update = false) {$this->setField('category5id', $category5id, $update);}

    /**
     * Filter category5id
     * @param int $category5id
     * @param string $operation
     */
    public function filterCategory5id($category5id, $operation = false) {$this->filterField('category5id', $category5id, $operation);}

    /**
     * Get category6id
     * @return int
     */
    public function getCategory6id() { return $this->getField('category6id');}

    /**
     * Set category6id
     * @param int $category6id
     */
    public function setCategory6id($category6id, $update = false) {$this->setField('category6id', $category6id, $update);}

    /**
     * Filter category6id
     * @param int $category6id
     * @param string $operation
     */
    public function filterCategory6id($category6id, $operation = false) {$this->filterField('category6id', $category6id, $operation);}

    /**
     * Get category7id
     * @return int
     */
    public function getCategory7id() { return $this->getField('category7id');}

    /**
     * Set category7id
     * @param int $category7id
     */
    public function setCategory7id($category7id, $update = false) {$this->setField('category7id', $category7id, $update);}

    /**
     * Filter category7id
     * @param int $category7id
     * @param string $operation
     */
    public function filterCategory7id($category7id, $operation = false) {$this->filterField('category7id', $category7id, $operation);}

    /**
     * Get category8id
     * @return int
     */
    public function getCategory8id() { return $this->getField('category8id');}

    /**
     * Set category8id
     * @param int $category8id
     */
    public function setCategory8id($category8id, $update = false) {$this->setField('category8id', $category8id, $update);}

    /**
     * Filter category8id
     * @param int $category8id
     * @param string $operation
     */
    public function filterCategory8id($category8id, $operation = false) {$this->filterField('category8id', $category8id, $operation);}

    /**
     * Get category9id
     * @return int
     */
    public function getCategory9id() { return $this->getField('category9id');}

    /**
     * Set category9id
     * @param int $category9id
     */
    public function setCategory9id($category9id, $update = false) {$this->setField('category9id', $category9id, $update);}

    /**
     * Filter category9id
     * @param int $category9id
     * @param string $operation
     */
    public function filterCategory9id($category9id, $operation = false) {$this->filterField('category9id', $category9id, $operation);}

    /**
     * Get category10id
     * @return int
     */
    public function getCategory10id() { return $this->getField('category10id');}

    /**
     * Set category10id
     * @param int $category10id
     */
    public function setCategory10id($category10id, $update = false) {$this->setField('category10id', $category10id, $update);}

    /**
     * Filter category10id
     * @param int $category10id
     * @param string $operation
     */
    public function filterCategory10id($category10id, $operation = false) {$this->filterField('category10id', $category10id, $operation);}

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
     * Get source
     * @return string
     */
    public function getSource() { return $this->getField('source');}

    /**
     * Set source
     * @param string $source
     */
    public function setSource($source, $update = false) {$this->setField('source', $source, $update);}

    /**
     * Filter source
     * @param string $source
     * @param string $operation
     */
    public function filterSource($source, $operation = false) {$this->filterField('source', $source, $operation);}

    /**
     * Get term
     * @return string
     */
    public function getTerm() { return $this->getField('term');}

    /**
     * Set term
     * @param string $term
     */
    public function setTerm($term, $update = false) {$this->setField('term', $term, $update);}

    /**
     * Filter term
     * @param string $term
     * @param string $operation
     */
    public function filterTerm($term, $operation = false) {$this->filterField('term', $term, $operation);}

    /**
     * Get pricebase
     * @return float
     */
    public function getPricebase() { return $this->getField('pricebase');}

    /**
     * Set pricebase
     * @param float $pricebase
     */
    public function setPricebase($pricebase, $update = false) {$this->setField('pricebase', $pricebase, $update);}

    /**
     * Filter pricebase
     * @param float $pricebase
     * @param string $operation
     */
    public function filterPricebase($pricebase, $operation = false) {$this->filterField('pricebase', $pricebase, $operation);}

    /**
     * Get pricesell
     * @return float
     */
    public function getPricesell() { return $this->getField('pricesell');}

    /**
     * Set pricesell
     * @param float $pricesell
     */
    public function setPricesell($pricesell, $update = false) {$this->setField('pricesell', $pricesell, $update);}

    /**
     * Filter pricesell
     * @param float $pricesell
     * @param string $operation
     */
    public function filterPricesell($pricesell, $operation = false) {$this->filterField('pricesell', $pricesell, $operation);}

    /**
     * Get datelifefrom
     * @return string
     */
    public function getDatelifefrom() { return $this->getField('datelifefrom');}

    /**
     * Set datelifefrom
     * @param string $datelifefrom
     */
    public function setDatelifefrom($datelifefrom, $update = false) {$this->setField('datelifefrom', $datelifefrom, $update);}

    /**
     * Filter datelifefrom
     * @param string $datelifefrom
     * @param string $operation
     */
    public function filterDatelifefrom($datelifefrom, $operation = false) {$this->filterField('datelifefrom', $datelifefrom, $operation);}

    /**
     * Get datelifeto
     * @return string
     */
    public function getDatelifeto() { return $this->getField('datelifeto');}

    /**
     * Set datelifeto
     * @param string $datelifeto
     */
    public function setDatelifeto($datelifeto, $update = false) {$this->setField('datelifeto', $datelifeto, $update);}

    /**
     * Filter datelifeto
     * @param string $datelifeto
     * @param string $operation
     */
    public function filterDatelifeto($datelifeto, $operation = false) {$this->filterField('datelifeto', $datelifeto, $operation);}

    /**
     * Get f_id
     * @return int
     */
    public function getF_id() { return $this->getField('f_id');}

    /**
     * Set f_id
     * @param int $f_id
     */
    public function setF_id($f_id, $update = false) {$this->setField('f_id', $f_id, $update);}

    /**
     * Filter f_id
     * @param int $f_id
     * @param string $operation
     */
    public function filterF_id($f_id, $operation = false) {$this->filterField('f_id', $f_id, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproduct');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProduct
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProduct
     */
    public static function Get($key) {return self::GetObject("XShopProduct", $key);}

}

SQLObject::SetFieldArray('shopproduct', array('id', 'isbox', 'name', 'name1', 'name2', 'description', 'tags', 'characteristics', 'image', 'tmpimageurl', 'imagecrop', 'price', 'priceold', 'currencyid', 'categoryid', 'brandid', 'model', 'articul', 'userid', 'top', 'rating', 'ratingcount', 'viewed', 'ordered', 'storaged', 'lastordered', 'divisibility', 'unit', 'barcode', 'warranty', 'hidden', 'hiddenold', 'deleted', 'sync', 'unsyncable', 'avail', 'suppliered', 'availtext', 'seriesname', 'url', 'siteurl', 'collectionid', 'length', 'width', 'height', 'weight', 'unitbox', 'discount', 'preorderDiscount', 'tax', 'payment', 'delivery', 'denycomments', 'descriptionshort', 'code1c', 'codesupplier', 'share', 'seodescription', 'seotitle', 'seoh1', 'seocontent', 'seokeywords', 'iconid', 'filedownload', 'supplierid', 'udate', 'rrc', 'cdate', 'imagegrouped', 'notdiscount', 'maxdiscount', 'price1', 'price2', 'price3', 'price4', 'price5', 'category1id', 'category2id', 'category3id', 'category4id', 'category5id', 'category6id', 'category7id', 'category8id', 'category9id', 'category10id', 'linkkey', 'source', 'term', 'pricebase', 'pricesell', 'datelifefrom', 'datelifeto', 'f_id'));
SQLObject::SetPrimaryKey('shopproduct', 'id');
