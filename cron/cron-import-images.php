<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @package ComaTelecom
 * @copyright ComaTelecom
 */

// @deprecated
exit();

set_time_limit(0);
ini_set('pcre.backtrack_limit', 300000);

include(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$imagesDir = MEDIA_PATH.'sync-products/';
$productImages = array();

$d = opendir($imagesDir);
while ($x = readdir($d)) {
    if (preg_match("/^(\d+)/is", $x, $r)) {
        // print_r($r);
        $code = $r[1];

        $productImages[$code][] = $x;
    }
}
closedir($d);

//посортируем массивы с фотографиями для товара, учитывая возможную пользовательскую сортировку - вставляется в скобках
//перед концом названия файла
$a = array();
foreach($productImages as $k=>$v) {
    if (count($v) > 1) {
        usort($v, "cmp");
    }
    $a[$k] = $v;
}

foreach ($a as $productID => $imagesArray) {

    // добавляем-обновляем товар
    try {
        SQLObject::TransactionStart();

        $oProduct = Shop::Get()->getShopService()->getProductByID($productID);
        print "product found...";

        $im_objects = array();
        foreach($imagesArray as $k => $im) {
            // 1-ю картинка пойдет как основная для продукта
            if ($k == 0) {
                try {
                    if (!Checker::CheckImageFormat($imagesDir.$im)) {
                        throw new ServiceUtils_Exception('Invalid image format');
                    }

                    $file = Shop::Get()->getShopService()->makeImagesUploadUrl($imagesDir.$im);

                    if (!file_exists(MEDIA_PATH.'/shop/'.$file)) {
                        copy($imagesDir.$im, MEDIA_PATH.'/shop/'.$file);
                    }

                    if ($oProduct->getImage() != $file) {
                        $oProduct->setImage($file);
                    }
                } catch (Exception $ge) {
                    SQLObject::TransactionRollback();
                    throw $ge;
                }
            } else {
                $im_objects[] = Shop::Get()->getShopService()->addProductImage($oProduct, $imagesDir.$im);
            }
        }

        $oProduct->update();

        SQLObject::TransactionCommit();
        print "ok";
    } catch (Exception $ge) {
        SQLObject::TransactionRollback();
    }
    print "\n";
}

print "\n\ndone.\n\n";

function cmp($a, $b) {
    $x = $y = 0;
    if(preg_match("#\((\s*\d+\s*)\)\s*\.jpg$#is", $a, $r)) {
        $x = $r[1];
    }
    if(preg_match("#\((\s*\d+\s*)\)\s*\.jpg$#is", $b, $r)) {
        $y = $r[1];
    }
    if ($x && !$y)
    return 1;
    if (!$x && $y)
    return -1;
    if ($x && $y) {
        if ($x == $y) {
            return 0;
        }
        return ($x < $y) ? -1 : 1;
    }
}