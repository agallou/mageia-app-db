<?php
include dirname(__FILE__) . '/../../../bootstrap/unit.php';

$t = new lime_test(1);

$e = new menuGroupException();
$t->ok($e instanceof sfException, 'menuGroupException extends sfException');
