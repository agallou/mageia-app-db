<?php


namespace {
  if (!class_exists('releaseDefault'))
  {
    class releaseDefault
    {
      public function getDefault()
      {
        return null;
      }
    }
  }
}

namespace tests\units {

require_once __DIR__ . '/../../../../plugins/sfAtoumPlugin/bootstrap/unit.php';

use \mageekguy\atoum;

class menuRenderer extends atoum\test
{

  public function testRender()
  {
    $_SERVER['SCRIPT_NAME'] = '/index.php';

    $configuration = \ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
    $context       = \sfContext::createInstance($configuration);

    $parameters = array(
      'release' => 2010,
      'application' => 1,
    );
    $parameterHolder = new \madbParameterHolder();
    $parameterHolder->add($parameters);
    $madbcontext = new \madbContext($parameterHolder);
    $madbUrl     = new \madbUrl($context);

    $request = new \sfWebRequest(new \sfEventDispatcher());

    $renderer = new \menuItemRenderer($madbcontext, $madbUrl, $request);

    $menuGroup = new \menuGroup();

    $item = new \menuItem('Homepage', '@homepage');
    $menuGroup->addMenuItem($item);

    $latestGroup = new \menuGroup('Latest');

    $extraparams = array('arch'=> '1','media'=>'1','source'=>'0');

    $updatesItem = new \menuItem ('Updates', 'rpm/list', array('extra_parameters' => array_merge($extraparams,array('listtype' => 'updates'))));
    $latestGroup->addMenuItem($updatesItem);

    $updatesCanItem = new \menuItem ('Update candidates', 'rpm/list', array('extra_parameters' => array_merge($extraparams, array('listtype' => 'updates_testing'))));
    $latestGroup->addMenuItem($updatesCanItem);

    $backports = new \menuItem('Backports', 'rpm/list', array('extra_parameters' => array_merge($extraparams,array('listtype' => 'backports'))));
    $latestGroup->addMenuItem($backports);

    $backportsCan = new \menuItem('Backport candidates', 'rpm/list', array('extra_parameters' => array_merge($extraparams,array('listtype' => 'backports_testing'))));
    $latestGroup->addMenuItem($backportsCan);

    $menuGroup->addMenuGroup($latestGroup);


    $browseGroup = new \menuGroup('Browse');

    $groupItem = new \menuItem('By group', 'group/list', array('extra_parameters' => $extraparams));
    $browseGroup->addMenuItem($groupItem);


    $nameItem = new \menuItem('By name', 'package/list', array('extra_parameters' => $extraparams));
    $browseGroup->addMenuItem($nameItem);

    $menuGroup->addMenuGroup($browseGroup);


    $renderer = new \menuRenderer($madbcontext, $madbUrl, $request);

    $expected = <<<EOF
<ul>
<li class="leaf "><a href="/index.php/default/home/release/2010">Homepage</a></li>
<li>
<h2>Latest</h2>
<ul>
<li class="leaf "><a href="/index.php/rpm/list/release/2010/arch/1/media/1/source/0/listtype/updates">Updates</a></li>
<li class="leaf "><a href="/index.php/rpm/list/release/2010/arch/1/media/1/source/0/listtype/updates_testing">Update candidates</a></li>
<li class="leaf "><a href="/index.php/rpm/list/release/2010/arch/1/media/1/source/0/listtype/backports">Backports</a></li>
<li class="leaf "><a href="/index.php/rpm/list/release/2010/arch/1/media/1/source/0/listtype/backports_testing">Backport candidates</a></li>
</ul>
</li>
<li>
<h2>Browse</h2>
<ul>
<li class="leaf "><a href="/index.php/group/list/release/2010/arch/1/media/1/source/0">By group</a></li>
<li class="leaf "><a href="/index.php/package/list/release/2010/arch/1/media/1/source/0">By name</a></li>
</ul>
</li>
</ul>

EOF;
    $this->assert->string($renderer->render($menuGroup))->isEqualTo($expected, 'render works');

  }

}
}
