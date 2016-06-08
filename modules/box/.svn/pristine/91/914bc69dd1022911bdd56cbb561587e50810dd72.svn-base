<?php
class file_index extends Engine_Class {

    public function process() {
        $files = Shop::Get()->getFileService()->getFilesAll();

        $block = Engine::GetContentDriver()->getContent('admin-file-block-list');
        $block->setValue('files', $files);
        $this->setValue('block', $block->render());
    }

}