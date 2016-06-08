<?php
class products_menu extends Engine_Class {

    public function process() {
        try {
            $user = $this->getUser();
            $productID = $this->getArgument('id');
            $product = Shop::Get()->getShopService()->getProductByID($productID);
            $this->setValue('productId', $productID);
            $this->setValue('productName', $product->makeName());
            $isOwner = ($user->getId() == $product->getUserid());

            if ($product->getImage()) {
                $this->setValue('image', $product->makeImageThumb(50, 50));
                $this->setValue('bigImage', '/media/shop/'.$product->getImage());
            }

            $this->setValue('description', $product->makeCharacteristicsString());

            $this->setValue(
                'canEdit',
                ($user->isAllowed('products-edit') || ($isOwner && $user->isAllowed('products-owner-edit')))
            );

            $this->setValue('canViewSuppliers', $user->isAllowed('products-suppliers'));
            $this->setValue('canViewFilters', $user->isAllowed('products-filters'));
            $this->setValue('canViewViews', $user->isAllowed('products-views'));
            $this->setValue('canViewComments', $user->isAllowed('products-comments'));
            $this->setValue('canViewHistory', $user->isAllowed('products-history'));
            $this->setValue('canViewPriceplaces', $user->isAllowed('priceplaces'));
            $this->setValue('canViewRelated', $user->isAllowed('products-related'));
            $this->setValue('canViewLists', $user->isAllowed('products-lists'));
            $this->setValue('canDelete', $user->isAllowed('products-delete'));

            // дополнительные табы от модулей
            $moduleTabArray = Shop_ModuleLoader::Get()->getProductTabArray($user);
            foreach ($moduleTabArray as $k => $moduleTabInfo) {
                $moduleTabArray[$k]['url'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                    $moduleTabInfo['contentID'],
                    $product->getId()
                );
            }
            $this->setValue('moduleTabArray', $moduleTabArray);

            $this->setValue('menuColor', Shop::Get()->getSettingsService()->getSettingValue('color-menu'));

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
        }
    }

}