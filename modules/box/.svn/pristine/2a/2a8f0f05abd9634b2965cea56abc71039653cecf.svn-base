<?php
class file_block_list extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();

        $files = $this->_getFiles();

        $filterName = $this->getArgumentSecure('filtername');
        if ($filterName) {
            $files->addWhere('name', '%'.str_replace(' ', '%', $filterName).'%', 'LIKE');
        }

        $filterLink = $this->getArgumentSecure('filterlink');
        if ($filterLink) {
            $files->addWhere('key', 'order-%'.$filterLink.'%', 'LIKE');
        }

        $filterAuthorID = $this->getArgumentSecure('filterauthorid');
        if ($filterAuthorID) {
            $files->setUserid($filterAuthorID);
        }

        $filterCdateFrom = $this->getArgumentSecure('filtercdatefrom', 'date');
        if ($filterCdateFrom) {
            $files->addWhere('cdate', $filterCdateFrom, '>=');
        }

        $filterCdateTo = $this->getArgumentSecure('filtercdateto', 'date');
        if ($filterCdateTo) {
            $files->addWhere('cdate', $filterCdateTo.' 23:59:59', '<=');
        }

        $filterID = $this->getArgumentSecure('filterid');
        if ($filterID) {
            $files->addWhere('id', '%'.$filterID.'%', 'LIKE');
        }

        $filterType = $this->getArgumentSecure('filtertype');
        if ($filterType) {
            $files->addWhere('contenttype', '%'.$filterType.'%', 'LIKE');
        }

        $datasource = new Datasource_File();
        $datasource->setSQLObject($files);
        $table = new Shop_ContentTable($datasource);
        $this->setValue('table', $table->render());

        // менеджеры
        $managers = Shop::Get()->getUserService()->getUsersManagers($cuser);
        $a = array();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('managerArray', $a);
    }

    /**
     * @return ShopFile
     */
    private function _getFiles() {
        return $this->getValue('files');
    }

}