<?php
include dirname(__FILE__) . '/../../../bootstrap/unit.php';

$_SERVER['SCRIPT_NAME'] = '/index.php';                                                                                                                                      
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);
$context       = sfContext::createInstance($configuration);

$t = new lime_test(3);

$item = new MenuItem('Homepage', '@homepage', array('filters_parameters' => true));

$parameters = array(
  'distrelease' => 2010,
  'application' => 1,
);
$parameterHolder = new madbParameterHolder();
$parameterHolder->add($parameters);
$madbcontext = new madbContext($parameterHolder);
$madbUrl     = new madbUrl($context);

$renderer = new menuItemRenderer($madbcontext, $madbUrl);
$expected = <<<EOF
<li><a href="/index.php/?distrelease=2010&application=1">Homepage</a></li>
EOF;

$expectedCurrent = <<<EOF
<li class="current"><a href="/index.php/?distrelease=2010&application=1">Homepage</a></li>
EOF;

$t->is($renderer->render($item), $expected, 'render if not current (is default value) works');
$t->is($renderer->render($item, false), $expected, 'render if not current works');
$t->is($renderer->render($item, true), $expectedCurrent, 'render if current works');



