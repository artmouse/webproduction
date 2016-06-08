<?php
class storage_product_search_json_autocomplete extends Engine_Class {

    public function process() {
        try {
            $searchTerm = $this->getArgument('searchTerm');
            $pageNum = $this->getArgument('pageNum');
            $pageSize = $this->getArgument('pageSize');
            $callback = $this->getArgument('callback');

            $a = array();
            if ($searchTerm) {
                $products = Shop::Get()->getShopService()->searchProducts($searchTerm, false);
                $products->setSource(false);
                $productCount = $products->getCount();
            } else {
                $products = Shop::Get()->getShopService()->getProductsAll();
                $products->setSource(false);
                $products->setDeleted(0);
                $productCount = 1000000;//$products->getCount();
            }
            
            $products->setLimit(($pageNum-1)*$pageSize, $pageSize);
            
            while ($x = $products->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'text' => htmlspecialchars($x->getName())
                );
            }
            
            echo $callback . '(' . json_encode(array(
            'Results' => $a,
            'Total' => $productCount
            )) .')';
            
        } catch (Exception $e) {

        }

        exit();
    }

}