<?php
/**
 * Class XShopEventIMAPConfig is ORM to table shopeventimapconfig
 * @author SQLObject
 * @package SQLObject
 */
class XShopEventIMAPConfig extends SQLObject {

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
     * Get host
     * @return string
     */
    public function getHost() { return $this->getField('host');}

    /**
     * Set host
     * @param string $host
     */
    public function setHost($host, $update = false) {$this->setField('host', $host, $update);}

    /**
     * Filter host
     * @param string $host
     * @param string $operation
     */
    public function filterHost($host, $operation = false) {$this->filterField('host', $host, $operation);}

    /**
     * Get port
     * @return int
     */
    public function getPort() { return $this->getField('port');}

    /**
     * Set port
     * @param int $port
     */
    public function setPort($port, $update = false) {$this->setField('port', $port, $update);}

    /**
     * Filter port
     * @param int $port
     * @param string $operation
     */
    public function filterPort($port, $operation = false) {$this->filterField('port', $port, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopeventimapconfig');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopEventIMAPConfig
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopEventIMAPConfig
     */
    public static function Get($key) {return self::GetObject("XShopEventIMAPConfig", $key);}

}

SQLObject::SetFieldArray('shopeventimapconfig', array('id', 'email', 'host', 'port', 'username', 'password'));
SQLObject::SetPrimaryKey('shopeventimapconfig', 'id');
