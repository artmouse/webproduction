<?php
/**
 * Кикер лишних клиентов of BoxMachine
 *
 * @author root
 */
class Box_KickMachine implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        if ($_SERVER['SERVER_ADDR'] != '127.0.0.1') {
            $query = Engine::Get()->getRequest();
            $file = MEDIA_PATH.'/tmp/key';
            try {
                if (!file_exists($file)) {
                    throw new ServiceUtils_Exception();
                }
                $employers = new XUser();
                $employers->filterLevel('1', '>');
                $employers->addWhereQuery(" email NOT LIKE '%@webproduction%' ");
                $idEmployers = array();
                while ($x = $employers->getNext()) {
                    $idEmployers[] = $x->getId();
                }
                $result = (int) file_get_contents($file);
                $auth = new XUserAuth();
                $auth->setOrder('adate', 'ASC');
                $auth->addWhereArray($idEmployers, 'userid', '=');
                $k = 0;
                while ($x = $auth->getNext()) {
                    $k++;
                    if ($k > $result) {
                        $u = Shop::Get()->getUserService()->getUserByID($x->getUserid());
                        Shop::Get()->getUserService()->logout($u);
                        header('Location: /');    
                    }
                }
            } catch (Exception $ex) {
                $query->setContentID(401); 
            }
        } 
    }
}