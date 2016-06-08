<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @deprecated
 *
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentFieldGravatar extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();

        $id = @$cellsArray[$keyPrimary];
        if ($id) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($id);
                $defaultImage = $user->makeImageThumb(50, 50, 'prop', true);
                $fullImageUrlDefaurl = '';
                $gravatar = '';
                try {
                    $fullImageUrlDefaurl = 'http://'.Engine::Get()->getConfigField('project-host').$defaultImage;
                } catch (Exception $e) {

                }

                if ($fullImageUrlDefaurl) {
                    $gravatar = $user->makeImageGravatar(50, $fullImageUrlDefaurl);
                }

                if (!$gravatar) {
                    // Если его нет, то показываем иконку
                    $gravatar = $defaultImage;

                }
                $assigns['gravatar'] = $gravatar;

            } catch (Exception $e) {

            }
        }

        return $this->getContentView()->render($assigns);
    }

}