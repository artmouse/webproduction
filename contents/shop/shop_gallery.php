<?php
class shop_gallery extends Engine_Class {

    public function process() {
        $gallery = GalleryService::Get()->getGalleryActive();
        $a = array();
        $gallery->setOrder('album', 'ASC');
        $albumNames = $this->_getAlbumNamesUnique();
        foreach ($albumNames as $album){
            $gallery->setAlbum($album);
            while ($x = $gallery->getNext()) {
                $a[] = array(
                    'name' => $x->makeName(),
                    'image' => $x->makeImageThumb(200, 200, 'crop'),
                    'url' => $x->makeURL(),
                    'album' =>$album,
                );
            }
        }
        $this->setValue('galleryArray', $a);
        $this->setValue('albums', $albumNames);
    }

    /**
     * @param $gallerys
     * @return mixed
     */
    private function _getAlbumNamesUnique(){
        $gallery = GalleryService::Get()->getGalleryActive();
        $gallery->setOrder('album', 'ASC');
        $arr = array();
        while ($x = $gallery->getNext()){
            $arr[] = $x->getAlbum();
        }
        $arr = array_unique($arr);
        return $arr;
    }

}