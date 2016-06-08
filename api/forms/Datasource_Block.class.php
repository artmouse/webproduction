<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Egor Gerasimchuk <milhous@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_Block extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getBlockService()->getBlocksAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $field->setEditable(false);
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('active');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_active'));
        $field->setQuickedit(true);
        $this->addField($field);
    }

    public function update($key, $fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::update($key, $fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $block = Shop::Get()->getBlockService()->getBlockByID($key);

                $diffArray = array();
                foreach ($fieldsArray as $field) {
                    if ($field->getEditable()) {
                        $diffArray[] = $field->getName().' '.$field->getValue();
                    }
                }

                CommentsAPI::Get()->addComment(
                    'shop-history-block-'.$block->getId(),
                    Shop::Get()->getTranslateService()->getTranslateSecure('translate_edited_block').' #'.$block->getId().' '.$block->getName()."\n".implode("\n", $diffArray),
                    $user->getId()
                );
            } catch (ServiceUtils_Exception $e) {

            }

            SQLObject::TransactionCommit();

            return $r;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }
}
