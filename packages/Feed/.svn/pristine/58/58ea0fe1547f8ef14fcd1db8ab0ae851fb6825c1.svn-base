<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.com.ua>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU LESSER GENERAL PUBLIC LICENSE
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 */

/**
 * Создатель RSS-лент на основе единого интерфейса
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Feed
 */
class Feed_CreatorRSS {

    public function __construct($title = false, $link = false) {
        if ($title) $this->setChannelTitle($title);
        if ($link) $this->setChannelLink($link);
    }

    private $_itemsArray = array();

    /**
     * Добавить элемент к ленте
     *
     * @param string $title
     * @param string $content
     * @param string $url
     * @param string $date
     * @param string $id
     */
    public function addItem($title, $content, $url, $date, $id = false) {
        if (!$id) {
            $id = $url;
        }

        // проверка URLа на полноту
        $parse = @parse_url($url);
        if (empty($parse['scheme'])) {
            throw new Exception("RSS_Creator: incorrect URL '{$url}'", 0);
        }

        $this->_itemsArray[] = array(
        'id' => $id,
        'url' => $url,
        'title' => $title,
        'date' => date('r', strtotime($date)),
        'content' => $content,
        );
    }

    private $_channelTitle = '';

    private $_channelLink = '';

    private $_channelDescription = '';

    private $_channelLanguage = '';

    private $_channelWebmasterEmail = '';

    /**
     * Установить заголовок RSS-канала
     *
     * @param string $title
     */
    public function setChannelTitle($title) {
        $this->_channelTitle = $title;
    }

    /**
     * Установить основную ссылку на RSS-канал
     *
     * @param string $link
     */
    public function setChannelLink($link) {
        $this->_channelLink = $link;
    }

    /**
     * Задать описание канала
     *
     * @param string $description
     */
    public function setChannelDescription($description) {
        $this->_channelDescription = $description;
    }

    /**
     * Задать язык канала
     *
     * @param string $language
     */
    public function setChannelLanguage($language) {
        $this->_channelLanguage = $language;
    }

    /**
     * Задать E-mail веб-мастера/администратора канала
     *
     * @param string $email
     */
    public function setChannelWebmasterEmail($email) {
        $this->_channelWebmasterEmail = $email;
    }

    /**
     * Сформировать RSS-ленту в формате RSS 2.0
     *
     * @param bool $headers
     * @return string
     */
    public function render($headers = false) {
        if ($headers) {
            header('Content-type: text/xml');
        }

        $channel = array();
        if ($this->_channelTitle) {
            $channel['title'] = $this->_channelTitle;
        }
        if ($this->_channelLink) {
            $channel['link'] = $this->_channelLink;
        }
        if ($this->_channelDescription) {
            $channel['description'] = $this->_channelDescription;
        }
        if ($this->_channelLanguage) {
            $channel['language'] = $this->_channelLanguage;
        }
        $channel['pubDate'] = date('r');
        $channel['lastBuildDate'] = date('r');
        $channel['generator'] = 'WebProduction Packages. Feed packages';
        if ($this->_channelWebmasterEmail) {
            $channel['webMaster'] = $this->_channelWebmasterEmail;
        }

        foreach ($this->_itemsArray as $x) {
            $channel['item'][] = array(
            'title' => $x['title'],
            'link' => $x['url'],
            'description' => $x['content'],
            'pubDate' => $x['date'],
            'guid' => $x['id'],
            );
        }

        $a['rss'] = array(
        '@attributes' => array('version' => '2.0'),
        'channel' => $channel,
        );

        return XML_Creator::CreateFromArray($a)->__toString();
    }

}