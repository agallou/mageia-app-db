<?php
include dirname(__FILE__) . '/../../../bootstrap/unit.php';

$t = new lime_test(1);

$e = new menuItemException();
$t->ok($e instanceof sfException, 'menuItemException extends sfException');
