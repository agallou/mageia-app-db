<?php

namespace tests\units {

require_once __DIR__ . '/../../../../plugins/sfAtoumPlugin/bootstrap/unit.php';

use \mageekguy\atoum;

class urlFilterGenerator extends atoum\test
{

  public function getTestsCases()
  {
    return array(
      array(
        'parameters' => array(
          'clean_urls'   => true,
          'php_self'     => '/index.php',
          'url'          =>  '/rpm/list/listtype/updates',
          'extra_params' => array(),
        ),
        'expected' => array(
          'new_url' => 'http://madb.localhost/index.php/rpm/list/listtype/updates',
          'changed' => 0,
        )
      ),
    );
  }


  public function testRender()
  {
    $_SERVER['SCRIPT_NAME'] = 'madb.localhost/index.php';
    $configuration          = \ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
    $context                = \sfContext::createInstance($configuration);
    $madbUrl                = new \madbUrl($context);
    $generator              = new \urlFilterGenerator($context->getRouting(), $madbUrl);

    foreach ($this->getTestsCases() as $testCase)
    {
      $params   = $testCase['parameters'];
      $urlInfos = $generator->generate($params['clean_urls'], $params['php_self'], $params['url'], $params['extra_params']);
      $this->assert->array($urlInfos)->isEqualTo($testCase['expected']);
    }

  }

  protected function getExtraParams()
  {
    return array (
      'release' => 
      array (
        0 => '1',
      ),
      'application' => 
      array (
        0 => '0',
      ),
      'group' => '',
      'arch' => 
      array (
        0 => '2',
      ),
      'media' => '',
      'source' => 
      array (
        0 => '0',
      ),
    );
  }

}

}
