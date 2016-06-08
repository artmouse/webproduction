<?php
class engine_include extends Engine_Class {

    public function process() {
        if (PackageLoader::Get()->getMode('no-minify')) {
            return false;
        }

        $cssArray = $this->getValue('cssfiles');
        $jsArray = $this->getValue('jsfiles');

        $path = PackageLoader::Get()->getProjectPath();

        $rev = '';
        $revFile = $path.'/rev.info';
        if (file_exists($revFile)) {
            $rev = file_get_contents($revFile);
        }

        // CSS
        $cssCacheFile = '/cache/'.md5(serialize($cssArray)).'-'.$rev.'.css';
        if (!file_exists($path.$cssCacheFile)) {
            $cssMin = '';
            foreach ($cssArray as $file) {
                $file = preg_replace("/\&(\d+)$/iu", '', $file);
                $file = preg_replace("/\?(\d+)$/iu", '', $file);

                $file = $path.$file;
                $cssMin .= file_get_contents($file);
                $cssMin .= "\n";
            }

            //$cssMin = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $cssMin);
            $cssMin = str_replace(array("\r", "\n", "\t", '  ', '   '), '', $cssMin);

            file_put_contents($path.$cssCacheFile, $cssMin, LOCK_EX);
        }
        $this->setValue('cssMin', $cssCacheFile);
        $this->setValue('cssfiles', false);

        // JS
        $outLinks = array();
        $jsCacheFile = '/cache/'.md5(serialize($jsArray)).'-'.$rev.'.js';
        if (!file_exists($path.$jsCacheFile)) {
            $jsMin = '';
            foreach ($jsArray as $file) {
                if (substr_count($file, '//')) {
                    $outLinks[] = $file;
                } else {
                    $file = preg_replace("/\&(\d+)$/iu", '', $file);
                    $file = preg_replace("/\?(\d+)$/iu", '', $file);

                    if (substr_count($file, '.min') || substr_count($file, '-min')) {
                        $fileMinVersion = $path.$file;
                    } else {
                        $fileMinVersion = md5($file.$rev).'-min.js';
                        $fileMinVersion = $path.'cache/'.$fileMinVersion;

                        if (!file_exists($fileMinVersion)) {
                            $data = file_get_contents($path.$file);
                            $data = JSMin::Minify($data);
                            file_put_contents($fileMinVersion, $data, LOCK_EX);
                        }
                    }

                    $jsMin .= file_get_contents($fileMinVersion);
                    $jsMin .= ";\n";
                }
            }
            file_put_contents($path.$jsCacheFile, $jsMin, LOCK_EX);
        }

        $this->setValue('jsfiles', $outLinks);
        $this->setValue('jsMin', $jsCacheFile);
    }

}