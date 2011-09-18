<?php
namespace tests\units;

require_once __DIR__ . '/../../../../plugins/sfAtoumPlugin/bootstrap/unit.php';

use \mageekguy\atoum;

class menuGroup extends atoum\test
{

  public function testIterable()
  {
    $group = new \menuGroup();
    $rc       = new \ReflectionClass($group);
    $this->assert->boolean($rc->isIterateable())->isEqualTo( true, 'group implements iterator');
  }

  public function testGetName()
  {
    $group = new \menuGroup('myGroupName');
    $this->assert->string($group->getName())->isEqualTo( 'myGroupName', 'getName works');
  }

  public function testGroup()
  {
    $group = new \menuGroup();
    $item  = new \menuItem('Homepage', '@homepage', array('filters_parameters' => true));
    $group2 = new \menuGroup('groupname');
    $group2->addMenuItem(new \menuItem('toto', 'rpm/list', array('filters_parameters' => true)));

    $group->addMenuItem($item);
    $group->addMenuGroup($group2);

    $cpt = 0;
    foreach ($group as $groupOrItem)
    {
      if ($cpt == 0)
      {
        $this->assert->object($groupOrItem)->isInstanceOf('menuItem', 'value is a menuItem');
        $this->assert->object($groupOrItem)->isEqualTo($item, 'value is correct');
      }
      elseif ($cpt == 1)
      {
        $this->assert->object($groupOrItem)->isInstanceOf('menuGroup', 'value is a menuGroup');
        $this->assert->object($groupOrItem)->isEqualTo($group2, 'value is correct');
      }
      else
      {
        //$this->assert->fail('there is too much elements');
      }
      $cpt++;
    }
    $this->assert->variable($group->getName())->isEqualTo(null, 'group has no name if noting passed to constructor');
  }

  public function testException()
  {
    $group = new \menuGroup();
    $tests = array(
      'something',
      array('onearray'),
      null,
    );

    foreach ($tests as $test)
    {
      $msg = 'with "' . var_export($test, true). ' we have an expection when append is called';
      $this->assert->exception(function() use($group, $test)
      {
        $group->append($test);
      })->isInstanceOf('menuGroupException');
    }
  }

}
