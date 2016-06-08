<?php
/**
 * Обработчик писем от Landingi
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Package
 */
class Processor_Landingi {

    public function process(ShopOrder $issue) {
        print_r($issue->getComments());

        $comment = $issue->getComments();

        $name = false;
        if (preg_match("/ВАШЕ ИМЯ: (.+?)\n/ius", $comment, $r)) {
            $name = trim($r[1]);
        }

        $phone = false;
        if (preg_match("/ВАШ ТЕЛЕФОН: (.+?)\n/ius", $comment, $r)) {
            $phone = trim($r[1]);
        }
        $phone = preg_replace("/\D+/ius", '', $phone);

        $email = $issue->getClientemail();

        /*print "Name = $name\n";
        print "Phone = $phone\n";
        print "Email = $email\n";*/

        $contact = false;

        // поиск клиента по телефону
        if ($phone) {
            try {
                $contact = Shop::Get()->getUserService()->findUserByContact($phone, 'phone');
            } catch (Exception $e) {

            }
        }

        if (!$contact && $email) {
            try {
                $contact = Shop::Get()->getUserService()->findUserByContact($email, 'email');
            } catch (Exception $e) {

            }
        }

        if ($contact) {
            if (!$contact->getPhone()) {
                $contact->setPhone($phone);
            }
            if (!$contact->getEmail()) {
                $contact->setEmail($email);
            }
            if (!$contact->getName()) {
                $contact->setName($name);
            }
            $contact->update();
        } else {
            $contact = new User();
            $contact->setTypesex('man');
            $contact->setName($name);
            $contact->setPhone($phone);
            $contact->setEmail($email);
            $contact->setCdate(date('Y-m-d H:i:s'));
            $contact->insert();
        }

        $issue->setComments('');
        $issue->setUserid($contact->getId());
        $issue->setClientname($contact->makeName(false));
        $issue->setClientphone($phone);
        $issue->update();
    }

}