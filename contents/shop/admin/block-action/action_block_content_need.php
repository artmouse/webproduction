<?php
class action_block_content_need extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));
    }

    public function processData() {
        $index = $this->getValue('index');

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode(
                array(
                    'data' => 1
                )
            )
        );

        $status = $this->_getStatus();
        $status->setNeedcontent(1);
        $status->update();
    }

    public function processDataDelete() {
        $status = $this->_getStatus();
        $status->setNeedcontent(0);
        $status->update();
    }

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

}