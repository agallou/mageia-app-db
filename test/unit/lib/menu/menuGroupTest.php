<?php
include dirname(__FILE__) . '/../../../bootstrap/unit.php';

$t = new lime_test(10);

$group = new menuGroup();

$rc = new ReflectionClass($group);
$t->ok($rc->isIterateable(), 'group implements iterator');

$group = new menuGroup();
$item  = new menuItem('Homepage', '@homepage', array('filters_parameters' => true));
$group2 = new menuGroup('groupname');
$group2->addMenuItem(new menuItem('toto', 'rpm/list', array('filters_parameters' => true)));

$group->addMenuItem($item);
$group->addMenuGroup($group2);

$cpt = 0;
foreach ($group as $groupOrItem)
{
  if ($cpt == 0)
  {
    $t->ok($groupOrItem instanceof menuItem, 'value is a menuItem');
    $t->is($groupOrItem, $item, 'value is correct');
  }
  elseif ($cpt == 1)
  {
    $t->ok($groupOrItem instanceof menuGroup, 'value is a menuGroup');
    $t->is($groupOrItem, $group2, 'value is correct');
  }
  else
  {
    $t->fail('there is too much elements');
  }
  $cpt++;
}

$t->ok($group->getName() === null, 'group has no name if noting passed to constructor');

$group = new menuGroup('myGroupName');
$t->is($group->getName(), 'myGroupName', 'getName works');


$group = new menuGroup();
$tests = array(
  'something',
  array('onearray'),
  null,
);

foreach ($tests as $test)
{
  $msg = 'with "' . var_export($test, true). ' we have an expection when append is called';
  try
  {
    $group->append($test);
    $t->fail($msg);
  }
  catch (menuGroupException $e)
  {
    $t->pass($msg);
  }
}


