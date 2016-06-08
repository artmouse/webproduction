<?php
/**
 * Class XShopRole is ORM to table shoprole
 * @author SQLObject
 * @package SQLObject
 */
class XShopRole extends SQLObject {

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
     * Get blockcolor
     * @return string
     */
    public function getBlockcolor() { return $this->getField('blockcolor');}

    /**
     * Set blockcolor
     * @param string $blockcolor
     */
    public function setBlockcolor($blockcolor, $update = false) {$this->setField('blockcolor', $blockcolor, $update);}

    /**
     * Filter blockcolor
     * @param string $blockcolor
     * @param string $operation
     */
    public function filterBlockcolor($blockcolor, $operation = false) {$this->filterField('blockcolor', $blockcolor, $operation);}

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
     * Get kpi1id
     * @return int
     */
    public function getKpi1id() { return $this->getField('kpi1id');}

    /**
     * Set kpi1id
     * @param int $kpi1id
     */
    public function setKpi1id($kpi1id, $update = false) {$this->setField('kpi1id', $kpi1id, $update);}

    /**
     * Filter kpi1id
     * @param int $kpi1id
     * @param string $operation
     */
    public function filterKpi1id($kpi1id, $operation = false) {$this->filterField('kpi1id', $kpi1id, $operation);}

    /**
     * Get kpi1param
     * @return string
     */
    public function getKpi1param() { return $this->getField('kpi1param');}

    /**
     * Set kpi1param
     * @param string $kpi1param
     */
    public function setKpi1param($kpi1param, $update = false) {$this->setField('kpi1param', $kpi1param, $update);}

    /**
     * Filter kpi1param
     * @param string $kpi1param
     * @param string $operation
     */
    public function filterKpi1param($kpi1param, $operation = false) {$this->filterField('kpi1param', $kpi1param, $operation);}

    /**
     * Get kpi1value
     * @return float
     */
    public function getKpi1value() { return $this->getField('kpi1value');}

    /**
     * Set kpi1value
     * @param float $kpi1value
     */
    public function setKpi1value($kpi1value, $update = false) {$this->setField('kpi1value', $kpi1value, $update);}

    /**
     * Filter kpi1value
     * @param float $kpi1value
     * @param string $operation
     */
    public function filterKpi1value($kpi1value, $operation = false) {$this->filterField('kpi1value', $kpi1value, $operation);}

    /**
     * Get salary1workflowid
     * @return int
     */
    public function getSalary1workflowid() { return $this->getField('salary1workflowid');}

    /**
     * Set salary1workflowid
     * @param int $salary1workflowid
     */
    public function setSalary1workflowid($salary1workflowid, $update = false) {$this->setField('salary1workflowid', $salary1workflowid, $update);}

    /**
     * Filter salary1workflowid
     * @param int $salary1workflowid
     * @param string $operation
     */
    public function filterSalary1workflowid($salary1workflowid, $operation = false) {$this->filterField('salary1workflowid', $salary1workflowid, $operation);}

    /**
     * Get salary1koef
     * @return float
     */
    public function getSalary1koef() { return $this->getField('salary1koef');}

    /**
     * Set salary1koef
     * @param float $salary1koef
     */
    public function setSalary1koef($salary1koef, $update = false) {$this->setField('salary1koef', $salary1koef, $update);}

    /**
     * Filter salary1koef
     * @param float $salary1koef
     * @param string $operation
     */
    public function filterSalary1koef($salary1koef, $operation = false) {$this->filterField('salary1koef', $salary1koef, $operation);}

    /**
     * Get kpi2id
     * @return int
     */
    public function getKpi2id() { return $this->getField('kpi2id');}

    /**
     * Set kpi2id
     * @param int $kpi2id
     */
    public function setKpi2id($kpi2id, $update = false) {$this->setField('kpi2id', $kpi2id, $update);}

    /**
     * Filter kpi2id
     * @param int $kpi2id
     * @param string $operation
     */
    public function filterKpi2id($kpi2id, $operation = false) {$this->filterField('kpi2id', $kpi2id, $operation);}

    /**
     * Get kpi2param
     * @return string
     */
    public function getKpi2param() { return $this->getField('kpi2param');}

    /**
     * Set kpi2param
     * @param string $kpi2param
     */
    public function setKpi2param($kpi2param, $update = false) {$this->setField('kpi2param', $kpi2param, $update);}

    /**
     * Filter kpi2param
     * @param string $kpi2param
     * @param string $operation
     */
    public function filterKpi2param($kpi2param, $operation = false) {$this->filterField('kpi2param', $kpi2param, $operation);}

    /**
     * Get kpi2value
     * @return float
     */
    public function getKpi2value() { return $this->getField('kpi2value');}

    /**
     * Set kpi2value
     * @param float $kpi2value
     */
    public function setKpi2value($kpi2value, $update = false) {$this->setField('kpi2value', $kpi2value, $update);}

    /**
     * Filter kpi2value
     * @param float $kpi2value
     * @param string $operation
     */
    public function filterKpi2value($kpi2value, $operation = false) {$this->filterField('kpi2value', $kpi2value, $operation);}

    /**
     * Get salary2workflowid
     * @return int
     */
    public function getSalary2workflowid() { return $this->getField('salary2workflowid');}

    /**
     * Set salary2workflowid
     * @param int $salary2workflowid
     */
    public function setSalary2workflowid($salary2workflowid, $update = false) {$this->setField('salary2workflowid', $salary2workflowid, $update);}

    /**
     * Filter salary2workflowid
     * @param int $salary2workflowid
     * @param string $operation
     */
    public function filterSalary2workflowid($salary2workflowid, $operation = false) {$this->filterField('salary2workflowid', $salary2workflowid, $operation);}

    /**
     * Get salary2koef
     * @return float
     */
    public function getSalary2koef() { return $this->getField('salary2koef');}

    /**
     * Set salary2koef
     * @param float $salary2koef
     */
    public function setSalary2koef($salary2koef, $update = false) {$this->setField('salary2koef', $salary2koef, $update);}

    /**
     * Filter salary2koef
     * @param float $salary2koef
     * @param string $operation
     */
    public function filterSalary2koef($salary2koef, $operation = false) {$this->filterField('salary2koef', $salary2koef, $operation);}

    /**
     * Get kpi3id
     * @return int
     */
    public function getKpi3id() { return $this->getField('kpi3id');}

    /**
     * Set kpi3id
     * @param int $kpi3id
     */
    public function setKpi3id($kpi3id, $update = false) {$this->setField('kpi3id', $kpi3id, $update);}

    /**
     * Filter kpi3id
     * @param int $kpi3id
     * @param string $operation
     */
    public function filterKpi3id($kpi3id, $operation = false) {$this->filterField('kpi3id', $kpi3id, $operation);}

    /**
     * Get kpi3param
     * @return string
     */
    public function getKpi3param() { return $this->getField('kpi3param');}

    /**
     * Set kpi3param
     * @param string $kpi3param
     */
    public function setKpi3param($kpi3param, $update = false) {$this->setField('kpi3param', $kpi3param, $update);}

    /**
     * Filter kpi3param
     * @param string $kpi3param
     * @param string $operation
     */
    public function filterKpi3param($kpi3param, $operation = false) {$this->filterField('kpi3param', $kpi3param, $operation);}

    /**
     * Get kpi3value
     * @return float
     */
    public function getKpi3value() { return $this->getField('kpi3value');}

    /**
     * Set kpi3value
     * @param float $kpi3value
     */
    public function setKpi3value($kpi3value, $update = false) {$this->setField('kpi3value', $kpi3value, $update);}

    /**
     * Filter kpi3value
     * @param float $kpi3value
     * @param string $operation
     */
    public function filterKpi3value($kpi3value, $operation = false) {$this->filterField('kpi3value', $kpi3value, $operation);}

    /**
     * Get salary3workflowid
     * @return int
     */
    public function getSalary3workflowid() { return $this->getField('salary3workflowid');}

    /**
     * Set salary3workflowid
     * @param int $salary3workflowid
     */
    public function setSalary3workflowid($salary3workflowid, $update = false) {$this->setField('salary3workflowid', $salary3workflowid, $update);}

    /**
     * Filter salary3workflowid
     * @param int $salary3workflowid
     * @param string $operation
     */
    public function filterSalary3workflowid($salary3workflowid, $operation = false) {$this->filterField('salary3workflowid', $salary3workflowid, $operation);}

    /**
     * Get salary3koef
     * @return float
     */
    public function getSalary3koef() { return $this->getField('salary3koef');}

    /**
     * Set salary3koef
     * @param float $salary3koef
     */
    public function setSalary3koef($salary3koef, $update = false) {$this->setField('salary3koef', $salary3koef, $update);}

    /**
     * Filter salary3koef
     * @param float $salary3koef
     * @param string $operation
     */
    public function filterSalary3koef($salary3koef, $operation = false) {$this->filterField('salary3koef', $salary3koef, $operation);}

    /**
     * Get kpi4id
     * @return int
     */
    public function getKpi4id() { return $this->getField('kpi4id');}

    /**
     * Set kpi4id
     * @param int $kpi4id
     */
    public function setKpi4id($kpi4id, $update = false) {$this->setField('kpi4id', $kpi4id, $update);}

    /**
     * Filter kpi4id
     * @param int $kpi4id
     * @param string $operation
     */
    public function filterKpi4id($kpi4id, $operation = false) {$this->filterField('kpi4id', $kpi4id, $operation);}

    /**
     * Get kpi4param
     * @return string
     */
    public function getKpi4param() { return $this->getField('kpi4param');}

    /**
     * Set kpi4param
     * @param string $kpi4param
     */
    public function setKpi4param($kpi4param, $update = false) {$this->setField('kpi4param', $kpi4param, $update);}

    /**
     * Filter kpi4param
     * @param string $kpi4param
     * @param string $operation
     */
    public function filterKpi4param($kpi4param, $operation = false) {$this->filterField('kpi4param', $kpi4param, $operation);}

    /**
     * Get kpi4value
     * @return float
     */
    public function getKpi4value() { return $this->getField('kpi4value');}

    /**
     * Set kpi4value
     * @param float $kpi4value
     */
    public function setKpi4value($kpi4value, $update = false) {$this->setField('kpi4value', $kpi4value, $update);}

    /**
     * Filter kpi4value
     * @param float $kpi4value
     * @param string $operation
     */
    public function filterKpi4value($kpi4value, $operation = false) {$this->filterField('kpi4value', $kpi4value, $operation);}

    /**
     * Get salary4workflowid
     * @return int
     */
    public function getSalary4workflowid() { return $this->getField('salary4workflowid');}

    /**
     * Set salary4workflowid
     * @param int $salary4workflowid
     */
    public function setSalary4workflowid($salary4workflowid, $update = false) {$this->setField('salary4workflowid', $salary4workflowid, $update);}

    /**
     * Filter salary4workflowid
     * @param int $salary4workflowid
     * @param string $operation
     */
    public function filterSalary4workflowid($salary4workflowid, $operation = false) {$this->filterField('salary4workflowid', $salary4workflowid, $operation);}

    /**
     * Get salary4koef
     * @return float
     */
    public function getSalary4koef() { return $this->getField('salary4koef');}

    /**
     * Set salary4koef
     * @param float $salary4koef
     */
    public function setSalary4koef($salary4koef, $update = false) {$this->setField('salary4koef', $salary4koef, $update);}

    /**
     * Filter salary4koef
     * @param float $salary4koef
     * @param string $operation
     */
    public function filterSalary4koef($salary4koef, $operation = false) {$this->filterField('salary4koef', $salary4koef, $operation);}

    /**
     * Get kpi5id
     * @return int
     */
    public function getKpi5id() { return $this->getField('kpi5id');}

    /**
     * Set kpi5id
     * @param int $kpi5id
     */
    public function setKpi5id($kpi5id, $update = false) {$this->setField('kpi5id', $kpi5id, $update);}

    /**
     * Filter kpi5id
     * @param int $kpi5id
     * @param string $operation
     */
    public function filterKpi5id($kpi5id, $operation = false) {$this->filterField('kpi5id', $kpi5id, $operation);}

    /**
     * Get kpi5param
     * @return string
     */
    public function getKpi5param() { return $this->getField('kpi5param');}

    /**
     * Set kpi5param
     * @param string $kpi5param
     */
    public function setKpi5param($kpi5param, $update = false) {$this->setField('kpi5param', $kpi5param, $update);}

    /**
     * Filter kpi5param
     * @param string $kpi5param
     * @param string $operation
     */
    public function filterKpi5param($kpi5param, $operation = false) {$this->filterField('kpi5param', $kpi5param, $operation);}

    /**
     * Get kpi5value
     * @return float
     */
    public function getKpi5value() { return $this->getField('kpi5value');}

    /**
     * Set kpi5value
     * @param float $kpi5value
     */
    public function setKpi5value($kpi5value, $update = false) {$this->setField('kpi5value', $kpi5value, $update);}

    /**
     * Filter kpi5value
     * @param float $kpi5value
     * @param string $operation
     */
    public function filterKpi5value($kpi5value, $operation = false) {$this->filterField('kpi5value', $kpi5value, $operation);}

    /**
     * Get salary5workflowid
     * @return int
     */
    public function getSalary5workflowid() { return $this->getField('salary5workflowid');}

    /**
     * Set salary5workflowid
     * @param int $salary5workflowid
     */
    public function setSalary5workflowid($salary5workflowid, $update = false) {$this->setField('salary5workflowid', $salary5workflowid, $update);}

    /**
     * Filter salary5workflowid
     * @param int $salary5workflowid
     * @param string $operation
     */
    public function filterSalary5workflowid($salary5workflowid, $operation = false) {$this->filterField('salary5workflowid', $salary5workflowid, $operation);}

    /**
     * Get salary5koef
     * @return float
     */
    public function getSalary5koef() { return $this->getField('salary5koef');}

    /**
     * Set salary5koef
     * @param float $salary5koef
     */
    public function setSalary5koef($salary5koef, $update = false) {$this->setField('salary5koef', $salary5koef, $update);}

    /**
     * Filter salary5koef
     * @param float $salary5koef
     * @param string $operation
     */
    public function filterSalary5koef($salary5koef, $operation = false) {$this->filterField('salary5koef', $salary5koef, $operation);}

    /**
     * Get kpi6id
     * @return int
     */
    public function getKpi6id() { return $this->getField('kpi6id');}

    /**
     * Set kpi6id
     * @param int $kpi6id
     */
    public function setKpi6id($kpi6id, $update = false) {$this->setField('kpi6id', $kpi6id, $update);}

    /**
     * Filter kpi6id
     * @param int $kpi6id
     * @param string $operation
     */
    public function filterKpi6id($kpi6id, $operation = false) {$this->filterField('kpi6id', $kpi6id, $operation);}

    /**
     * Get kpi6param
     * @return string
     */
    public function getKpi6param() { return $this->getField('kpi6param');}

    /**
     * Set kpi6param
     * @param string $kpi6param
     */
    public function setKpi6param($kpi6param, $update = false) {$this->setField('kpi6param', $kpi6param, $update);}

    /**
     * Filter kpi6param
     * @param string $kpi6param
     * @param string $operation
     */
    public function filterKpi6param($kpi6param, $operation = false) {$this->filterField('kpi6param', $kpi6param, $operation);}

    /**
     * Get kpi6value
     * @return float
     */
    public function getKpi6value() { return $this->getField('kpi6value');}

    /**
     * Set kpi6value
     * @param float $kpi6value
     */
    public function setKpi6value($kpi6value, $update = false) {$this->setField('kpi6value', $kpi6value, $update);}

    /**
     * Filter kpi6value
     * @param float $kpi6value
     * @param string $operation
     */
    public function filterKpi6value($kpi6value, $operation = false) {$this->filterField('kpi6value', $kpi6value, $operation);}

    /**
     * Get salary6workflowid
     * @return int
     */
    public function getSalary6workflowid() { return $this->getField('salary6workflowid');}

    /**
     * Set salary6workflowid
     * @param int $salary6workflowid
     */
    public function setSalary6workflowid($salary6workflowid, $update = false) {$this->setField('salary6workflowid', $salary6workflowid, $update);}

    /**
     * Filter salary6workflowid
     * @param int $salary6workflowid
     * @param string $operation
     */
    public function filterSalary6workflowid($salary6workflowid, $operation = false) {$this->filterField('salary6workflowid', $salary6workflowid, $operation);}

    /**
     * Get salary6koef
     * @return float
     */
    public function getSalary6koef() { return $this->getField('salary6koef');}

    /**
     * Set salary6koef
     * @param float $salary6koef
     */
    public function setSalary6koef($salary6koef, $update = false) {$this->setField('salary6koef', $salary6koef, $update);}

    /**
     * Filter salary6koef
     * @param float $salary6koef
     * @param string $operation
     */
    public function filterSalary6koef($salary6koef, $operation = false) {$this->filterField('salary6koef', $salary6koef, $operation);}

    /**
     * Get kpi7id
     * @return int
     */
    public function getKpi7id() { return $this->getField('kpi7id');}

    /**
     * Set kpi7id
     * @param int $kpi7id
     */
    public function setKpi7id($kpi7id, $update = false) {$this->setField('kpi7id', $kpi7id, $update);}

    /**
     * Filter kpi7id
     * @param int $kpi7id
     * @param string $operation
     */
    public function filterKpi7id($kpi7id, $operation = false) {$this->filterField('kpi7id', $kpi7id, $operation);}

    /**
     * Get kpi7param
     * @return string
     */
    public function getKpi7param() { return $this->getField('kpi7param');}

    /**
     * Set kpi7param
     * @param string $kpi7param
     */
    public function setKpi7param($kpi7param, $update = false) {$this->setField('kpi7param', $kpi7param, $update);}

    /**
     * Filter kpi7param
     * @param string $kpi7param
     * @param string $operation
     */
    public function filterKpi7param($kpi7param, $operation = false) {$this->filterField('kpi7param', $kpi7param, $operation);}

    /**
     * Get kpi7value
     * @return float
     */
    public function getKpi7value() { return $this->getField('kpi7value');}

    /**
     * Set kpi7value
     * @param float $kpi7value
     */
    public function setKpi7value($kpi7value, $update = false) {$this->setField('kpi7value', $kpi7value, $update);}

    /**
     * Filter kpi7value
     * @param float $kpi7value
     * @param string $operation
     */
    public function filterKpi7value($kpi7value, $operation = false) {$this->filterField('kpi7value', $kpi7value, $operation);}

    /**
     * Get salary7workflowid
     * @return int
     */
    public function getSalary7workflowid() { return $this->getField('salary7workflowid');}

    /**
     * Set salary7workflowid
     * @param int $salary7workflowid
     */
    public function setSalary7workflowid($salary7workflowid, $update = false) {$this->setField('salary7workflowid', $salary7workflowid, $update);}

    /**
     * Filter salary7workflowid
     * @param int $salary7workflowid
     * @param string $operation
     */
    public function filterSalary7workflowid($salary7workflowid, $operation = false) {$this->filterField('salary7workflowid', $salary7workflowid, $operation);}

    /**
     * Get salary7koef
     * @return float
     */
    public function getSalary7koef() { return $this->getField('salary7koef');}

    /**
     * Set salary7koef
     * @param float $salary7koef
     */
    public function setSalary7koef($salary7koef, $update = false) {$this->setField('salary7koef', $salary7koef, $update);}

    /**
     * Filter salary7koef
     * @param float $salary7koef
     * @param string $operation
     */
    public function filterSalary7koef($salary7koef, $operation = false) {$this->filterField('salary7koef', $salary7koef, $operation);}

    /**
     * Get kpi8id
     * @return int
     */
    public function getKpi8id() { return $this->getField('kpi8id');}

    /**
     * Set kpi8id
     * @param int $kpi8id
     */
    public function setKpi8id($kpi8id, $update = false) {$this->setField('kpi8id', $kpi8id, $update);}

    /**
     * Filter kpi8id
     * @param int $kpi8id
     * @param string $operation
     */
    public function filterKpi8id($kpi8id, $operation = false) {$this->filterField('kpi8id', $kpi8id, $operation);}

    /**
     * Get kpi8param
     * @return string
     */
    public function getKpi8param() { return $this->getField('kpi8param');}

    /**
     * Set kpi8param
     * @param string $kpi8param
     */
    public function setKpi8param($kpi8param, $update = false) {$this->setField('kpi8param', $kpi8param, $update);}

    /**
     * Filter kpi8param
     * @param string $kpi8param
     * @param string $operation
     */
    public function filterKpi8param($kpi8param, $operation = false) {$this->filterField('kpi8param', $kpi8param, $operation);}

    /**
     * Get kpi8value
     * @return float
     */
    public function getKpi8value() { return $this->getField('kpi8value');}

    /**
     * Set kpi8value
     * @param float $kpi8value
     */
    public function setKpi8value($kpi8value, $update = false) {$this->setField('kpi8value', $kpi8value, $update);}

    /**
     * Filter kpi8value
     * @param float $kpi8value
     * @param string $operation
     */
    public function filterKpi8value($kpi8value, $operation = false) {$this->filterField('kpi8value', $kpi8value, $operation);}

    /**
     * Get salary8workflowid
     * @return int
     */
    public function getSalary8workflowid() { return $this->getField('salary8workflowid');}

    /**
     * Set salary8workflowid
     * @param int $salary8workflowid
     */
    public function setSalary8workflowid($salary8workflowid, $update = false) {$this->setField('salary8workflowid', $salary8workflowid, $update);}

    /**
     * Filter salary8workflowid
     * @param int $salary8workflowid
     * @param string $operation
     */
    public function filterSalary8workflowid($salary8workflowid, $operation = false) {$this->filterField('salary8workflowid', $salary8workflowid, $operation);}

    /**
     * Get salary8koef
     * @return float
     */
    public function getSalary8koef() { return $this->getField('salary8koef');}

    /**
     * Set salary8koef
     * @param float $salary8koef
     */
    public function setSalary8koef($salary8koef, $update = false) {$this->setField('salary8koef', $salary8koef, $update);}

    /**
     * Filter salary8koef
     * @param float $salary8koef
     * @param string $operation
     */
    public function filterSalary8koef($salary8koef, $operation = false) {$this->filterField('salary8koef', $salary8koef, $operation);}

    /**
     * Get kpi9id
     * @return int
     */
    public function getKpi9id() { return $this->getField('kpi9id');}

    /**
     * Set kpi9id
     * @param int $kpi9id
     */
    public function setKpi9id($kpi9id, $update = false) {$this->setField('kpi9id', $kpi9id, $update);}

    /**
     * Filter kpi9id
     * @param int $kpi9id
     * @param string $operation
     */
    public function filterKpi9id($kpi9id, $operation = false) {$this->filterField('kpi9id', $kpi9id, $operation);}

    /**
     * Get kpi9param
     * @return string
     */
    public function getKpi9param() { return $this->getField('kpi9param');}

    /**
     * Set kpi9param
     * @param string $kpi9param
     */
    public function setKpi9param($kpi9param, $update = false) {$this->setField('kpi9param', $kpi9param, $update);}

    /**
     * Filter kpi9param
     * @param string $kpi9param
     * @param string $operation
     */
    public function filterKpi9param($kpi9param, $operation = false) {$this->filterField('kpi9param', $kpi9param, $operation);}

    /**
     * Get kpi9value
     * @return float
     */
    public function getKpi9value() { return $this->getField('kpi9value');}

    /**
     * Set kpi9value
     * @param float $kpi9value
     */
    public function setKpi9value($kpi9value, $update = false) {$this->setField('kpi9value', $kpi9value, $update);}

    /**
     * Filter kpi9value
     * @param float $kpi9value
     * @param string $operation
     */
    public function filterKpi9value($kpi9value, $operation = false) {$this->filterField('kpi9value', $kpi9value, $operation);}

    /**
     * Get salary9workflowid
     * @return int
     */
    public function getSalary9workflowid() { return $this->getField('salary9workflowid');}

    /**
     * Set salary9workflowid
     * @param int $salary9workflowid
     */
    public function setSalary9workflowid($salary9workflowid, $update = false) {$this->setField('salary9workflowid', $salary9workflowid, $update);}

    /**
     * Filter salary9workflowid
     * @param int $salary9workflowid
     * @param string $operation
     */
    public function filterSalary9workflowid($salary9workflowid, $operation = false) {$this->filterField('salary9workflowid', $salary9workflowid, $operation);}

    /**
     * Get salary9koef
     * @return float
     */
    public function getSalary9koef() { return $this->getField('salary9koef');}

    /**
     * Set salary9koef
     * @param float $salary9koef
     */
    public function setSalary9koef($salary9koef, $update = false) {$this->setField('salary9koef', $salary9koef, $update);}

    /**
     * Filter salary9koef
     * @param float $salary9koef
     * @param string $operation
     */
    public function filterSalary9koef($salary9koef, $operation = false) {$this->filterField('salary9koef', $salary9koef, $operation);}

    /**
     * Get kpi10id
     * @return int
     */
    public function getKpi10id() { return $this->getField('kpi10id');}

    /**
     * Set kpi10id
     * @param int $kpi10id
     */
    public function setKpi10id($kpi10id, $update = false) {$this->setField('kpi10id', $kpi10id, $update);}

    /**
     * Filter kpi10id
     * @param int $kpi10id
     * @param string $operation
     */
    public function filterKpi10id($kpi10id, $operation = false) {$this->filterField('kpi10id', $kpi10id, $operation);}

    /**
     * Get kpi10param
     * @return string
     */
    public function getKpi10param() { return $this->getField('kpi10param');}

    /**
     * Set kpi10param
     * @param string $kpi10param
     */
    public function setKpi10param($kpi10param, $update = false) {$this->setField('kpi10param', $kpi10param, $update);}

    /**
     * Filter kpi10param
     * @param string $kpi10param
     * @param string $operation
     */
    public function filterKpi10param($kpi10param, $operation = false) {$this->filterField('kpi10param', $kpi10param, $operation);}

    /**
     * Get kpi10value
     * @return float
     */
    public function getKpi10value() { return $this->getField('kpi10value');}

    /**
     * Set kpi10value
     * @param float $kpi10value
     */
    public function setKpi10value($kpi10value, $update = false) {$this->setField('kpi10value', $kpi10value, $update);}

    /**
     * Filter kpi10value
     * @param float $kpi10value
     * @param string $operation
     */
    public function filterKpi10value($kpi10value, $operation = false) {$this->filterField('kpi10value', $kpi10value, $operation);}

    /**
     * Get salary10workflowid
     * @return int
     */
    public function getSalary10workflowid() { return $this->getField('salary10workflowid');}

    /**
     * Set salary10workflowid
     * @param int $salary10workflowid
     */
    public function setSalary10workflowid($salary10workflowid, $update = false) {$this->setField('salary10workflowid', $salary10workflowid, $update);}

    /**
     * Filter salary10workflowid
     * @param int $salary10workflowid
     * @param string $operation
     */
    public function filterSalary10workflowid($salary10workflowid, $operation = false) {$this->filterField('salary10workflowid', $salary10workflowid, $operation);}

    /**
     * Get salary10koef
     * @return float
     */
    public function getSalary10koef() { return $this->getField('salary10koef');}

    /**
     * Set salary10koef
     * @param float $salary10koef
     */
    public function setSalary10koef($salary10koef, $update = false) {$this->setField('salary10koef', $salary10koef, $update);}

    /**
     * Filter salary10koef
     * @param float $salary10koef
     * @param string $operation
     */
    public function filterSalary10koef($salary10koef, $operation = false) {$this->filterField('salary10koef', $salary10koef, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoprole');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopRole
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopRole
     */
    public static function Get($key) {return self::GetObject("XShopRole", $key);}

}

SQLObject::SetFieldArray('shoprole', array('id', 'name', 'description', 'blockcolor', 'parentid', 'kpi1id', 'kpi1param', 'kpi1value', 'salary1workflowid', 'salary1koef', 'kpi2id', 'kpi2param', 'kpi2value', 'salary2workflowid', 'salary2koef', 'kpi3id', 'kpi3param', 'kpi3value', 'salary3workflowid', 'salary3koef', 'kpi4id', 'kpi4param', 'kpi4value', 'salary4workflowid', 'salary4koef', 'kpi5id', 'kpi5param', 'kpi5value', 'salary5workflowid', 'salary5koef', 'kpi6id', 'kpi6param', 'kpi6value', 'salary6workflowid', 'salary6koef', 'kpi7id', 'kpi7param', 'kpi7value', 'salary7workflowid', 'salary7koef', 'kpi8id', 'kpi8param', 'kpi8value', 'salary8workflowid', 'salary8koef', 'kpi9id', 'kpi9param', 'kpi9value', 'salary9workflowid', 'salary9koef', 'kpi10id', 'kpi10param', 'kpi10value', 'salary10workflowid', 'salary10koef'));
SQLObject::SetPrimaryKey('shoprole', 'id');
