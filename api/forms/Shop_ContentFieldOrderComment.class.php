<?php

/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class Shop_ContentFieldOrderComment extends Forms_ContentFieldTextarea {

    /**
     * Отрисовать поле для просмотра (в табличном выводе, например).
     *
     * @param int $rowIndex
     * @param array $cellsArray
     * @return string
     */
    public function renderView($rowIndex, $cellsArray) {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID($cellsArray['id']);

            $value = $order->makeComment();
        } catch (Exception $orderEx) {
            $value = false;
        }

        //$value = @htmlspecialchars($cellsArray[$this->getKey()]);

        // если можно ограничить запись - ограничиеваем ее
        if (PackageLoader::Get()->isImported('StringUtils')) {
            $l = $this->getViewLimitLength();
            if ($l > 0) {
                $valueSmall = StringUtils_Limiter::LimitLength($value, $l);

                if ($valueSmall == $value) {
                    return $valueSmall;
                }

                return $this->getContentView()->render(array(
                'value' => $valueSmall,
                'hint' => $value
                ));
            }
        }

        return $value;
    }

}