<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Подгрузка ACL по требованию
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Document_ACL implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        Shop::Get()->getAclService()->addACLPermission(
            'documents',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_documents')
        );

        Shop::Get()->getAclService()->addACLPermission(
            'documents-all-view',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_documents_all_view')
        );

        Shop::Get()->getAclService()->addACLPermission(
            'documents-all-edit',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_documents_all_edit')
        );

        Shop::Get()->getAclService()->addACLPermission(
            'documents-all-delete',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_documents_all_delete')
        );

        $acl = array();

        // ACL по шаблонам документов
        $documents = DocumentService::Get()->getDocumentTemplatesActive();
        while ($doc = $documents->getNext()) {
            $acl[] = array(
                'name' => 'Документы :: Создание документов :: '.$doc->getName(),
                'key' => 'document-print-'.$doc->getId(),
            );

            $acl[] = array(
                'name' => 'Документы :: Доступ по шаблону :: Просмотр :: '.$doc->getName(),
                'key' => 'document-template-'.$doc->getId().'-view',
            );
        }

        $acl[] = array(
            'name' => 'Документы :: Доступ по шаблону :: Просмотр :: Все',
            'key' => 'document-template-all-view',
        );

        $acl[] = array(
            'name' => 'Документы :: Доступ по автору :: Все :: Просмотр',
            'key' => 'document-manager-all-view',
        );

        // ACL по управлению документами
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($s = $managers->getNext()) {
            $acl[] = array(
                'name' => 'Документы :: Доступ по автору :: '.$s->makeName(false, 'lmf').' :: Просмотр',
                'key' => 'document-manager-'.$s->getId().'-view',
            );

            $acl[] = array(
                'name' => 'Документы :: Доступ по автору :: '.$s->makeName(false, 'lmf').' :: Редактирование полное',
                'key' => 'document-manager-' . $s->getId() . '-edit',
            );

            $acl[] = array(
                'name' => 'Документы :: Доступ по автору :: '.$s->makeName(false, 'lmf').' :: Редактирование полей',
                'key' => 'document-manager-' . $s->getId() . '-editfields',
            );

            $acl[] = array(
                'name' => 'Документы :: Доступ по автору :: '.$s->makeName(false, 'lmf').' :: Удаление',
                'key' => 'document-manager-' . $s->getId() . '-delete',
            );
        }

        foreach ($acl as $aclValue) {
            Shop::Get()->getAclService()->addACLPermission($aclValue['key'], $aclValue['name']);
        }
    }

}