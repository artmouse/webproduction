<?php
$products = Shop::Get()->getShopService()->getProductsAll();
$products->setOrder('id', 'DESC');
$products->addWhereQuery(
    '(supplier1id>0 OR supplier2id>0 OR supplier3id>0 OR supplier4id>0 OR supplier5id>0 OR
      supplier6id>0 OR supplier7id>0 OR supplier8id>0 OR supplier9id>0 OR supplier10id>0)'
);
while ($p = $products->getNext()) {
    print "Build supplier data for product #".$p->getId()."\n";

    try {
        Shop::Get()->getSupplierService()->updateProductSuppliers($p);
    } catch (Exception $e) {
        print $e;
    }
}