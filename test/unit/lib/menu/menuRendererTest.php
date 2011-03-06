<?php
include dirname(__FILE__) . '/../../../bootstrap/unit.php';

$_SERVER['SCRIPT_NAME'] = '/index.php';                                                                                                                                      
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);
$context       = sfContext::createInstance($configuration);

$t = new lime_test(1);

$parameters = array(
  'distrelease' => 2010,
  'application' => 1,
);
$parameterHolder = new madbParameterHolder();
$parameterHolder->add($parameters);
$madbcontext = new madbContext($parameterHolder);
$madbUrl     = new madbUrl($context);

$renderer = new menuItemRenderer($madbcontext, $madbUrl);

$menuGroup = new menuGroup();
$menuGroup->addMenuItem($item);
$latestGroup = new menuGroup('Latest');
$menuGroup->addMenuGroup($latestGroup);


$item = new MenuItem('Homepage', '@homepage', array('filters_parameters' => true));
$menuGroup->addMenuItem($item);

$renderer = new menuRenderer($madbcontext, $madbUrl);
//<div id="menu"></div>
$expected = <<<EOF
<ul>
  <li><a href="/index.php/?distrelease=2010&application=1">Homepage</a></li>
  <li>
    <h2>Latest</h2>
    <ul>
      <li><a href="/index.php/rpm/list/distrelease/2010/application/1/arch/1%2C2/media/1%2C2%2C3/source/0%2C1/listtype/updates">Updates</a></li>
      <li><a href="/index.php/rpm/list/distrelease/2010/application/1/arch/1%2C2/media/1%2C2%2C3/sourcea/0%2C1/listtype/updates_testing">Update candidates</a></li>
      <li><a href="/index.php/rpm/list/distrelease/2010/application/1/arch/1%2C2/media/1%2C2%2C3/source/0%2C1/listtype/backports">Backports</a></li>
      <li><a href="/index.php/rpm/list/distrelease/2010/application/1/arch/1%2C2/media/1%2C2%2C3/source/0%2C1/listtype/backports_testing">Backport candidates</a></li>
    </ul>
  </li>
  <li>
    <h2>Browse</h2>
    <ul>
      <li><a href="/frontend_dev.php/group/list/distrelease/1%2C2%2C3/application/1%2C0/arch/1%2C2/media/1%2C2%2C3/source/0%2C1">By group</a></li>
      <li>By popularity</li>
      <li><a href="/frontend_dev.php/package/list/distrelease/1%2C2%2C3/application/1%2C0/arch/1%2C2/media/1%2C2%2C3/source/0%2C1">By name</a></li>
    </ul>
  </li>
</ul>
EOF;
$t->is($renderer->render($menuGroup), $expected, 'render works');

