<?php
class block_comment_product extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID($this->getValue('productid'));
            $productBlock = Engine::GetContentDriver()->getContent('shop-product');

            // ловим комментарий
            if ($this->getControlValue('submitcomment')) {
                try {
                    if ($this->getControlValue('ajs') != 'ready') {
                        throw new ServiceUtils_Exception('bot');
                    }

                    Shop::Get()->getShopService()->addProductComment(
                        $product,
                        $this->getUser(),
                        $this->getControlValue('postcomment'),
                        $this->getControlValue('postplus'),
                        $this->getControlValue('postminus'),
                        $this->getControlValue('commentrating'),
                        $this->getArgumentSecure('upload_image', 'file')
                    );


                } catch (Exception $commentException) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $commentException;
                    }

                    $productBlock->setValue('message', 'commenterror');
                }
            }

            // комментарии по товару
            if (!$product->getDenycomments()) {
                // получить отзывы о товаре
                $comments = Shop::Get()->getShopService()->getProductComments($product);
                $commentProduct = $this->_commentProductArray($comments);
                // если кол-во комментариев в товару <5, то добавить отзывами о магазине
                if (5 > count($commentProduct)) {
                    // массив отзывов о магазине для тех товаров у кого меньше 5 отзывов
                    $commentShop = $this->_commentShopArray($product, 5-count($commentProduct));
                    $commentProduct = array_merge($commentProduct, $commentShop);
                }

                $productBlock->setValue('commentsArray', $commentProduct);

                // разрешено ли комментировать товар?
                $productBlock->setValue('allowcomment', $this->isUserAuthorized());
                if ($this->isUserAuthorized()) {
                    $ratingArray = array(0, 1, 2, 3, 4, 5);
                    $productBlock->setValue('ratingArray', $ratingArray);
                }
            }
        } catch (Exception $e) {

        }
    }
    
    private function _commentProductArray (ShopProductComment $comments) {
        $a = array();
        $index = 0;
        while ($x = $comments->getNext()) {
            $name = $x->getUsername();
            if (!$name) {
                try {
                    $name = htmlspecialchars(Shop::Get()->getUserService()->getUserByID($x->getUserid())->getName());
                } catch (Exception $e) {

                }
            }

            $a[] = array(
                'id' => $x->getId(),
                'index' => $index,
                'content' => htmlspecialchars($x->getText()),
                'plus' => htmlspecialchars($x->getPlus()),
                'minus' => htmlspecialchars($x->getMinus()),
                'datetime' => DateTime_Formatter::DateISO9075($x->getCdate()),
                'rating' => $x->getRating(),
                'name' => $name,
                'image' => $x->makeImage(),
                'imagecrop' => $x->makeImageThumb(),
                'answer' => $x->getAnswer(),
                'shopgb' => 0,
            );
            $index ++;
        }
        return $a;
    }

    private function _commentShopArray (ShopProduct $product, $cnt) {
        // последняя цифра id коммента о магазине = последней цифре id товара
        // делительдля полсеней цифры
        $i = 10;
        $sql = "id%".$i." LIKE '%".$product->getId() % $i."'";
        $shopComment = $this->_commentShopBlockArray($cnt, $sql);
        //если отзывов не хватило - добавить последние, которые еще не брались
        if ($cnt > count($shopComment)) {
            $sql = "id%".$i." NOT LIKE '%".$product->getId() % $i."'";
            $shopCommentRand = $this->_commentShopBlockArray($cnt-count($shopComment), $sql);

            return array_merge($shopComment, $shopCommentRand);
        }
        return $shopComment;
    }

    private function _commentShopBlockArray ($cnt, $sql) {
        // последняя цифра id коммента о магазине = последней цифре id товара
        $a = array();
        $shopComments = new ShopGuestBook();
        $shopComments->setDone(1);
        $shopComments->addWhereQuery($sql);
        $shopComments->setOrder('cdate', 'DESC');
        $shopComments->setLimitCount($cnt);
        while ($comment = $shopComments->getNext()) {
            $namegb = $comment->getName();
            if (!$namegb) {
                try {
                    $namegb = htmlspecialchars(
                        Shop::Get()->getUserService()->getUserByID($comment->getUserid())->getName()
                    );
                } catch (Exception $e){

                }
            }
            $a[] = array(
                'id' => $comment->getId(),
                'content' => htmlspecialchars($comment->getText()),
                'datetime' => DateTime_Formatter::DateISO9075($comment->getCdate()),
                'name' => $namegb,
                'shopgb' => 1,
            );
        }
        return $a;
    }

}