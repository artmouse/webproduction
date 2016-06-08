<?php
class load_product_properties_ajax extends Engine_Class {

    public function process() {
        $produtId = $this->getArgumentSecure('id');
        if ($produtId) {
            $properties = $this->_getProductPropertiesArray($produtId);
            if ($properties) {
                echo json_encode($properties);
            } else {
                echo 'error';
            }
        }

    }

    /**
     * @param $productId
     * @return array|bool
     */
    private function _getProductPropertiesArray($productId) {

        try {
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencyDefault();

            $product = Shop::Get()->getShopService()->getProductByID($productId);

            $pricesArr = RtmService::Get()->getProductPricesArray($product, $currencyDefault);

            list($proba, $weight) = explode(' ', $product->getExchangeweight());
            $exchangeWeight = '';

            if ($proba && $weight) {
                $exchangeWeight = $proba.'&deg; '.$weight.'г';
            }
            $inventarNumber = $product->getInventarnumber();
            $productName = $product->getName(false);
            $productNameSmall = mb_strtolower($productName);
            $title = $productName.', код: '.$inventarNumber.' | Ремточмеханика';
            $metakewords =  mb_strtolower($productNameSmall).', золотой, код: '.$inventarNumber.', киев, интернет-магазин, ремточмеханика';
            $padezhArray = array(
                'браслет' => 'Золотой',
                'булавк' => 'Золотая',
                'значек' => 'Золотой',
                'кольцо' => 'Золотое',
                'кулон' => 'Золотой',
                'перстень' => 'Золотой',
                'крест' => 'Золотой',
                'крестик' => 'Золотой',
                'ладанка' => 'Золотая',
                'серьга' => 'Золотая',
                'серьги' => 'Золотые',
                'цепь' => 'Золотая',
            );
            $metaDescription = '';
            foreach ($padezhArray as $key => $val) {
                if (substr_count($productNameSmall,$key)) {
                    $metaDescription = $val;
                    break;
                }
            }
            if (!$metaDescription) {
                $metaDescription = 'Золотой';
            }
            $metaDescription .= ' '.$productNameSmall.', код: '.$inventarNumber.'. Интернет-магазин ювелирных изделий “Ремточмеханика” - широкий ассортимент украшений, превосходное качество.';

            $a = array (
                'id' => $product->getId(),
                'inventarNumber' => $inventarNumber,
                'name' => htmlspecialchars($product->getName()),
                'price' => number_format($pricesArr['price'], 0, '.', ' '),
                'priceProduct' => number_format($pricesArr['productPrice'], 0, '.', ' '),
                'priceOld' => number_format($pricesArr['priceOld'], 0, '.', ' '),
                'priceProductOld' => number_format($pricesArr['productPriceOld'], 0, '.', ' '),
                'weight' => 'Вес изделия: '.$product->getWeight(),
                'exchangeWeightChar' => 'Вес золота для обмена: '.$weight,
                'exchangeWeight' => $exchangeWeight,
                'url' => $this->_getSimilarProductUrl($product->makeURL()),
                'currency' => $currencyDefault->getSymbol(),
                'title' => $title,
                'metakewords' => $metakewords,
                'metaDescription' => $metaDescription,
            );

            return $a;

        } catch (Exception $e) {
            return false;
        }

    }

    /**
     * @param $url
     * @return mixed
     */
    private function _getSimilarProductUrl($url) {
        if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $h = 'https://';
        } else {
            $h = 'http://';
        }
        return str_replace($h.Engine::Get()->getProjectHost(), '', $url);
    }

}