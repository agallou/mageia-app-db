<?php

require_once dirname(__FILE__).'/../vendor/symfony/symfony1/lib/autoload/sfCoreAutoload.class.php';
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

    if (
      is_dir(sfConfig::get('sf_root_dir') . '/plugins/sfAtoumPlugin')
      &&
      (in_array(sfConfig::get('sf_environment'), array('dev', 'test')) || (sfConfig::get('sf_environment') === null))
    )
    {
      require_once sfConfig::get('sf_root_dir') . '/vendor/symfony/symfony1/lib/helper/AssetHelper.php';
      $this->enablePlugins('sfAtoumPlugin', 'elXHProfPlugin');
    }

    sfConfig::set('sf_phing_path', sfConfig::get('sf_root_dir') .'/vendor/phing/phing');
    sfConfig::set('sf_propel_path', sfConfig::get('sf_root_dir') .'/vendor/propel/propel1');
    sfConfig::set('sf_atoum_path', dirname(__FILE__) . '/../vendor/atoum/atoum');

    require_once dirname(__FILE__).'/../vendor/openlss/func-format/func/format.php';
  }
}
