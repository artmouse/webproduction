<?php
class products_filters extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );

            $this->setValue('productid', $product->getId());
            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_tovar_').$product->getId()
            );
     
            // сохраняем выбор юзера
            if ($this->getControlValue('ok')) {
                try {
                    $filterIds = $this->getArgumentSecure('filterid');
                    $filterValues = $this->getArgumentSecure('filtervalue');
                    $filterMarkups = $this->getArgumentSecure('filtermarkup');

                    $dataArray = array();
                    foreach ($filterIds as $filterKey => $filterId) {

                        try {
                            Shop::Get()->getShopService()->getProductFilterByID($filterId);

                            $filterValue = @$filterValues[$filterKey];
                            $filterMarkup =  @$filterMarkups[$filterKey];
                            $filterUse = $this->getArgumentSecure('filteruse'.$filterKey);
                            $filterActual = $this->getArgumentSecure('filteractual'.$filterKey);
                            $filterOption = $this->getArgumentSecure('filteroption'.$filterKey);
                        } catch (Exception $e) {
                            $filterId = 0;
                            $filterValue = '';
                            $filterActual = 0;
                            $filterUse = 0;
                            $filterOption = 0;
                            $filterMarkup = 0.00;
                        }

                        $dataArray[] = array(
                            'filterId' => $filterId,
                            'filterValue' => $filterValue,
                            'filterUse' => $filterUse,
                            'filterActual' => $filterActual,
                            'filterOption' => $filterOption,
                            'filterMarkup' => $filterMarkup
                        );

                    }

                    Shop::Get()->getShopService()->updateProductFilterData(
                        $product,
                        $dataArray
                    );

                    $this->setValue('message', 'ok');

                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }
            
            // проставить товару фильтры по умолчанию
            Shop::Get()->getShopService()->updateProductFilterDefault($product);
            
            // значения по данному товару
            $a = array();

            $filter = new XShopProductFilterValue();
            $filter->setProductid($product->getId());
            $filter->addWhere('filterid', 0, '>');
            $filter->setOrder('id');

            while ($x = $filter->getNext()) {
                $a[] = array(
                    'id' => $x->getFilterid(),
                    'value' => htmlspecialchars($x->getFiltervalue()),
                    'use' => $x->getFilteruse(),
                    'actual' => $x->getFilteractual(),
                    'option' => $x->getFilteroption(),
                    'markup' => $x->getFiltermarkup(),
                );
            }

            // +5 полей
            for ($i = 1; $i <= 5; $i++) {
                $a[] = array();
            }

            $this->setValue('valuesArray', $a);

            // список фильтров
            $filters = Shop::Get()->getShopService()->getProductFiltersAll();
            $this->setValue('filtersArray', $filters->toArray());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'filters');
            $this->setValue('menu', $menu->render());

            $this->setValue(
                'addFilteUrl',
                Engine::GetLinkMaker()->makeURLByContentID('shop-admin-products-filters-index')
            );

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}