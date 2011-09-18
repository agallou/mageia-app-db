<?php

namespace tests\units;

require_once __DIR__ . '/../../../../plugins/sfAtoumPlugin/bootstrap/unit.php';

use \mageekguy\atoum;

class menuItem extends atoum\test
{

  public function testConstructParameters()
  {
    $item = new \menuItem('Homepage', '@homepage', array('filters_parameters' => true));
    $this->assert->string($item->getName())->isEqualTo('Homepage', 'getName works');
    $this->assert->string($item->getInternalUri())->isEqualTo('@homepage', 'getInternalUri works');
    $this->assert->phpArray($item->getOptions())->isEqualTo( array('filters_parameters' => true), 'getOptions works');

    $item = new \MenuItem('Homepage');
    $this->assert->string($item->getName())->isEqualTo('Homepage', 'getName works');
    $this->assert->variable($item->getInternalUri())->isEqualTo(null, 'getInternalUri could be not setted and as for default value null');
    $this->assert->phpArray($item->getOptions())->isEqualTo(array(), 'getOptions could be ne setted and as for default value an array');

    $item = new \MenuItem('Homepage');
    $this->assert->string($item->getName())->isEqualTo('Homepage', 'getName works');
    $this->assert->variable($item->getInternalUri())->isEqualTo(null, 'getInternalUri could be not setted and as for default value null');
    $this->assert->phpArray($item->getOptions())->isEqualTo(array(), 'getOptions could be ne setted and as for default value an array');
  }

  public function testConstructExceptionForName()
  {
     $values = array(
       array(),
       null,
       new \MenuItem('test'),
       3,
     );
     foreach ($values as $value)
     {
       $this->assert->exception(function() use($value)
       {
         $item = new \MenuItem($value);
       })
       ->isInstanceOf('MenuItemException')->hasMessage('invalid name');
     }
  }

  public function testConstructExceptionForInternalUri()
  {
     $values = array(
       array(),
       new \MenuItem('test'),
       3,
     );
     foreach ($values as $value)
     {
       $this->assert->exception(function() use($value)
       {
         $item = new \MenuItem('test', $value);
       })
       ->isInstanceOf('MenuItemException');
     }
  }

}

