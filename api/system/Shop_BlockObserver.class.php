<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Подключить все активные блоки
 *
 * @copyright WebProduction
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 */
class Shop_BlockObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $contentObject = $event->getContent();

        // сами в себя не передаем
        if (substr_count($contentObject->getContentID(), 'block-')) {
            return;
        }

        if (substr_count($contentObject->getContentID(), '-ajax')) {
            return;
        }

        // строим массив блоков
        if (!$this->_blockArray) {
            $index = 0;

            $blocks = Shop::Get()->getBlockService()->getBlocksActive();
            while ($x = $blocks->getNext()) {
                try {
                    if ($x->getPosition()) {
                        // динамический блокс позиционированием,
                        // передается в контент в заранее заданные переменные

                        $key = 'block_position_'.$x->getPosition();

                        $this->_blockPositionedArray[$key][] = array(
                        'index' => $index,
                        'html' => Engine::GetContentDriver()->getContent($x->getContentid())->render(),
                        'sort' => $x->getPositionsort(),
                        );

                        $index ++;
                    } else {
                        // обычный блок
                        $key = str_replace('-', '_', $x->getContentid());
                        $this->_blockArray[$key] = Engine::GetContentDriver()->getContent(
                            $x->getContentid()
                        )->render();
                    }
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            if ($this->_blockPositionedArray) {
                // сортировка позицинных блоков
                uasort($this->_blockPositionedArray, array($this, '_sortPositionBlocks'));

                // превращение блоков в html
                foreach ($this->_blockPositionedArray as $key => $blockArray) {
                    foreach ($blockArray as $data) {
                        if (!isset($this->_blockArray[$key])) {
                            $this->_blockArray[$key] = '';
                        }

                        $this->_blockArray[$key] .= $data['html'];
                    }
                }
            }

            unset($this->_blockPositionedArray);
        }

        // передаем все блоки в каждый контент
        // (фактический notify)
        $contentObject->addValuesArray($this->_blockArray);

        // передаем все баннера
        if (!$this->_bannerPlacedArray) {
            $bannerArray = Shop::Get()->getShopService()->getBanners();
            foreach ($bannerArray as $x) {
                $this->_bannerPlacedArray['banner_'.$x['place']][] = $x;
            }
        }
        $contentObject->addValuesArray($this->_bannerPlacedArray);
    }

    private function _sortPositionBlocks($a, $b) {
        // сначала сортировка по sort
        if ($a['sort'] != $b['sort']) {
            return $a['sort'] > $b['sort'];
        }

        // затем по index
        return $a['index'] > $b['index'];
    }

    private $_blockArray = array();

    private $_blockPositionedArray = array();

    private $_bannerPlacedArray = array();

}