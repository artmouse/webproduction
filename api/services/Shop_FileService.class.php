<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Сервис по работе с файлами
 *
 * @copyright OneBox
 */
class Shop_FileService extends ServiceUtils_AbstractService {

    /**
     * Получить все файлы
     *
     * @return ShopFile
     */
    public function getFilesAll() {
        $x = $this->getObjectsAll('ShopFile');
        $x->setDeleted(0);
        $x->setOrder('id', 'DESC');
        return $x;
    }

    /**
     * Получить файл по ID
     *
     * @return ShopFile
     */
    public function getFileByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopFile');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('ShopFile by id not found');
    }

    /**
     * Получить файлы по ключу-привязке
     *
     * @param string $linkkey
     *
     * @return ShopFile
     */
    public function getFilesByLinkkey($linkkey) {
        $files = $this->getFilesAll();
        $files->setKey($linkkey);
        return $files;
    }

    /**
     * Добавить файл.
     * Метод вернет объект ShopFile.
     * В $filePath нужно передавать полный путь на файл или URL
     * В $user нужно передавать автора файла (кто добавляет файл).
     * В $linkkey - привязку (ключ-привязку)
     *
     * @param string $filePath
     * @param string $name
     * @param string $type
     * @param User $user
     * @param bool $checkDoublicates
     * @param string $linkkey
     *
     * @return ShopFile
     */
    public function addFile($filePath, $name, $type, $user = false, $linkkey = false, $checkDoublicates = false) {
        try {
            SQLObject::TransactionStart();

            $hash = $this->uploadFileToMedia($filePath, $name);

            $file = new ShopFile();
            $file->setFile($hash);
            if ($linkkey) {
                $file->setKey($linkkey);
            }

            $skip = false;
            if ($linkkey && $checkDoublicates) {
                if ($file->select()) {
                    $skip = true;
                }
            }

            if (!$skip) {
                $file->setCdate(date('Y-m-d H:i:s'));
                if ($user) {
                    $file->setUserid($user->getId());
                }
                $file->setName($name);
                $file->setContenttype($type);
                $file->insert();
            }

            SQLObject::TransactionCommit();

            return $file;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить файл по его содержимому.
     * Метод вернет объект ShopFile.
     * В $fileContent нужно передавать содержимое файла.
     * В $user нужно передавать автора файла (кто добавляет файл).
     * В $linkkey - привязку (ключ-привязку)
     *
     * @param string $filePath
     * @param string $name
     * @param string $type
     * @param User $user
     * @param bool $checkDoublicates
     * @param string $linkkey
     *
     * @return ShopFile
     */
    public function addFileByContent($fileContent, $name, $type, $user = false,
    $linkkey = false, $checkDoublicates = false) {
        $hash = $this->uploadFileContentToMedia($fileContent, $name);
        $filePath = $this->makeFilePathByHash($hash);
        return $this->addFile($filePath, $name, $type, $user, $linkkey, $checkDoublicates);
    }

    /**
     * Скопировать файл.
     * Автором нового файла станет $user.
     * Привязка linkkey будет убрана.
     *
     * @param ShopFile $file
     * @param User $user
     *
     * @return ShopFile
     */
    public function copyFile(ShopFile $file, $user = false) {
        $newFile = new ShopFile();
        $newFile->setCdate(date('Y-m-d H:i:s'));
        if ($user) {
            $newFile->setUserid($user->getId());
        } else {
            $newFile->setUserid($file->getUserid());
        }
        $newFile->setName($file->getName());
        $newFile->setFile($file->getFile());
        $newFile->setContenttype($file->getContenttype());
        $newFile->insert();

        return $newFile;
    }

    /**
     * Редактирование файла
     *
     * @param User $user
     * @param ShopFile $file
     * @param string $path
     * @param string $type
     *
     * @return ShopFile
     */
    public function editFile(User $user, ShopFile $file, $path, $type) {
        $user;

        try {
            SQLObject::TransactionStart();

            $md5 = md5(file_get_contents($path));

            $file->setFile($md5);
            $file->setCdate(date('Y-m-d H:i:s'));
            //$file->setUserid($user->getId());
            $file->setContenttype($type);
            $file->update();

            copy($path, PackageLoader::Get()->getProjectPath().'media/file/'.$md5);

            SQLObject::TransactionCommit();

            return $file;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить файл
     *
     * @param User $user
     * @param ShopFile $file
     */
    public function deleteFile(User $user, ShopFile $file) {
        $user;

        try {
            SQLObject::TransactionStart();

            $file->setDeleted(1);
            $file->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Загрузить файл на static-сервер и вернуть hash+ext файла.
     * Внимание! Метод принимает ТОЛЬКО путь к файлу.
     * И метод НЕ ПРОВЕРЯЕТ mime types.
     *
     * Exception, если что-то не получилось или статического сервера просто нет.
     *
     * @param string $filePath
     *
     * @return string
     * @throws Exception
     */
    public function uploadFileToStaticServer($filePath, $name) {
        $post = array(
            'file'=> '@'.$filePath.';filename='.$name,
        );

        $url = Engine::Get()->getConfigField('static-server').'upload.php';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $a = (array) json_decode($result);

        if (!$a) {
            throw new ServiceUtils_Exception();
        }
        if (empty($a['hash'])) {
            throw new ServiceUtils_Exception();
        }

        return $a['hash'];
    }

    /**
     * Загрузить файл в директорию media
     * и вернуть относительный путь к файлу (хеш-путь)
     *
     * @param string $filePath
     *
     * @return string
     */
    public function uploadFileToMedia($filePath, $name) {
        $saveDir = $this->getMediaPath();

        $content = @file_get_contents($filePath);

        if (!$content) {
            throw new ServiceUtils_Exception();
        }

        $md5 = md5($content);

        $folder1 = substr($md5, 0, 2);
        $folder2 = substr($md5, 2, 2);

        @mkdir($saveDir.$folder1);
        @mkdir($saveDir.$folder1.'/'.$folder2);

        $ext = pathinfo($name, PATHINFO_EXTENSION);
        if ($ext) {
            $ext = '.'.$ext;
        }

        $md5x = $folder1.'/'.$folder2.'/'.$md5.$ext;

        if (!file_exists($saveDir.$md5x)) {
            copy($filePath, $saveDir.$md5x);
        }

        return $md5.$ext;
    }

    /**
     * Залить в media файл по содержимому
     * и вернуть относительный путь к файлу (хеш-путь)
     *
     * @param string $content
     * @param string $name
     *
     * @return string
     */
    public function uploadFileContentToMedia($content, $name) {
        $saveDir = $this->getMediaPath();

        if (!$content) {
            throw new ServiceUtils_Exception();
        }

        $md5 = md5($content);

        $folder1 = substr($md5, 0, 2);
        $folder2 = substr($md5, 2, 2);

        @mkdir($saveDir.$folder1);
        @mkdir($saveDir.$folder1.'/'.$folder2);

        $ext = pathinfo($name, PATHINFO_EXTENSION);
        if (!$ext) {
            $ext = '.'.$ext;
        }

        $md5x = $folder1.'/'.$folder2.'/'.$md5.$ext;

        if (!file_exists($saveDir.$md5x)) {
            file_put_contents($saveDir.$md5x, $content, LOCK_EX);
        }

        return $md5.$ext;
    }

    /**
     * Получить полный путь на файл по его хешу.
     * Система сама знает где хранить файлы, поэтому уникальным является только hash.
     *
     * @param string $hash
     *
     * @return string
     */
    public function makeFilePathByHash($hash) {
        $hash1 = substr($hash, 0, 2);
        $hash2 = substr($hash, 2, 2);

        $path = $this->getMediaPath().$hash1.'/'.$hash2.'/'.$hash;
        return $path;
    }

    /**
     * Получить путь на файл по его хешу.
     * Система сама знает где хранить файлы, поэтому уникальным является только hash.
     *
     * @param string $hash
     *
     * @return string
     */
    public function makeFileURLByHash($hash) {
        $hash1 = substr($hash, 0, 2);
        $hash2 = substr($hash, 2, 2);

        $path = '/media/'.$hash1.'/'.$hash2.'/'.$hash3.'/'.$hash;
        return $path;
    }

    /**
     * Получить последний файп по хешу
     *
     * @param string $hash
     *
     * @return ShopFile
     */
    public function getFileByHash($hash) {
        $x = new ShopFile();
        $x->setFile($hash);
        $x->setOrder('id', 'DESC');
        $x->setLimitCount(1);
        return $x->getNext(true);
    }

    /**
     * Получить директорию, в которую загружаются файлы
     *
     * @return string
     */
    public function getMediaPath() {
        return PackageLoader::Get()->getProjectPath().'media/';
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_FileService
     */
    public static function Get() {
        if (!self::$_Instance) {
            $classname = self::$_Classname;
            if ($classname) {
                self::$_Instance = new $classname();
            } else {
                self::$_Instance = new self();
            }
        }
        return self::$_Instance;
    }

    /**
     * Задать класс сервиса.
     * override-метод.
     *
     * @param string $classname
     */
    public static function Set($classname) {
        self::$_Classname = $classname;
        self::$_Instance = null;
    }

    /**
     * Подменяемый объект сервиса
     *
     * @var Shop_FileService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}