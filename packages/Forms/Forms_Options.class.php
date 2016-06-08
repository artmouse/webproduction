<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_Options extends ArrayObject {

    public function getName() {
        return @$this['name'];
    }

    public function setName($name) {
        $this['name'] = $name;
    }

    public function getPosition() {
        return (int) @$this['position'];
    }

    public function setPosition($position) {
        $this['position'] = (int) $position;
    }

    public function getEditable() {
        return (bool) @$this['editable'];
    }

    public function setEditable($editable) {
        $this['editable'] = (bool) $editable;
    }

    public function getViewable() {
        return (bool) @$this['viewable'];
    }

    public function setViewable($viewable) {
        $this['viewable'] = (bool) $viewable;
    }

    /**
	 * Включить поле в форме.
	 *
	 * Investigation report:
	 * По умолчанию в большинстве форм поля включены, и чтобы их
	 * отключать требуется опция disabled. Поэтому мы и храним значения
	 * enabled/disabled именно как disabled.
	 *
	 * @param bool $enabled
	 */
    public function setEnabled($enabled = true) {
        $this['disabled'] = !$enabled;
    }

    public function setDisabled($disabled = true) {
        $this['disabled'] = (bool) $disabled;
    }

    public function getEnabled() {
        return (bool) @!$this['disabled'];
    }

    public function getDisabled() {
        return (bool) @$this['disabled'];
    }

    public function getSortable() {
        return (bool) @$this['sortable'];
    }

    public function setSortable($sortable) {
        $this['sortable'] = (bool) $sortable;
    }

}