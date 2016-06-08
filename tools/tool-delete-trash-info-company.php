<?php
require(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$company = new User();
while ($x = $company->getNext()) {
    $name = $x->getCompany();
    $name = preg_replace('/http\:\/\//ius', '', $name);
    $name = preg_replace('/https\:\/\//ius', '', $name);
    $name = preg_replace('/\&.+?\;/ius', '', $name);
    $name = preg_replace('/\//ius', '', $name);

    $phones = $x->getPhones();
    if (preg_match('/^380/ius', $phones)) {
        if (strlen($phones) > 16) {
            $phones = mb_substr($phones, 0, 12);
            $x->setPhones($phones);
        }
    }

    $phone = $x->getPhone();
    if (preg_match('/^380/ius', $phone)) {
        if (strlen($phone) > 16) {
            $phone = mb_substr($phone, 0, 12);
            $x->setPhone($phone);
        }
    }

    $x->setCompany(trim($name));
    $x->update();

    print "Update #".$x->getId()."\n";
}

print "\n\ndone.\n\n";