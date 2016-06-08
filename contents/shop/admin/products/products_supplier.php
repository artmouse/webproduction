<?php
class products_supplier extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );

            $this->setValue('productid', $product->getId());
            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_tovar_').$product->getId()
            );


            // сохраняем поставщиков
            if ($this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();
                    
                    $tmp = new XShopProductSupplier();
                    $tmp->setProductid($product->getId());
                    $supplierIDArray = array();
                    while ($x = $tmp->getNext()) {
                        $supplierIDArray[$x->getSupplierid()] = $x;
                    }
                    // Принимаем всех что были + 1 возможно добавленный
                    $productSuppliers = Shop::Get()->getSupplierService()->getProductSupplierFromProduct($product);
                    $supplier_count = $productSuppliers->getCount() + 1;
                    

                    for ($j = 1; $j <= $supplier_count; $j++) {
                        $supplierDiscount = 0;
                        try {
                            $supplierID = $this->getControlValue('supplier'.$j.'id');
                            $supplierDiscount = $this->getControlValue('supplier'.$j.'discount');
                            $supplierCode = $this->getControlValue('supplier'.$j.'code');
                            $supplierPrice = $this->getControlValue('supplier'.$j.'price');
                            $supplierCurrencyID = $this->getControlValue('supplier'.$j.'currencyid');
                            $supplierAvailText = $this->getControlValue('supplier'.$j.'availtext');
                            $supplierComment = $this->getControlValue('supplier'.$j.'comment');
                            $supplierAvail = $this->getControlValue('supplier'.$j.'avail');
                            $supplierMinretail = $this->getControlValue('supplier'.$j.'minretail');
                            $supplierMinretail_cur_id = $this->getControlValue('supplier'.$j.'minretail_cur_id');
                            $supplierRecommretail = $this->getControlValue('supplier'.$j.'recommretail');
                            $supplierRecommretail_cur_id = $this->getControlValue('supplier'.$j.'recommretail_cur_id');
                            
                            if (!$supplierID) {
                                continue;
                            }
                            // добавляем, обновляем
                            $productSupplier = new ShopProductSupplier();
                            $productSupplier->setSupplierid($supplierID);
                            $productSupplier->setProductid($product->getId());
                            if (!$productSupplier->select()) {
                                $productSupplier->insert();
                            }
                            $productSupplier->setDiscount($supplierDiscount);
                            $productSupplier->setCode($supplierCode);
                            $productSupplier->setPrice($supplierPrice);
                            $productSupplier->setCurrencyid($supplierCurrencyID);
                            $productSupplier->setAvailtext($supplierAvailText);
                            $productSupplier->setComment($supplierComment);
                            $productSupplier->setAvail($supplierAvail);
                            $productSupplier->setMinretail($supplierMinretail);
                            $productSupplier->setMinretail_cur_id($supplierMinretail_cur_id);
                            $productSupplier->setRecommretail($supplierRecommretail);
                            $productSupplier->setRecommretail_cur_id($supplierRecommretail_cur_id);
                            $productSupplier->update();
                            
                            // если обновили - убираем из массива
                            if (isset($supplierIDArray[$supplierID])) {
                                unset($supplierIDArray[$supplierID]);
                            }
                        } catch (Exception $e) {
                          
                        }
                    }

                    //$product->update();
                    
                    // удаляем все не актуальные данные
                    foreach ($supplierIDArray as $object) {
                        $object->delete();
                    }

                    if (Shop_ModuleLoader::Get()->isImported('product-supplierprice')) {
                        // пересчет наличия по поставщикам
                        ProcessorQueService::Get()->addProcessor('ShopSupplier_Processor_Avail');
                    }


                    $this->setValue('message', 'ok');

                    SQLObject::TransactionCommit();
                } catch (ServiceUtils_Exception $e) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            // текущий поставщик
            $currentSupplierID = $product->getSupplierid();

            // значения поставщиков
            $a = array();
            $supplierIDArray = array(-1);
            
            $productSuppliers = Shop::Get()->getSupplierService()->getProductSupplierFromProduct($product);
            
            $j = 1;
            while ($x = $productSuppliers->getNext()) {
                $supplierID =  $x->getSupplierid();
                $supplierCode = $x->getCode();
                $supplierPrice = $x->getPrice();
                $supplierCurrencyID = $x->getCurrencyid();
                $supplierDate = $x->getDate();
                $supplierAvailText = $x->getAvailtext();
                $supplierComment = $x->getComment();
                $supplierAvail = $x->getAvail();
                $supplierDiscount = $x->getDiscount();
                $supplierMinretail = $x->getMinretail();
                $supplierMinretail_cur_id = $x->getMinretail_cur_id();
                $supplierRecommretail = $x->getRecommretail();
                $supplierRecommretail_cur_id = $x->getRecommretail_cur_id();
                
                try {
                    $supplierObject = Shop::Get()->getSupplierService()->getSupplierByID($supplierID);
                    $deliveryTime = $supplierObject->getDeliverytime();
                    if (!$deliveryTime) {
                        $deliveryTime = '---';
                    }
                } catch (Exception $e) {
                    $deliveryTime = '---';
                }


                $current = ($currentSupplierID && $supplierID == $currentSupplierID);
                
                if ($supplierID > 0) {
                    $supplierIDArray[] = $supplierID;
                }

                if (Checker::CheckDate($supplierDate)) {
                    $supplierDate = DateTime_Formatter::DateTimePhonetic($supplierDate);
                } else {
                    $supplierDate = false;
                }
                
                $a[$j] = array(
                    'supplierID' => $supplierID,
                    'supplierCode' => htmlspecialchars($supplierCode),
                    'supplierPrice' => $supplierPrice,
                    'supplierCurrencyID' => $supplierCurrencyID,
                    'supplierDate' => $supplierDate,
                    'supplierAvailText' => htmlspecialchars($supplierAvailText),
                    'supplierComment' => htmlspecialchars($supplierComment),
                    'supplierAvail' => htmlspecialchars($supplierAvail),
                    'supplierDiscount' => $supplierDiscount,
                    'supplierMinretail' => $supplierMinretail,
                    'supplierMinretail_cur_id' => $supplierMinretail_cur_id,
                    'supplierRecommretail' => $supplierRecommretail,
                    'supplierRecommretail_cur_id' => $supplierRecommretail_cur_id,
                    'deliveryTime' => $deliveryTime,     
                    'current' => $current,
                );
                $j++;
            }
            // Допишем одну пустую добавления
            $a[$j] = array(
                'supplierID' => 0,
                'supplierCode' => '',
                'supplierPrice' => 0,
                'supplierCurrencyID' => 0,
                'supplierDate' => 0,
                'supplierAvailText' => '',
                'supplierComment' => '',
                'supplierAvail' => 0,
                'supplierDiscount' => 0,
                'supplierMinretail' => 0,
                'supplierMinretail_cur_id' => 0,
                'supplierRecommretail' => 0,
                'supplierRecommretail_cur_id' => 0,
                'deliveryTime' => 0,     
                'current' => 0,
            );
            
            
            
            
            
            $this->setValue('valueArray', $a);
            $this->setValue('suppliersCount', Shop::Get()->getShopService()->getSuppliersAll()->getCount());

            // список поставщиков
            $suppliers = Shop::Get()->getShopService()->getSuppliersAll();
            $suppliers->addWhereQuery("(id IN (".implode(',', $supplierIDArray).") OR hidden=0)");
            $a = array();
            while ($x = $suppliers->getNext()) {
                try {
                    $contact = $x->getContact();
                    $contactId = $contact->getId();
                    $url = $contact->makeURLEdit();
                } catch (Exception $e) {
                    $contactId = '';
                    $url = '';
                }    
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'color' => $x->getColor(),
                'contactId' => $contactId,
                'url' => $url,    
                );
            }
            $this->setValue('supplierArray', $a);

            // список валют
            $currencies = Shop::Get()->getCurrencyService()->getCurrencyActive();
            $a = array();
            while ($x = $currencies->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                );
            }
            $this->setValue('currencyArray', $a);

            // меню
            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'supplier');
            $this->setValue('menu', $menu->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}