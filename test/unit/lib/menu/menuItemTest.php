<?php
include dirname(__FILE__) . '/../../../bootstrap/unit.php';

$t = new lime_test(16);


$item = new MenuItem('Homepage', '@homepage', array('filters_parameters' => true));
$t->is($item->getName(), 'Homepage', 'getName works');
$t->is($item->getInternalUri(), '@homepage', 'getInternalUri works');
$t->is($item->getOptions(), array('filters_parameters' => true), 'getOptions works');

$item = new MenuItem('Homepage', '@homepage');
$t->is($item->getName(), 'Homepage', 'getName works');
$t->is($item->getInternalUri(), '@homepage', 'getInternalUri works');
$t->is($item->getOptions(), array(), 'getOptions could be ne setted and as for default value an array');

$item = new MenuItem('Homepage');
$t->is($item->getName(), 'Homepage', 'getName works');
$t->is($item->getInternalUri(), null, 'getInternalUri could be not setted and as for default value null');
$t->is($item->getOptions(), array(), 'getOptions could be ne setted and as for default value an array');

$msgFormat = 'we must have an exception if %s is not a string (here %s)';
$values = array(
  array(),
  null,
  new MenuItem('test'),
  3,
);

foreach ($values as $value)
{
  try
  {
    $item = new MenuItem($value);
    $t->fail(sprintf($msgFormat, 'name', var_export($value, true)));
  }
  catch (MenuItemException $e)
  {
    $t->pass(sprintf($msgFormat, 'name', var_export($value, true)));
  }
}


$msgFormat = 'we must have an exception if %s is not a string (here %s)';
$values = array(
  array(),
  new MenuItem('test'),
  3,
);
foreach ($values as $value)
{
  try
  {
    $item = new MenuItem('test', $value);
    $t->fail(sprintf($msgFormat, 'internalUri', var_export($value, true)));
  }
  catch (MenuItemException $e)
  {
    $t->pass(sprintf($msgFormat, 'internalUri', var_export($value, true)));
  }
}
