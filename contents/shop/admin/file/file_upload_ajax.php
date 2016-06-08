<?php
class file_upload_ajax extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $files = $this->getArgument('file', 'array');
            $resultArray = array();

            $pathArray = $files['tmp_name'];
            $nameArray = $files['name'];
            $typeArray = $files['type'];

            foreach ($pathArray as $k => $path) {
                $name = $nameArray[$k];
                $type = $typeArray[$k];

                $file = Shop::Get()->getFileService()->addFile($path, $name, $type, $cuser);

                $resultArray[] = array(
                'id' => $file->getId(),
                'name' => $name
                );
            }

            print json_encode(array('status' => 'ok', 'result' => $resultArray));
        } catch (Exception $se) {

        }
    }

}