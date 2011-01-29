<?php
include dirname(__FILE__) . '/../../../bootstrap/unit.php';

$t = new lime_test(18);

// unit test RpmPeer::evrSplit()
$t->is(RpmPeer::evrSplit("1:7.6.5-0.1mdv2010.1"), array('1', '7.6.5', '0.1mdv2010.1'), "1:7.6.5-0.1mdv2010.1 => 1, 7.6.5, 0.1mdv2010.1");
$t->is(RpmPeer::evrSplit("0:7.6.5-0.1mdv2010.1"), array('0', '7.6.5', '0.1mdv2010.1'), "0:7.6.5-0.1mdv2010.1 => 0, 7.6.5, 0.1mdv2010.1");
$t->is(RpmPeer::evrSplit("7.6.5-0.1mdv2010.1"), array(null, '7.6.5', '0.1mdv2010.1'), "7.6.5-0.1mdv2010.1 => null, 7.6.5, 0.1mdv2010.1");
$t->is(RpmPeer::evrSplit("7.6.5"), array(null, '7.6.5', null), "7.6.5 => null, 7.6.5, null");
$t->is(RpmPeer::evrSplit("1:7.6.5"), array(1, '7.6.5', null), "1:7.6.5 => 1, 7.6.5, null");

// unit test RpmPeer::evrCompare()
// from perl-RPM4 with the author's consent :
$t->is(RpmPeer::evrCompare("1", "1"), 0, "comparing version only, equal");
$t->is(RpmPeer::evrCompare("2", "1"), 1, "comparing version only, higther");
$t->is(RpmPeer::evrCompare("1", "2"), -1, "comparing version only, lesser");
$t->is(RpmPeer::evrCompare("1-1mdk", "1-1mdk"), 0, "comparing version-release only, equal");
$t->is(RpmPeer::evrCompare("2-1mdk", "1-1mdk"), 1, "comparing version-release only, higther");
$t->is(RpmPeer::evrCompare("1-1mdk", "2-1mdk"), -1, "comparing version-release only, lesser");
$t->is(RpmPeer::evrCompare("1:1-1mdk", "1:1-1mdk"), 0, "comparing epoch:version-release only, equal");
$t->is(RpmPeer::evrCompare("2:1-1mdk", "1:1-1mdk"), 1, "comparing epoch:version-release only, higther");
$t->is(RpmPeer::evrCompare("1:1-1mdk", "2:1-1mdk"), -1, "comparing epoch:version-release only, lesser");

$t->is(RpmPeer::evrCompare("0:1-1mdk", "1-1mdk"), 1, "comparing epoch 0 vs no epoch");
$t->is(RpmPeer::evrCompare("1:1-1mdk", "1-1mdk"), 1, "comparing epoch 1 vs no epoch");
$t->is(RpmPeer::evrCompare("1.0-1mdk", "1.0"), 1, "comparing version-release vs version only");
$t->is(RpmPeer::evrCompare("0:1-1mdk", "1.0"), 1, "comparing epoch:version-release vs no version");