<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    if (sfConfig::get('sf_environment') == 'dev')
    {
      ini_set('memory_limit', '128M');
    }
    $this->enablePlugins('sfPropelORMPlugin', 'sfGuardPlugin', 'omCrossAppUrlPlugin');
    if (sfConfig::get('sf_environment') != 'prod')
    {
      $this->enablePlugins('sfAtoumPlugin');
    }
    require_once($this->getConfigCache()->checkConfig('config/madbconf.yml'));
  }
}
