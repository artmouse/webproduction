<?php
class ajax_supplier_search_products extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');
            $products = Shop::Get()->getShopService()->searchProducts($query, false);
            $products->unsetField('hidden');
            $products->unsetField('deleted');

            $arguments = $this->getArguments();
            foreach ($arguments as $keyArgument => $argument) {
                if (!$argument) {
                    continue;
                }
                if (strpos($keyArgument, 'custom_filter_') === 0) {
                    $filterId = str_replace('custom_filter_', '', $keyArgument);
                    $filterValue = str_replace(' ', '%', $argument);

                    $products->addWhereQuery(
                        '`id` IN (
                    SELECT `productid` FROM `shopproductfiltervalue`
                    WHERE `filterid` = "'.$filterId.'" AND `filtervalue` LIKE "%'.$filterValue.'%")'
                    );

                }
            }

            $products->setLimitCount(100);

            $productArray = array();
            while ($product = $products->getNext()) {
                $currencyName = '';
                try {
                    $currencyName = $product->getCurrency()->getSymbol();
                } catch (ServiceUtils_Exception $se) {

                }
                $productArray[] = array(
                    'id' => $product->getId(),
                    'name' => $product->makeName(),
                    'price' => $product->getPrice(),
                    'currency' => $currencyName,
                );
            }

            echo json_encode($productArray);
            exit();
        } catch (Exception $e) {
            echo $e;
            exit();
        }
    }

}