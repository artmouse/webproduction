<?php
class product_add extends Engine_Class {

    public function process() {
        $result = false;
        $status = false;
        $errorsArray = array();

        try {
            $name = @trim($this->getArgumentSecure('name'));
            $categoryID = $this->getArgumentSecure('categoryid', 'int');
            $price = $this->getArgumentSecure('price', 'float');
            $currencyID = $this->getArgumentSecure('currencyid', 'int');
            $brandID = $this->getArgumentSecure('brandid', 'int');
            $source = $this->getArgumentSecure('source');
            $term = @trim($this->getArgumentSecure('term'));
            $pricebase = $this->getArgumentSecure('pricebase', 'float');
            $unit = @trim($this->getArgumentSecure('unit'));
            $hidden = @trim($this->getArgumentSecure('hidden'));


            SQLObject::TransactionStart();

            $product = Shop::Get()->getShopService()->addProduct($name);

            if ($categoryID) {
                $product->setCategoryid($categoryID);
                Shop::Get()->getShopService()->buildProductCategories($product);
            }

            if($brandID) {
                $product->setBrandid($brandID);
            }

            if($source) {
                $product->setSource($source);
            }

            if($term) {
                $product->setTerm($term);
            }

            if ($pricebase) {
                $product->setPricebase($pricebase);
            }

            if ($unit) {
                $product->setUnit($unit);
            }

            if ( is_numeric($hidden) ) {
                $product->setHidden($hidden);
            }

            // issue #15617
            if ($currencyID && $price) {
                $product->setCurrencyid($currencyID);
                $product->setPrice($price);
                $product->update();
            }

            SQLObject::TransactionCommit();

            $result = array(
            'id' => $product->getId(),
            'name' => htmlspecialchars($product->getName()),
            'price' => $product->getPrice(),
            'currencyid' => $product->getCurrencyid(),
            'brandid' => $product->getBrandid(),
            'source' => $product->getSource(),
            'term' => $product->getTerm(),
            'pricebase' => $product->getPricebase(),
            'hidden' => $product->getHidden(),
            'unit' => $product->getUnit()
            );
            $status = 'success';
        } catch (ServiceUtils_Exception $se) {
            SQLObject::TransactionRollback();

            $status = 'error';
            $errorsArray = $se->getErrorsArray();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();

            $status = 'error';
            $errorsArray = array();
        }

        $json = array(
        'status' => $status,
        'result' => $result,
        'errors' => $errorsArray
        );

        echo json_encode($json);
        exit();
    }

}