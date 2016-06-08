<?php

class shop_search extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgument('query');

            $url = Engine::GetLinkMaker()->makeURLByContentIDParam('shop-search', urlencode($query), 'queryfixed');
            header('Location: '.$url);
            exit();
        } catch (Exception $e) {

        }

        try {
            $query = urldecode($this->getArgument('queryfixed'));
            Engine::GetURLParser()->setArgument('query', $query);

            $products = $this->searchProducts(
                $query
            );



            Engine::GetHTMLHead()->setTitle($this->getControlValue('query'));
            $slogan = Shop::Get()->getSettingsService()->getSettingValue('shop-slogan');
            if ($slogan) {
                Engine::GetHTMLHead()->setMetaDescription($slogan);
            }

            $products->setHidden(0);
            $products->addWhere('showincategory', 1, '=');
            $this->setValue('count', $products->getCount());

            $render = Engine::GetContentDriver()->getContent('shop-product-list');
            $render->setValue('items', $products);
            $this->setValue('items', $render->render());


        } catch (Exception $e) {
            $this->setValue('error', true);
            echo $e->getMessage();
        }
    }

    public function searchProducts($query, $log = true) {
        $query = trim($query);
        if (strlen($query) < 3 && !is_numeric($query)) {
            throw new ServiceUtils_Exception();
        }


        $products = Shop::Get()->getShopService()->getProductsAll();
        $connection = $products->getConnectionDatabase();

        if ((strlen($query) >= 3) && !is_numeric($query) && (strlen($query) < 7)) {
            $products->addWhere('code1c', $query, '=');
            $productsTmp = clone $products;
            if ($productsTmp->select()) {
                return $products;
            }
        }

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        $products->setDeleted(0);

        // Если user.level>=2 то искать даже hidden товары
        // issue #17016
        try {
            if (!Shop::Get()->getUserService()->getUser()->isAdmin()) {
                throw new ServiceUtils_Exception();
            }
        } catch (Exception $e) {
            $products->setHidden(0);
        }


        foreach ($a as $part) {
            $w = array();
            $orderBy = array();

            if (is_numeric($part)) {
                $w[] = $products->getTablename().".id = '$part'";
                // если длинна строки == 13 - значит поиск по штрих-коду
                if (strlen($part) == 13) {
                    $w[] = $products->getTablename().".barcode = '$part'";
                }
            }
            if (Shop::Get()->getSettingsService()->getSettingValue('use-code-1c')) {
                $w[] = $products->getTablename().".code1c LIKE '%$part%'";
            }
            $w[] = $products->getTablename().".inventarnumber LIKE '%$part%'";
            $w[] = $products->getTablename().".name LIKE '%$part%'";
            $w[] = $products->getTablename().".seokeywords LIKE '%$part%'";
            $w[] = $products->getTablename().".description LIKE '%$part%'";

            $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$part%' THEN 2 ELSE 0 END)";

            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);

                $partTr = $connection->escapeString($partTr);

                $w[] = $products->getTablename().".name LIKE '%$partTr%'";
                $w[] = $products->getTablename().".seokeywords LIKE '%$partTr%'";
                $w[] = $products->getTablename().".description LIKE '%$partTr%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$partTr%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);

                $partRu = $connection->escapeString($partRu);

                $w[] = $products->getTablename().".name LIKE '%$partRu%'";
                $w[] = $products->getTablename().".seokeywords LIKE '%$partRu%'";
                $w[] = $products->getTablename().".description LIKE '%$partRu%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$partRu%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);

                $partEn = $connection->escapeString($partEn);

                $w[] = $products->getTablename().".name LIKE '%$partEn%'";
                $w[] = $products->getTablename().".seokeywords LIKE '%$partEn%'";
                $w[] = $products->getTablename().".description LIKE '%$partEn%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$partEn%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            $products->addWhereQuery("(".implode(' OR ', $w).")");
        }

        $products->addFieldQuery(implode('+', $orderBy).' AS relevance');
        $products->setOrder('`relevance`', 'DESC');

        // записываем в историю
        if ($log) {
            $log = new XShopSearchLog();
            $log->setCdate(date('Y-m-d H:i:s'));
            @session_start();
            $log->setSid(@session_id());
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $log->setUserid($user->getId());
            } catch (Exception $e) {

            }
            $log->setQuery($query);
            $log->setCountresult($products->getCount());
            $log->insert();
        }

        return $products;
    }

}