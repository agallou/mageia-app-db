<?php

namespace tests\units;

require_once dirname(__FILE__) . '/../../../../plugins/sfAtoumPlugin/bootstrap/unit.php';

use \mageekguy\atoum;

class Rpm extends atoum\test
{

  public function testEvrSplit()
  {
    $this->assert->phpArray(\RpmPeer::evrSplit("1:7.6.5-0.1mdv2010.1"))->isEqualTo(array('1', '7.6.5', '0.1mdv2010.1'), "1:7.6.5-0.1mdv2010.1 => 1, 7.6.5, 0.1mdv2010.1");
    $this->assert->phpArray(\RpmPeer::evrSplit("0:7.6.5-0.1mdv2010.1"))->isEqualTo( array('0', '7.6.5', '0.1mdv2010.1'), "0:7.6.5-0.1mdv2010.1 => 0, 7.6.5, 0.1mdv2010.1");
    $this->assert->phpArray(\RpmPeer::evrSplit("7.6.5-0.1mdv2010.1"))->isEqualTo( array(null, '7.6.5', '0.1mdv2010.1'), "7.6.5-0.1mdv2010.1 => null, 7.6.5, 0.1mdv2010.1");
    $this->assert->phpArray(\RpmPeer::evrSplit("7.6.5"))->isEqualTo(array(null, '7.6.5', null), "7.6.5 => null, 7.6.5, null");
    $this->assert->phpArray(\RpmPeer::evrSplit("1:7.6.5"))->isEqualTo( array(1, '7.6.5', null), "1:7.6.5 => 1, 7.6.5, null");
  }


  public function testEvrCompare()
  {
     // from perl-RPM4 with the author's consent :
    $this->assert->variable(\RpmPeer::evrCompare("1", "1"))->isEqualTo(null, "comparing version only, equal"); //TODO should be 0, no ?
    $this->assert->integer(\RpmPeer::evrCompare("2", "1"))->isEqualTo( 1, "comparing version only, higther");
    $this->assert->integer(\RpmPeer::evrCompare("1", "2"))->isEqualTo( -1, "comparing version only, lesser");
    $this->assert->integer(\RpmPeer::evrCompare("1-1mdk", "1-1mdk"))->isEqualTo(0, "comparing version-release only, equal");
    $this->assert->integer(\RpmPeer::evrCompare("2-1mdk", "1-1mdk"))->isEqualTo(1, "comparing version-release only, higther");
    $this->assert->integer(\RpmPeer::evrCompare("1-1mdk", "2-1mdk"))->isEqualTo(-1, "comparing version-release only, lesser");
    $this->assert->integer(\RpmPeer::evrCompare("1:1-1mdk", "1:1-1mdk"))->isEqualTo(0, "comparing epoch:version-release only, equal");
    $this->assert->integer(\RpmPeer::evrCompare("2:1-1mdk", "1:1-1mdk"))->isEqualTo(1, "comparing epoch:version-release only, higther");
    $this->assert->integer(\RpmPeer::evrCompare("1:1-1mdk", "2:1-1mdk"))->isEqualTo(-1, "comparing epoch:version-release only, lesser");

    $this->assert->integer(\RpmPeer::evrCompare("0:1-1mdk", "1-1mdk"))->isEqualTo(1, "comparing epoch 0 vs no epoch");
    $this->assert->integer(\RpmPeer::evrCompare("1:1-1mdk", "1-1mdk"))->isEqualTo(1, "comparing epoch 1 vs no epoch");
    $this->assert->integer(\RpmPeer::evrCompare("1.0-1mdk", "1.0"))->isEqualTo(1, "comparing version-release vs version only");
    $this->assert->integer(\RpmPeer::evrCompare("0:1-1mdk", "1.0"))->isEqualTo(1, "comparing epoch:version-release vs no version");
  }

}