<?php
class orders_addproduct extends Engine_Class {

    public function process() {
        try {
            SQLObject::TransactionStart();

            $id = $this->getArgument('id');
            $type = $this->getArgument('type');

            if ($type == 'product') {
                $product = Shop::Get()->getShopService()->getProductByID($id);
            }

            if ($type == 'storage') {
                // получаем товар
                $product = Shop::Get()->getStorageService()->getStorageByID($id)->getProduct();
            }

            if ($type == 'price') {
                $price = Shop::Get()->getShopService()->getPriceByID($id);

                try {
                    // есть ссылка на наш товар
                    $product = $price->getProduct();
                } catch (Exception $e) {
                    // нет ссылки на товар

                    $productID = $this->getControlValue('productid');
                    $productIDAdd = $this->getControlValue('product-add');

                    try {
                        // достаем товар
                        $product = Shop::Get()->getShopService()->getProductByID($productID);

                        // связываем прайс с товаром
                        $price->setProductid($product->getId());
                        //$price->setMdate(date('Y-m-d H:i:s'));
                        $price->update();
                    } catch (Exception $pe) {
                        if ($productIDAdd && !is_numeric($productID)) {
                            // создаем новый товар с указанным именем
                            $product = Shop::Get()->getShopService()->addProduct(
                            $productID
                            );

                            // связываем прайс с товаром
                            $price->setProductid($product->getId());
                            //$price->setMdate(date('Y-m-d H:i:s'));
                            $price->update();
                        }
                    }

                    if (empty($product)) {
                        $this->setValue('link', true);
                        $this->setValue('pricename', htmlspecialchars($price->getName()));
                        $this->setValue('pricecode', htmlspecialchars($price->getSerial()));

                        PackageLoader::Get()->import('JSPrototypeAutocomplete');
                        return;
                    }
                }
            }

            if (empty($product)) {
                throw new ServiceUtils_Exception();
            }

            // кладем его в корзину
            Shop::Get()->getShopService()->addToBasket(
            $product->getId(),
            1
            );

            SQLObject::TransactionCommit();

            $this->setValue('message', 'ok');
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            $this->setValue('message', 'error');

            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
        }
    }

}