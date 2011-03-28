<?php
include dirname(__FILE__) . '/../../bootstrap/functional.php';

$b = new sfTestBrowser();

$params = array(
  'baseurl' => 'aHR0cDovL21hZ2VpYS1hcHAtZGIubG9jYWxob3N0L2Zyb250ZW5kX2Rldi5waHAvZGVmYXVsdC9uZXdzL2FwcGxpY2F0aW9uLzAvc291cmNlLzA=',
  'extraParams' => array(
    'application' => array(0),
    'source' => array(0),
  )
);

$b->setHttpHeader('X-Requested-With', 'XMLHttpRequest');
$b->post('/default/getUrl/', $params);
$b->with('response')->isStatusCode(200);
$content = $b->getResponse()->getContent();
$json = json_decode($content);
$b->test()->is($json->url, 'http://localhost/index.php/default/news/application/0/source/0', 'url ok');
$b->test()->is($json->changed, 0, 'changed if not changed ok');


$params['extraParams']['source'] = array(1);
$b->setHttpHeader('X-Requested-With', 'XMLHttpRequest');
$b->post('/default/getUrl/', $params);
$b->with('response')->isStatusCode(200);
$content = $b->getResponse()->getContent();
$json = json_decode($content);
$b->test()->is($json->url, 'http://localhost/index.php/default/news/application/0/source/1', 'url ok');
$b->test()->is($json->changed, 1, 'changed if not changed ok');

