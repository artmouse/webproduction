<?php

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$files = Shop::Get()->getFileService()->getFilesAll();
while ($x = $files->getNext()) {
    
    $filePath = $x->makePath();
    if (file_exists($filePath)) {
        $hash = $x->getFile();
        $product = new XShopProduct();
        $product->addWhereQuery("image LIKE '%".$hash."%' OR imagecrop LIKE '%".$hash."%'");
        $product = $product->getNext();
        $prodImg = new XShopImage();
        $prodImg->addWhere('file', "%".$hash."%", 'LIKE');
        $prodImg = $prodImg->getNext();

        $banner = new XShopBanner();
        $banner->addWhere('image', "%".$hash."%", 'LIKE');
        $banner = $banner->getNext();

        $user = new XUser();
        $user->addWhere('image', "%".$hash."%", 'LIKE');
        $user = $user->getNext();

        $category = new XShopCategory();
        $category->addWhereQuery(
            "image LIKE '%".$hash."%' OR imagecrop LIKE '%".$hash."%'"
        );
        $category = $category->getNext();

        $brands = new XShopBrand();
        $brands->addWhere('image', "%".$hash."%", 'LIKE');
        $brands = $brands->getNext();

        $logo = new XShopLogo();
        $logo->addWhere('file', "%".$hash."%", 'LIKE');
        $logo = $logo->getNext();
        
        if (!$product && !$prodImg && !$banner && !$user && !$category && !$brands && !$logo) {
            unlink($filePath);
            $x->delete();
            print "Delete file #".$x->getId()."\n";
        }
    } else {
        print "Skip file #".$x->getId()."\n";
        $x->delete();
    }
    
}