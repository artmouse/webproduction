<?php

require(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$path = MEDIA_PATH.'shop/';
$accept = @$argv[1];
foreach (scandir($path) as $item => $key) {
    if ($key == '.' || $key == '..') {
        continue;
    }
    $path2 = $path.$key;
    if (!@scandir($path2)) {
        continue;
    }
    foreach (scandir($path2) as $item2 => $key2) {
        if ($key2 == '.' || $key2 == '..') {
            continue;
        }
        $path3 = $path2."/".$key2;
        if (!@scandir($path3)) {
            continue;
        }
        foreach (scandir($path3) as $item3 => $key3) {
            if ($key3 == '.' || $key3 == '..') {
                continue;
            }
            $path4 = $path3."/".$key3;
            if (preg_match('/.jpg|.png|.jpeg/ius', $path4)) {
                $product = new XShopProduct();
                $product->addWhereQuery("image LIKE '%".$key3."%' OR imagecrop LIKE '%".$key3."%'");
                $product = $product->getNext();
                $prodImg = new XShopImage();
                $prodImg->addWhere('file', "%".$key3."%", 'LIKE');
                $prodImg = $prodImg->getNext();

                $banner = new XShopBanner();
                $banner->addWhere('image', "%".$key3."%", 'LIKE');
                $banner = $banner->getNext();
                                    
                $user = new XUser();
                $user->addWhere('image', "%".$key3."%", 'LIKE');
                $user = $user->getNext();
                                                  
                $category = new XShopCategory();
                $category->addWhereQuery(
                    "image LIKE '%".$key3."%' OR imagecrop LIKE '%".$key3."%'"
                );
                $category = $category->getNext();

                $brands = new XShopBrand();
                $brands->addWhere('image', "%".$key3."%", 'LIKE');
                $brands = $brands->getNext();
                                    
                $logo = new XShopLogo();
                $logo->addWhere('file', "%".$key3."%", 'LIKE');
                $logo = $logo->getNext();
                                    
                if (!$product && !$prodImg && !$banner && !$user && !$category && !$brands && !$logo) {
                    if ($accept) {
                        if (!file_exists(MEDIA_PATH.'/tmp/to-delete/')) {
                            mkdir(MEDIA_PATH.'/tmp/to-delete/');
                        }
                        rename($path3."/".$key3, MEDIA_PATH.'/tmp/to-delete/'.$key3);
                    }
                    print "Delete: ".$path4."\n";
                }
            }
            if (!@scandir($path4)) {
                continue;
            }
            foreach (scandir($path4) as $item4 => $key4) {
                if ($key4 == '.' || $key4 == '..') {
                    continue;
                }
                $path5 = $path4."/".$key4;
                if (preg_match('/.jpg|.png|.jpeg/ius', $path5)) {
                    $product = new XShopProduct();
                    $product->addWhereQuery("image LIKE '%".$key4."%' OR imagecrop LIKE '%".$key4."%'");
                    $product = $product->getNext();

                    $prodImg = new XShopImage();
                    $prodImg->addWhere('file', "%".$key4."%", 'LIKE');
                    $prodImg = $prodImg->getNext();

                    $banner = new XShopBanner();
                    $banner->addWhere('image', "%".$key4."%", 'LIKE');
                    $banner = $banner->getNext();
                                                           
                    $user = new XUser();
                    $user->addWhere('image', "%".$key4."%", 'LIKE');
                    $user = $user->getNext();
                    
                                        
                    $category = new XShopCategory();
                    $category->addWhereQuery(
                        "image LIKE '%".$key4."%' OR imagecrop LIKE '%".$key4."%'"
                    );
                    $category = $category->getNext();
                    
                    $brands = new XShopBrand();
                    $brands->addWhere('image', "%".$key4."%", 'LIKE');
                    $brands = $brands->getNext();
                    
                    $logo = new XShopLogo();
                    $logo->addWhere('file', "%".$key3."%", 'LIKE');
                    $logo = $logo->getNext();
                    
                    if (!$product && !$prodImg && !$banner && !$user && !$category && !$brands && !$logo) {
                        if ($accept) {
                            if (!file_exists(MEDIA_PATH.'/tmp/to-delete/')) {
                                mkdir(MEDIA_PATH.'/tmp/to-delete/');
                            }
                            rename($path4."/".$key4, MEDIA_PATH.'/tmp/to-delete/'.$key4);
                        }
                        print "Delete: ".$path5."\n";
                    }
                }
                if (!@scandir($path5)) {
                    continue;
                }
                foreach (scandir($path5) as $item5 => $key5) {
                    if ($key5 == '.' || $key5 == '..') {
                        continue;
                    }
                    $product = new XShopProduct();
                    $product->addWhereQuery("image LIKE '%".$key5."%' OR imagecrop LIKE '%".$key5."%'");
                    $product = $product->getNext();

                    $prodImg = new XShopImage();
                    $prodImg->addWhere('file', "%".$key5."%", 'LIKE');
                    $prodImg = $prodImg->getNext();

                    $banner = new XShopBanner();
                    $banner->addWhere('image', "%".$key5."%", 'LIKE');
                    $banner = $banner->getNext();
                    
                    $user = new XUser();
                    $user->addWhere('image', "%".$key5."%", 'LIKE');
                    $user = $user->getNext();
                    
                    $category = new XShopCategory();
                    $category->addWhereQuery(
                        "image LIKE '%".$key5."%' OR imagecrop LIKE '%".$key5."%'"
                    );
                    $category = $category->getNext();
                    
                    $brands = new XShopBrand();
                    $brands->addWhere('image', "%".$key5."%", 'LIKE');
                    $brands = $brands->getNext();
                    
                    $logo = new XShopLogo();
                    $logo->addWhere('file', "%".$key3."%", 'LIKE');
                    $logo = $logo->getNext();
                    
                    if (!$product && !$prodImg && !$banner && !$user && !$category && !$brands && !$logo) {
                        if ($accept) {
                            if (!file_exists(MEDIA_PATH.'/tmp/to-delete/')) {
                                mkdir(MEDIA_PATH.'/tmp/to-delete/');
                            }
                            rename($path5."/".$key5, MEDIA_PATH.'/tmp/to-delete/'.$key5);
                        }
                        print "Delete: ".$path5."/".$key5."\n";
                    }
                }
            }
        }
    }
}