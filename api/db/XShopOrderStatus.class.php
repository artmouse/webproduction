<?php
/**
 * Class XShopOrderStatus is ORM to table shoporderstatus
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderStatus extends SQLObject {

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
     * Get message
     * @return string
     */
    public function getMessage() { return $this->getField('message');}

    /**
     * Set message
     * @param string $message
     */
    public function setMessage($message, $update = false) {$this->setField('message', $message, $update);}

    /**
     * Filter message
     * @param string $message
     * @param string $operation
     */
    public function filterMessage($message, $operation = false) {$this->filterField('message', $message, $operation);}

    /**
     * Get messageadmin
     * @return string
     */
    public function getMessageadmin() { return $this->getField('messageadmin');}

    /**
     * Set messageadmin
     * @param string $messageadmin
     */
    public function setMessageadmin($messageadmin, $update = false) {$this->setField('messageadmin', $messageadmin, $update);}

    /**
     * Filter messageadmin
     * @param string $messageadmin
     * @param string $operation
     */
    public function filterMessageadmin($messageadmin, $operation = false) {$this->filterField('messageadmin', $messageadmin, $operation);}

    /**
     * Get sms
     * @return string
     */
    public function getSms() { return $this->getField('sms');}

    /**
     * Set sms
     * @param string $sms
     */
    public function setSms($sms, $update = false) {$this->setField('sms', $sms, $update);}

    /**
     * Filter sms
     * @param string $sms
     * @param string $operation
     */
    public function filterSms($sms, $operation = false) {$this->filterField('sms', $sms, $operation);}

    /**
     * Get smsadmin
     * @return string
     */
    public function getSmsadmin() { return $this->getField('smsadmin');}

    /**
     * Set smsadmin
     * @param string $smsadmin
     */
    public function setSmsadmin($smsadmin, $update = false) {$this->setField('smsadmin', $smsadmin, $update);}

    /**
     * Filter smsadmin
     * @param string $smsadmin
     * @param string $operation
     */
    public function filterSmsadmin($smsadmin, $operation = false) {$this->filterField('smsadmin', $smsadmin, $operation);}

    /**
     * Get smslogicclass
     * @return string
     */
    public function getSmslogicclass() { return $this->getField('smslogicclass');}

    /**
     * Set smslogicclass
     * @param string $smslogicclass
     */
    public function setSmslogicclass($smslogicclass, $update = false) {$this->setField('smslogicclass', $smslogicclass, $update);}

    /**
     * Filter smslogicclass
     * @param string $smslogicclass
     * @param string $operation
     */
    public function filterSmslogicclass($smslogicclass, $operation = false) {$this->filterField('smslogicclass', $smslogicclass, $operation);}

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
     * Get payed
     * @return int
     */
    public function getPayed() { return $this->getField('payed');}

    /**
     * Set payed
     * @param int $payed
     */
    public function setPayed($payed, $update = false) {$this->setField('payed', $payed, $update);}

    /**
     * Filter payed
     * @param int $payed
     * @param string $operation
     */
    public function filterPayed($payed, $operation = false) {$this->filterField('payed', $payed, $operation);}

    /**
     * Get saled
     * @return int
     */
    public function getSaled() { return $this->getField('saled');}

    /**
     * Set saled
     * @param int $saled
     */
    public function setSaled($saled, $update = false) {$this->setField('saled', $saled, $update);}

    /**
     * Filter saled
     * @param int $saled
     * @param string $operation
     */
    public function filterSaled($saled, $operation = false) {$this->filterField('saled', $saled, $operation);}

    /**
     * Get downloadable
     * @return int
     */
    public function getDownloadable() { return $this->getField('downloadable');}

    /**
     * Set downloadable
     * @param int $downloadable
     */
    public function setDownloadable($downloadable, $update = false) {$this->setField('downloadable', $downloadable, $update);}

    /**
     * Filter downloadable
     * @param int $downloadable
     * @param string $operation
     */
    public function filterDownloadable($downloadable, $operation = false) {$this->filterField('downloadable', $downloadable, $operation);}

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
     * Get content
     * @return string
     */
    public function getContent() { return $this->getField('content');}

    /**
     * Set content
     * @param string $content
     */
    public function setContent($content, $update = false) {$this->setField('content', $content, $update);}

    /**
     * Filter content
     * @param string $content
     * @param string $operation
     */
    public function filterContent($content, $operation = false) {$this->filterField('content', $content, $operation);}

    /**
     * Get x
     * @return int
     */
    public function getX() { return $this->getField('x');}

    /**
     * Set x
     * @param int $x
     */
    public function setX($x, $update = false) {$this->setField('x', $x, $update);}

    /**
     * Filter x
     * @param int $x
     * @param string $operation
     */
    public function filterX($x, $operation = false) {$this->filterField('x', $x, $operation);}

    /**
     * Get y
     * @return int
     */
    public function getY() { return $this->getField('y');}

    /**
     * Set y
     * @param int $y
     */
    public function setY($y, $update = false) {$this->setField('y', $y, $update);}

    /**
     * Filter y
     * @param int $y
     * @param string $operation
     */
    public function filterY($y, $operation = false) {$this->filterField('y', $y, $operation);}

    /**
     * Get width
     * @return int
     */
    public function getWidth() { return $this->getField('width');}

    /**
     * Set width
     * @param int $width
     */
    public function setWidth($width, $update = false) {$this->setField('width', $width, $update);}

    /**
     * Filter width
     * @param int $width
     * @param string $operation
     */
    public function filterWidth($width, $operation = false) {$this->filterField('width', $width, $operation);}

    /**
     * Get height
     * @return int
     */
    public function getHeight() { return $this->getField('height');}

    /**
     * Set height
     * @param int $height
     */
    public function setHeight($height, $update = false) {$this->setField('height', $height, $update);}

    /**
     * Filter height
     * @param int $height
     * @param string $operation
     */
    public function filterHeight($height, $operation = false) {$this->filterField('height', $height, $operation);}

    /**
     * Get colour
     * @return string
     */
    public function getColour() { return $this->getField('colour');}

    /**
     * Set colour
     * @param string $colour
     */
    public function setColour($colour, $update = false) {$this->setField('colour', $colour, $update);}

    /**
     * Filter colour
     * @param string $colour
     * @param string $operation
     */
    public function filterColour($colour, $operation = false) {$this->filterField('colour', $colour, $operation);}

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
     * Get termperiod
     * @return string
     */
    public function getTermperiod() { return $this->getField('termperiod');}

    /**
     * Set termperiod
     * @param string $termperiod
     */
    public function setTermperiod($termperiod, $update = false) {$this->setField('termperiod', $termperiod, $update);}

    /**
     * Filter termperiod
     * @param string $termperiod
     * @param string $operation
     */
    public function filterTermperiod($termperiod, $operation = false) {$this->filterField('termperiod', $termperiod, $operation);}

    /**
     * Get processor
     * @return string
     */
    public function getProcessor() { return $this->getField('processor');}

    /**
     * Set processor
     * @param string $processor
     */
    public function setProcessor($processor, $update = false) {$this->setField('processor', $processor, $update);}

    /**
     * Filter processor
     * @param string $processor
     * @param string $operation
     */
    public function filterProcessor($processor, $operation = false) {$this->filterField('processor', $processor, $operation);}

    /**
     * Get processorform
     * @return string
     */
    public function getProcessorform() { return $this->getField('processorform');}

    /**
     * Set processorform
     * @param string $processorform
     */
    public function setProcessorform($processorform, $update = false) {$this->setField('processorform', $processorform, $update);}

    /**
     * Filter processorform
     * @param string $processorform
     * @param string $operation
     */
    public function filterProcessorform($processorform, $operation = false) {$this->filterField('processorform', $processorform, $operation);}

    /**
     * Get roleid
     * @return int
     */
    public function getRoleid() { return $this->getField('roleid');}

    /**
     * Set roleid
     * @param int $roleid
     */
    public function setRoleid($roleid, $update = false) {$this->setField('roleid', $roleid, $update);}

    /**
     * Filter roleid
     * @param int $roleid
     * @param string $operation
     */
    public function filterRoleid($roleid, $operation = false) {$this->filterField('roleid', $roleid, $operation);}

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
     * Get cnt
     * @return int
     */
    public function getCnt() { return $this->getField('cnt');}

    /**
     * Set cnt
     * @param int $cnt
     */
    public function setCnt($cnt, $update = false) {$this->setField('cnt', $cnt, $update);}

    /**
     * Filter cnt
     * @param int $cnt
     * @param string $operation
     */
    public function filterCnt($cnt, $operation = false) {$this->filterField('cnt', $cnt, $operation);}

    /**
     * Get cntlast
     * @return int
     */
    public function getCntlast() { return $this->getField('cntlast');}

    /**
     * Set cntlast
     * @param int $cntlast
     */
    public function setCntlast($cntlast, $update = false) {$this->setField('cntlast', $cntlast, $update);}

    /**
     * Filter cntlast
     * @param int $cntlast
     * @param string $operation
     */
    public function filterCntlast($cntlast, $operation = false) {$this->filterField('cntlast', $cntlast, $operation);}

    /**
     * Get onlyauto
     * @return int
     */
    public function getOnlyauto() { return $this->getField('onlyauto');}

    /**
     * Set onlyauto
     * @param int $onlyauto
     */
    public function setOnlyauto($onlyauto, $update = false) {$this->setField('onlyauto', $onlyauto, $update);}

    /**
     * Filter onlyauto
     * @param int $onlyauto
     * @param string $operation
     */
    public function filterOnlyauto($onlyauto, $operation = false) {$this->filterField('onlyauto', $onlyauto, $operation);}

    /**
     * Get onlyissue
     * @return int
     */
    public function getOnlyissue() { return $this->getField('onlyissue');}

    /**
     * Set onlyissue
     * @param int $onlyissue
     */
    public function setOnlyissue($onlyissue, $update = false) {$this->setField('onlyissue', $onlyissue, $update);}

    /**
     * Filter onlyissue
     * @param int $onlyissue
     * @param string $operation
     */
    public function filterOnlyissue($onlyissue, $operation = false) {$this->filterField('onlyissue', $onlyissue, $operation);}

    /**
     * Get jumpmanager
     * @return int
     */
    public function getJumpmanager() { return $this->getField('jumpmanager');}

    /**
     * Set jumpmanager
     * @param int $jumpmanager
     */
    public function setJumpmanager($jumpmanager, $update = false) {$this->setField('jumpmanager', $jumpmanager, $update);}

    /**
     * Filter jumpmanager
     * @param int $jumpmanager
     * @param string $operation
     */
    public function filterJumpmanager($jumpmanager, $operation = false) {$this->filterField('jumpmanager', $jumpmanager, $operation);}

    /**
     * Get prepayed
     * @return int
     */
    public function getPrepayed() { return $this->getField('prepayed');}

    /**
     * Set prepayed
     * @param int $prepayed
     */
    public function setPrepayed($prepayed, $update = false) {$this->setField('prepayed', $prepayed, $update);}

    /**
     * Filter prepayed
     * @param int $prepayed
     * @param string $operation
     */
    public function filterPrepayed($prepayed, $operation = false) {$this->filterField('prepayed', $prepayed, $operation);}

    /**
     * Get notifysmsclient
     * @return int
     */
    public function getNotifysmsclient() { return $this->getField('notifysmsclient');}

    /**
     * Set notifysmsclient
     * @param int $notifysmsclient
     */
    public function setNotifysmsclient($notifysmsclient, $update = false) {$this->setField('notifysmsclient', $notifysmsclient, $update);}

    /**
     * Filter notifysmsclient
     * @param int $notifysmsclient
     * @param string $operation
     */
    public function filterNotifysmsclient($notifysmsclient, $operation = false) {$this->filterField('notifysmsclient', $notifysmsclient, $operation);}

    /**
     * Get notifysmsadmin
     * @return int
     */
    public function getNotifysmsadmin() { return $this->getField('notifysmsadmin');}

    /**
     * Set notifysmsadmin
     * @param int $notifysmsadmin
     */
    public function setNotifysmsadmin($notifysmsadmin, $update = false) {$this->setField('notifysmsadmin', $notifysmsadmin, $update);}

    /**
     * Filter notifysmsadmin
     * @param int $notifysmsadmin
     * @param string $operation
     */
    public function filterNotifysmsadmin($notifysmsadmin, $operation = false) {$this->filterField('notifysmsadmin', $notifysmsadmin, $operation);}

    /**
     * Get notifysmsmanager
     * @return int
     */
    public function getNotifysmsmanager() { return $this->getField('notifysmsmanager');}

    /**
     * Set notifysmsmanager
     * @param int $notifysmsmanager
     */
    public function setNotifysmsmanager($notifysmsmanager, $update = false) {$this->setField('notifysmsmanager', $notifysmsmanager, $update);}

    /**
     * Filter notifysmsmanager
     * @param int $notifysmsmanager
     * @param string $operation
     */
    public function filterNotifysmsmanager($notifysmsmanager, $operation = false) {$this->filterField('notifysmsmanager', $notifysmsmanager, $operation);}

    /**
     * Get notifyemailclient
     * @return int
     */
    public function getNotifyemailclient() { return $this->getField('notifyemailclient');}

    /**
     * Set notifyemailclient
     * @param int $notifyemailclient
     */
    public function setNotifyemailclient($notifyemailclient, $update = false) {$this->setField('notifyemailclient', $notifyemailclient, $update);}

    /**
     * Filter notifyemailclient
     * @param int $notifyemailclient
     * @param string $operation
     */
    public function filterNotifyemailclient($notifyemailclient, $operation = false) {$this->filterField('notifyemailclient', $notifyemailclient, $operation);}

    /**
     * Get notifyemailadmin
     * @return int
     */
    public function getNotifyemailadmin() { return $this->getField('notifyemailadmin');}

    /**
     * Set notifyemailadmin
     * @param int $notifyemailadmin
     */
    public function setNotifyemailadmin($notifyemailadmin, $update = false) {$this->setField('notifyemailadmin', $notifyemailadmin, $update);}

    /**
     * Filter notifyemailadmin
     * @param int $notifyemailadmin
     * @param string $operation
     */
    public function filterNotifyemailadmin($notifyemailadmin, $operation = false) {$this->filterField('notifyemailadmin', $notifyemailadmin, $operation);}

    /**
     * Get notifyemailmanager
     * @return int
     */
    public function getNotifyemailmanager() { return $this->getField('notifyemailmanager');}

    /**
     * Set notifyemailmanager
     * @param int $notifyemailmanager
     */
    public function setNotifyemailmanager($notifyemailmanager, $update = false) {$this->setField('notifyemailmanager', $notifyemailmanager, $update);}

    /**
     * Filter notifyemailmanager
     * @param int $notifyemailmanager
     * @param string $operation
     */
    public function filterNotifyemailmanager($notifyemailmanager, $operation = false) {$this->filterField('notifyemailmanager', $notifyemailmanager, $operation);}

    /**
     * Get needcontent
     * @return int
     */
    public function getNeedcontent() { return $this->getField('needcontent');}

    /**
     * Set needcontent
     * @param int $needcontent
     */
    public function setNeedcontent($needcontent, $update = false) {$this->setField('needcontent', $needcontent, $update);}

    /**
     * Filter needcontent
     * @param int $needcontent
     * @param string $operation
     */
    public function filterNeedcontent($needcontent, $operation = false) {$this->filterField('needcontent', $needcontent, $operation);}

    /**
     * Get needdocument
     * @return int
     */
    public function getNeeddocument() { return $this->getField('needdocument');}

    /**
     * Set needdocument
     * @param int $needdocument
     */
    public function setNeeddocument($needdocument, $update = false) {$this->setField('needdocument', $needdocument, $update);}

    /**
     * Filter needdocument
     * @param int $needdocument
     * @param string $operation
     */
    public function filterNeeddocument($needdocument, $operation = false) {$this->filterField('needdocument', $needdocument, $operation);}

    /**
     * Get closed
     * @return int
     */
    public function getClosed() { return $this->getField('closed');}

    /**
     * Set closed
     * @param int $closed
     */
    public function setClosed($closed, $update = false) {$this->setField('closed', $closed, $update);}

    /**
     * Filter closed
     * @param int $closed
     * @param string $operation
     */
    public function filterClosed($closed, $operation = false) {$this->filterField('closed', $closed, $operation);}

    /**
     * Get done
     * @return int
     */
    public function getDone() { return $this->getField('done');}

    /**
     * Set done
     * @param int $done
     */
    public function setDone($done, $update = false) {$this->setField('done', $done, $update);}

    /**
     * Filter done
     * @param int $done
     * @param string $operation
     */
    public function filterDone($done, $operation = false) {$this->filterField('done', $done, $operation);}

    /**
     * Get shipped
     * @return int
     */
    public function getShipped() { return $this->getField('shipped');}

    /**
     * Set shipped
     * @param int $shipped
     */
    public function setShipped($shipped, $update = false) {$this->setField('shipped', $shipped, $update);}

    /**
     * Filter shipped
     * @param int $shipped
     * @param string $operation
     */
    public function filterShipped($shipped, $operation = false) {$this->filterField('shipped', $shipped, $operation);}

    /**
     * Get cancelOrderSupplier
     * @return int
     */
    public function getCancelOrderSupplier() { return $this->getField('cancelOrderSupplier');}

    /**
     * Set cancelOrderSupplier
     * @param int $cancelOrderSupplier
     */
    public function setCancelOrderSupplier($cancelOrderSupplier, $update = false) {$this->setField('cancelOrderSupplier', $cancelOrderSupplier, $update);}

    /**
     * Filter cancelOrderSupplier
     * @param int $cancelOrderSupplier
     * @param string $operation
     */
    public function filterCancelOrderSupplier($cancelOrderSupplier, $operation = false) {$this->filterField('cancelOrderSupplier', $cancelOrderSupplier, $operation);}

    /**
     * Get createOrderSupplier
     * @return int
     */
    public function getCreateOrderSupplier() { return $this->getField('createOrderSupplier');}

    /**
     * Set createOrderSupplier
     * @param int $createOrderSupplier
     */
    public function setCreateOrderSupplier($createOrderSupplier, $update = false) {$this->setField('createOrderSupplier', $createOrderSupplier, $update);}

    /**
     * Filter createOrderSupplier
     * @param int $createOrderSupplier
     * @param string $operation
     */
    public function filterCreateOrderSupplier($createOrderSupplier, $operation = false) {$this->filterField('createOrderSupplier', $createOrderSupplier, $operation);}

    /**
     * Get createXml
     * @return int
     */
    public function getCreateXml() { return $this->getField('createXml');}

    /**
     * Set createXml
     * @param int $createXml
     */
    public function setCreateXml($createXml, $update = false) {$this->setField('createXml', $createXml, $update);}

    /**
     * Filter createXml
     * @param int $createXml
     * @param string $operation
     */
    public function filterCreateXml($createXml, $operation = false) {$this->filterField('createXml', $createXml, $operation);}

    /**
     * Get createCsv
     * @return int
     */
    public function getCreateCsv() { return $this->getField('createCsv');}

    /**
     * Set createCsv
     * @param int $createCsv
     */
    public function setCreateCsv($createCsv, $update = false) {$this->setField('createCsv', $createCsv, $update);}

    /**
     * Filter createCsv
     * @param int $createCsv
     * @param string $operation
     */
    public function filterCreateCsv($createCsv, $operation = false) {$this->filterField('createCsv', $createCsv, $operation);}

    /**
     * Get autorepeat
     * @return int
     */
    public function getAutorepeat() { return $this->getField('autorepeat');}

    /**
     * Set autorepeat
     * @param int $autorepeat
     */
    public function setAutorepeat($autorepeat, $update = false) {$this->setField('autorepeat', $autorepeat, $update);}

    /**
     * Filter autorepeat
     * @param int $autorepeat
     * @param string $operation
     */
    public function filterAutorepeat($autorepeat, $operation = false) {$this->filterField('autorepeat', $autorepeat, $operation);}

    /**
     * Get nextworkflowid
     * @return int
     */
    public function getNextworkflowid() { return $this->getField('nextworkflowid');}

    /**
     * Set nextworkflowid
     * @param int $nextworkflowid
     */
    public function setNextworkflowid($nextworkflowid, $update = false) {$this->setField('nextworkflowid', $nextworkflowid, $update);}

    /**
     * Filter nextworkflowid
     * @param int $nextworkflowid
     * @param string $operation
     */
    public function filterNextworkflowid($nextworkflowid, $operation = false) {$this->filterField('nextworkflowid', $nextworkflowid, $operation);}

    /**
     * Get nextstatusid
     * @return int
     */
    public function getNextstatusid() { return $this->getField('nextstatusid');}

    /**
     * Set nextstatusid
     * @param int $nextstatusid
     */
    public function setNextstatusid($nextstatusid, $update = false) {$this->setField('nextstatusid', $nextstatusid, $update);}

    /**
     * Filter nextstatusid
     * @param int $nextstatusid
     * @param string $operation
     */
    public function filterNextstatusid($nextstatusid, $operation = false) {$this->filterField('nextstatusid', $nextstatusid, $operation);}

    /**
     * Get subworkflow1
     * @return int
     */
    public function getSubworkflow1() { return $this->getField('subworkflow1');}

    /**
     * Set subworkflow1
     * @param int $subworkflow1
     */
    public function setSubworkflow1($subworkflow1, $update = false) {$this->setField('subworkflow1', $subworkflow1, $update);}

    /**
     * Filter subworkflow1
     * @param int $subworkflow1
     * @param string $operation
     */
    public function filterSubworkflow1($subworkflow1, $operation = false) {$this->filterField('subworkflow1', $subworkflow1, $operation);}

    /**
     * Get subworkflow1name
     * @return string
     */
    public function getSubworkflow1name() { return $this->getField('subworkflow1name');}

    /**
     * Set subworkflow1name
     * @param string $subworkflow1name
     */
    public function setSubworkflow1name($subworkflow1name, $update = false) {$this->setField('subworkflow1name', $subworkflow1name, $update);}

    /**
     * Filter subworkflow1name
     * @param string $subworkflow1name
     * @param string $operation
     */
    public function filterSubworkflow1name($subworkflow1name, $operation = false) {$this->filterField('subworkflow1name', $subworkflow1name, $operation);}

    /**
     * Get subworkflow1date
     * @return int
     */
    public function getSubworkflow1date() { return $this->getField('subworkflow1date');}

    /**
     * Set subworkflow1date
     * @param int $subworkflow1date
     */
    public function setSubworkflow1date($subworkflow1date, $update = false) {$this->setField('subworkflow1date', $subworkflow1date, $update);}

    /**
     * Filter subworkflow1date
     * @param int $subworkflow1date
     * @param string $operation
     */
    public function filterSubworkflow1date($subworkflow1date, $operation = false) {$this->filterField('subworkflow1date', $subworkflow1date, $operation);}

    /**
     * Get subworkflow1description
     * @return string
     */
    public function getSubworkflow1description() { return $this->getField('subworkflow1description');}

    /**
     * Set subworkflow1description
     * @param string $subworkflow1description
     */
    public function setSubworkflow1description($subworkflow1description, $update = false) {$this->setField('subworkflow1description', $subworkflow1description, $update);}

    /**
     * Filter subworkflow1description
     * @param string $subworkflow1description
     * @param string $operation
     */
    public function filterSubworkflow1description($subworkflow1description, $operation = false) {$this->filterField('subworkflow1description', $subworkflow1description, $operation);}

    /**
     * Get subworkflow2
     * @return int
     */
    public function getSubworkflow2() { return $this->getField('subworkflow2');}

    /**
     * Set subworkflow2
     * @param int $subworkflow2
     */
    public function setSubworkflow2($subworkflow2, $update = false) {$this->setField('subworkflow2', $subworkflow2, $update);}

    /**
     * Filter subworkflow2
     * @param int $subworkflow2
     * @param string $operation
     */
    public function filterSubworkflow2($subworkflow2, $operation = false) {$this->filterField('subworkflow2', $subworkflow2, $operation);}

    /**
     * Get subworkflow2name
     * @return string
     */
    public function getSubworkflow2name() { return $this->getField('subworkflow2name');}

    /**
     * Set subworkflow2name
     * @param string $subworkflow2name
     */
    public function setSubworkflow2name($subworkflow2name, $update = false) {$this->setField('subworkflow2name', $subworkflow2name, $update);}

    /**
     * Filter subworkflow2name
     * @param string $subworkflow2name
     * @param string $operation
     */
    public function filterSubworkflow2name($subworkflow2name, $operation = false) {$this->filterField('subworkflow2name', $subworkflow2name, $operation);}

    /**
     * Get subworkflow2date
     * @return int
     */
    public function getSubworkflow2date() { return $this->getField('subworkflow2date');}

    /**
     * Set subworkflow2date
     * @param int $subworkflow2date
     */
    public function setSubworkflow2date($subworkflow2date, $update = false) {$this->setField('subworkflow2date', $subworkflow2date, $update);}

    /**
     * Filter subworkflow2date
     * @param int $subworkflow2date
     * @param string $operation
     */
    public function filterSubworkflow2date($subworkflow2date, $operation = false) {$this->filterField('subworkflow2date', $subworkflow2date, $operation);}

    /**
     * Get subworkflow2description
     * @return string
     */
    public function getSubworkflow2description() { return $this->getField('subworkflow2description');}

    /**
     * Set subworkflow2description
     * @param string $subworkflow2description
     */
    public function setSubworkflow2description($subworkflow2description, $update = false) {$this->setField('subworkflow2description', $subworkflow2description, $update);}

    /**
     * Filter subworkflow2description
     * @param string $subworkflow2description
     * @param string $operation
     */
    public function filterSubworkflow2description($subworkflow2description, $operation = false) {$this->filterField('subworkflow2description', $subworkflow2description, $operation);}

    /**
     * Get subworkflow3
     * @return int
     */
    public function getSubworkflow3() { return $this->getField('subworkflow3');}

    /**
     * Set subworkflow3
     * @param int $subworkflow3
     */
    public function setSubworkflow3($subworkflow3, $update = false) {$this->setField('subworkflow3', $subworkflow3, $update);}

    /**
     * Filter subworkflow3
     * @param int $subworkflow3
     * @param string $operation
     */
    public function filterSubworkflow3($subworkflow3, $operation = false) {$this->filterField('subworkflow3', $subworkflow3, $operation);}

    /**
     * Get subworkflow3name
     * @return string
     */
    public function getSubworkflow3name() { return $this->getField('subworkflow3name');}

    /**
     * Set subworkflow3name
     * @param string $subworkflow3name
     */
    public function setSubworkflow3name($subworkflow3name, $update = false) {$this->setField('subworkflow3name', $subworkflow3name, $update);}

    /**
     * Filter subworkflow3name
     * @param string $subworkflow3name
     * @param string $operation
     */
    public function filterSubworkflow3name($subworkflow3name, $operation = false) {$this->filterField('subworkflow3name', $subworkflow3name, $operation);}

    /**
     * Get subworkflow3date
     * @return int
     */
    public function getSubworkflow3date() { return $this->getField('subworkflow3date');}

    /**
     * Set subworkflow3date
     * @param int $subworkflow3date
     */
    public function setSubworkflow3date($subworkflow3date, $update = false) {$this->setField('subworkflow3date', $subworkflow3date, $update);}

    /**
     * Filter subworkflow3date
     * @param int $subworkflow3date
     * @param string $operation
     */
    public function filterSubworkflow3date($subworkflow3date, $operation = false) {$this->filterField('subworkflow3date', $subworkflow3date, $operation);}

    /**
     * Get subworkflow3description
     * @return string
     */
    public function getSubworkflow3description() { return $this->getField('subworkflow3description');}

    /**
     * Set subworkflow3description
     * @param string $subworkflow3description
     */
    public function setSubworkflow3description($subworkflow3description, $update = false) {$this->setField('subworkflow3description', $subworkflow3description, $update);}

    /**
     * Filter subworkflow3description
     * @param string $subworkflow3description
     * @param string $operation
     */
    public function filterSubworkflow3description($subworkflow3description, $operation = false) {$this->filterField('subworkflow3description', $subworkflow3description, $operation);}

    /**
     * Get subworkflow4
     * @return int
     */
    public function getSubworkflow4() { return $this->getField('subworkflow4');}

    /**
     * Set subworkflow4
     * @param int $subworkflow4
     */
    public function setSubworkflow4($subworkflow4, $update = false) {$this->setField('subworkflow4', $subworkflow4, $update);}

    /**
     * Filter subworkflow4
     * @param int $subworkflow4
     * @param string $operation
     */
    public function filterSubworkflow4($subworkflow4, $operation = false) {$this->filterField('subworkflow4', $subworkflow4, $operation);}

    /**
     * Get subworkflow4name
     * @return string
     */
    public function getSubworkflow4name() { return $this->getField('subworkflow4name');}

    /**
     * Set subworkflow4name
     * @param string $subworkflow4name
     */
    public function setSubworkflow4name($subworkflow4name, $update = false) {$this->setField('subworkflow4name', $subworkflow4name, $update);}

    /**
     * Filter subworkflow4name
     * @param string $subworkflow4name
     * @param string $operation
     */
    public function filterSubworkflow4name($subworkflow4name, $operation = false) {$this->filterField('subworkflow4name', $subworkflow4name, $operation);}

    /**
     * Get subworkflow4date
     * @return int
     */
    public function getSubworkflow4date() { return $this->getField('subworkflow4date');}

    /**
     * Set subworkflow4date
     * @param int $subworkflow4date
     */
    public function setSubworkflow4date($subworkflow4date, $update = false) {$this->setField('subworkflow4date', $subworkflow4date, $update);}

    /**
     * Filter subworkflow4date
     * @param int $subworkflow4date
     * @param string $operation
     */
    public function filterSubworkflow4date($subworkflow4date, $operation = false) {$this->filterField('subworkflow4date', $subworkflow4date, $operation);}

    /**
     * Get subworkflow4description
     * @return string
     */
    public function getSubworkflow4description() { return $this->getField('subworkflow4description');}

    /**
     * Set subworkflow4description
     * @param string $subworkflow4description
     */
    public function setSubworkflow4description($subworkflow4description, $update = false) {$this->setField('subworkflow4description', $subworkflow4description, $update);}

    /**
     * Filter subworkflow4description
     * @param string $subworkflow4description
     * @param string $operation
     */
    public function filterSubworkflow4description($subworkflow4description, $operation = false) {$this->filterField('subworkflow4description', $subworkflow4description, $operation);}

    /**
     * Get subworkflow5
     * @return int
     */
    public function getSubworkflow5() { return $this->getField('subworkflow5');}

    /**
     * Set subworkflow5
     * @param int $subworkflow5
     */
    public function setSubworkflow5($subworkflow5, $update = false) {$this->setField('subworkflow5', $subworkflow5, $update);}

    /**
     * Filter subworkflow5
     * @param int $subworkflow5
     * @param string $operation
     */
    public function filterSubworkflow5($subworkflow5, $operation = false) {$this->filterField('subworkflow5', $subworkflow5, $operation);}

    /**
     * Get subworkflow5name
     * @return string
     */
    public function getSubworkflow5name() { return $this->getField('subworkflow5name');}

    /**
     * Set subworkflow5name
     * @param string $subworkflow5name
     */
    public function setSubworkflow5name($subworkflow5name, $update = false) {$this->setField('subworkflow5name', $subworkflow5name, $update);}

    /**
     * Filter subworkflow5name
     * @param string $subworkflow5name
     * @param string $operation
     */
    public function filterSubworkflow5name($subworkflow5name, $operation = false) {$this->filterField('subworkflow5name', $subworkflow5name, $operation);}

    /**
     * Get subworkflow5date
     * @return int
     */
    public function getSubworkflow5date() { return $this->getField('subworkflow5date');}

    /**
     * Set subworkflow5date
     * @param int $subworkflow5date
     */
    public function setSubworkflow5date($subworkflow5date, $update = false) {$this->setField('subworkflow5date', $subworkflow5date, $update);}

    /**
     * Filter subworkflow5date
     * @param int $subworkflow5date
     * @param string $operation
     */
    public function filterSubworkflow5date($subworkflow5date, $operation = false) {$this->filterField('subworkflow5date', $subworkflow5date, $operation);}

    /**
     * Get subworkflow5description
     * @return string
     */
    public function getSubworkflow5description() { return $this->getField('subworkflow5description');}

    /**
     * Set subworkflow5description
     * @param string $subworkflow5description
     */
    public function setSubworkflow5description($subworkflow5description, $update = false) {$this->setField('subworkflow5description', $subworkflow5description, $update);}

    /**
     * Filter subworkflow5description
     * @param string $subworkflow5description
     * @param string $operation
     */
    public function filterSubworkflow5description($subworkflow5description, $operation = false) {$this->filterField('subworkflow5description', $subworkflow5description, $operation);}

    /**
     * Get subworkflow6
     * @return int
     */
    public function getSubworkflow6() { return $this->getField('subworkflow6');}

    /**
     * Set subworkflow6
     * @param int $subworkflow6
     */
    public function setSubworkflow6($subworkflow6, $update = false) {$this->setField('subworkflow6', $subworkflow6, $update);}

    /**
     * Filter subworkflow6
     * @param int $subworkflow6
     * @param string $operation
     */
    public function filterSubworkflow6($subworkflow6, $operation = false) {$this->filterField('subworkflow6', $subworkflow6, $operation);}

    /**
     * Get subworkflow6name
     * @return string
     */
    public function getSubworkflow6name() { return $this->getField('subworkflow6name');}

    /**
     * Set subworkflow6name
     * @param string $subworkflow6name
     */
    public function setSubworkflow6name($subworkflow6name, $update = false) {$this->setField('subworkflow6name', $subworkflow6name, $update);}

    /**
     * Filter subworkflow6name
     * @param string $subworkflow6name
     * @param string $operation
     */
    public function filterSubworkflow6name($subworkflow6name, $operation = false) {$this->filterField('subworkflow6name', $subworkflow6name, $operation);}

    /**
     * Get subworkflow6date
     * @return int
     */
    public function getSubworkflow6date() { return $this->getField('subworkflow6date');}

    /**
     * Set subworkflow6date
     * @param int $subworkflow6date
     */
    public function setSubworkflow6date($subworkflow6date, $update = false) {$this->setField('subworkflow6date', $subworkflow6date, $update);}

    /**
     * Filter subworkflow6date
     * @param int $subworkflow6date
     * @param string $operation
     */
    public function filterSubworkflow6date($subworkflow6date, $operation = false) {$this->filterField('subworkflow6date', $subworkflow6date, $operation);}

    /**
     * Get subworkflow6description
     * @return string
     */
    public function getSubworkflow6description() { return $this->getField('subworkflow6description');}

    /**
     * Set subworkflow6description
     * @param string $subworkflow6description
     */
    public function setSubworkflow6description($subworkflow6description, $update = false) {$this->setField('subworkflow6description', $subworkflow6description, $update);}

    /**
     * Filter subworkflow6description
     * @param string $subworkflow6description
     * @param string $operation
     */
    public function filterSubworkflow6description($subworkflow6description, $operation = false) {$this->filterField('subworkflow6description', $subworkflow6description, $operation);}

    /**
     * Get subworkflow7
     * @return int
     */
    public function getSubworkflow7() { return $this->getField('subworkflow7');}

    /**
     * Set subworkflow7
     * @param int $subworkflow7
     */
    public function setSubworkflow7($subworkflow7, $update = false) {$this->setField('subworkflow7', $subworkflow7, $update);}

    /**
     * Filter subworkflow7
     * @param int $subworkflow7
     * @param string $operation
     */
    public function filterSubworkflow7($subworkflow7, $operation = false) {$this->filterField('subworkflow7', $subworkflow7, $operation);}

    /**
     * Get subworkflow7name
     * @return string
     */
    public function getSubworkflow7name() { return $this->getField('subworkflow7name');}

    /**
     * Set subworkflow7name
     * @param string $subworkflow7name
     */
    public function setSubworkflow7name($subworkflow7name, $update = false) {$this->setField('subworkflow7name', $subworkflow7name, $update);}

    /**
     * Filter subworkflow7name
     * @param string $subworkflow7name
     * @param string $operation
     */
    public function filterSubworkflow7name($subworkflow7name, $operation = false) {$this->filterField('subworkflow7name', $subworkflow7name, $operation);}

    /**
     * Get subworkflow7date
     * @return int
     */
    public function getSubworkflow7date() { return $this->getField('subworkflow7date');}

    /**
     * Set subworkflow7date
     * @param int $subworkflow7date
     */
    public function setSubworkflow7date($subworkflow7date, $update = false) {$this->setField('subworkflow7date', $subworkflow7date, $update);}

    /**
     * Filter subworkflow7date
     * @param int $subworkflow7date
     * @param string $operation
     */
    public function filterSubworkflow7date($subworkflow7date, $operation = false) {$this->filterField('subworkflow7date', $subworkflow7date, $operation);}

    /**
     * Get subworkflow7description
     * @return string
     */
    public function getSubworkflow7description() { return $this->getField('subworkflow7description');}

    /**
     * Set subworkflow7description
     * @param string $subworkflow7description
     */
    public function setSubworkflow7description($subworkflow7description, $update = false) {$this->setField('subworkflow7description', $subworkflow7description, $update);}

    /**
     * Filter subworkflow7description
     * @param string $subworkflow7description
     * @param string $operation
     */
    public function filterSubworkflow7description($subworkflow7description, $operation = false) {$this->filterField('subworkflow7description', $subworkflow7description, $operation);}

    /**
     * Get subworkflow8
     * @return int
     */
    public function getSubworkflow8() { return $this->getField('subworkflow8');}

    /**
     * Set subworkflow8
     * @param int $subworkflow8
     */
    public function setSubworkflow8($subworkflow8, $update = false) {$this->setField('subworkflow8', $subworkflow8, $update);}

    /**
     * Filter subworkflow8
     * @param int $subworkflow8
     * @param string $operation
     */
    public function filterSubworkflow8($subworkflow8, $operation = false) {$this->filterField('subworkflow8', $subworkflow8, $operation);}

    /**
     * Get subworkflow8name
     * @return string
     */
    public function getSubworkflow8name() { return $this->getField('subworkflow8name');}

    /**
     * Set subworkflow8name
     * @param string $subworkflow8name
     */
    public function setSubworkflow8name($subworkflow8name, $update = false) {$this->setField('subworkflow8name', $subworkflow8name, $update);}

    /**
     * Filter subworkflow8name
     * @param string $subworkflow8name
     * @param string $operation
     */
    public function filterSubworkflow8name($subworkflow8name, $operation = false) {$this->filterField('subworkflow8name', $subworkflow8name, $operation);}

    /**
     * Get subworkflow8date
     * @return int
     */
    public function getSubworkflow8date() { return $this->getField('subworkflow8date');}

    /**
     * Set subworkflow8date
     * @param int $subworkflow8date
     */
    public function setSubworkflow8date($subworkflow8date, $update = false) {$this->setField('subworkflow8date', $subworkflow8date, $update);}

    /**
     * Filter subworkflow8date
     * @param int $subworkflow8date
     * @param string $operation
     */
    public function filterSubworkflow8date($subworkflow8date, $operation = false) {$this->filterField('subworkflow8date', $subworkflow8date, $operation);}

    /**
     * Get subworkflow8description
     * @return string
     */
    public function getSubworkflow8description() { return $this->getField('subworkflow8description');}

    /**
     * Set subworkflow8description
     * @param string $subworkflow8description
     */
    public function setSubworkflow8description($subworkflow8description, $update = false) {$this->setField('subworkflow8description', $subworkflow8description, $update);}

    /**
     * Filter subworkflow8description
     * @param string $subworkflow8description
     * @param string $operation
     */
    public function filterSubworkflow8description($subworkflow8description, $operation = false) {$this->filterField('subworkflow8description', $subworkflow8description, $operation);}

    /**
     * Get subworkflow9
     * @return int
     */
    public function getSubworkflow9() { return $this->getField('subworkflow9');}

    /**
     * Set subworkflow9
     * @param int $subworkflow9
     */
    public function setSubworkflow9($subworkflow9, $update = false) {$this->setField('subworkflow9', $subworkflow9, $update);}

    /**
     * Filter subworkflow9
     * @param int $subworkflow9
     * @param string $operation
     */
    public function filterSubworkflow9($subworkflow9, $operation = false) {$this->filterField('subworkflow9', $subworkflow9, $operation);}

    /**
     * Get subworkflow9name
     * @return string
     */
    public function getSubworkflow9name() { return $this->getField('subworkflow9name');}

    /**
     * Set subworkflow9name
     * @param string $subworkflow9name
     */
    public function setSubworkflow9name($subworkflow9name, $update = false) {$this->setField('subworkflow9name', $subworkflow9name, $update);}

    /**
     * Filter subworkflow9name
     * @param string $subworkflow9name
     * @param string $operation
     */
    public function filterSubworkflow9name($subworkflow9name, $operation = false) {$this->filterField('subworkflow9name', $subworkflow9name, $operation);}

    /**
     * Get subworkflow9date
     * @return int
     */
    public function getSubworkflow9date() { return $this->getField('subworkflow9date');}

    /**
     * Set subworkflow9date
     * @param int $subworkflow9date
     */
    public function setSubworkflow9date($subworkflow9date, $update = false) {$this->setField('subworkflow9date', $subworkflow9date, $update);}

    /**
     * Filter subworkflow9date
     * @param int $subworkflow9date
     * @param string $operation
     */
    public function filterSubworkflow9date($subworkflow9date, $operation = false) {$this->filterField('subworkflow9date', $subworkflow9date, $operation);}

    /**
     * Get subworkflow9description
     * @return string
     */
    public function getSubworkflow9description() { return $this->getField('subworkflow9description');}

    /**
     * Set subworkflow9description
     * @param string $subworkflow9description
     */
    public function setSubworkflow9description($subworkflow9description, $update = false) {$this->setField('subworkflow9description', $subworkflow9description, $update);}

    /**
     * Filter subworkflow9description
     * @param string $subworkflow9description
     * @param string $operation
     */
    public function filterSubworkflow9description($subworkflow9description, $operation = false) {$this->filterField('subworkflow9description', $subworkflow9description, $operation);}

    /**
     * Get subworkflow10
     * @return int
     */
    public function getSubworkflow10() { return $this->getField('subworkflow10');}

    /**
     * Set subworkflow10
     * @param int $subworkflow10
     */
    public function setSubworkflow10($subworkflow10, $update = false) {$this->setField('subworkflow10', $subworkflow10, $update);}

    /**
     * Filter subworkflow10
     * @param int $subworkflow10
     * @param string $operation
     */
    public function filterSubworkflow10($subworkflow10, $operation = false) {$this->filterField('subworkflow10', $subworkflow10, $operation);}

    /**
     * Get subworkflow10name
     * @return string
     */
    public function getSubworkflow10name() { return $this->getField('subworkflow10name');}

    /**
     * Set subworkflow10name
     * @param string $subworkflow10name
     */
    public function setSubworkflow10name($subworkflow10name, $update = false) {$this->setField('subworkflow10name', $subworkflow10name, $update);}

    /**
     * Filter subworkflow10name
     * @param string $subworkflow10name
     * @param string $operation
     */
    public function filterSubworkflow10name($subworkflow10name, $operation = false) {$this->filterField('subworkflow10name', $subworkflow10name, $operation);}

    /**
     * Get subworkflow10date
     * @return int
     */
    public function getSubworkflow10date() { return $this->getField('subworkflow10date');}

    /**
     * Set subworkflow10date
     * @param int $subworkflow10date
     */
    public function setSubworkflow10date($subworkflow10date, $update = false) {$this->setField('subworkflow10date', $subworkflow10date, $update);}

    /**
     * Filter subworkflow10date
     * @param int $subworkflow10date
     * @param string $operation
     */
    public function filterSubworkflow10date($subworkflow10date, $operation = false) {$this->filterField('subworkflow10date', $subworkflow10date, $operation);}

    /**
     * Get subworkflow10description
     * @return string
     */
    public function getSubworkflow10description() { return $this->getField('subworkflow10description');}

    /**
     * Set subworkflow10description
     * @param string $subworkflow10description
     */
    public function setSubworkflow10description($subworkflow10description, $update = false) {$this->setField('subworkflow10description', $subworkflow10description, $update);}

    /**
     * Filter subworkflow10description
     * @param string $subworkflow10description
     * @param string $operation
     */
    public function filterSubworkflow10description($subworkflow10description, $operation = false) {$this->filterField('subworkflow10description', $subworkflow10description, $operation);}

    /**
     * Get subworkflow11
     * @return int
     */
    public function getSubworkflow11() { return $this->getField('subworkflow11');}

    /**
     * Set subworkflow11
     * @param int $subworkflow11
     */
    public function setSubworkflow11($subworkflow11, $update = false) {$this->setField('subworkflow11', $subworkflow11, $update);}

    /**
     * Filter subworkflow11
     * @param int $subworkflow11
     * @param string $operation
     */
    public function filterSubworkflow11($subworkflow11, $operation = false) {$this->filterField('subworkflow11', $subworkflow11, $operation);}

    /**
     * Get subworkflow11name
     * @return string
     */
    public function getSubworkflow11name() { return $this->getField('subworkflow11name');}

    /**
     * Set subworkflow11name
     * @param string $subworkflow11name
     */
    public function setSubworkflow11name($subworkflow11name, $update = false) {$this->setField('subworkflow11name', $subworkflow11name, $update);}

    /**
     * Filter subworkflow11name
     * @param string $subworkflow11name
     * @param string $operation
     */
    public function filterSubworkflow11name($subworkflow11name, $operation = false) {$this->filterField('subworkflow11name', $subworkflow11name, $operation);}

    /**
     * Get subworkflow11date
     * @return int
     */
    public function getSubworkflow11date() { return $this->getField('subworkflow11date');}

    /**
     * Set subworkflow11date
     * @param int $subworkflow11date
     */
    public function setSubworkflow11date($subworkflow11date, $update = false) {$this->setField('subworkflow11date', $subworkflow11date, $update);}

    /**
     * Filter subworkflow11date
     * @param int $subworkflow11date
     * @param string $operation
     */
    public function filterSubworkflow11date($subworkflow11date, $operation = false) {$this->filterField('subworkflow11date', $subworkflow11date, $operation);}

    /**
     * Get subworkflow11description
     * @return string
     */
    public function getSubworkflow11description() { return $this->getField('subworkflow11description');}

    /**
     * Set subworkflow11description
     * @param string $subworkflow11description
     */
    public function setSubworkflow11description($subworkflow11description, $update = false) {$this->setField('subworkflow11description', $subworkflow11description, $update);}

    /**
     * Filter subworkflow11description
     * @param string $subworkflow11description
     * @param string $operation
     */
    public function filterSubworkflow11description($subworkflow11description, $operation = false) {$this->filterField('subworkflow11description', $subworkflow11description, $operation);}

    /**
     * Get subworkflow12
     * @return int
     */
    public function getSubworkflow12() { return $this->getField('subworkflow12');}

    /**
     * Set subworkflow12
     * @param int $subworkflow12
     */
    public function setSubworkflow12($subworkflow12, $update = false) {$this->setField('subworkflow12', $subworkflow12, $update);}

    /**
     * Filter subworkflow12
     * @param int $subworkflow12
     * @param string $operation
     */
    public function filterSubworkflow12($subworkflow12, $operation = false) {$this->filterField('subworkflow12', $subworkflow12, $operation);}

    /**
     * Get subworkflow12name
     * @return string
     */
    public function getSubworkflow12name() { return $this->getField('subworkflow12name');}

    /**
     * Set subworkflow12name
     * @param string $subworkflow12name
     */
    public function setSubworkflow12name($subworkflow12name, $update = false) {$this->setField('subworkflow12name', $subworkflow12name, $update);}

    /**
     * Filter subworkflow12name
     * @param string $subworkflow12name
     * @param string $operation
     */
    public function filterSubworkflow12name($subworkflow12name, $operation = false) {$this->filterField('subworkflow12name', $subworkflow12name, $operation);}

    /**
     * Get subworkflow12date
     * @return int
     */
    public function getSubworkflow12date() { return $this->getField('subworkflow12date');}

    /**
     * Set subworkflow12date
     * @param int $subworkflow12date
     */
    public function setSubworkflow12date($subworkflow12date, $update = false) {$this->setField('subworkflow12date', $subworkflow12date, $update);}

    /**
     * Filter subworkflow12date
     * @param int $subworkflow12date
     * @param string $operation
     */
    public function filterSubworkflow12date($subworkflow12date, $operation = false) {$this->filterField('subworkflow12date', $subworkflow12date, $operation);}

    /**
     * Get subworkflow12description
     * @return string
     */
    public function getSubworkflow12description() { return $this->getField('subworkflow12description');}

    /**
     * Set subworkflow12description
     * @param string $subworkflow12description
     */
    public function setSubworkflow12description($subworkflow12description, $update = false) {$this->setField('subworkflow12description', $subworkflow12description, $update);}

    /**
     * Filter subworkflow12description
     * @param string $subworkflow12description
     * @param string $operation
     */
    public function filterSubworkflow12description($subworkflow12description, $operation = false) {$this->filterField('subworkflow12description', $subworkflow12description, $operation);}

    /**
     * Get subworkflow13
     * @return int
     */
    public function getSubworkflow13() { return $this->getField('subworkflow13');}

    /**
     * Set subworkflow13
     * @param int $subworkflow13
     */
    public function setSubworkflow13($subworkflow13, $update = false) {$this->setField('subworkflow13', $subworkflow13, $update);}

    /**
     * Filter subworkflow13
     * @param int $subworkflow13
     * @param string $operation
     */
    public function filterSubworkflow13($subworkflow13, $operation = false) {$this->filterField('subworkflow13', $subworkflow13, $operation);}

    /**
     * Get subworkflow13name
     * @return string
     */
    public function getSubworkflow13name() { return $this->getField('subworkflow13name');}

    /**
     * Set subworkflow13name
     * @param string $subworkflow13name
     */
    public function setSubworkflow13name($subworkflow13name, $update = false) {$this->setField('subworkflow13name', $subworkflow13name, $update);}

    /**
     * Filter subworkflow13name
     * @param string $subworkflow13name
     * @param string $operation
     */
    public function filterSubworkflow13name($subworkflow13name, $operation = false) {$this->filterField('subworkflow13name', $subworkflow13name, $operation);}

    /**
     * Get subworkflow13date
     * @return int
     */
    public function getSubworkflow13date() { return $this->getField('subworkflow13date');}

    /**
     * Set subworkflow13date
     * @param int $subworkflow13date
     */
    public function setSubworkflow13date($subworkflow13date, $update = false) {$this->setField('subworkflow13date', $subworkflow13date, $update);}

    /**
     * Filter subworkflow13date
     * @param int $subworkflow13date
     * @param string $operation
     */
    public function filterSubworkflow13date($subworkflow13date, $operation = false) {$this->filterField('subworkflow13date', $subworkflow13date, $operation);}

    /**
     * Get subworkflow13description
     * @return string
     */
    public function getSubworkflow13description() { return $this->getField('subworkflow13description');}

    /**
     * Set subworkflow13description
     * @param string $subworkflow13description
     */
    public function setSubworkflow13description($subworkflow13description, $update = false) {$this->setField('subworkflow13description', $subworkflow13description, $update);}

    /**
     * Filter subworkflow13description
     * @param string $subworkflow13description
     * @param string $operation
     */
    public function filterSubworkflow13description($subworkflow13description, $operation = false) {$this->filterField('subworkflow13description', $subworkflow13description, $operation);}

    /**
     * Get subworkflow14
     * @return int
     */
    public function getSubworkflow14() { return $this->getField('subworkflow14');}

    /**
     * Set subworkflow14
     * @param int $subworkflow14
     */
    public function setSubworkflow14($subworkflow14, $update = false) {$this->setField('subworkflow14', $subworkflow14, $update);}

    /**
     * Filter subworkflow14
     * @param int $subworkflow14
     * @param string $operation
     */
    public function filterSubworkflow14($subworkflow14, $operation = false) {$this->filterField('subworkflow14', $subworkflow14, $operation);}

    /**
     * Get subworkflow14name
     * @return string
     */
    public function getSubworkflow14name() { return $this->getField('subworkflow14name');}

    /**
     * Set subworkflow14name
     * @param string $subworkflow14name
     */
    public function setSubworkflow14name($subworkflow14name, $update = false) {$this->setField('subworkflow14name', $subworkflow14name, $update);}

    /**
     * Filter subworkflow14name
     * @param string $subworkflow14name
     * @param string $operation
     */
    public function filterSubworkflow14name($subworkflow14name, $operation = false) {$this->filterField('subworkflow14name', $subworkflow14name, $operation);}

    /**
     * Get subworkflow14date
     * @return int
     */
    public function getSubworkflow14date() { return $this->getField('subworkflow14date');}

    /**
     * Set subworkflow14date
     * @param int $subworkflow14date
     */
    public function setSubworkflow14date($subworkflow14date, $update = false) {$this->setField('subworkflow14date', $subworkflow14date, $update);}

    /**
     * Filter subworkflow14date
     * @param int $subworkflow14date
     * @param string $operation
     */
    public function filterSubworkflow14date($subworkflow14date, $operation = false) {$this->filterField('subworkflow14date', $subworkflow14date, $operation);}

    /**
     * Get subworkflow14description
     * @return string
     */
    public function getSubworkflow14description() { return $this->getField('subworkflow14description');}

    /**
     * Set subworkflow14description
     * @param string $subworkflow14description
     */
    public function setSubworkflow14description($subworkflow14description, $update = false) {$this->setField('subworkflow14description', $subworkflow14description, $update);}

    /**
     * Filter subworkflow14description
     * @param string $subworkflow14description
     * @param string $operation
     */
    public function filterSubworkflow14description($subworkflow14description, $operation = false) {$this->filterField('subworkflow14description', $subworkflow14description, $operation);}

    /**
     * Get subworkflow15
     * @return int
     */
    public function getSubworkflow15() { return $this->getField('subworkflow15');}

    /**
     * Set subworkflow15
     * @param int $subworkflow15
     */
    public function setSubworkflow15($subworkflow15, $update = false) {$this->setField('subworkflow15', $subworkflow15, $update);}

    /**
     * Filter subworkflow15
     * @param int $subworkflow15
     * @param string $operation
     */
    public function filterSubworkflow15($subworkflow15, $operation = false) {$this->filterField('subworkflow15', $subworkflow15, $operation);}

    /**
     * Get subworkflow15name
     * @return string
     */
    public function getSubworkflow15name() { return $this->getField('subworkflow15name');}

    /**
     * Set subworkflow15name
     * @param string $subworkflow15name
     */
    public function setSubworkflow15name($subworkflow15name, $update = false) {$this->setField('subworkflow15name', $subworkflow15name, $update);}

    /**
     * Filter subworkflow15name
     * @param string $subworkflow15name
     * @param string $operation
     */
    public function filterSubworkflow15name($subworkflow15name, $operation = false) {$this->filterField('subworkflow15name', $subworkflow15name, $operation);}

    /**
     * Get subworkflow15date
     * @return int
     */
    public function getSubworkflow15date() { return $this->getField('subworkflow15date');}

    /**
     * Set subworkflow15date
     * @param int $subworkflow15date
     */
    public function setSubworkflow15date($subworkflow15date, $update = false) {$this->setField('subworkflow15date', $subworkflow15date, $update);}

    /**
     * Filter subworkflow15date
     * @param int $subworkflow15date
     * @param string $operation
     */
    public function filterSubworkflow15date($subworkflow15date, $operation = false) {$this->filterField('subworkflow15date', $subworkflow15date, $operation);}

    /**
     * Get subworkflow15description
     * @return string
     */
    public function getSubworkflow15description() { return $this->getField('subworkflow15description');}

    /**
     * Set subworkflow15description
     * @param string $subworkflow15description
     */
    public function setSubworkflow15description($subworkflow15description, $update = false) {$this->setField('subworkflow15description', $subworkflow15description, $update);}

    /**
     * Filter subworkflow15description
     * @param string $subworkflow15description
     * @param string $operation
     */
    public function filterSubworkflow15description($subworkflow15description, $operation = false) {$this->filterField('subworkflow15description', $subworkflow15description, $operation);}

    /**
     * Get subworkflow16
     * @return int
     */
    public function getSubworkflow16() { return $this->getField('subworkflow16');}

    /**
     * Set subworkflow16
     * @param int $subworkflow16
     */
    public function setSubworkflow16($subworkflow16, $update = false) {$this->setField('subworkflow16', $subworkflow16, $update);}

    /**
     * Filter subworkflow16
     * @param int $subworkflow16
     * @param string $operation
     */
    public function filterSubworkflow16($subworkflow16, $operation = false) {$this->filterField('subworkflow16', $subworkflow16, $operation);}

    /**
     * Get subworkflow16name
     * @return string
     */
    public function getSubworkflow16name() { return $this->getField('subworkflow16name');}

    /**
     * Set subworkflow16name
     * @param string $subworkflow16name
     */
    public function setSubworkflow16name($subworkflow16name, $update = false) {$this->setField('subworkflow16name', $subworkflow16name, $update);}

    /**
     * Filter subworkflow16name
     * @param string $subworkflow16name
     * @param string $operation
     */
    public function filterSubworkflow16name($subworkflow16name, $operation = false) {$this->filterField('subworkflow16name', $subworkflow16name, $operation);}

    /**
     * Get subworkflow16date
     * @return int
     */
    public function getSubworkflow16date() { return $this->getField('subworkflow16date');}

    /**
     * Set subworkflow16date
     * @param int $subworkflow16date
     */
    public function setSubworkflow16date($subworkflow16date, $update = false) {$this->setField('subworkflow16date', $subworkflow16date, $update);}

    /**
     * Filter subworkflow16date
     * @param int $subworkflow16date
     * @param string $operation
     */
    public function filterSubworkflow16date($subworkflow16date, $operation = false) {$this->filterField('subworkflow16date', $subworkflow16date, $operation);}

    /**
     * Get subworkflow16description
     * @return string
     */
    public function getSubworkflow16description() { return $this->getField('subworkflow16description');}

    /**
     * Set subworkflow16description
     * @param string $subworkflow16description
     */
    public function setSubworkflow16description($subworkflow16description, $update = false) {$this->setField('subworkflow16description', $subworkflow16description, $update);}

    /**
     * Filter subworkflow16description
     * @param string $subworkflow16description
     * @param string $operation
     */
    public function filterSubworkflow16description($subworkflow16description, $operation = false) {$this->filterField('subworkflow16description', $subworkflow16description, $operation);}

    /**
     * Get subworkflow17
     * @return int
     */
    public function getSubworkflow17() { return $this->getField('subworkflow17');}

    /**
     * Set subworkflow17
     * @param int $subworkflow17
     */
    public function setSubworkflow17($subworkflow17, $update = false) {$this->setField('subworkflow17', $subworkflow17, $update);}

    /**
     * Filter subworkflow17
     * @param int $subworkflow17
     * @param string $operation
     */
    public function filterSubworkflow17($subworkflow17, $operation = false) {$this->filterField('subworkflow17', $subworkflow17, $operation);}

    /**
     * Get subworkflow17name
     * @return string
     */
    public function getSubworkflow17name() { return $this->getField('subworkflow17name');}

    /**
     * Set subworkflow17name
     * @param string $subworkflow17name
     */
    public function setSubworkflow17name($subworkflow17name, $update = false) {$this->setField('subworkflow17name', $subworkflow17name, $update);}

    /**
     * Filter subworkflow17name
     * @param string $subworkflow17name
     * @param string $operation
     */
    public function filterSubworkflow17name($subworkflow17name, $operation = false) {$this->filterField('subworkflow17name', $subworkflow17name, $operation);}

    /**
     * Get subworkflow17date
     * @return int
     */
    public function getSubworkflow17date() { return $this->getField('subworkflow17date');}

    /**
     * Set subworkflow17date
     * @param int $subworkflow17date
     */
    public function setSubworkflow17date($subworkflow17date, $update = false) {$this->setField('subworkflow17date', $subworkflow17date, $update);}

    /**
     * Filter subworkflow17date
     * @param int $subworkflow17date
     * @param string $operation
     */
    public function filterSubworkflow17date($subworkflow17date, $operation = false) {$this->filterField('subworkflow17date', $subworkflow17date, $operation);}

    /**
     * Get subworkflow17description
     * @return string
     */
    public function getSubworkflow17description() { return $this->getField('subworkflow17description');}

    /**
     * Set subworkflow17description
     * @param string $subworkflow17description
     */
    public function setSubworkflow17description($subworkflow17description, $update = false) {$this->setField('subworkflow17description', $subworkflow17description, $update);}

    /**
     * Filter subworkflow17description
     * @param string $subworkflow17description
     * @param string $operation
     */
    public function filterSubworkflow17description($subworkflow17description, $operation = false) {$this->filterField('subworkflow17description', $subworkflow17description, $operation);}

    /**
     * Get subworkflow18
     * @return int
     */
    public function getSubworkflow18() { return $this->getField('subworkflow18');}

    /**
     * Set subworkflow18
     * @param int $subworkflow18
     */
    public function setSubworkflow18($subworkflow18, $update = false) {$this->setField('subworkflow18', $subworkflow18, $update);}

    /**
     * Filter subworkflow18
     * @param int $subworkflow18
     * @param string $operation
     */
    public function filterSubworkflow18($subworkflow18, $operation = false) {$this->filterField('subworkflow18', $subworkflow18, $operation);}

    /**
     * Get subworkflow18name
     * @return string
     */
    public function getSubworkflow18name() { return $this->getField('subworkflow18name');}

    /**
     * Set subworkflow18name
     * @param string $subworkflow18name
     */
    public function setSubworkflow18name($subworkflow18name, $update = false) {$this->setField('subworkflow18name', $subworkflow18name, $update);}

    /**
     * Filter subworkflow18name
     * @param string $subworkflow18name
     * @param string $operation
     */
    public function filterSubworkflow18name($subworkflow18name, $operation = false) {$this->filterField('subworkflow18name', $subworkflow18name, $operation);}

    /**
     * Get subworkflow18date
     * @return int
     */
    public function getSubworkflow18date() { return $this->getField('subworkflow18date');}

    /**
     * Set subworkflow18date
     * @param int $subworkflow18date
     */
    public function setSubworkflow18date($subworkflow18date, $update = false) {$this->setField('subworkflow18date', $subworkflow18date, $update);}

    /**
     * Filter subworkflow18date
     * @param int $subworkflow18date
     * @param string $operation
     */
    public function filterSubworkflow18date($subworkflow18date, $operation = false) {$this->filterField('subworkflow18date', $subworkflow18date, $operation);}

    /**
     * Get subworkflow18description
     * @return string
     */
    public function getSubworkflow18description() { return $this->getField('subworkflow18description');}

    /**
     * Set subworkflow18description
     * @param string $subworkflow18description
     */
    public function setSubworkflow18description($subworkflow18description, $update = false) {$this->setField('subworkflow18description', $subworkflow18description, $update);}

    /**
     * Filter subworkflow18description
     * @param string $subworkflow18description
     * @param string $operation
     */
    public function filterSubworkflow18description($subworkflow18description, $operation = false) {$this->filterField('subworkflow18description', $subworkflow18description, $operation);}

    /**
     * Get subworkflow19
     * @return int
     */
    public function getSubworkflow19() { return $this->getField('subworkflow19');}

    /**
     * Set subworkflow19
     * @param int $subworkflow19
     */
    public function setSubworkflow19($subworkflow19, $update = false) {$this->setField('subworkflow19', $subworkflow19, $update);}

    /**
     * Filter subworkflow19
     * @param int $subworkflow19
     * @param string $operation
     */
    public function filterSubworkflow19($subworkflow19, $operation = false) {$this->filterField('subworkflow19', $subworkflow19, $operation);}

    /**
     * Get subworkflow19name
     * @return string
     */
    public function getSubworkflow19name() { return $this->getField('subworkflow19name');}

    /**
     * Set subworkflow19name
     * @param string $subworkflow19name
     */
    public function setSubworkflow19name($subworkflow19name, $update = false) {$this->setField('subworkflow19name', $subworkflow19name, $update);}

    /**
     * Filter subworkflow19name
     * @param string $subworkflow19name
     * @param string $operation
     */
    public function filterSubworkflow19name($subworkflow19name, $operation = false) {$this->filterField('subworkflow19name', $subworkflow19name, $operation);}

    /**
     * Get subworkflow19date
     * @return int
     */
    public function getSubworkflow19date() { return $this->getField('subworkflow19date');}

    /**
     * Set subworkflow19date
     * @param int $subworkflow19date
     */
    public function setSubworkflow19date($subworkflow19date, $update = false) {$this->setField('subworkflow19date', $subworkflow19date, $update);}

    /**
     * Filter subworkflow19date
     * @param int $subworkflow19date
     * @param string $operation
     */
    public function filterSubworkflow19date($subworkflow19date, $operation = false) {$this->filterField('subworkflow19date', $subworkflow19date, $operation);}

    /**
     * Get subworkflow19description
     * @return string
     */
    public function getSubworkflow19description() { return $this->getField('subworkflow19description');}

    /**
     * Set subworkflow19description
     * @param string $subworkflow19description
     */
    public function setSubworkflow19description($subworkflow19description, $update = false) {$this->setField('subworkflow19description', $subworkflow19description, $update);}

    /**
     * Filter subworkflow19description
     * @param string $subworkflow19description
     * @param string $operation
     */
    public function filterSubworkflow19description($subworkflow19description, $operation = false) {$this->filterField('subworkflow19description', $subworkflow19description, $operation);}

    /**
     * Get subworkflow20
     * @return int
     */
    public function getSubworkflow20() { return $this->getField('subworkflow20');}

    /**
     * Set subworkflow20
     * @param int $subworkflow20
     */
    public function setSubworkflow20($subworkflow20, $update = false) {$this->setField('subworkflow20', $subworkflow20, $update);}

    /**
     * Filter subworkflow20
     * @param int $subworkflow20
     * @param string $operation
     */
    public function filterSubworkflow20($subworkflow20, $operation = false) {$this->filterField('subworkflow20', $subworkflow20, $operation);}

    /**
     * Get subworkflow20name
     * @return string
     */
    public function getSubworkflow20name() { return $this->getField('subworkflow20name');}

    /**
     * Set subworkflow20name
     * @param string $subworkflow20name
     */
    public function setSubworkflow20name($subworkflow20name, $update = false) {$this->setField('subworkflow20name', $subworkflow20name, $update);}

    /**
     * Filter subworkflow20name
     * @param string $subworkflow20name
     * @param string $operation
     */
    public function filterSubworkflow20name($subworkflow20name, $operation = false) {$this->filterField('subworkflow20name', $subworkflow20name, $operation);}

    /**
     * Get subworkflow20date
     * @return int
     */
    public function getSubworkflow20date() { return $this->getField('subworkflow20date');}

    /**
     * Set subworkflow20date
     * @param int $subworkflow20date
     */
    public function setSubworkflow20date($subworkflow20date, $update = false) {$this->setField('subworkflow20date', $subworkflow20date, $update);}

    /**
     * Filter subworkflow20date
     * @param int $subworkflow20date
     * @param string $operation
     */
    public function filterSubworkflow20date($subworkflow20date, $operation = false) {$this->filterField('subworkflow20date', $subworkflow20date, $operation);}

    /**
     * Get subworkflow20description
     * @return string
     */
    public function getSubworkflow20description() { return $this->getField('subworkflow20description');}

    /**
     * Set subworkflow20description
     * @param string $subworkflow20description
     */
    public function setSubworkflow20description($subworkflow20description, $update = false) {$this->setField('subworkflow20description', $subworkflow20description, $update);}

    /**
     * Filter subworkflow20description
     * @param string $subworkflow20description
     * @param string $operation
     */
    public function filterSubworkflow20description($subworkflow20description, $operation = false) {$this->filterField('subworkflow20description', $subworkflow20description, $operation);}

    /**
     * Get subworkflow21
     * @return int
     */
    public function getSubworkflow21() { return $this->getField('subworkflow21');}

    /**
     * Set subworkflow21
     * @param int $subworkflow21
     */
    public function setSubworkflow21($subworkflow21, $update = false) {$this->setField('subworkflow21', $subworkflow21, $update);}

    /**
     * Filter subworkflow21
     * @param int $subworkflow21
     * @param string $operation
     */
    public function filterSubworkflow21($subworkflow21, $operation = false) {$this->filterField('subworkflow21', $subworkflow21, $operation);}

    /**
     * Get subworkflow21name
     * @return string
     */
    public function getSubworkflow21name() { return $this->getField('subworkflow21name');}

    /**
     * Set subworkflow21name
     * @param string $subworkflow21name
     */
    public function setSubworkflow21name($subworkflow21name, $update = false) {$this->setField('subworkflow21name', $subworkflow21name, $update);}

    /**
     * Filter subworkflow21name
     * @param string $subworkflow21name
     * @param string $operation
     */
    public function filterSubworkflow21name($subworkflow21name, $operation = false) {$this->filterField('subworkflow21name', $subworkflow21name, $operation);}

    /**
     * Get subworkflow21date
     * @return int
     */
    public function getSubworkflow21date() { return $this->getField('subworkflow21date');}

    /**
     * Set subworkflow21date
     * @param int $subworkflow21date
     */
    public function setSubworkflow21date($subworkflow21date, $update = false) {$this->setField('subworkflow21date', $subworkflow21date, $update);}

    /**
     * Filter subworkflow21date
     * @param int $subworkflow21date
     * @param string $operation
     */
    public function filterSubworkflow21date($subworkflow21date, $operation = false) {$this->filterField('subworkflow21date', $subworkflow21date, $operation);}

    /**
     * Get subworkflow21description
     * @return string
     */
    public function getSubworkflow21description() { return $this->getField('subworkflow21description');}

    /**
     * Set subworkflow21description
     * @param string $subworkflow21description
     */
    public function setSubworkflow21description($subworkflow21description, $update = false) {$this->setField('subworkflow21description', $subworkflow21description, $update);}

    /**
     * Filter subworkflow21description
     * @param string $subworkflow21description
     * @param string $operation
     */
    public function filterSubworkflow21description($subworkflow21description, $operation = false) {$this->filterField('subworkflow21description', $subworkflow21description, $operation);}

    /**
     * Get subworkflow22
     * @return int
     */
    public function getSubworkflow22() { return $this->getField('subworkflow22');}

    /**
     * Set subworkflow22
     * @param int $subworkflow22
     */
    public function setSubworkflow22($subworkflow22, $update = false) {$this->setField('subworkflow22', $subworkflow22, $update);}

    /**
     * Filter subworkflow22
     * @param int $subworkflow22
     * @param string $operation
     */
    public function filterSubworkflow22($subworkflow22, $operation = false) {$this->filterField('subworkflow22', $subworkflow22, $operation);}

    /**
     * Get subworkflow22name
     * @return string
     */
    public function getSubworkflow22name() { return $this->getField('subworkflow22name');}

    /**
     * Set subworkflow22name
     * @param string $subworkflow22name
     */
    public function setSubworkflow22name($subworkflow22name, $update = false) {$this->setField('subworkflow22name', $subworkflow22name, $update);}

    /**
     * Filter subworkflow22name
     * @param string $subworkflow22name
     * @param string $operation
     */
    public function filterSubworkflow22name($subworkflow22name, $operation = false) {$this->filterField('subworkflow22name', $subworkflow22name, $operation);}

    /**
     * Get subworkflow22date
     * @return int
     */
    public function getSubworkflow22date() { return $this->getField('subworkflow22date');}

    /**
     * Set subworkflow22date
     * @param int $subworkflow22date
     */
    public function setSubworkflow22date($subworkflow22date, $update = false) {$this->setField('subworkflow22date', $subworkflow22date, $update);}

    /**
     * Filter subworkflow22date
     * @param int $subworkflow22date
     * @param string $operation
     */
    public function filterSubworkflow22date($subworkflow22date, $operation = false) {$this->filterField('subworkflow22date', $subworkflow22date, $operation);}

    /**
     * Get subworkflow22description
     * @return string
     */
    public function getSubworkflow22description() { return $this->getField('subworkflow22description');}

    /**
     * Set subworkflow22description
     * @param string $subworkflow22description
     */
    public function setSubworkflow22description($subworkflow22description, $update = false) {$this->setField('subworkflow22description', $subworkflow22description, $update);}

    /**
     * Filter subworkflow22description
     * @param string $subworkflow22description
     * @param string $operation
     */
    public function filterSubworkflow22description($subworkflow22description, $operation = false) {$this->filterField('subworkflow22description', $subworkflow22description, $operation);}

    /**
     * Get subworkflow23
     * @return int
     */
    public function getSubworkflow23() { return $this->getField('subworkflow23');}

    /**
     * Set subworkflow23
     * @param int $subworkflow23
     */
    public function setSubworkflow23($subworkflow23, $update = false) {$this->setField('subworkflow23', $subworkflow23, $update);}

    /**
     * Filter subworkflow23
     * @param int $subworkflow23
     * @param string $operation
     */
    public function filterSubworkflow23($subworkflow23, $operation = false) {$this->filterField('subworkflow23', $subworkflow23, $operation);}

    /**
     * Get subworkflow23name
     * @return string
     */
    public function getSubworkflow23name() { return $this->getField('subworkflow23name');}

    /**
     * Set subworkflow23name
     * @param string $subworkflow23name
     */
    public function setSubworkflow23name($subworkflow23name, $update = false) {$this->setField('subworkflow23name', $subworkflow23name, $update);}

    /**
     * Filter subworkflow23name
     * @param string $subworkflow23name
     * @param string $operation
     */
    public function filterSubworkflow23name($subworkflow23name, $operation = false) {$this->filterField('subworkflow23name', $subworkflow23name, $operation);}

    /**
     * Get subworkflow23date
     * @return int
     */
    public function getSubworkflow23date() { return $this->getField('subworkflow23date');}

    /**
     * Set subworkflow23date
     * @param int $subworkflow23date
     */
    public function setSubworkflow23date($subworkflow23date, $update = false) {$this->setField('subworkflow23date', $subworkflow23date, $update);}

    /**
     * Filter subworkflow23date
     * @param int $subworkflow23date
     * @param string $operation
     */
    public function filterSubworkflow23date($subworkflow23date, $operation = false) {$this->filterField('subworkflow23date', $subworkflow23date, $operation);}

    /**
     * Get subworkflow23description
     * @return string
     */
    public function getSubworkflow23description() { return $this->getField('subworkflow23description');}

    /**
     * Set subworkflow23description
     * @param string $subworkflow23description
     */
    public function setSubworkflow23description($subworkflow23description, $update = false) {$this->setField('subworkflow23description', $subworkflow23description, $update);}

    /**
     * Filter subworkflow23description
     * @param string $subworkflow23description
     * @param string $operation
     */
    public function filterSubworkflow23description($subworkflow23description, $operation = false) {$this->filterField('subworkflow23description', $subworkflow23description, $operation);}

    /**
     * Get subworkflow24
     * @return int
     */
    public function getSubworkflow24() { return $this->getField('subworkflow24');}

    /**
     * Set subworkflow24
     * @param int $subworkflow24
     */
    public function setSubworkflow24($subworkflow24, $update = false) {$this->setField('subworkflow24', $subworkflow24, $update);}

    /**
     * Filter subworkflow24
     * @param int $subworkflow24
     * @param string $operation
     */
    public function filterSubworkflow24($subworkflow24, $operation = false) {$this->filterField('subworkflow24', $subworkflow24, $operation);}

    /**
     * Get subworkflow24name
     * @return string
     */
    public function getSubworkflow24name() { return $this->getField('subworkflow24name');}

    /**
     * Set subworkflow24name
     * @param string $subworkflow24name
     */
    public function setSubworkflow24name($subworkflow24name, $update = false) {$this->setField('subworkflow24name', $subworkflow24name, $update);}

    /**
     * Filter subworkflow24name
     * @param string $subworkflow24name
     * @param string $operation
     */
    public function filterSubworkflow24name($subworkflow24name, $operation = false) {$this->filterField('subworkflow24name', $subworkflow24name, $operation);}

    /**
     * Get subworkflow24date
     * @return int
     */
    public function getSubworkflow24date() { return $this->getField('subworkflow24date');}

    /**
     * Set subworkflow24date
     * @param int $subworkflow24date
     */
    public function setSubworkflow24date($subworkflow24date, $update = false) {$this->setField('subworkflow24date', $subworkflow24date, $update);}

    /**
     * Filter subworkflow24date
     * @param int $subworkflow24date
     * @param string $operation
     */
    public function filterSubworkflow24date($subworkflow24date, $operation = false) {$this->filterField('subworkflow24date', $subworkflow24date, $operation);}

    /**
     * Get subworkflow24description
     * @return string
     */
    public function getSubworkflow24description() { return $this->getField('subworkflow24description');}

    /**
     * Set subworkflow24description
     * @param string $subworkflow24description
     */
    public function setSubworkflow24description($subworkflow24description, $update = false) {$this->setField('subworkflow24description', $subworkflow24description, $update);}

    /**
     * Filter subworkflow24description
     * @param string $subworkflow24description
     * @param string $operation
     */
    public function filterSubworkflow24description($subworkflow24description, $operation = false) {$this->filterField('subworkflow24description', $subworkflow24description, $operation);}

    /**
     * Get subworkflow25
     * @return int
     */
    public function getSubworkflow25() { return $this->getField('subworkflow25');}

    /**
     * Set subworkflow25
     * @param int $subworkflow25
     */
    public function setSubworkflow25($subworkflow25, $update = false) {$this->setField('subworkflow25', $subworkflow25, $update);}

    /**
     * Filter subworkflow25
     * @param int $subworkflow25
     * @param string $operation
     */
    public function filterSubworkflow25($subworkflow25, $operation = false) {$this->filterField('subworkflow25', $subworkflow25, $operation);}

    /**
     * Get subworkflow25name
     * @return string
     */
    public function getSubworkflow25name() { return $this->getField('subworkflow25name');}

    /**
     * Set subworkflow25name
     * @param string $subworkflow25name
     */
    public function setSubworkflow25name($subworkflow25name, $update = false) {$this->setField('subworkflow25name', $subworkflow25name, $update);}

    /**
     * Filter subworkflow25name
     * @param string $subworkflow25name
     * @param string $operation
     */
    public function filterSubworkflow25name($subworkflow25name, $operation = false) {$this->filterField('subworkflow25name', $subworkflow25name, $operation);}

    /**
     * Get subworkflow25date
     * @return int
     */
    public function getSubworkflow25date() { return $this->getField('subworkflow25date');}

    /**
     * Set subworkflow25date
     * @param int $subworkflow25date
     */
    public function setSubworkflow25date($subworkflow25date, $update = false) {$this->setField('subworkflow25date', $subworkflow25date, $update);}

    /**
     * Filter subworkflow25date
     * @param int $subworkflow25date
     * @param string $operation
     */
    public function filterSubworkflow25date($subworkflow25date, $operation = false) {$this->filterField('subworkflow25date', $subworkflow25date, $operation);}

    /**
     * Get subworkflow25description
     * @return string
     */
    public function getSubworkflow25description() { return $this->getField('subworkflow25description');}

    /**
     * Set subworkflow25description
     * @param string $subworkflow25description
     */
    public function setSubworkflow25description($subworkflow25description, $update = false) {$this->setField('subworkflow25description', $subworkflow25description, $update);}

    /**
     * Filter subworkflow25description
     * @param string $subworkflow25description
     * @param string $operation
     */
    public function filterSubworkflow25description($subworkflow25description, $operation = false) {$this->filterField('subworkflow25description', $subworkflow25description, $operation);}

    /**
     * Get subworkflow26
     * @return int
     */
    public function getSubworkflow26() { return $this->getField('subworkflow26');}

    /**
     * Set subworkflow26
     * @param int $subworkflow26
     */
    public function setSubworkflow26($subworkflow26, $update = false) {$this->setField('subworkflow26', $subworkflow26, $update);}

    /**
     * Filter subworkflow26
     * @param int $subworkflow26
     * @param string $operation
     */
    public function filterSubworkflow26($subworkflow26, $operation = false) {$this->filterField('subworkflow26', $subworkflow26, $operation);}

    /**
     * Get subworkflow26name
     * @return string
     */
    public function getSubworkflow26name() { return $this->getField('subworkflow26name');}

    /**
     * Set subworkflow26name
     * @param string $subworkflow26name
     */
    public function setSubworkflow26name($subworkflow26name, $update = false) {$this->setField('subworkflow26name', $subworkflow26name, $update);}

    /**
     * Filter subworkflow26name
     * @param string $subworkflow26name
     * @param string $operation
     */
    public function filterSubworkflow26name($subworkflow26name, $operation = false) {$this->filterField('subworkflow26name', $subworkflow26name, $operation);}

    /**
     * Get subworkflow26date
     * @return int
     */
    public function getSubworkflow26date() { return $this->getField('subworkflow26date');}

    /**
     * Set subworkflow26date
     * @param int $subworkflow26date
     */
    public function setSubworkflow26date($subworkflow26date, $update = false) {$this->setField('subworkflow26date', $subworkflow26date, $update);}

    /**
     * Filter subworkflow26date
     * @param int $subworkflow26date
     * @param string $operation
     */
    public function filterSubworkflow26date($subworkflow26date, $operation = false) {$this->filterField('subworkflow26date', $subworkflow26date, $operation);}

    /**
     * Get subworkflow26description
     * @return string
     */
    public function getSubworkflow26description() { return $this->getField('subworkflow26description');}

    /**
     * Set subworkflow26description
     * @param string $subworkflow26description
     */
    public function setSubworkflow26description($subworkflow26description, $update = false) {$this->setField('subworkflow26description', $subworkflow26description, $update);}

    /**
     * Filter subworkflow26description
     * @param string $subworkflow26description
     * @param string $operation
     */
    public function filterSubworkflow26description($subworkflow26description, $operation = false) {$this->filterField('subworkflow26description', $subworkflow26description, $operation);}

    /**
     * Get subworkflow27
     * @return int
     */
    public function getSubworkflow27() { return $this->getField('subworkflow27');}

    /**
     * Set subworkflow27
     * @param int $subworkflow27
     */
    public function setSubworkflow27($subworkflow27, $update = false) {$this->setField('subworkflow27', $subworkflow27, $update);}

    /**
     * Filter subworkflow27
     * @param int $subworkflow27
     * @param string $operation
     */
    public function filterSubworkflow27($subworkflow27, $operation = false) {$this->filterField('subworkflow27', $subworkflow27, $operation);}

    /**
     * Get subworkflow27name
     * @return string
     */
    public function getSubworkflow27name() { return $this->getField('subworkflow27name');}

    /**
     * Set subworkflow27name
     * @param string $subworkflow27name
     */
    public function setSubworkflow27name($subworkflow27name, $update = false) {$this->setField('subworkflow27name', $subworkflow27name, $update);}

    /**
     * Filter subworkflow27name
     * @param string $subworkflow27name
     * @param string $operation
     */
    public function filterSubworkflow27name($subworkflow27name, $operation = false) {$this->filterField('subworkflow27name', $subworkflow27name, $operation);}

    /**
     * Get subworkflow27date
     * @return int
     */
    public function getSubworkflow27date() { return $this->getField('subworkflow27date');}

    /**
     * Set subworkflow27date
     * @param int $subworkflow27date
     */
    public function setSubworkflow27date($subworkflow27date, $update = false) {$this->setField('subworkflow27date', $subworkflow27date, $update);}

    /**
     * Filter subworkflow27date
     * @param int $subworkflow27date
     * @param string $operation
     */
    public function filterSubworkflow27date($subworkflow27date, $operation = false) {$this->filterField('subworkflow27date', $subworkflow27date, $operation);}

    /**
     * Get subworkflow27description
     * @return string
     */
    public function getSubworkflow27description() { return $this->getField('subworkflow27description');}

    /**
     * Set subworkflow27description
     * @param string $subworkflow27description
     */
    public function setSubworkflow27description($subworkflow27description, $update = false) {$this->setField('subworkflow27description', $subworkflow27description, $update);}

    /**
     * Filter subworkflow27description
     * @param string $subworkflow27description
     * @param string $operation
     */
    public function filterSubworkflow27description($subworkflow27description, $operation = false) {$this->filterField('subworkflow27description', $subworkflow27description, $operation);}

    /**
     * Get subworkflow28
     * @return int
     */
    public function getSubworkflow28() { return $this->getField('subworkflow28');}

    /**
     * Set subworkflow28
     * @param int $subworkflow28
     */
    public function setSubworkflow28($subworkflow28, $update = false) {$this->setField('subworkflow28', $subworkflow28, $update);}

    /**
     * Filter subworkflow28
     * @param int $subworkflow28
     * @param string $operation
     */
    public function filterSubworkflow28($subworkflow28, $operation = false) {$this->filterField('subworkflow28', $subworkflow28, $operation);}

    /**
     * Get subworkflow28name
     * @return string
     */
    public function getSubworkflow28name() { return $this->getField('subworkflow28name');}

    /**
     * Set subworkflow28name
     * @param string $subworkflow28name
     */
    public function setSubworkflow28name($subworkflow28name, $update = false) {$this->setField('subworkflow28name', $subworkflow28name, $update);}

    /**
     * Filter subworkflow28name
     * @param string $subworkflow28name
     * @param string $operation
     */
    public function filterSubworkflow28name($subworkflow28name, $operation = false) {$this->filterField('subworkflow28name', $subworkflow28name, $operation);}

    /**
     * Get subworkflow28date
     * @return int
     */
    public function getSubworkflow28date() { return $this->getField('subworkflow28date');}

    /**
     * Set subworkflow28date
     * @param int $subworkflow28date
     */
    public function setSubworkflow28date($subworkflow28date, $update = false) {$this->setField('subworkflow28date', $subworkflow28date, $update);}

    /**
     * Filter subworkflow28date
     * @param int $subworkflow28date
     * @param string $operation
     */
    public function filterSubworkflow28date($subworkflow28date, $operation = false) {$this->filterField('subworkflow28date', $subworkflow28date, $operation);}

    /**
     * Get subworkflow28description
     * @return string
     */
    public function getSubworkflow28description() { return $this->getField('subworkflow28description');}

    /**
     * Set subworkflow28description
     * @param string $subworkflow28description
     */
    public function setSubworkflow28description($subworkflow28description, $update = false) {$this->setField('subworkflow28description', $subworkflow28description, $update);}

    /**
     * Filter subworkflow28description
     * @param string $subworkflow28description
     * @param string $operation
     */
    public function filterSubworkflow28description($subworkflow28description, $operation = false) {$this->filterField('subworkflow28description', $subworkflow28description, $operation);}

    /**
     * Get subworkflow29
     * @return int
     */
    public function getSubworkflow29() { return $this->getField('subworkflow29');}

    /**
     * Set subworkflow29
     * @param int $subworkflow29
     */
    public function setSubworkflow29($subworkflow29, $update = false) {$this->setField('subworkflow29', $subworkflow29, $update);}

    /**
     * Filter subworkflow29
     * @param int $subworkflow29
     * @param string $operation
     */
    public function filterSubworkflow29($subworkflow29, $operation = false) {$this->filterField('subworkflow29', $subworkflow29, $operation);}

    /**
     * Get subworkflow29name
     * @return string
     */
    public function getSubworkflow29name() { return $this->getField('subworkflow29name');}

    /**
     * Set subworkflow29name
     * @param string $subworkflow29name
     */
    public function setSubworkflow29name($subworkflow29name, $update = false) {$this->setField('subworkflow29name', $subworkflow29name, $update);}

    /**
     * Filter subworkflow29name
     * @param string $subworkflow29name
     * @param string $operation
     */
    public function filterSubworkflow29name($subworkflow29name, $operation = false) {$this->filterField('subworkflow29name', $subworkflow29name, $operation);}

    /**
     * Get subworkflow29date
     * @return int
     */
    public function getSubworkflow29date() { return $this->getField('subworkflow29date');}

    /**
     * Set subworkflow29date
     * @param int $subworkflow29date
     */
    public function setSubworkflow29date($subworkflow29date, $update = false) {$this->setField('subworkflow29date', $subworkflow29date, $update);}

    /**
     * Filter subworkflow29date
     * @param int $subworkflow29date
     * @param string $operation
     */
    public function filterSubworkflow29date($subworkflow29date, $operation = false) {$this->filterField('subworkflow29date', $subworkflow29date, $operation);}

    /**
     * Get subworkflow29description
     * @return string
     */
    public function getSubworkflow29description() { return $this->getField('subworkflow29description');}

    /**
     * Set subworkflow29description
     * @param string $subworkflow29description
     */
    public function setSubworkflow29description($subworkflow29description, $update = false) {$this->setField('subworkflow29description', $subworkflow29description, $update);}

    /**
     * Filter subworkflow29description
     * @param string $subworkflow29description
     * @param string $operation
     */
    public function filterSubworkflow29description($subworkflow29description, $operation = false) {$this->filterField('subworkflow29description', $subworkflow29description, $operation);}

    /**
     * Get subworkflow30
     * @return int
     */
    public function getSubworkflow30() { return $this->getField('subworkflow30');}

    /**
     * Set subworkflow30
     * @param int $subworkflow30
     */
    public function setSubworkflow30($subworkflow30, $update = false) {$this->setField('subworkflow30', $subworkflow30, $update);}

    /**
     * Filter subworkflow30
     * @param int $subworkflow30
     * @param string $operation
     */
    public function filterSubworkflow30($subworkflow30, $operation = false) {$this->filterField('subworkflow30', $subworkflow30, $operation);}

    /**
     * Get subworkflow30name
     * @return string
     */
    public function getSubworkflow30name() { return $this->getField('subworkflow30name');}

    /**
     * Set subworkflow30name
     * @param string $subworkflow30name
     */
    public function setSubworkflow30name($subworkflow30name, $update = false) {$this->setField('subworkflow30name', $subworkflow30name, $update);}

    /**
     * Filter subworkflow30name
     * @param string $subworkflow30name
     * @param string $operation
     */
    public function filterSubworkflow30name($subworkflow30name, $operation = false) {$this->filterField('subworkflow30name', $subworkflow30name, $operation);}

    /**
     * Get subworkflow30date
     * @return int
     */
    public function getSubworkflow30date() { return $this->getField('subworkflow30date');}

    /**
     * Set subworkflow30date
     * @param int $subworkflow30date
     */
    public function setSubworkflow30date($subworkflow30date, $update = false) {$this->setField('subworkflow30date', $subworkflow30date, $update);}

    /**
     * Filter subworkflow30date
     * @param int $subworkflow30date
     * @param string $operation
     */
    public function filterSubworkflow30date($subworkflow30date, $operation = false) {$this->filterField('subworkflow30date', $subworkflow30date, $operation);}

    /**
     * Get subworkflow30description
     * @return string
     */
    public function getSubworkflow30description() { return $this->getField('subworkflow30description');}

    /**
     * Set subworkflow30description
     * @param string $subworkflow30description
     */
    public function setSubworkflow30description($subworkflow30description, $update = false) {$this->setField('subworkflow30description', $subworkflow30description, $update);}

    /**
     * Filter subworkflow30description
     * @param string $subworkflow30description
     * @param string $operation
     */
    public function filterSubworkflow30description($subworkflow30description, $operation = false) {$this->filterField('subworkflow30description', $subworkflow30description, $operation);}

    /**
     * Get autonextstatusid
     * @return int
     */
    public function getAutonextstatusid() { return $this->getField('autonextstatusid');}

    /**
     * Set autonextstatusid
     * @param int $autonextstatusid
     */
    public function setAutonextstatusid($autonextstatusid, $update = false) {$this->setField('autonextstatusid', $autonextstatusid, $update);}

    /**
     * Filter autonextstatusid
     * @param int $autonextstatusid
     * @param string $operation
     */
    public function filterAutonextstatusid($autonextstatusid, $operation = false) {$this->filterField('autonextstatusid', $autonextstatusid, $operation);}

    /**
     * Get no_communication
     * @return int
     */
    public function getNo_communication() { return $this->getField('no_communication');}

    /**
     * Set no_communication
     * @param int $no_communication
     */
    public function setNo_communication($no_communication, $update = false) {$this->setField('no_communication', $no_communication, $update);}

    /**
     * Filter no_communication
     * @param int $no_communication
     * @param string $operation
     */
    public function filterNo_communication($no_communication, $operation = false) {$this->filterField('no_communication', $no_communication, $operation);}

    /**
     * Get no_communication_call
     * @return int
     */
    public function getNo_communication_call() { return $this->getField('no_communication_call');}

    /**
     * Set no_communication_call
     * @param int $no_communication_call
     */
    public function setNo_communication_call($no_communication_call, $update = false) {$this->setField('no_communication_call', $no_communication_call, $update);}

    /**
     * Filter no_communication_call
     * @param int $no_communication_call
     * @param string $operation
     */
    public function filterNo_communication_call($no_communication_call, $operation = false) {$this->filterField('no_communication_call', $no_communication_call, $operation);}

    /**
     * Get no_communication_email
     * @return int
     */
    public function getNo_communication_email() { return $this->getField('no_communication_email');}

    /**
     * Set no_communication_email
     * @param int $no_communication_email
     */
    public function setNo_communication_email($no_communication_email, $update = false) {$this->setField('no_communication_email', $no_communication_email, $update);}

    /**
     * Filter no_communication_email
     * @param int $no_communication_email
     * @param string $operation
     */
    public function filterNo_communication_email($no_communication_email, $operation = false) {$this->filterField('no_communication_email', $no_communication_email, $operation);}

    /**
     * Get nextdate
     * @return string
     */
    public function getNextdate() { return $this->getField('nextdate');}

    /**
     * Set nextdate
     * @param string $nextdate
     */
    public function setNextdate($nextdate, $update = false) {$this->setField('nextdate', $nextdate, $update);}

    /**
     * Filter nextdate
     * @param string $nextdate
     * @param string $operation
     */
    public function filterNextdate($nextdate, $operation = false) {$this->filterField('nextdate', $nextdate, $operation);}

    /**
     * Get storage_incoming
     * @return int
     */
    public function getStorage_incoming() { return $this->getField('storage_incoming');}

    /**
     * Set storage_incoming
     * @param int $storage_incoming
     */
    public function setStorage_incoming($storage_incoming, $update = false) {$this->setField('storage_incoming', $storage_incoming, $update);}

    /**
     * Filter storage_incoming
     * @param int $storage_incoming
     * @param string $operation
     */
    public function filterStorage_incoming($storage_incoming, $operation = false) {$this->filterField('storage_incoming', $storage_incoming, $operation);}

    /**
     * Get storagenameid_incoming
     * @return int
     */
    public function getStoragenameid_incoming() { return $this->getField('storagenameid_incoming');}

    /**
     * Set storagenameid_incoming
     * @param int $storagenameid_incoming
     */
    public function setStoragenameid_incoming($storagenameid_incoming, $update = false) {$this->setField('storagenameid_incoming', $storagenameid_incoming, $update);}

    /**
     * Filter storagenameid_incoming
     * @param int $storagenameid_incoming
     * @param string $operation
     */
    public function filterStoragenameid_incoming($storagenameid_incoming, $operation = false) {$this->filterField('storagenameid_incoming', $storagenameid_incoming, $operation);}

    /**
     * Get storage_sale
     * @return int
     */
    public function getStorage_sale() { return $this->getField('storage_sale');}

    /**
     * Set storage_sale
     * @param int $storage_sale
     */
    public function setStorage_sale($storage_sale, $update = false) {$this->setField('storage_sale', $storage_sale, $update);}

    /**
     * Filter storage_sale
     * @param int $storage_sale
     * @param string $operation
     */
    public function filterStorage_sale($storage_sale, $operation = false) {$this->filterField('storage_sale', $storage_sale, $operation);}

    /**
     * Get storage_reserve
     * @return int
     */
    public function getStorage_reserve() { return $this->getField('storage_reserve');}

    /**
     * Set storage_reserve
     * @param int $storage_reserve
     */
    public function setStorage_reserve($storage_reserve, $update = false) {$this->setField('storage_reserve', $storage_reserve, $update);}

    /**
     * Filter storage_reserve
     * @param int $storage_reserve
     * @param string $operation
     */
    public function filterStorage_reserve($storage_reserve, $operation = false) {$this->filterField('storage_reserve', $storage_reserve, $operation);}

    /**
     * Get storage_unreserve
     * @return int
     */
    public function getStorage_unreserve() { return $this->getField('storage_unreserve');}

    /**
     * Set storage_unreserve
     * @param int $storage_unreserve
     */
    public function setStorage_unreserve($storage_unreserve, $update = false) {$this->setField('storage_unreserve', $storage_unreserve, $update);}

    /**
     * Filter storage_unreserve
     * @param int $storage_unreserve
     * @param string $operation
     */
    public function filterStorage_unreserve($storage_unreserve, $operation = false) {$this->filterField('storage_unreserve', $storage_unreserve, $operation);}

    /**
     * Get storage_return
     * @return int
     */
    public function getStorage_return() { return $this->getField('storage_return');}

    /**
     * Set storage_return
     * @param int $storage_return
     */
    public function setStorage_return($storage_return, $update = false) {$this->setField('storage_return', $storage_return, $update);}

    /**
     * Filter storage_return
     * @param int $storage_return
     * @param string $operation
     */
    public function filterStorage_return($storage_return, $operation = false) {$this->filterField('storage_return', $storage_return, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoporderstatus');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderStatus
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderStatus
     */
    public static function Get($key) {return self::GetObject("XShopOrderStatus", $key);}

}

SQLObject::SetFieldArray('shoporderstatus', array('id', 'name', 'message', 'messageadmin', 'sms', 'smsadmin', 'smslogicclass', 'default', 'payed', 'saled', 'downloadable', 'sort', 'priority', 'linkkey', 'categoryid', 'content', 'x', 'y', 'width', 'height', 'colour', 'term', 'termperiod', 'processor', 'processorform', 'roleid', 'managerid', 'cnt', 'cntlast', 'onlyauto', 'onlyissue', 'jumpmanager', 'prepayed', 'notifysmsclient', 'notifysmsadmin', 'notifysmsmanager', 'notifyemailclient', 'notifyemailadmin', 'notifyemailmanager', 'needcontent', 'needdocument', 'closed', 'done', 'shipped', 'cancelOrderSupplier', 'createOrderSupplier', 'createXml', 'createCsv', 'autorepeat', 'nextworkflowid', 'nextstatusid', 'subworkflow1', 'subworkflow1name', 'subworkflow1date', 'subworkflow1description', 'subworkflow2', 'subworkflow2name', 'subworkflow2date', 'subworkflow2description', 'subworkflow3', 'subworkflow3name', 'subworkflow3date', 'subworkflow3description', 'subworkflow4', 'subworkflow4name', 'subworkflow4date', 'subworkflow4description', 'subworkflow5', 'subworkflow5name', 'subworkflow5date', 'subworkflow5description', 'subworkflow6', 'subworkflow6name', 'subworkflow6date', 'subworkflow6description', 'subworkflow7', 'subworkflow7name', 'subworkflow7date', 'subworkflow7description', 'subworkflow8', 'subworkflow8name', 'subworkflow8date', 'subworkflow8description', 'subworkflow9', 'subworkflow9name', 'subworkflow9date', 'subworkflow9description', 'subworkflow10', 'subworkflow10name', 'subworkflow10date', 'subworkflow10description', 'subworkflow11', 'subworkflow11name', 'subworkflow11date', 'subworkflow11description', 'subworkflow12', 'subworkflow12name', 'subworkflow12date', 'subworkflow12description', 'subworkflow13', 'subworkflow13name', 'subworkflow13date', 'subworkflow13description', 'subworkflow14', 'subworkflow14name', 'subworkflow14date', 'subworkflow14description', 'subworkflow15', 'subworkflow15name', 'subworkflow15date', 'subworkflow15description', 'subworkflow16', 'subworkflow16name', 'subworkflow16date', 'subworkflow16description', 'subworkflow17', 'subworkflow17name', 'subworkflow17date', 'subworkflow17description', 'subworkflow18', 'subworkflow18name', 'subworkflow18date', 'subworkflow18description', 'subworkflow19', 'subworkflow19name', 'subworkflow19date', 'subworkflow19description', 'subworkflow20', 'subworkflow20name', 'subworkflow20date', 'subworkflow20description', 'subworkflow21', 'subworkflow21name', 'subworkflow21date', 'subworkflow21description', 'subworkflow22', 'subworkflow22name', 'subworkflow22date', 'subworkflow22description', 'subworkflow23', 'subworkflow23name', 'subworkflow23date', 'subworkflow23description', 'subworkflow24', 'subworkflow24name', 'subworkflow24date', 'subworkflow24description', 'subworkflow25', 'subworkflow25name', 'subworkflow25date', 'subworkflow25description', 'subworkflow26', 'subworkflow26name', 'subworkflow26date', 'subworkflow26description', 'subworkflow27', 'subworkflow27name', 'subworkflow27date', 'subworkflow27description', 'subworkflow28', 'subworkflow28name', 'subworkflow28date', 'subworkflow28description', 'subworkflow29', 'subworkflow29name', 'subworkflow29date', 'subworkflow29description', 'subworkflow30', 'subworkflow30name', 'subworkflow30date', 'subworkflow30description', 'autonextstatusid', 'no_communication', 'no_communication_call', 'no_communication_email', 'nextdate', 'storage_incoming', 'storagenameid_incoming', 'storage_sale', 'storage_reserve', 'storage_unreserve', 'storage_return'));
SQLObject::SetPrimaryKey('shoporderstatus', 'id');
