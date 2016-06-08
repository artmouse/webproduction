<?php
/*
 * @author i.ustimenko
 * @copyright WebProduction
 * @package Shop
 */
class Shop_Event_Category extends Events_Event {

    /*
     * 
     * @param ShopCategory category
     */
    public function setCategory(ShopCategory $category) {
        $this->_category = $category;
    }

    /*
     * 
     * @return ShopCategory
     */
    public function getCategory() {
        return $this->_category;
    }

    private $_category;

}