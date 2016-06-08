<?php
class document_template_view_ajax extends Engine_Class {

    public function process() {
        set_error_handler(array(&$this, "myErrorHandler"));

        $content = $this->getArgument('content');
        $type = $this->getArgumentSecure('type');
        $id = $this->getArgumentSecure('id');

        if ($type == 'ShopOrder') {
            if (!$id) {
                $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
                $orders->addWhere('sum', '0', '>');
                $orders->addWhere('clientname', '', '<>');
                $orders->setOrder('deliveryid', 'DESC');
                $orders = $orders->getNext();
                if ($orders) {
                    $id = $orders->getId();
                }
            }

            try{
                $order = Shop::Get()->getShopService()->getOrderByID($id);
                $assign = $order->makeAssignArrayForDocument();
                $newContent = Engine::GetSmarty()->fetchString($content, $assign);
                if (!$newContent) {
                    $newContent = $content;
                }
                echo json_encode(array('content' => $newContent, 'id' => $id));
                exit;
            } catch (Exception $e) {
                echo json_encode(array('content' => $content, 'id' => $id));
                exit;
            }
        } elseif ($type == 'User') {
            if (!$id) {
                $users = Shop::Get()->getUserService()->getUsersAll($this->getUser());
                $users->addWhere('name', '', '<>');
                $users->addWhere('email', '', '<>');
                $users->addWhere('phone', '', '<>');
                $users->setOrder('company', 'DESC');
                $users = $users->getNext();
                if ($users) {
                    $id = $users->getId();
                }
            }
            try{
                $user = Shop::Get()->getUserService()->getUserByID($id);
                $assign = $user->makeAssignArrayForDocument();
                $newContent = Engine::GetSmarty()->fetchString($content, $assign);
                if (!$newContent) {
                    $newContent = $content;
                }
                echo json_encode(array('content' => $newContent, 'id' => $id));
                exit;
            } catch (Exception $e) {
                echo json_encode(array('content' => $content, 'id' => $id));
                exit;
            }
        } else {
            try{
                if ($id) {
                    $obj = new $type($id);
                } else {
                    $obj = new $type();
                    $obj = $obj->getNext();
                }
                
                $assign = $obj->makeAssignArrayForDocument();
                $newContent = Engine::GetSmarty()->fetchString($content, $assign);
                if (!$newContent) {
                    $newContent = $content;
                }
                echo json_encode(array('content' => $newContent, 'id' => $id));
                exit;
            } catch (Exception $ee) {

            }

            echo json_encode(array('content' => $content, 'id' => $id));
            exit;
        }
    }

    public function myErrorHandler($errno, $errstr) {
        if ($errno == E_USER_ERROR) {
            echo json_encode(array('error' => "<b>Фатальная ошибка:</b> $errstr<br />\n"));
            exit;
        }
        return true;
    }



}