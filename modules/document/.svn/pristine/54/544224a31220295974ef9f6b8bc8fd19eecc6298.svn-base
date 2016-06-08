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
 * событие для Sync
 *
 * @author    i.ustimenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Document_Sync implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        try {
            SQLObject::TransactionStart(); 

            $languagesArray = array(
                'ukr' => 'UA',
                'ru' => 'RU',
                'eng' => 'EN',
            );
            
            foreach ($languagesArray as $key => $name) {
              
                DocumentService::Get()->addDocumentTempalte(
                    'Акт выполненных работ ('.$name.')',
                    'file:/modules/document/media/shop-document-akt-'.$key.'.html',
                    'order-act-'.$key,
                    'ShopOrder'               
                );
                
                DocumentService::Get()->addDocumentTempalte(
                    'Счет-фактура ('.$name.')',
                    'file:/modules/document/media/shop-document-invoice-'.$key.'.html',
                    'invoice-'.$key,
                    'ShopOrder'                    
                );
                             
                DocumentService::Get()->addDocumentTempalte(
                    'Накладная заказа ('.$name.')',
                    'file:/modules/document/media/shop-document-salebill-'.$key.'.html',
                    'salebill-'.$key,
                    'ShopOrder'                    
                );
            }
 
            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
        
        
        Shop::Get()->getSettingsService()->addSetting(
            'show-onebox-info-print',
            'Показывать подпись OneBox в печати документов',
            'Блоки, отображение, внешний вид',
            'Показывать ли подпись CRM OneBox при печати документов или формировании pdf файла.',
            1, // default value
            'boolean'
        );
    }

}