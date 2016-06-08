<?php
/**
 * Построитель sitemap.xml.
 *
 * Важно: все ссылки он держит в памяти,
 * а затем формирует файлы в указанную директорию.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Sitemap
 */
class Sitemap {

    public function __construct($projectURL) {
        $this->_projectURL = $projectURL;
    }

    public function addURL($url, $priority = false, $changefreq = false, $lastmod = false, $imageArray = false) {
        $page = array(
        'url' => $url,
        'priority' => $priority,
        'changefreq' => $changefreq,
        'lastmod' => $lastmod,
        'imageArray' => $imageArray,
        );
        $this->_pagesArray[] = $page;
    }

    public function render($savePath) {
        $date = date('Y-m-d');

        $urlLimit = 20000 - 1; // max 50 000, но я поставил 20К, чтобы не тупило
        $b = array();
        $a = array();
        $index = 1;

        foreach ($this->_pagesArray as $page) {
            $a[] = $page;

            // если превышаем лимит для одного файла
            if (count($a) >= $urlLimit) {
                $name = '/sitemap'.$index++.'.xml';
                $file = $savePath.$name;
                $this->_buildSitemap($a, $file);
                $b[] = $name; // массив файлов sitemap

                // обнуляем временный массив страниц
                $a = array();
            }
        }

        // и если остались URLы
        if ($a) {
            $name = '/sitemap'.$index++.'.xml';
            $file = $savePath.$name;
            $this->_buildSitemap($a, $file);
            $b[] = $name;
        }

        if (count($b) == 0) {
            return false;
        } elseif (count($b) == 1) {
            // если файл sitemap один
            $tmp = file_get_contents($savePath.$b[0]);
            file_put_contents($savePath.'/sitemap.xml', $tmp, LOCK_EX);
            unlink($savePath.$b[0]);
        } else {
            // если файлов sitemap много
            // @todo: use XML package
            $xml = '';
            $xml .= '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            foreach ($b as $url) {
                $url = $this->_projectURL.$url;
                if (!substr_count($url, 'http://')) {
                    $url = 'http://'.$url;
                }

                $xml .= '<sitemap>';
                $xml .= '<loc>'.$url.'</loc>';
                $xml .= '<lastmod>'.$date.'</lastmod>';
                $xml .= '</sitemap>';
            }
            $xml .= '</sitemapindex>';

            file_put_contents($savePath.'/sitemap.xml', $xml, LOCK_EX);
        }
    }

    private function _buildSitemap($a, $file) {
        // @todo: use XML package
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
        foreach ($a as $page) {
            $url = $page['url'];
            $imageArray = $page['imageArray'];
            if (!substr_count($url, $this->_projectURL)) {
                $url = $this->_projectURL.$url;
            }

            if (!substr_count($url, 'http://')) {
                $url = 'http://'.$url;
            }

            $xml .= '<url>';
            $xml .= '<loc>'.$url.'</loc>';
            if ($page['priority']) {
                $xml .= '<priority>'.$page['priority'].'</priority>';
            }
            if ($page['changefreq']) {
                $xml .= '<changefreq>'.$page['changefreq'].'</changefreq>';
            }
            if ($page['lastmod']) {
                $lastmod = date('Y-m-d', strtotime($page['lastmod']));
                $xml .= '<lastmod>'.$lastmod.'</lastmod>';
            }
            if ($imageArray) {
                foreach ($imageArray as $img) {
                    $imageURL = $this->_projectURL.$img;
                    if (!substr_count($imageURL, 'http://')) {
                        $imageURL = 'http://'.$imageURL;
                    }

                    $xml .= '<image:image>';
                    $xml .= '<image:loc>';
                    $xml .= $imageURL;
                    $xml .= '</image:loc>';
                    $xml .= '</image:image>';
                }
            }
            $xml .= '</url>';
        }
        $xml .= '</urlset>';

        file_put_contents($file, $xml, LOCK_EX);
    }

    private $_pagesArray = array();

    private $_projectURL;

}