<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Shop
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class Shop {

    /**
     * Получить сервис
     *
     * @return Shop_UserService
     */
    public function getUserService() {
        return Shop_UserService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setUserService($service) {
        Shop_UserService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_AclService
     */
    public function getAclService() {
        return Shop_AclService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setAclService($service) {
        Shop_AclService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_FeedbackService
     */
    public function getFeedbackService() {
        return Shop_FeedbackService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setFeedbackService($service) {
        Shop_FeedbackService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_CallbackService
     */
    public function getCallbackService() {
        return Shop_CallbackService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setCallbackService($service) {
        Shop_CallbackService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_ProductsNoticeOfAvailabilityService
     */
    public function getProductsNoticeOfAvailabilityService() {
        return Shop_ProductsNoticeOfAvailabilityService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setProductsNoticeOfAvailabilityService($service) {
        Shop_ProductsNoticeOfAvailabilityService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_ShopService
     */
    public function getShopService() {
        return Shop_ShopService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setShopService($service) {
        Shop_ShopService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_CompareService
     */
    public function getCompareService() {
        return Shop_CompareService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setCompareService($service) {
        Shop_CompareService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_SettingsService
     */
    public function getSettingsService() {
        return Shop_SettingsService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setSettingService($service) {
        Shop_SettingsService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_FaqService
     */
    public function getFaqService() {
        return Shop_FaqService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setFaqService($service) {
        Shop_FaqService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_NewsService
     */
    public function getNewsService() {
        return Shop_NewsService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setNewsService($service) {
        Shop_NewsService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_FileService
     */
    public function getFileService() {
        return Shop_FileService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setFileService($service) {
        Shop_FileService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_DeliveryService
     */
    public function getDeliveryService() {
        return Shop_DeliveryService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setDeliveryService($service) {
        Shop_DeliveryService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_TextPageService
     */
    public function getTextPageService() {
        return Shop_TextPageService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     */
    public function setTextpageService($service) {
        Shop_TextPageService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_CurrencyService
     */
    public function getCurrencyService() {
        return Shop_CurrencyService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setCurrencyService($service) {
        Shop_CurrencyService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_SupplierService
     */
    public function getSupplierService() {
        return Shop_SupplierService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setSupplierService($service) {
        Shop_SupplierService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_NotificationService
     */
    public function getNotificationService() {
        return Shop_NotificationService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setNotificationService($service) {
        Shop_NotificationService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_GuestBookService
     */
    public function getGuestBookService() {
        return Shop_GuestBookService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setGuestbookService($service) {
        Shop_GuestBookService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_BlockService
     */
    public function getBlockService() {
        return Shop_BlockService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setBlockService($service) {
        Shop_BlockService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @deprecated
     *
     * @return Shop_NovaPoshtaApiService
     */
    public function getNovaPoshtaApiService() {
        return Shop_NovaPoshtaApiService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setNovaPoshtaApiService($service) {
        Shop_NovaPoshtaApiService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return SEOService
     *
     * @deprecated
     */
    public function getSEOService() {
        return SEOService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setSEOService($service) {
        SEOService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return PricePlaceService
     *
     * @deprecated
     */
    public function getPricePlaceService() {
        return PricePlaceService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setPricePlaceService($service) {
        PricePlaceService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_TranslateService
     */
    public function getTranslateService() {
        return Shop_TranslateService::Get();
    }

    /**
     * Задать сервис
     *
     * @param string $service
     *
     * @deprecated
     */
    public function setTranslateService($service) {
        Shop_TranslateService::Set($service);
    }

    /**
     * Получить сервис
     *
     * @return Shop_BannerService
     */
    public function getBannerService() {
        return Shop_BannerService::Get();
    }

    /**
     * Получить точку входа в Shop.
     *
     * @return Shop
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __clone() {

    }

    private static $_Instance = null;

}