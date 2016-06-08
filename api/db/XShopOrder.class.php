<?php
/**
 * Class XShopOrder is ORM to table shoporder
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrder extends SQLObject {

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
     * Get number
     * @return string
     */
    public function getNumber() { return $this->getField('number');}

    /**
     * Set number
     * @param string $number
     */
    public function setNumber($number, $update = false) {$this->setField('number', $number, $update);}

    /**
     * Filter number
     * @param string $number
     * @param string $operation
     */
    public function filterNumber($number, $operation = false) {$this->filterField('number', $number, $operation);}

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
     * Get clientmanagerid
     * @return int
     */
    public function getClientmanagerid() { return $this->getField('clientmanagerid');}

    /**
     * Set clientmanagerid
     * @param int $clientmanagerid
     */
    public function setClientmanagerid($clientmanagerid, $update = false) {$this->setField('clientmanagerid', $clientmanagerid, $update);}

    /**
     * Filter clientmanagerid
     * @param int $clientmanagerid
     * @param string $operation
     */
    public function filterClientmanagerid($clientmanagerid, $operation = false) {$this->filterField('clientmanagerid', $clientmanagerid, $operation);}

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
     * Get authorid
     * @return int
     */
    public function getAuthorid() { return $this->getField('authorid');}

    /**
     * Set authorid
     * @param int $authorid
     */
    public function setAuthorid($authorid, $update = false) {$this->setField('authorid', $authorid, $update);}

    /**
     * Filter authorid
     * @param int $authorid
     * @param string $operation
     */
    public function filterAuthorid($authorid, $operation = false) {$this->filterField('authorid', $authorid, $operation);}

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
     * Get uuserid
     * @return int
     */
    public function getUuserid() { return $this->getField('uuserid');}

    /**
     * Set uuserid
     * @param int $uuserid
     */
    public function setUuserid($uuserid, $update = false) {$this->setField('uuserid', $uuserid, $update);}

    /**
     * Filter uuserid
     * @param int $uuserid
     * @param string $operation
     */
    public function filterUuserid($uuserid, $operation = false) {$this->filterField('uuserid', $uuserid, $operation);}

    /**
     * Get datetoyear
     * @return int
     */
    public function getDatetoyear() { return $this->getField('datetoyear');}

    /**
     * Set datetoyear
     * @param int $datetoyear
     */
    public function setDatetoyear($datetoyear, $update = false) {$this->setField('datetoyear', $datetoyear, $update);}

    /**
     * Filter datetoyear
     * @param int $datetoyear
     * @param string $operation
     */
    public function filterDatetoyear($datetoyear, $operation = false) {$this->filterField('datetoyear', $datetoyear, $operation);}

    /**
     * Get datetomonth
     * @return int
     */
    public function getDatetomonth() { return $this->getField('datetomonth');}

    /**
     * Set datetomonth
     * @param int $datetomonth
     */
    public function setDatetomonth($datetomonth, $update = false) {$this->setField('datetomonth', $datetomonth, $update);}

    /**
     * Filter datetomonth
     * @param int $datetomonth
     * @param string $operation
     */
    public function filterDatetomonth($datetomonth, $operation = false) {$this->filterField('datetomonth', $datetomonth, $operation);}

    /**
     * Get datetoday
     * @return int
     */
    public function getDatetoday() { return $this->getField('datetoday');}

    /**
     * Set datetoday
     * @param int $datetoday
     */
    public function setDatetoday($datetoday, $update = false) {$this->setField('datetoday', $datetoday, $update);}

    /**
     * Filter datetoday
     * @param int $datetoday
     * @param string $operation
     */
    public function filterDatetoday($datetoday, $operation = false) {$this->filterField('datetoday', $datetoday, $operation);}

    /**
     * Get dateto
     * @return string
     */
    public function getDateto() { return $this->getField('dateto');}

    /**
     * Set dateto
     * @param string $dateto
     */
    public function setDateto($dateto, $update = false) {$this->setField('dateto', $dateto, $update);}

    /**
     * Filter dateto
     * @param string $dateto
     * @param string $operation
     */
    public function filterDateto($dateto, $operation = false) {$this->filterField('dateto', $dateto, $operation);}

    /**
     * Get statusid
     * @return int
     */
    public function getStatusid() { return $this->getField('statusid');}

    /**
     * Set statusid
     * @param int $statusid
     */
    public function setStatusid($statusid, $update = false) {$this->setField('statusid', $statusid, $update);}

    /**
     * Filter statusid
     * @param int $statusid
     * @param string $operation
     */
    public function filterStatusid($statusid, $operation = false) {$this->filterField('statusid', $statusid, $operation);}

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
     * Get clientname
     * @return string
     */
    public function getClientname() { return $this->getField('clientname');}

    /**
     * Set clientname
     * @param string $clientname
     */
    public function setClientname($clientname, $update = false) {$this->setField('clientname', $clientname, $update);}

    /**
     * Filter clientname
     * @param string $clientname
     * @param string $operation
     */
    public function filterClientname($clientname, $operation = false) {$this->filterField('clientname', $clientname, $operation);}

    /**
     * Get clientemail
     * @return string
     */
    public function getClientemail() { return $this->getField('clientemail');}

    /**
     * Set clientemail
     * @param string $clientemail
     */
    public function setClientemail($clientemail, $update = false) {$this->setField('clientemail', $clientemail, $update);}

    /**
     * Filter clientemail
     * @param string $clientemail
     * @param string $operation
     */
    public function filterClientemail($clientemail, $operation = false) {$this->filterField('clientemail', $clientemail, $operation);}

    /**
     * Get clientphone
     * @return string
     */
    public function getClientphone() { return $this->getField('clientphone');}

    /**
     * Set clientphone
     * @param string $clientphone
     */
    public function setClientphone($clientphone, $update = false) {$this->setField('clientphone', $clientphone, $update);}

    /**
     * Filter clientphone
     * @param string $clientphone
     * @param string $operation
     */
    public function filterClientphone($clientphone, $operation = false) {$this->filterField('clientphone', $clientphone, $operation);}

    /**
     * Get clientaddress
     * @return string
     */
    public function getClientaddress() { return $this->getField('clientaddress');}

    /**
     * Set clientaddress
     * @param string $clientaddress
     */
    public function setClientaddress($clientaddress, $update = false) {$this->setField('clientaddress', $clientaddress, $update);}

    /**
     * Filter clientaddress
     * @param string $clientaddress
     * @param string $operation
     */
    public function filterClientaddress($clientaddress, $operation = false) {$this->filterField('clientaddress', $clientaddress, $operation);}

    /**
     * Get clientcontacts
     * @return string
     */
    public function getClientcontacts() { return $this->getField('clientcontacts');}

    /**
     * Set clientcontacts
     * @param string $clientcontacts
     */
    public function setClientcontacts($clientcontacts, $update = false) {$this->setField('clientcontacts', $clientcontacts, $update);}

    /**
     * Filter clientcontacts
     * @param string $clientcontacts
     * @param string $operation
     */
    public function filterClientcontacts($clientcontacts, $operation = false) {$this->filterField('clientcontacts', $clientcontacts, $operation);}

    /**
     * Get comments
     * @return string
     */
    public function getComments() { return $this->getField('comments');}

    /**
     * Set comments
     * @param string $comments
     */
    public function setComments($comments, $update = false) {$this->setField('comments', $comments, $update);}

    /**
     * Filter comments
     * @param string $comments
     * @param string $operation
     */
    public function filterComments($comments, $operation = false) {$this->filterField('comments', $comments, $operation);}

    /**
     * Get sum
     * @return float
     */
    public function getSum() { return $this->getField('sum');}

    /**
     * Set sum
     * @param float $sum
     */
    public function setSum($sum, $update = false) {$this->setField('sum', $sum, $update);}

    /**
     * Filter sum
     * @param float $sum
     * @param string $operation
     */
    public function filterSum($sum, $operation = false) {$this->filterField('sum', $sum, $operation);}

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
     * Get deliveryid
     * @return int
     */
    public function getDeliveryid() { return $this->getField('deliveryid');}

    /**
     * Set deliveryid
     * @param int $deliveryid
     */
    public function setDeliveryid($deliveryid, $update = false) {$this->setField('deliveryid', $deliveryid, $update);}

    /**
     * Filter deliveryid
     * @param int $deliveryid
     * @param string $operation
     */
    public function filterDeliveryid($deliveryid, $operation = false) {$this->filterField('deliveryid', $deliveryid, $operation);}

    /**
     * Get deliveryprice
     * @return float
     */
    public function getDeliveryprice() { return $this->getField('deliveryprice');}

    /**
     * Set deliveryprice
     * @param float $deliveryprice
     */
    public function setDeliveryprice($deliveryprice, $update = false) {$this->setField('deliveryprice', $deliveryprice, $update);}

    /**
     * Filter deliveryprice
     * @param float $deliveryprice
     * @param string $operation
     */
    public function filterDeliveryprice($deliveryprice, $operation = false) {$this->filterField('deliveryprice', $deliveryprice, $operation);}

    /**
     * Get paymentid
     * @return int
     */
    public function getPaymentid() { return $this->getField('paymentid');}

    /**
     * Set paymentid
     * @param int $paymentid
     */
    public function setPaymentid($paymentid, $update = false) {$this->setField('paymentid', $paymentid, $update);}

    /**
     * Filter paymentid
     * @param int $paymentid
     * @param string $operation
     */
    public function filterPaymentid($paymentid, $operation = false) {$this->filterField('paymentid', $paymentid, $operation);}

    /**
     * Get discountid
     * @return int
     */
    public function getDiscountid() { return $this->getField('discountid');}

    /**
     * Set discountid
     * @param int $discountid
     */
    public function setDiscountid($discountid, $update = false) {$this->setField('discountid', $discountid, $update);}

    /**
     * Filter discountid
     * @param int $discountid
     * @param string $operation
     */
    public function filterDiscountid($discountid, $operation = false) {$this->filterField('discountid', $discountid, $operation);}

    /**
     * Get discountsum
     * @return float
     */
    public function getDiscountsum() { return $this->getField('discountsum');}

    /**
     * Set discountsum
     * @param float $discountsum
     */
    public function setDiscountsum($discountsum, $update = false) {$this->setField('discountsum', $discountsum, $update);}

    /**
     * Filter discountsum
     * @param float $discountsum
     * @param string $operation
     */
    public function filterDiscountsum($discountsum, $operation = false) {$this->filterField('discountsum', $discountsum, $operation);}

    /**
     * Get hash
     * @return string
     */
    public function getHash() { return $this->getField('hash');}

    /**
     * Set hash
     * @param string $hash
     */
    public function setHash($hash, $update = false) {$this->setField('hash', $hash, $update);}

    /**
     * Filter hash
     * @param string $hash
     * @param string $operation
     */
    public function filterHash($hash, $operation = false) {$this->filterField('hash', $hash, $operation);}

    /**
     * Get contractorid
     * @return int
     */
    public function getContractorid() { return $this->getField('contractorid');}

    /**
     * Set contractorid
     * @param int $contractorid
     */
    public function setContractorid($contractorid, $update = false) {$this->setField('contractorid', $contractorid, $update);}

    /**
     * Filter contractorid
     * @param int $contractorid
     * @param string $operation
     */
    public function filterContractorid($contractorid, $operation = false) {$this->filterField('contractorid', $contractorid, $operation);}

    /**
     * Get deliverynote
     * @return string
     */
    public function getDeliverynote() { return $this->getField('deliverynote');}

    /**
     * Set deliverynote
     * @param string $deliverynote
     */
    public function setDeliverynote($deliverynote, $update = false) {$this->setField('deliverynote', $deliverynote, $update);}

    /**
     * Filter deliverynote
     * @param string $deliverynote
     * @param string $operation
     */
    public function filterDeliverynote($deliverynote, $operation = false) {$this->filterField('deliverynote', $deliverynote, $operation);}

    /**
     * Get sumpaid
     * @return float
     */
    public function getSumpaid() { return $this->getField('sumpaid');}

    /**
     * Set sumpaid
     * @param float $sumpaid
     */
    public function setSumpaid($sumpaid, $update = false) {$this->setField('sumpaid', $sumpaid, $update);}

    /**
     * Filter sumpaid
     * @param float $sumpaid
     * @param string $operation
     */
    public function filterSumpaid($sumpaid, $operation = false) {$this->filterField('sumpaid', $sumpaid, $operation);}

    /**
     * Get dateshipped
     * @return string
     */
    public function getDateshipped() { return $this->getField('dateshipped');}

    /**
     * Set dateshipped
     * @param string $dateshipped
     */
    public function setDateshipped($dateshipped, $update = false) {$this->setField('dateshipped', $dateshipped, $update);}

    /**
     * Filter dateshipped
     * @param string $dateshipped
     * @param string $operation
     */
    public function filterDateshipped($dateshipped, $operation = false) {$this->filterField('dateshipped', $dateshipped, $operation);}

    /**
     * Get dateclosed
     * @return string
     */
    public function getDateclosed() { return $this->getField('dateclosed');}

    /**
     * Set dateclosed
     * @param string $dateclosed
     */
    public function setDateclosed($dateclosed, $update = false) {$this->setField('dateclosed', $dateclosed, $update);}

    /**
     * Filter dateclosed
     * @param string $dateclosed
     * @param string $operation
     */
    public function filterDateclosed($dateclosed, $operation = false) {$this->filterField('dateclosed', $dateclosed, $operation);}

    /**
     * Get datedone
     * @return string
     */
    public function getDatedone() { return $this->getField('datedone');}

    /**
     * Set datedone
     * @param string $datedone
     */
    public function setDatedone($datedone, $update = false) {$this->setField('datedone', $datedone, $update);}

    /**
     * Filter datedone
     * @param string $datedone
     * @param string $operation
     */
    public function filterDatedone($datedone, $operation = false) {$this->filterField('datedone', $datedone, $operation);}

    /**
     * Get isshipped
     * @return int
     */
    public function getIsshipped() { return $this->getField('isshipped');}

    /**
     * Set isshipped
     * @param int $isshipped
     */
    public function setIsshipped($isshipped, $update = false) {$this->setField('isshipped', $isshipped, $update);}

    /**
     * Filter isshipped
     * @param int $isshipped
     * @param string $operation
     */
    public function filterIsshipped($isshipped, $operation = false) {$this->filterField('isshipped', $isshipped, $operation);}

    /**
     * Get sourceid
     * @return int
     */
    public function getSourceid() { return $this->getField('sourceid');}

    /**
     * Set sourceid
     * @param int $sourceid
     */
    public function setSourceid($sourceid, $update = false) {$this->setField('sourceid', $sourceid, $update);}

    /**
     * Filter sourceid
     * @param int $sourceid
     * @param string $operation
     */
    public function filterSourceid($sourceid, $operation = false) {$this->filterField('sourceid', $sourceid, $operation);}

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
     * Get parentstatusid
     * @return int
     */
    public function getParentstatusid() { return $this->getField('parentstatusid');}

    /**
     * Set parentstatusid
     * @param int $parentstatusid
     */
    public function setParentstatusid($parentstatusid, $update = false) {$this->setField('parentstatusid', $parentstatusid, $update);}

    /**
     * Filter parentstatusid
     * @param int $parentstatusid
     * @param string $operation
     */
    public function filterParentstatusid($parentstatusid, $operation = false) {$this->filterField('parentstatusid', $parentstatusid, $operation);}

    /**
     * Get resource
     * @return string
     */
    public function getResource() { return $this->getField('resource');}

    /**
     * Set resource
     * @param string $resource
     */
    public function setResource($resource, $update = false) {$this->setField('resource', $resource, $update);}

    /**
     * Filter resource
     * @param string $resource
     * @param string $operation
     */
    public function filterResource($resource, $operation = false) {$this->filterField('resource', $resource, $operation);}

    /**
     * Get estimate
     * @return float
     */
    public function getEstimate() { return $this->getField('estimate');}

    /**
     * Set estimate
     * @param float $estimate
     */
    public function setEstimate($estimate, $update = false) {$this->setField('estimate', $estimate, $update);}

    /**
     * Filter estimate
     * @param float $estimate
     * @param string $operation
     */
    public function filterEstimate($estimate, $operation = false) {$this->filterField('estimate', $estimate, $operation);}

    /**
     * Get money
     * @return float
     */
    public function getMoney() { return $this->getField('money');}

    /**
     * Set money
     * @param float $money
     */
    public function setMoney($money, $update = false) {$this->setField('money', $money, $update);}

    /**
     * Filter money
     * @param float $money
     * @param string $operation
     */
    public function filterMoney($money, $operation = false) {$this->filterField('money', $money, $operation);}

    /**
     * Get sumbase
     * @return float
     */
    public function getSumbase() { return $this->getField('sumbase');}

    /**
     * Set sumbase
     * @param float $sumbase
     */
    public function setSumbase($sumbase, $update = false) {$this->setField('sumbase', $sumbase, $update);}

    /**
     * Filter sumbase
     * @param float $sumbase
     * @param string $operation
     */
    public function filterSumbase($sumbase, $operation = false) {$this->filterField('sumbase', $sumbase, $operation);}

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
     * Get ip
     * @return string
     */
    public function getIp() { return $this->getField('ip');}

    /**
     * Set ip
     * @param string $ip
     */
    public function setIp($ip, $update = false) {$this->setField('ip', $ip, $update);}

    /**
     * Filter ip
     * @param string $ip
     * @param string $operation
     */
    public function filterIp($ip, $operation = false) {$this->filterField('ip', $ip, $operation);}

    /**
     * Get forgift
     * @return int
     */
    public function getForgift() { return $this->getField('forgift');}

    /**
     * Set forgift
     * @param int $forgift
     */
    public function setForgift($forgift, $update = false) {$this->setField('forgift', $forgift, $update);}

    /**
     * Filter forgift
     * @param int $forgift
     * @param string $operation
     */
    public function filterForgift($forgift, $operation = false) {$this->filterField('forgift', $forgift, $operation);}

    /**
     * Get nextid
     * @return int
     */
    public function getNextid() { return $this->getField('nextid');}

    /**
     * Set nextid
     * @param int $nextid
     */
    public function setNextid($nextid, $update = false) {$this->setField('nextid', $nextid, $update);}

    /**
     * Filter nextid
     * @param int $nextid
     * @param string $operation
     */
    public function filterNextid($nextid, $operation = false) {$this->filterField('nextid', $nextid, $operation);}

    /**
     * Get previd
     * @return int
     */
    public function getPrevid() { return $this->getField('previd');}

    /**
     * Set previd
     * @param int $previd
     */
    public function setPrevid($previd, $update = false) {$this->setField('previd', $previd, $update);}

    /**
     * Filter previd
     * @param int $previd
     * @param string $operation
     */
    public function filterPrevid($previd, $operation = false) {$this->filterField('previd', $previd, $operation);}

    /**
     * Get send_mail_comment
     * @return int
     */
    public function getSend_mail_comment() { return $this->getField('send_mail_comment');}

    /**
     * Set send_mail_comment
     * @param int $send_mail_comment
     */
    public function setSend_mail_comment($send_mail_comment, $update = false) {$this->setField('send_mail_comment', $send_mail_comment, $update);}

    /**
     * Filter send_mail_comment
     * @param int $send_mail_comment
     * @param string $operation
     */
    public function filterSend_mail_comment($send_mail_comment, $operation = false) {$this->filterField('send_mail_comment', $send_mail_comment, $operation);}

    /**
     * Get priority
     * @return int
     */
    public function getPriority() { return $this->getField('priority');}

    /**
     * Set priority
     * @param int $priority
     */
    public function setPriority($priority, $update = false) {$this->setField('priority', $priority, $update);}

    /**
     * Filter priority
     * @param int $priority
     * @param string $operation
     */
    public function filterPriority($priority, $operation = false) {$this->filterField('priority', $priority, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoporder');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrder
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrder
     */
    public static function Get($key) {return self::GetObject("XShopOrder", $key);}

}

SQLObject::SetFieldArray('shoporder', array('id', 'number', 'name', 'userid', 'clientmanagerid', 'managerid', 'authorid', 'cdate', 'udate', 'uuserid', 'datetoyear', 'datetomonth', 'datetoday', 'dateto', 'statusid', 'categoryid', 'clientname', 'clientemail', 'clientphone', 'clientaddress', 'clientcontacts', 'comments', 'sum', 'currencyid', 'deliveryid', 'deliveryprice', 'paymentid', 'discountid', 'discountsum', 'hash', 'contractorid', 'deliverynote', 'sumpaid', 'dateshipped', 'dateclosed', 'datedone', 'isshipped', 'sourceid', 'issue', 'outcoming', 'parentid', 'parentstatusid', 'resource', 'estimate', 'money', 'sumbase', 'linkkey', 'ip', 'forgift', 'nextid', 'previd', 'send_mail_comment', 'priority', 'type', 'code1c', 'deleted'));
SQLObject::SetPrimaryKey('shoporder', 'id');
