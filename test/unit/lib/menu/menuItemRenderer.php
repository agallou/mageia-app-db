<?php

namespace tests\units;

require_once __DIR__ . '/../../../../plugins/sfAtoumPlugin/bootstrap/unit.php';

use \mageekguy\atoum;

class menuItemRenderer extends atoum\test
{

  public function testRender()
  {
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $configuration = \ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);
    $context       = \sfContext::createInstance($configuration);

    $item = new \MenuItem('Homepage', '@homepage', array('filters_parameters' => true));

    $parameters = array(
      'distrelease' => 2010,
      'application' => 1,
    );
    $parameterHolder = new \madbParameterHolder();
    $parameterHolder->add($parameters);
    $madbcontext = new \madbContext($parameterHolder);
    $madbUrl     = new \madbUrl($context);

    $renderer = new \menuItemRenderer($madbcontext, $madbUrl);
    $expected = <<<EOF
<li><a href="/default/news/distrelease/2010">Homepage</a></li>
EOF;

    $expectedCurrent = <<<EOF
<li class="current"><a href="/default/news/distrelease/2010">Homepage</a></li>
EOF;

    $this->assert->string($renderer->render($item))->isEqualTo($expected, 'render if not current (is default value) works');
    $this->assert->string($renderer->render($item, false))->isEqualTo($expected, 'render if not current works');
    $this->assert->string($renderer->render($item, true))->isEqualTo($expectedCurrent, 'render if current works');
  }

}