<?php
class box_block_files extends Engine_Class {

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
        $user = $this->getUser();


        // файлы-вложения
        $files = new ShopFile();
        $files->setKey('order-'.$order->getId());
        $files->setDeleted(0);
        $a = array();
        while ($x = $files->getNext()) {
            try {
                $username = Shop::Get()->getUserService()->getUserByID($x->getUserid())->makeName(true, 'lfm');
            } catch (Exception $e) {
                $username = false;
            }

            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'url' => $x->makeURL(),
                'username' => $username,
                'cdate' => $x->getCdate(),
                'size' => $x->makeSize(),
                'urlDelete' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                    array(
                        'filedelete' => $x->getId()
                    )
                ),
            );
        }
        $this->setValue('fileArray', $a);

        // удаление файла
        try {
            $file = new ShopFile(
                $this->getArgument('filedelete')
            );

            $file->setDeleted(1);
            $file->update();
        } catch (Exception $e) {

        }

    }

}