<?php
/**
 * Class XUser is ORM to table users
 * @author SQLObject
 * @package SQLObject
 */
class XUser extends SQLObject {

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
     * Get login
     * @return string
     */
    public function getLogin() { return $this->getField('login');}

    /**
     * Set login
     * @param string $login
     */
    public function setLogin($login, $update = false) {$this->setField('login', $login, $update);}

    /**
     * Filter login
     * @param string $login
     * @param string $operation
     */
    public function filterLogin($login, $operation = false) {$this->filterField('login', $login, $operation);}

    /**
     * Get password
     * @return string
     */
    public function getPassword() { return $this->getField('password');}

    /**
     * Set password
     * @param string $password
     */
    public function setPassword($password, $update = false) {$this->setField('password', $password, $update);}

    /**
     * Filter password
     * @param string $password
     * @param string $operation
     */
    public function filterPassword($password, $operation = false) {$this->filterField('password', $password, $operation);}

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
     * Get email
     * @return string
     */
    public function getEmail() { return $this->getField('email');}

    /**
     * Set email
     * @param string $email
     */
    public function setEmail($email, $update = false) {$this->setField('email', $email, $update);}

    /**
     * Filter email
     * @param string $email
     * @param string $operation
     */
    public function filterEmail($email, $operation = false) {$this->filterField('email', $email, $operation);}

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
     * Get namelast
     * @return string
     */
    public function getNamelast() { return $this->getField('namelast');}

    /**
     * Set namelast
     * @param string $namelast
     */
    public function setNamelast($namelast, $update = false) {$this->setField('namelast', $namelast, $update);}

    /**
     * Filter namelast
     * @param string $namelast
     * @param string $operation
     */
    public function filterNamelast($namelast, $operation = false) {$this->filterField('namelast', $namelast, $operation);}

    /**
     * Get namemiddle
     * @return string
     */
    public function getNamemiddle() { return $this->getField('namemiddle');}

    /**
     * Set namemiddle
     * @param string $namemiddle
     */
    public function setNamemiddle($namemiddle, $update = false) {$this->setField('namemiddle', $namemiddle, $update);}

    /**
     * Filter namemiddle
     * @param string $namemiddle
     * @param string $operation
     */
    public function filterNamemiddle($namemiddle, $operation = false) {$this->filterField('namemiddle', $namemiddle, $operation);}

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
     * Get phone
     * @return string
     */
    public function getPhone() { return $this->getField('phone');}

    /**
     * Set phone
     * @param string $phone
     */
    public function setPhone($phone, $update = false) {$this->setField('phone', $phone, $update);}

    /**
     * Filter phone
     * @param string $phone
     * @param string $operation
     */
    public function filterPhone($phone, $operation = false) {$this->filterField('phone', $phone, $operation);}

    /**
     * Get phones
     * @return string
     */
    public function getPhones() { return $this->getField('phones');}

    /**
     * Set phones
     * @param string $phones
     */
    public function setPhones($phones, $update = false) {$this->setField('phones', $phones, $update);}

    /**
     * Filter phones
     * @param string $phones
     * @param string $operation
     */
    public function filterPhones($phones, $operation = false) {$this->filterField('phones', $phones, $operation);}

    /**
     * Get address
     * @return string
     */
    public function getAddress() { return $this->getField('address');}

    /**
     * Set address
     * @param string $address
     */
    public function setAddress($address, $update = false) {$this->setField('address', $address, $update);}

    /**
     * Filter address
     * @param string $address
     * @param string $operation
     */
    public function filterAddress($address, $operation = false) {$this->filterField('address', $address, $operation);}

    /**
     * Get bdate
     * @return string
     */
    public function getBdate() { return $this->getField('bdate');}

    /**
     * Set bdate
     * @param string $bdate
     */
    public function setBdate($bdate, $update = false) {$this->setField('bdate', $bdate, $update);}

    /**
     * Filter bdate
     * @param string $bdate
     * @param string $operation
     */
    public function filterBdate($bdate, $operation = false) {$this->filterField('bdate', $bdate, $operation);}

    /**
     * Get urls
     * @return string
     */
    public function getUrls() { return $this->getField('urls');}

    /**
     * Set urls
     * @param string $urls
     */
    public function setUrls($urls, $update = false) {$this->setField('urls', $urls, $update);}

    /**
     * Filter urls
     * @param string $urls
     * @param string $operation
     */
    public function filterUrls($urls, $operation = false) {$this->filterField('urls', $urls, $operation);}

    /**
     * Get emails
     * @return string
     */
    public function getEmails() { return $this->getField('emails');}

    /**
     * Set emails
     * @param string $emails
     */
    public function setEmails($emails, $update = false) {$this->setField('emails', $emails, $update);}

    /**
     * Filter emails
     * @param string $emails
     * @param string $operation
     */
    public function filterEmails($emails, $operation = false) {$this->filterField('emails', $emails, $operation);}

    /**
     * Get skype
     * @return string
     */
    public function getSkype() { return $this->getField('skype');}

    /**
     * Set skype
     * @param string $skype
     */
    public function setSkype($skype, $update = false) {$this->setField('skype', $skype, $update);}

    /**
     * Filter skype
     * @param string $skype
     * @param string $operation
     */
    public function filterSkype($skype, $operation = false) {$this->filterField('skype', $skype, $operation);}

    /**
     * Get jabber
     * @return string
     */
    public function getJabber() { return $this->getField('jabber');}

    /**
     * Set jabber
     * @param string $jabber
     */
    public function setJabber($jabber, $update = false) {$this->setField('jabber', $jabber, $update);}

    /**
     * Filter jabber
     * @param string $jabber
     * @param string $operation
     */
    public function filterJabber($jabber, $operation = false) {$this->filterField('jabber', $jabber, $operation);}

    /**
     * Get whatsapp
     * @return string
     */
    public function getWhatsapp() { return $this->getField('whatsapp');}

    /**
     * Set whatsapp
     * @param string $whatsapp
     */
    public function setWhatsapp($whatsapp, $update = false) {$this->setField('whatsapp', $whatsapp, $update);}

    /**
     * Filter whatsapp
     * @param string $whatsapp
     * @param string $operation
     */
    public function filterWhatsapp($whatsapp, $operation = false) {$this->filterField('whatsapp', $whatsapp, $operation);}

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
     * Get time
     * @return string
     */
    public function getTime() { return $this->getField('time');}

    /**
     * Set time
     * @param string $time
     */
    public function setTime($time, $update = false) {$this->setField('time', $time, $update);}

    /**
     * Filter time
     * @param string $time
     * @param string $operation
     */
    public function filterTime($time, $operation = false) {$this->filterField('time', $time, $operation);}

    /**
     * Get commentadmin
     * @return string
     */
    public function getCommentadmin() { return $this->getField('commentadmin');}

    /**
     * Set commentadmin
     * @param string $commentadmin
     */
    public function setCommentadmin($commentadmin, $update = false) {$this->setField('commentadmin', $commentadmin, $update);}

    /**
     * Filter commentadmin
     * @param string $commentadmin
     * @param string $operation
     */
    public function filterCommentadmin($commentadmin, $operation = false) {$this->filterField('commentadmin', $commentadmin, $operation);}

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
     * Get company
     * @return string
     */
    public function getCompany() { return $this->getField('company');}

    /**
     * Set company
     * @param string $company
     */
    public function setCompany($company, $update = false) {$this->setField('company', $company, $update);}

    /**
     * Filter company
     * @param string $company
     * @param string $operation
     */
    public function filterCompany($company, $operation = false) {$this->filterField('company', $company, $operation);}

    /**
     * Get post
     * @return string
     */
    public function getPost() { return $this->getField('post');}

    /**
     * Set post
     * @param string $post
     */
    public function setPost($post, $update = false) {$this->setField('post', $post, $update);}

    /**
     * Filter post
     * @param string $post
     * @param string $operation
     */
    public function filterPost($post, $operation = false) {$this->filterField('post', $post, $operation);}

    /**
     * Get groupid
     * @return int
     */
    public function getGroupid() { return $this->getField('groupid');}

    /**
     * Set groupid
     * @param int $groupid
     */
    public function setGroupid($groupid, $update = false) {$this->setField('groupid', $groupid, $update);}

    /**
     * Filter groupid
     * @param int $groupid
     * @param string $operation
     */
    public function filterGroupid($groupid, $operation = false) {$this->filterField('groupid', $groupid, $operation);}

    /**
     * Get pricelevel
     * @return int
     */
    public function getPricelevel() { return $this->getField('pricelevel');}

    /**
     * Set pricelevel
     * @param int $pricelevel
     */
    public function setPricelevel($pricelevel, $update = false) {$this->setField('pricelevel', $pricelevel, $update);}

    /**
     * Filter pricelevel
     * @param int $pricelevel
     * @param string $operation
     */
    public function filterPricelevel($pricelevel, $operation = false) {$this->filterField('pricelevel', $pricelevel, $operation);}

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
     * Get activatecode
     * @return string
     */
    public function getActivatecode() { return $this->getField('activatecode');}

    /**
     * Set activatecode
     * @param string $activatecode
     */
    public function setActivatecode($activatecode, $update = false) {$this->setField('activatecode', $activatecode, $update);}

    /**
     * Filter activatecode
     * @param string $activatecode
     * @param string $operation
     */
    public function filterActivatecode($activatecode, $operation = false) {$this->filterField('activatecode', $activatecode, $operation);}

    /**
     * Get distribution
     * @return int
     */
    public function getDistribution() { return $this->getField('distribution');}

    /**
     * Set distribution
     * @param int $distribution
     */
    public function setDistribution($distribution, $update = false) {$this->setField('distribution', $distribution, $update);}

    /**
     * Filter distribution
     * @param int $distribution
     * @param string $operation
     */
    public function filterDistribution($distribution, $operation = false) {$this->filterField('distribution', $distribution, $operation);}

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
     * Get edate
     * @return string
     */
    public function getEdate() { return $this->getField('edate');}

    /**
     * Set edate
     * @param string $edate
     */
    public function setEdate($edate, $update = false) {$this->setField('edate', $edate, $update);}

    /**
     * Filter edate
     * @param string $edate
     * @param string $operation
     */
    public function filterEdate($edate, $operation = false) {$this->filterField('edate', $edate, $operation);}

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
     * Get typesex
     * @return string
     */
    public function getTypesex() { return $this->getField('typesex');}

    /**
     * Set typesex
     * @param string $typesex
     */
    public function setTypesex($typesex, $update = false) {$this->setField('typesex', $typesex, $update);}

    /**
     * Filter typesex
     * @param string $typesex
     * @param string $operation
     */
    public function filterTypesex($typesex, $operation = false) {$this->filterField('typesex', $typesex, $operation);}

    /**
     * Get activitydate
     * @return string
     */
    public function getActivitydate() { return $this->getField('activitydate');}

    /**
     * Set activitydate
     * @param string $activitydate
     */
    public function setActivitydate($activitydate, $update = false) {$this->setField('activitydate', $activitydate, $update);}

    /**
     * Filter activitydate
     * @param string $activitydate
     * @param string $operation
     */
    public function filterActivitydate($activitydate, $operation = false) {$this->filterField('activitydate', $activitydate, $operation);}

    /**
     * Get activitydatein
     * @return string
     */
    public function getActivitydatein() { return $this->getField('activitydatein');}

    /**
     * Set activitydatein
     * @param string $activitydatein
     */
    public function setActivitydatein($activitydatein, $update = false) {$this->setField('activitydatein', $activitydatein, $update);}

    /**
     * Filter activitydatein
     * @param string $activitydatein
     * @param string $operation
     */
    public function filterActivitydatein($activitydatein, $operation = false) {$this->filterField('activitydatein', $activitydatein, $operation);}

    /**
     * Get activitydateout
     * @return string
     */
    public function getActivitydateout() { return $this->getField('activitydateout');}

    /**
     * Set activitydateout
     * @param string $activitydateout
     */
    public function setActivitydateout($activitydateout, $update = false) {$this->setField('activitydateout', $activitydateout, $update);}

    /**
     * Filter activitydateout
     * @param string $activitydateout
     * @param string $operation
     */
    public function filterActivitydateout($activitydateout, $operation = false) {$this->filterField('activitydateout', $activitydateout, $operation);}

    /**
     * Get employer
     * @return int
     */
    public function getEmployer() { return $this->getField('employer');}

    /**
     * Set employer
     * @param int $employer
     */
    public function setEmployer($employer, $update = false) {$this->setField('employer', $employer, $update);}

    /**
     * Filter employer
     * @param int $employer
     * @param string $operation
     */
    public function filterEmployer($employer, $operation = false) {$this->filterField('employer', $employer, $operation);}

    /**
     * Get allowreferal
     * @return int
     */
    public function getAllowreferal() { return $this->getField('allowreferal');}

    /**
     * Set allowreferal
     * @param int $allowreferal
     */
    public function setAllowreferal($allowreferal, $update = false) {$this->setField('allowreferal', $allowreferal, $update);}

    /**
     * Filter allowreferal
     * @param int $allowreferal
     * @param string $operation
     */
    public function filterAllowreferal($allowreferal, $operation = false) {$this->filterField('allowreferal', $allowreferal, $operation);}

    /**
     * Get utm_source
     * @return string
     */
    public function getUtm_source() { return $this->getField('utm_source');}

    /**
     * Set utm_source
     * @param string $utm_source
     */
    public function setUtm_source($utm_source, $update = false) {$this->setField('utm_source', $utm_source, $update);}

    /**
     * Filter utm_source
     * @param string $utm_source
     * @param string $operation
     */
    public function filterUtm_source($utm_source, $operation = false) {$this->filterField('utm_source', $utm_source, $operation);}

    /**
     * Get utm_medium
     * @return string
     */
    public function getUtm_medium() { return $this->getField('utm_medium');}

    /**
     * Set utm_medium
     * @param string $utm_medium
     */
    public function setUtm_medium($utm_medium, $update = false) {$this->setField('utm_medium', $utm_medium, $update);}

    /**
     * Filter utm_medium
     * @param string $utm_medium
     * @param string $operation
     */
    public function filterUtm_medium($utm_medium, $operation = false) {$this->filterField('utm_medium', $utm_medium, $operation);}

    /**
     * Get utm_campaign
     * @return string
     */
    public function getUtm_campaign() { return $this->getField('utm_campaign');}

    /**
     * Set utm_campaign
     * @param string $utm_campaign
     */
    public function setUtm_campaign($utm_campaign, $update = false) {$this->setField('utm_campaign', $utm_campaign, $update);}

    /**
     * Filter utm_campaign
     * @param string $utm_campaign
     * @param string $operation
     */
    public function filterUtm_campaign($utm_campaign, $operation = false) {$this->filterField('utm_campaign', $utm_campaign, $operation);}

    /**
     * Get utm_content
     * @return string
     */
    public function getUtm_content() { return $this->getField('utm_content');}

    /**
     * Set utm_content
     * @param string $utm_content
     */
    public function setUtm_content($utm_content, $update = false) {$this->setField('utm_content', $utm_content, $update);}

    /**
     * Filter utm_content
     * @param string $utm_content
     * @param string $operation
     */
    public function filterUtm_content($utm_content, $operation = false) {$this->filterField('utm_content', $utm_content, $operation);}

    /**
     * Get utm_term
     * @return string
     */
    public function getUtm_term() { return $this->getField('utm_term');}

    /**
     * Set utm_term
     * @param string $utm_term
     */
    public function setUtm_term($utm_term, $update = false) {$this->setField('utm_term', $utm_term, $update);}

    /**
     * Filter utm_term
     * @param string $utm_term
     * @param string $operation
     */
    public function filterUtm_term($utm_term, $operation = false) {$this->filterField('utm_term', $utm_term, $operation);}

    /**
     * Get utm_date
     * @return string
     */
    public function getUtm_date() { return $this->getField('utm_date');}

    /**
     * Set utm_date
     * @param string $utm_date
     */
    public function setUtm_date($utm_date, $update = false) {$this->setField('utm_date', $utm_date, $update);}

    /**
     * Filter utm_date
     * @param string $utm_date
     * @param string $operation
     */
    public function filterUtm_date($utm_date, $operation = false) {$this->filterField('utm_date', $utm_date, $operation);}

    /**
     * Get utm_referrer
     * @return string
     */
    public function getUtm_referrer() { return $this->getField('utm_referrer');}

    /**
     * Set utm_referrer
     * @param string $utm_referrer
     */
    public function setUtm_referrer($utm_referrer, $update = false) {$this->setField('utm_referrer', $utm_referrer, $update);}

    /**
     * Filter utm_referrer
     * @param string $utm_referrer
     * @param string $operation
     */
    public function filterUtm_referrer($utm_referrer, $operation = false) {$this->filterField('utm_referrer', $utm_referrer, $operation);}

    /**
     * Get identifier
     * @return string
     */
    public function getIdentifier() { return $this->getField('identifier');}

    /**
     * Set identifier
     * @param string $identifier
     */
    public function setIdentifier($identifier, $update = false) {$this->setField('identifier', $identifier, $update);}

    /**
     * Filter identifier
     * @param string $identifier
     * @param string $operation
     */
    public function filterIdentifier($identifier, $operation = false) {$this->filterField('identifier', $identifier, $operation);}

    /**
     * Get lost_basket
     * @return string
     */
    public function getLost_basket() { return $this->getField('lost_basket');}

    /**
     * Set lost_basket
     * @param string $lost_basket
     */
    public function setLost_basket($lost_basket, $update = false) {$this->setField('lost_basket', $lost_basket, $update);}

    /**
     * Filter lost_basket
     * @param string $lost_basket
     * @param string $operation
     */
    public function filterLost_basket($lost_basket, $operation = false) {$this->filterField('lost_basket', $lost_basket, $operation);}

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
     * Get worktimesystem
     * @return int
     */
    public function getWorktimesystem() { return $this->getField('worktimesystem');}

    /**
     * Set worktimesystem
     * @param int $worktimesystem
     */
    public function setWorktimesystem($worktimesystem, $update = false) {$this->setField('worktimesystem', $worktimesystem, $update);}

    /**
     * Filter worktimesystem
     * @param int $worktimesystem
     * @param string $operation
     */
    public function filterWorktimesystem($worktimesystem, $operation = false) {$this->filterField('worktimesystem', $worktimesystem, $operation);}

    /**
     * Get voipblock
     * @return int
     */
    public function getVoipblock() { return $this->getField('voipblock');}

    /**
     * Set voipblock
     * @param int $voipblock
     */
    public function setVoipblock($voipblock, $update = false) {$this->setField('voipblock', $voipblock, $update);}

    /**
     * Filter voipblock
     * @param int $voipblock
     * @param string $operation
     */
    public function filterVoipblock($voipblock, $operation = false) {$this->filterField('voipblock', $voipblock, $operation);}

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
     * Get notificationblock
     * @return int
     */
    public function getNotificationblock() { return $this->getField('notificationblock');}

    /**
     * Set notificationblock
     * @param int $notificationblock
     */
    public function setNotificationblock($notificationblock, $update = false) {$this->setField('notificationblock', $notificationblock, $update);}

    /**
     * Filter notificationblock
     * @param int $notificationblock
     * @param string $operation
     */
    public function filterNotificationblock($notificationblock, $operation = false) {$this->filterField('notificationblock', $notificationblock, $operation);}

    /**
     * Get lost_basket_date1
     * @return string
     */
    public function getLost_basket_date1() { return $this->getField('lost_basket_date1');}

    /**
     * Set lost_basket_date1
     * @param string $lost_basket_date1
     */
    public function setLost_basket_date1($lost_basket_date1, $update = false) {$this->setField('lost_basket_date1', $lost_basket_date1, $update);}

    /**
     * Filter lost_basket_date1
     * @param string $lost_basket_date1
     * @param string $operation
     */
    public function filterLost_basket_date1($lost_basket_date1, $operation = false) {$this->filterField('lost_basket_date1', $lost_basket_date1, $operation);}

    /**
     * Get lost_basket_date2
     * @return string
     */
    public function getLost_basket_date2() { return $this->getField('lost_basket_date2');}

    /**
     * Set lost_basket_date2
     * @param string $lost_basket_date2
     */
    public function setLost_basket_date2($lost_basket_date2, $update = false) {$this->setField('lost_basket_date2', $lost_basket_date2, $update);}

    /**
     * Filter lost_basket_date2
     * @param string $lost_basket_date2
     * @param string $operation
     */
    public function filterLost_basket_date2($lost_basket_date2, $operation = false) {$this->filterField('lost_basket_date2', $lost_basket_date2, $operation);}

    /**
     * Get lost_basket_date3
     * @return string
     */
    public function getLost_basket_date3() { return $this->getField('lost_basket_date3');}

    /**
     * Set lost_basket_date3
     * @param string $lost_basket_date3
     */
    public function setLost_basket_date3($lost_basket_date3, $update = false) {$this->setField('lost_basket_date3', $lost_basket_date3, $update);}

    /**
     * Filter lost_basket_date3
     * @param string $lost_basket_date3
     * @param string $operation
     */
    public function filterLost_basket_date3($lost_basket_date3, $operation = false) {$this->filterField('lost_basket_date3', $lost_basket_date3, $operation);}

    /**
     * Get lost_basket_date4
     * @return string
     */
    public function getLost_basket_date4() { return $this->getField('lost_basket_date4');}

    /**
     * Set lost_basket_date4
     * @param string $lost_basket_date4
     */
    public function setLost_basket_date4($lost_basket_date4, $update = false) {$this->setField('lost_basket_date4', $lost_basket_date4, $update);}

    /**
     * Filter lost_basket_date4
     * @param string $lost_basket_date4
     * @param string $operation
     */
    public function filterLost_basket_date4($lost_basket_date4, $operation = false) {$this->filterField('lost_basket_date4', $lost_basket_date4, $operation);}

    /**
     * Get lost_basket_date5
     * @return string
     */
    public function getLost_basket_date5() { return $this->getField('lost_basket_date5');}

    /**
     * Set lost_basket_date5
     * @param string $lost_basket_date5
     */
    public function setLost_basket_date5($lost_basket_date5, $update = false) {$this->setField('lost_basket_date5', $lost_basket_date5, $update);}

    /**
     * Filter lost_basket_date5
     * @param string $lost_basket_date5
     * @param string $operation
     */
    public function filterLost_basket_date5($lost_basket_date5, $operation = false) {$this->filterField('lost_basket_date5', $lost_basket_date5, $operation);}

    /**
     * Get notify_email_one
     * @return int
     */
    public function getNotify_email_one() { return $this->getField('notify_email_one');}

    /**
     * Set notify_email_one
     * @param int $notify_email_one
     */
    public function setNotify_email_one($notify_email_one, $update = false) {$this->setField('notify_email_one', $notify_email_one, $update);}

    /**
     * Filter notify_email_one
     * @param int $notify_email_one
     * @param string $operation
     */
    public function filterNotify_email_one($notify_email_one, $operation = false) {$this->filterField('notify_email_one', $notify_email_one, $operation);}

    /**
     * Get notify_email_group
     * @return int
     */
    public function getNotify_email_group() { return $this->getField('notify_email_group');}

    /**
     * Set notify_email_group
     * @param int $notify_email_group
     */
    public function setNotify_email_group($notify_email_group, $update = false) {$this->setField('notify_email_group', $notify_email_group, $update);}

    /**
     * Filter notify_email_group
     * @param int $notify_email_group
     * @param string $operation
     */
    public function filterNotify_email_group($notify_email_group, $operation = false) {$this->filterField('notify_email_group', $notify_email_group, $operation);}

    /**
     * Get notify_sms
     * @return int
     */
    public function getNotify_sms() { return $this->getField('notify_sms');}

    /**
     * Set notify_sms
     * @param int $notify_sms
     */
    public function setNotify_sms($notify_sms, $update = false) {$this->setField('notify_sms', $notify_sms, $update);}

    /**
     * Filter notify_sms
     * @param int $notify_sms
     * @param string $operation
     */
    public function filterNotify_sms($notify_sms, $operation = false) {$this->filterField('notify_sms', $notify_sms, $operation);}

    /**
     * Get controlip
     * @return string
     */
    public function getControlip() { return $this->getField('controlip');}

    /**
     * Set controlip
     * @param string $controlip
     */
    public function setControlip($controlip, $update = false) {$this->setField('controlip', $controlip, $update);}

    /**
     * Filter controlip
     * @param string $controlip
     * @param string $operation
     */
    public function filterControlip($controlip, $operation = false) {$this->filterField('controlip', $controlip, $operation);}

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
        $this->setTablename('users');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XUser
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XUser
     */
    public static function Get($key) {return self::GetObject("XUser", $key);}

}

SQLObject::SetFieldArray('users', array('id', 'login', 'password', 'level', 'cdate', 'email', 'name', 'namelast', 'namemiddle', 'image', 'phone', 'phones', 'address', 'bdate', 'urls', 'emails', 'skype', 'jabber', 'whatsapp', 'parentid', 'time', 'commentadmin', 'managerid', 'company', 'post', 'groupid', 'pricelevel', 'discountid', 'activatecode', 'distribution', 'tags', 'edate', 'udate', 'contractorid', 'sourceid', 'authorid', 'typesex', 'activitydate', 'activitydatein', 'activitydateout', 'employer', 'allowreferal', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'utm_date', 'utm_referrer', 'identifier', 'lost_basket', 'code1c', 'worktimesystem', 'voipblock', 'ip', 'notificationblock', 'lost_basket_date1', 'lost_basket_date2', 'lost_basket_date3', 'lost_basket_date4', 'lost_basket_date5', 'notify_email_one', 'notify_email_group', 'notify_sms', 'controlip', 'deleted'));
SQLObject::SetPrimaryKey('users', 'id');
