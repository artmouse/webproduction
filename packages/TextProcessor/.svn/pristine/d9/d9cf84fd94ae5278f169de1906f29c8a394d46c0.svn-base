<?php
/**
 * Get content-data from URL with cache TTL.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * 
 * @copyright WebProduction
 * 
 * @package TextProcessor
 */
class TextProcessor_ActionContentFromURL implements TextProcessor_IAction {

    /**
     * *
     * @param string $url URL to retrive content
     * @param int $ttl Cache time to live
     */
    public function __construct($url, $ttl = 0) {
        // @todo: check URL with Checker
        $this->_url = $url;
        $this->_ttl = $ttl;

        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $this->_userAgent = $userAgent;

        // issue #46914 - auto clean cache
        if (rand(0, 20) == 1) {
            $this->cleanCache();
        }
    }

    public function setUserAgent($userAgent) {
        $this->_userAgent = $userAgent;
    }

    public function setProxy($proxy) {
        $this->_proxy = $proxy;
    }
    
    public function setSocksProxy($proxy) {     
        $this->_proxySocks = $proxy;      
    }

    public function cleanCache() {
        // max cache time = 24h
        $maxTTL = 24*60*60;

        $cacheDir = dirname(__FILE__).'/cache/';
        $d = opendir($cacheDir);
        while ($x = readdir($d)) {
            // skip no-MD5 files
            if (strlen($x) != 32) {
                continue;
            }

            $time = filemtime($cacheDir.$x);

            // remove old files
            if ($time < time() - $maxTTL) {
                @unlink($cacheDir.$x);
            }
        }
        closedir($d);
    }

    /**
     * *
     * @param string $text
     * @return string
     */
    public function process($text) {
        $text;
        $hash = md5($this->_url);

        $cacheFile = dirname(__FILE__).'/cache/'.$hash;

        // load from cache
        if (@filemtime($cacheFile) + $this->_ttl > time()) {
            return file_get_contents($cacheFile);
        }

        $data = $this->_getData($this->_url);
        if ($this->_ttl) {
            file_put_contents($cacheFile, $data, LOCK_EX);
        }
        return $data;
    }

    /**
     * Retrieve data from URL
     *
     * @param string $url
     * return string
     */
    protected function _getData($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->_userAgent);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if ($this->_proxy) {
            curl_setopt($ch, CURLOPT_PROXY, $this->_proxy);
        }
        if ($this->_proxySocks) {
            curl_setopt($ch, CURLOPT_PROXY, $this->_proxy);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    private $_userAgent;

    private $_proxy;
    
    private $_proxySocks;

    private $_url;

    private $_ttl;

}