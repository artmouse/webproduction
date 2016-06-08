<?php
class shop_search_json_autocomplete extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgument('name');

            $a = array();

            $showNoImageProducts = Shop::Get()->getSettingsService()->getSettingValue('show-nophoto-products');

            // поиск по товарам
            $products = Shop::Get()->getShopService()->searchProducts($query, false);
            $products->addWhere('showincategory', 1, '=');
            $products->setLimitCount(10);
            $products->setHidden(0);
            $products->setDeleted(0);


            while ($x = $products->getNext()) {

                if (!$showNoImageProducts && !$x->getImage()) {
                    continue;
                }

                $description = strip_tags($x->getDescription());
                $description = StringUtils_Limiter::LimitWordsSmart($description, 20);

                $a[] = array(
                    'id' => $x->getId(),
                    'name' => htmlspecialchars($x->getName()),
                    'url' => $x->makeURL(),
                    'image' => $x->makeImageThumb(100),
                    'description' => $description,
                );
            }

            // поиск по текстовым страницам
            $queryEscape = ConnectionManager::Get()->getConnectionDatabase()->escapeString($query);
            $queryEscape = str_replace(' ', '%', $queryEscape);
            $textpages = new ShopTextPage();
            $textpages->addWhereQuery("name LIKE '%$queryEscape%' OR content LIKE '%$queryEscape%'");
            while ($x = $textpages->getNext()) {
                $description = strip_tags($x->getContent());
                $description = StringUtils_Limiter::LimitWordsSmart($description, 20);

                $a[] = array(
                    'id' => $x->getId(),
                    'name' => htmlspecialchars($x->getName()),
                    'url' => $x->makeURL(),
                    'image' => false,
                    'description' => $description,
                );
            }

            echo json_encode($a);
        } catch (Exception $e) {

        }

        exit();
    }

}