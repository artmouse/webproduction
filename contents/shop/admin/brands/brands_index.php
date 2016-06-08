<?php
class brands_index extends Engine_Class {

    public function process() {

        if ($this->getControlValue('movetop')) {
            try {
                $top = $this->getControlValue('topbrand');

                if($top != '-1'){
                    if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                        foreach ($r[1] as $brandID) {
                            try {
                                SQLObject::TransactionStart();

                                $brand = Shop::Get()->getShopService()->getBrandByID($brandID);
                                $brand->setTop($top);
                                $brand->update();

                                SQLObject::TransactionCommit();
                            } catch (Exceprion $e) {
                                SQLObject::TransactionRollback();
                            }
                        }
                    }
                }

            } catch (Exception $e) {

            }
        }

        if($this->getControlValue('changeshowtype')){
            try {

                $showType = $this->getControlValue('showtype');
                if($showType != '0'){
                    if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                        foreach ($r[1] as $brandID) {
                            try {
                                SQLObject::TransactionStart();

                                $brand = Shop::Get()->getShopService()->getBrandByID($brandID);
                                $brand->setShowtype($showType);
                                $brand->update();

                                SQLObject::TransactionCommit();
                            } catch (Exceprion $e) {
                                SQLObject::TransactionRollback();
                            }
                        }
                    }
                }

            } catch (Exception $e) {

            }
        }


        if ($this->getControlValue('changehidden')) {
            try {
                $hidden = $this->getControlValue('hiddenbrand');

                if($hidden != '-1'){
                    if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                        foreach ($r[1] as $brandID) {
                            try {
                                SQLObject::TransactionStart();

                                $brand = Shop::Get()->getShopService()->getBrandByID($brandID);
                                $brand->setHidden($hidden);
                                $brand->update();

                                SQLObject::TransactionCommit();
                            } catch (Exceprion $e) {
                                SQLObject::TransactionRollback();
                            }
                        }
                    }
                }

            } catch (Exception $e) {

            }
        }


        $table = new Shop_ContentTable(new Datasource_Brands());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-brands-control', 'id');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_brand'));

        $this->setValue('table', $table->render());
    }

}