<?php
class ajax_clear_cache extends Engine_Class {

    public function process() {
        set_time_limit(5*60);

        $resultArray['log'] = '';
        $step = 1000;

        // сбрасываем кеш
        try {
            // чистка основного кеша
            Engine::GetCache()->clearCache();

            // удаление всех thumbnail изображений
            if ($this->getArgumentSecure('thumbnails') == 'on') {
                $path = PackageLoader::Get()->getProjectPath().'media/shop/';
                // получаем все файлы
                $fileArray = $this->_scandirTree($path);
                $index = 0;
                foreach ($fileArray as $x) {
                    // удаляем thumbы
                    if (substr_count($x, '.ipthumb')) {
                        unlink($x);
                        $resultArray['log'] .= 'Deleting '.$x."\n";
                        $index ++;
                    }

                    // issue #41050 - задержка сброса кэша
                    if ($index == $step) {
                        $index = 0;
                        sleep(1);
                    }
                }
            }

            $resultArray['status'] = 'success';
        } catch (Exception $e) {
            $resultArray['status'] = 'error';
        }
        echo json_encode($resultArray);
        exit();
    }

    private function _scandirTree($path) {
        $fileArray = scandir($path);
        $a = array();
        foreach ($fileArray as $x) {
            $file = $path.'/'.$x;
            if (is_file($file)) {
                $a[] = $file;
            } elseif ($x != '.' && $x != '..' && is_dir($file)) {
                $tmp = $this->_scandirTree($file);
                $a = array_merge($a, $tmp);
            }
        }
        return $a;
    }

}