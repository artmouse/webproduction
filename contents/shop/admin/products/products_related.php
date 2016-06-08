<?php
class products_related extends Engine_Class {

    public function process() {
        try{
            $productID = $this->getArgumentSecure('id');
            
            $this->setValue('productid', $productID);

            // добавление кодов
            if ($this->getControlValue('ok')) {
                try {
                    $list = Shop::Get()->getShopService()->getProductsListByLinkKey('product-'.$productID.'-related');

                    // удалить товары из списка
                    $delete = $this->getArgumentSecure('delete');
                    if ($delete) {
                        Shop::Get()->getShopService()->deleteProductsFromList(
                            $list,
                            $delete
                        );
                    }
                    
                    // добавить товары список
                    $add = $this->getArgumentSecure('codes');
                    if ($add) {
                        
                        $product = Shop::Get()->getShopService()->getProductByID($productID);
                        Shop::Get()->getShopService()->checkProductRelatedDuplicate($product, $add);
                       
                        Shop::Get()->getShopService()->addProductsToList(
                            $list,
                            $add
                        );
                    }

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $te) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $te;
                    }
                    $this->setValue('errorsArray', $te->getErrorsArray());
                    $this->setValue('message', 'error');
                }
            }

            // отображение товаров в выбранном списке
            try {
                try {
                    $product = Shop::Get()->getShopService()->getProductByCode1c($productID);
                } catch (Exception $e) {
                    $product = Shop::Get()->getShopService()->getProductByID($productID);
                }

                try{
                    $list = Shop::Get()->getShopService()->getProductsListByLinkKey('product-'.$productID.'-related');
                } catch(Exception $e) {
                    try {
                        $list = Shop::Get()->getShopService()->getProductsListByLinkKey(
                            'product-'.$product->getCode1c().'-related'
                        );
                    } catch (Exception $e) {
                        $list = Shop::Get()->getShopService()->getProductsListAll();
                        $list->setHidden(0);
                        $list->setLinkkey('product-'.$productID.'-related');
                        $list->setName(
                            Shop::Get()->getTranslateService()->getTranslateSecure(
                                'translate_svyazannie_tovari_c_productid'
                            )." ".$product->getName()
                        );
                        $list->setNameshort(
                            Shop::Get()->getTranslateService()->getTranslateSecure('translate_our_recomendation')
                        );
                        $list->setShowtype('table');
                        $list->insert();
                    }

                }

                $this->setValue('name', $list->makeName());

                $table = new Shop_ContentTable(new Datasource_ProductsInList($list));

                $field = new Forms_ContentFieldCheckboxKey('checkbox');
                $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_motion'));
                $table->addField($field);

                $this->setValue('table', $table->render());
            } catch (Exception $listEx) {

            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'related');
            $this->setValue('menu', $menu->render());
        }catch(Exception $e){

        }
    }

}