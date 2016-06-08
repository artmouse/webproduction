<?php
class products_image_upload_ajax extends Engine_Class {

    public function process() {
        $id = $this->getArgument('id');
        $image = $this->getArgument('file');
        $product = Shop::Get()->getShopService()->getProductByID($id);

        $path = PackageLoader::Get()->getProjectPath().'media/shop/';
        $image = $path.$image;

        if ($this->getArgumentSecure('main')) {
            $product = Shop::Get()->getShopService()->addProductMainImageByImageUrl(
                $product,
                $image
            );

            print json_encode($product->getImage());
        } else {
            $imageObject = Shop::Get()->getShopService()->addProductImageByImageUrl(
                $product,
                $image
            );

            print json_encode($imageObject->getId());
        }
        exit(0);
    }

}