<?php
class action_block_ajax extends Engine_Class {

    public function process() {
        $contentId = $this->getArgument('contentId');
        if (Engine::GetContentDataSource()->getDataByID($contentId)) {
            $block = Engine::GetContentDriver()->getContent($contentId);
            $block->setValue('status', Shop::Get()->getShopService()->getStatusByID($this->getArgument('statusid')));
            $block->setValue('index', $this->getArgument('index'));

            $contentBlock = new XShopOrderStatusActionBlock();
            $contentBlock->setContentid($block->getContentid());
            $contentBlock = $contentBlock->getNext();
            if ($contentBlock) {
                $block->setValue('description', $contentBlock->getDescription());
                $block->setValue('blockName', $contentBlock->getName());
            }
            $html = $block->render();
        } else {
            $html = false;
        }

        echo json_encode(array('html' => $html, 'index' => $this->getArgument('index')));
        exit;
    }

}