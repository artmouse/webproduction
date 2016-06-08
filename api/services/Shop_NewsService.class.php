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
 * Сервис по работе с новостями
 *
 * @author Golub Oleksii <avator@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_NewsService extends ServiceUtils_AbstractService {

    /**
     * Получить заказные звонки
     *
     * @return ShopNews
     */
    public function getNewsAll() {
        $x = new ShopNews();
        $x->setOrder('cdate', 'DESC');
        return $x;
    }

    /**
     * Получить новость по ID
     *
     * @return ShopNews
     */
    public function getNewsByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopNews');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить новости по товару
     *
     * @param ShopProduct $product
     *
     * @return ShopNews
     */
    public function getNewsByProduct(ShopProduct $product) {
        $n = $this->getNewsAll();
        $n->setHidden(0);
        $n->setProductid($product->getId());
        return $n;
    }

    /**
     * Получить новость по URL
     *
     * @param string $url
     *
     * @return ShopNews
     */
    public function getNewsByURL($url) {
        if (!$url) {
            throw new ServiceUtils_Exception();
        }

        $x = new ShopNews();
        $x->setUrl($url);
        if ($x->select()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Обновить новость
     *
     * @param ShopNews $news
     * @param $cdate
     * @param $hidden
     * @param $name
     * @param $contentPreview
     * @param $content
     * @param $image
     * @param $productid
     * @param $seodescription
     * @param $seotitle
     * @param $seocontent
     * @param $seokeywords
     *
     * @throws ServiceUtils_Exception
     * @throws Exception
     */
    public function updateNews(ShopNews $news, $cdate, $hidden, $name, $contentPreview, $content, $image,
    $imageDelete, $productid, $categoryID, $brandID, $url, $seodescription, $seotitle, $seocontent, $seokeywords ) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            if (!$name) {
                $ex->addError('name');
            }

            if (!Checker::CheckDate($cdate)) {
                $ex->addError('cdate');
            }

            if ($image && !Checker::CheckImageFormat($image)) {
                $ex->addError('image');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $url = trim($url);

            $news->setCdate($cdate);
            $news->setHidden($hidden);
            $news->setName($name);
            $news->setContent($content);
            $news->setContentpreview($contentPreview);
            $news->setProductid($productid);
            $news->setCategoryid($categoryID);
            $news->setBrandid($brandID);
            $news->setSeodescription($seodescription);
            $news->setSeotitle($seotitle);
            $news->setSeocontent($seocontent);
            $news->setSeokeywords($seokeywords);

            if ($imageDelete) {
                $news->setImage('');
            }

            if ($image) {
                // конвертация изображения в необходимый формат
                // и допустимый размер
                $image = Shop::Get()->getShopService()->convertImage($image);

                $file = Shop::Get()->getShopService()->makeImagesUploadUrl(
                    $image,
                    '/shop/',
                    false
                );
                copy($image, PackageLoader::Get()->getProjectPath().'media/shop/'.$file);

                $news->setImage($file);
            }

            $news->update();

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Добавить новость
     *
     * @param string $cdate
     * @param bool $hidden
     * @param string $name
     * @param string $contentPreview
     * @param string $content
     * @param string $image
     * @param int $productid
     * @param int $categoryID
     * @param int $brandID
     * @param string $url
     * @param string $seodescription
     * @param string $seotitle
     * @param string $seocontent
     * @param string $seokeywords
     *
     * @return ShopNews
     */
    public function addNews($cdate, $hidden, $name, $contentPreview, $content, $image, $productid, $categoryID,
    $brandID, $url, $seodescription, $seotitle, $seocontent, $seokeywords) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            if (!$name) {
                $ex->addError('name');
            }

            if ($image && !Checker::CheckImageFormat($image)) {
                $ex->addError('image');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            if (!$cdate) {
                $cdate = date('Y-m-d H:i:s');
            }

            $url = trim($url);

            $x = new ShopNews();
            $x->setCdate($cdate);
            $x->setHidden($hidden);
            $x->setName($name);
            $x->setContent($content);
            $x->setContentpreview($contentPreview);
            $x->setProductid($productid);
            $x->setCategoryid($categoryID);
            $x->setBrandid($brandID);
            $x->setSeodescription($seodescription);
            $x->setSeotitle($seotitle);
            $x->setSeocontent($seocontent);
            $x->setSeokeywords($seokeywords);

            if ($image) {
                // конвертация изображения в необходимый формат
                // и допустимый размер
                $image = Shop::Get()->getShopService()->convertImage($image);

                $file = Shop::Get()->getShopService()->makeImagesUploadUrl(
                    $image,
                    '/shop/',
                    false
                );

                copy($image, PackageLoader::Get()->getProjectPath().'media/shop/'.$file);

                $x->setImage($file);
            }

            $x->insert();

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Удаление новости
     *
     * @param $newsID
     *
     * @throws Exception
     */
    public function deleteNewsByID($newsID) {
        try {
            SQLObject::TransactionStart();

            $news = $this->getNewsByID($newsID);
            $news->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    public function makeImageThumb($width = 200, $height = false, $method = 'prop') {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {
            return false;
        }

        // получаем формат
        $format = Shop::Get()->getSettingsService()->getSettingValue('image-format');
        $format = strtolower($format);
        if ($format != 'png' && $format != 'jpg') {
            $format = 'jpg';
        }

        // ширина меньше 100px смысла не имеет
        if ($width <= 100) {
            $width = 100;
        }

        // приводим размер изображений к кратности 100px (в большую сторону)
        $width = round(ceil($width / 100) * 100);

        return ImageProcessor_Thumber::makeThumbUniversal($src, $width, $height, $method, PROJECT_PATH, $format);
    }
    
    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_NewsService
     */
    public static function Get() {
        if (!self::$_Instance) {
            $classname = self::$_Classname;
            if ($classname) {
                self::$_Instance = new $classname();
            } else {
                self::$_Instance = new self();
            }
        }
        return self::$_Instance;
    }

    /**
     * Задать класс сервиса.
     * override-метод.
     *
     * @param string $classname
     */
    public static function Set($classname) {
        self::$_Classname = $classname;
        self::$_Instance = null;
    }

    /**
     * Подменяемый объект сервиса
     *
     * @var Shop_NewsService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}