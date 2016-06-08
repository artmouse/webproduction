<?php

$hash = md5(md5(123456).md5('WebProduction'));

print_r($hash);