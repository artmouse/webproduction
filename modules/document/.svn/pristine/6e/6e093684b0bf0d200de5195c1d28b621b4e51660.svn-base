<?php
class document_debug extends Engine_Class {

    public function process() {

        if ($this->getArgumentSecure('ok')) {
            try{

                $ex = new ServiceUtils_Exception();

                $id = (int) $this->getArgumentSecure('id');
                $type = $this->getArgumentSecure('type');
                $path = $this->getArgumentSecure('path');

                if (!$id) {
                    $ex->addError('id');
                } else {
                    try{
                        if ($type == 'order') {
                            $obj = Shop::Get()->getShopService()->getOrderByID($id);
                        } elseif ($type == 'user') {
                            $obj = Shop::Get()->getUserService()->getUserByID($id);
                        } elseif ($type == 'storage') {
                            $obj = new ShopStorageTransaction($id);
                        }
                    } catch (Exception $eobj) {
                        $ex->addError('obj');
                    }
                }

                if (!$path) {
                    $ex->addError('path');
                }

                if (!file_exists(PackageLoader::Get()->getProjectPath().$path)) {
                    $ex->addError('fileempty');
                }

                if ($ex->getCount()) {
                    throw $ex;
                }

                $assign = $obj->makeAssignArrayForDocument();
                $content = Engine::GetSmarty()->fetchString(
                    file_get_contents(PackageLoader::Get()->getProjectPath().$path),
                    $assign
                );
                
                $this->setValue('content', $content);

            } catch (ServiceUtils_Exception $e) {
                $this->setValue('errorsArray', $e->getErrorsArray());
            }

        }
    }

}