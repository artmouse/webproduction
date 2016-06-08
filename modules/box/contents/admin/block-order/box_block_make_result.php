<?php
class box_block_make_result extends Engine_Class {

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

    public function process() {
        // получаем заказ
        $order = $this->_getOrder();
        $process = $this->getValue('process');

        // текущий авторизированный пользователь
        $user = $this->getUser();
        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);

        PackageLoader::Get()->registerJSFile('/_js/admin/comment.js');

        // когда нажата кнопка Сохранить
        if (!$process && $canEdit && $this->getControlValue('ok')) {

            // добавления комментария/файла
            $comment = $this->getControlValue('postcomment_result');
            $comment = trim($comment);
            $fileIDArray = $this->getArgumentSecure('fileid_result', 'array');

            if (($comment || $fileIDArray)
                && $this->getArgumentSecure('commenttype') == 'comment') {
                try {
                    Shop::Get()->getShopService()->addOrderResult(
                        $order,
                        $this->getUser(),
                        $comment,
                        $fileIDArray
                    );

                    $this->setValue('message', 'commentok');
                } catch (Exception $commentException) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $commentException;
                    }

                    $this->setValue('message', 'commenterror');
                }
            }

        }

    }

}