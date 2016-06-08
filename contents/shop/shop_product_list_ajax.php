<?php
class shop_product_list_ajax extends Engine_Class {

    public function process() {

        $id = $this->getArgumentSecure('id') * 1;
        $key = trim($this->getArgumentSecure('key'));
        $url = urldecode(trim($this->getArgumentSecure('url')));

        $render = Engine::GetContentDriver()->getContent('shop-product-list');
        $render->setValue('items', $this->_getProducts($key, $id));
        $render->setValue('showtype', $this->getArgumentSecure('showtype'));
        if ($key == 'category') {
            $render->setValue('filterbrand', true);
            $render->setValue('filtervalue', true);
        } else if ($key == 'brand') {
            $render->setValue('filtercategory', true);
        }

        echo $render->render();
        exit();
    }

    /**
     * Получить продукты
     *
     * @param $key
     * @param $id
     * 
     * @return ShopProduct
     */
    private function _getProducts($key, $id) {
        if ($key == 'category') {
            try {
                $category = Shop::Get()->getShopService()->getCategoryByID($id);
                if ($category->getLogicclass()
                    && class_exists($category->getLogicclass())
                    && method_exists($category->getLogicclass(), 'getProducts')
                ) {
                    try {
                        $class = $category->getLogicclass();
                        $object = new $class;
                        return $object->getProducts();

                    } catch(Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                        return $category->getProducts();
                    }

                } else {
                    return $category->getProducts();
                }
            } catch (Exception $e) {

            }
        } else if ($key == 'brand') {
            try {
                try {
                    $brand = Shop::Get()->getShopService()->getBrandByID($id);
                    return $brand->getProducts();
                } catch (Exception $e) {

                }
            } catch (Exception $e) {

            }
        }
    }

}